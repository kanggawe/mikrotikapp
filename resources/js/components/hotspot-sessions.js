// Hotspot Sessions Component
export default function hotspotSessions(config) {
    return {
        sessions: config.sessions,
        stats: config.stats,
        urls: config.urls,
        selectedSessions: new Set(),
        isRefreshing: false,
        searchQuery: '',
        profileFilter: '',
        statusFilter: '',
        sortBy: 'startTime',
        lastUpdated: new Date().toLocaleString(),

        init() {
            this.setupAutoRefresh();
        },

        setupAutoRefresh() {
            setInterval(() => {
                if (document.visibilityState === 'visible') {
                    this.refreshSessions();
                }
            }, 30000); // Refresh every 30 seconds
        },        async refreshSessions() {
            this.isRefreshing = true;
            try {
                const response = await fetch(this.urls.refresh);
                const data = await response.json();
                this.sessions = data.sessions;
                this.stats = data.stats;
                this.lastUpdated = new Date().toLocaleString();
                this.showNotification('Sessions refreshed successfully', 'success');
            } catch (error) {
                this.showNotification('Failed to refresh sessions', 'error');
            } finally {
                this.isRefreshing = false;
            }
        },

        async disconnectSession(sessionId) {
            if (!confirm('Are you sure you want to disconnect this session?')) {
                return;
            }            try {
                await fetch(this.urls.disconnect.replace('__ID__', sessionId), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                this.sessions = this.sessions.filter(s => s.id !== sessionId);
                this.showNotification('Session disconnected successfully', 'success');
            } catch (error) {
                this.showNotification('Failed to disconnect session', 'error');
            }
        },

        async bulkDisconnect() {
            if (this.selectedSessions.size === 0) {
                this.showNotification('Please select sessions to disconnect', 'warning');
                return;
            }

            if (!confirm(`Are you sure you want to disconnect ${this.selectedSessions.size} sessions?`)) {
                return;
            }

            try {
                await fetch(this.urls.bulkDisconnect, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        ids: Array.from(this.selectedSessions)
                    })
                });

                this.sessions = this.sessions.filter(s => !this.selectedSessions.has(s.id));
                this.selectedSessions.clear();
                this.showNotification('Selected sessions disconnected successfully', 'success');
            } catch (error) {
                this.showNotification('Failed to disconnect sessions', 'error');
            }
        },

        async sendMessage(sessionId, message, duration) {
            try {
                const response = await fetch(this.urls.sendMessage.replace('__ID__', sessionId), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ message, duration })
                });

                if (!response.ok) {
                    throw new Error('Failed to send message');
                }

                const result = await response.json();
                this.showNotification(result.message, result.success ? 'success' : 'error');
                return result.success;
            } catch (error) {
                this.showNotification('Failed to send message: ' + error.message, 'error');
                return false;
            }
        },

        async bulkMessage(message, duration) {
            if (this.selectedSessions.size === 0) {
                this.showNotification('Please select sessions to send message to', 'warning');
                return;
            }

            try {
                const response = await fetch(this.urls.bulkMessage, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        ids: Array.from(this.selectedSessions),
                        message,
                        duration
                    })
                });

                if (!response.ok) {
                    throw new Error('Failed to send messages');
                }

                const result = await response.json();
                this.showNotification(result.message, result.success ? 'success' : 'error');
                this.selectedSessions.clear();
            } catch (error) {
                this.showNotification('Failed to send messages: ' + error.message, 'error');
            }
        },

        exportSessions() {
            window.location.href = this.urls.export;
        },

        openMessageDialog(sessionId = null) {
            this.$dispatch('open-message-modal', { sessionId });
        },

        openBulkMessageDialog() {
            if (this.selectedSessions.size === 0) {
                this.showNotification('Please select sessions to send message to', 'warning');
                return;
            }
            this.$dispatch('open-message-modal', { bulk: true });
        },

        toggleSessionSelection(sessionId) {
            if (this.selectedSessions.has(sessionId)) {
                this.selectedSessions.delete(sessionId);
            } else {
                this.selectedSessions.add(sessionId);
            }
        },

        toggleSelectAll() {
            if (this.selectedSessions.size === this.filteredSessions.length) {
                this.selectedSessions.clear();
            } else {
                this.filteredSessions.forEach(session => {
                    this.selectedSessions.add(session.id);
                });
            }
        },

        get filteredSessions() {
            return this.sessions.filter(session => {
                const matchesSearch = !this.searchQuery || 
                    session.username.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    session.ip.includes(this.searchQuery) ||
                    session.mac.toLowerCase().includes(this.searchQuery);
                    
                const matchesProfile = !this.profileFilter || session.profile === this.profileFilter;
                const matchesStatus = !this.statusFilter || session.status === this.statusFilter;
                
                return matchesSearch && matchesProfile && matchesStatus;
            }).sort((a, b) => {
                switch (this.sortBy) {
                    case 'username':
                        return a.username.localeCompare(b.username);
                    case 'data_usage':
                        return (b.download + b.upload) - (a.download + a.upload);
                    case 'session_time':
                        return b.sessionTime - a.sessionTime;
                    default: // start_time
                        return new Date(b.startTime) - new Date(a.startTime);
                }
            });
        },

        formatBytes(bytes) {
            if (bytes === 0) return '0 B';
            const k = 1024;
            const sizes = ['B', 'KB', 'MB', 'GB', 'TB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        },

        formatSessionTime(seconds) {
            const hours = Math.floor(seconds / 3600);
            const minutes = Math.floor((seconds % 3600) / 60);
            const secs = seconds % 60;
            
            if (hours > 0) {
                return `${hours}h ${minutes}m`;
            } else if (minutes > 0) {
                return `${minutes}m ${secs}s`;
            } else {
                return `${secs}s`;
            }
        },

        showNotification(message, type = 'info') {
            const event = new CustomEvent('show-notification', {
                detail: { message, type }
            });
            window.dispatchEvent(event);
        }
    };
}
