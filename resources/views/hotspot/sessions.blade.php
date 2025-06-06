@extends('layouts.app')

@section('title', 'Hotspot Sessions - MikroTik RADIUS Management')
@section('page_title', 'Hotspot Sessions')
@section('page_subtitle', 'Monitor active hotspot sessions and user connections')

@section('content')
@verbatim
<div x-data="hotspotSessions({
    sessions: @json($sessions),
    stats: @json($stats),
    urls: {
        refresh: '{{ route('hotspot.sessions.refresh') }}',
        disconnect: '{{ route('hotspot.sessions.disconnect', ':id') }}',
        bulkDisconnect: '{{ route('hotspot.sessions.bulkDisconnect') }}',
        sendMessage: '{{ route('hotspot.sessions.sendMessage', ':id') }}',
        bulkMessage: '{{ route('hotspot.sessions.bulkMessage') }}',
        export: '{{ route('hotspot.sessions.export') }}'
    }
})" class="content-section">
    <!-- Header with Actions -->
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Hotspot Session Monitoring</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Real-time monitoring of hotspot user sessions</p>
            </div>
            
            <div class="flex items-center space-x-3">
                <button @click="refreshSessions()" class="btn-primary" :disabled="isRefreshing">
                    <i class="fas fa-sync-alt mr-2" :class="{'animate-spin': isRefreshing}"></i>
                    Refresh
                </button>
                <button @click="exportSessions()" class="btn-secondary">
                    <i class="fas fa-download mr-2"></i>
                    Export
                </button>
                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="autoRefresh" x-model="autoRefresh" class="rounded border-gray-300 dark:border-gray-600">
                    <label for="autoRefresh" class="text-sm text-gray-700 dark:text-gray-300">Auto Refresh (30s)</label>
                </div>
            </div>
        </div>
    </div>
      <!-- Stats Cards -->
    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
            <!-- Total Sessions -->
            <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-blue-900 dark:text-blue-100" x-text="stats.total || 0"></h3>
                        <p class="text-blue-600 dark:text-blue-300 text-sm">Total Sessions</p>
                    </div>
                </div>
            </div>
            
            <!-- Active Sessions -->
            <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-wifi text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-green-900 dark:text-green-100" x-text="stats.active || 0"></h3>
                        <p class="text-green-600 dark:text-green-300 text-sm">Active</p>
                    </div>
                </div>
            </div>

            <!-- Idle Sessions -->
            <div class="bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-yellow-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-pause text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-yellow-900 dark:text-yellow-100" x-text="stats.idle || 0"></h3>
                        <p class="text-yellow-600 dark:text-yellow-300 text-sm">Idle</p>
                    </div>
                </div>
            </div>

            <!-- Total Traffic -->
            <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-line text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-purple-900 dark:text-purple-100" x-text="formatBytes(stats.data_usage || 0)"></h3>
                        <p class="text-purple-600 dark:text-purple-300 text-sm">Total Traffic</p>
                    </div>
                </div>
            </div>

            <!-- Average Session Time -->
            <div class="bg-orange-50 dark:bg-orange-900/20 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-orange-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-orange-900 dark:text-orange-100" x-text="formatSessionTime(stats.average_time || 0)"></h3>
                        <p class="text-orange-600 dark:text-orange-300 text-sm">Avg Session</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filters -->
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-64">
                <input type="text" 
                       x-model="searchQuery" 
                       placeholder="Search by username, IP, or MAC..." 
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            </div>
            
            <select x-model="statusFilter" 
                    class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="idle">Idle</option>
                <option value="blocked">Blocked</option>
            </select>
            
            <select x-model="profileFilter" 
                    class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                <option value="">All Profiles</option>
                <template x-for="profile in uniqueProfiles" :key="profile">
                    <option :value="profile" x-text="profile"></option>
                </template>
            </select>
            
            <select x-model="sortBy" 
                    class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                <option value="startTime">Sort by Start Time</option>
                <option value="username">Sort by Username</option>
                <option value="data_usage">Sort by Data Usage</option>
                <option value="session_time">Sort by Session Time</option>
            </select>
        </div>
    </div>
    
    <!-- Sessions Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th class="px-6 py-3 text-left">
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   @click="toggleSelectAll()" 
                                   :checked="selectedSessions.size === filteredSessions.length && filteredSessions.length > 0"
                                   class="rounded border-gray-300 dark:border-gray-600">
                            <span class="ml-2 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">User Info</span>
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Connection</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Session Time</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Data Usage</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                <template x-for="session in filteredSessions" :key="session.id">
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       :checked="selectedSessions.has(session.id)"
                                       @change="toggleSessionSelection(session.id)"
                                       class="rounded border-gray-300 dark:border-gray-600">
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white" x-text="session.username"></div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400" x-text="session.mac"></div>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium" 
                                          :class="getProfileColor(session.profile)">
                                        <span x-text="session.profile"></span>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 dark:text-white" x-text="session.ip"></div>
                            <div class="text-sm text-gray-500 dark:text-gray-400" x-text="'Port: ' + session.nasPort"></div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 dark:text-white" x-text="formatSessionTime(session.sessionTime)"></div>
                            <div class="text-sm text-gray-500 dark:text-gray-400" x-text="formatDate(session.startTime)"></div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm">
                                <div class="text-gray-900 dark:text-white">↓ <span x-text="formatBytes(session.download)"></span></div>
                                <div class="text-gray-500 dark:text-gray-400">↑ <span x-text="formatBytes(session.upload)"></span></div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                  :class="getStatusColor(session.status)">
                                <span class="w-2 h-2 mr-1 rounded-full"
                                      :class="{'bg-green-400 animate-pulse': session.status === 'active',
                                              'bg-yellow-400': session.status === 'idle',
                                              'bg-red-400': session.status === 'blocked'}">
                                </span>
                                <span x-text="session.status.charAt(0).toUpperCase() + session.status.slice(1)"></span>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center space-x-2">
                                <button @click="viewSession(session)" 
                                        class="p-1 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded" 
                                        title="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button @click="openMessageDialog(session.id)" 
                                        class="p-1 text-green-600 hover:bg-green-50 dark:hover:bg-green-900/20 rounded" 
                                        title="Send Message">
                                    <i class="fas fa-comment"></i>
                                </button>
                                <button @click="disconnectSession(session.id)" 
                                        class="p-1 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded" 
                                        title="Disconnect">
                                    <i class="fas fa-power-off"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>

    <!-- Table Footer -->
    <div class="px-6 py-3 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700 dark:text-gray-300">
                Showing <span x-text="filteredSessions.length"></span> sessions
                <span class="ml-4 text-gray-500">Last updated: <span x-text="lastUpdated"></span></span>
            </div>
            <div class="flex items-center space-x-2">
                <button @click="bulkDisconnect()" 
                        :disabled="selectedSessions.size === 0"
                        class="bg-red-600 hover:bg-red-700 disabled:bg-red-400 text-white px-3 py-1 rounded text-sm">
                    <i class="fas fa-power-off mr-1"></i>
                    Disconnect Selected
                </button>
                <button @click="openBulkMessageDialog()"
                        :disabled="selectedSessions.size === 0"
                        class="bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 text-white px-3 py-1 rounded text-sm">
                    <i class="fas fa-comment mr-1"></i>
                    Send Message
                </button>
            </div>
        </div>
    </div>

    <!-- Session Details Modal -->
    <div x-show="showSessionModal" 
         class="fixed inset-0 z-50 overflow-y-auto" 
         x-cloak>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-black/50" @click="showSessionModal = false"></div>
            <div class="relative bg-white dark:bg-gray-800 rounded-lg max-w-2xl w-full shadow-xl">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Session Details</h3>
                        <button @click="showSessionModal = false" class="text-gray-400 hover:text-gray-500">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <template x-if="selectedSession">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- User Information -->
                            <div class="space-y-4">
                                <h4 class="font-semibold text-gray-900 dark:text-white">User Information</h4>
                                <div class="space-y-2">
                                    <div><span class="font-medium">Username:</span> <span x-text="selectedSession.username"></span></div>
                                    <div><span class="font-medium">Profile:</span> <span x-text="selectedSession.profile"></span></div>
                                    <div><span class="font-medium">MAC Address:</span> <span x-text="selectedSession.mac"></span></div>
                                </div>
                            </div>
                            
                            <!-- Connection Details -->
                            <div class="space-y-4">
                                <h4 class="font-semibold text-gray-900 dark:text-white">Connection Details</h4>
                                <div class="space-y-2">
                                    <div><span class="font-medium">IP Address:</span> <span x-text="selectedSession.ip"></span></div>
                                    <div><span class="font-medium">NAS Port:</span> <span x-text="selectedSession.nasPort"></span></div>
                                    <div><span class="font-medium">Status:</span> <span x-text="selectedSession.status"></span></div>
                                </div>
                            </div>
                            
                            <!-- Session Statistics -->
                            <div class="space-y-4">
                                <h4 class="font-semibold text-gray-900 dark:text-white">Session Statistics</h4>
                                <div class="space-y-2">
                                    <div><span class="font-medium">Session Time:</span> <span x-text="formatSessionTime(selectedSession.sessionTime)"></span></div>
                                    <div><span class="font-medium">Start Time:</span> <span x-text="formatDate(selectedSession.startTime)"></span></div>
                                    <div><span class="font-medium">Last Activity:</span> <span x-text="formatDate(selectedSession.lastActivity)"></span></div>
                                </div>
                            </div>
                            
                            <!-- Data Usage -->
                            <div class="space-y-4">
                                <h4 class="font-semibold text-gray-900 dark:text-white">Data Usage</h4>
                                <div class="space-y-2">
                                    <div><span class="font-medium">Download:</span> <span x-text="formatBytes(selectedSession.download)"></span></div>
                                    <div><span class="font-medium">Upload:</span> <span x-text="formatBytes(selectedSession.upload)"></span></div>
                                    <div><span class="font-medium">Total:</span> <span x-text="formatBytes(selectedSession.download + selectedSession.upload)"></span></div>
                                </div>
                            </div>
                        </div>
                    </template>
                    
                    <div class="mt-6 flex justify-end space-x-3">
                        <button @click="showSessionModal = false" class="btn-secondary">Close</button>
                        <button @click="disconnectSession(selectedSession?.id)" class="btn-danger">
                            <i class="fas fa-power-off mr-2"></i>
                            Disconnect Session
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Message Modal -->
    <div x-show="showMessageModal" 
         class="fixed inset-0 z-50 overflow-y-auto" 
         x-cloak>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-black/50" @click="showMessageModal = false"></div>
            <div class="relative bg-white dark:bg-gray-800 rounded-lg max-w-lg w-full shadow-xl">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white" x-text="messageSessionId ? 'Send Message to User' : 'Send Bulk Message'"></h3>
                        <button @click="showMessageModal = false" class="text-gray-400 hover:text-gray-500">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <form @submit.prevent="sendMessageAndClose">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Message</label>
                                <textarea x-model="messageText" 
                                        rows="4" 
                                        placeholder="Enter your message..." 
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white"></textarea>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Display Duration</label>
                                <select x-model="messageDuration" 
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                    <option value="10">10 seconds</option>
                                    <option value="30">30 seconds</option>
                                    <option value="60">1 minute</option>
                                    <option value="300">5 minutes</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" @click="showMessageModal = false" class="btn-secondary">Cancel</button>
                            <button type="submit" class="btn-primary">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifications -->
    <div x-data
         @show-notification.window="$store.notifications.show($event.detail.message, $event.detail.type)"
         class="fixed top-4 right-4 z-50 space-y-4">
        <template x-for="notification in $store.notifications.items" :key="notification.id">
            <div x-show="notification.show"
                 x-transition:enter="transform ease-out duration-300 transition"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transform ease-in duration-300 transition"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full"
                 :class="{
                     'success': 'bg-green-500',
                     'error': 'bg-red-500',
                     'warning': 'bg-yellow-500',
                     'info': 'bg-blue-500'
                 }[notification.type]"
                 class="text-white px-4 py-2 rounded-lg shadow-lg">
                <div class="flex items-center space-x-3">
                    <span x-text="notification.message"></span>
                    <button @click="$store.notifications.remove(notification.id)" class="text-white hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </template>
    </div>
</div>
@endverbatim
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('hotspotSessions', (config) => ({
            sessions: config.sessions,
            stats: config.stats,
            urls: config.urls,
            selectedSessions: new Set(),
            showSessionModal: false,
            showMessageModal: false,
            selectedSession: null,
            messageSessionId: null,
            messageText: '',
            messageDuration: '30',
            searchQuery: '',
            profileFilter: '',
            statusFilter: '',
            sortBy: 'startTime',
            autoRefresh: true,
            isRefreshing: false,
            lastUpdated: new Date().toLocaleString(),
            refreshInterval: null,

            init() {
                this.setupAutoRefresh();
                this.$watch('autoRefresh', (value) => {
                    if (value) {
                        this.setupAutoRefresh();
                    } else {
                        this.stopAutoRefresh();
                    }
                });
            },

            setupAutoRefresh() {
                if (this.refreshInterval) {
                    clearInterval(this.refreshInterval);
                }
                this.refreshInterval = setInterval(() => {
                    if (document.visibilityState === 'visible' && this.autoRefresh) {
                        this.refreshSessions();
                    }
                }, 30000);
            },

            stopAutoRefresh() {
                if (this.refreshInterval) {
                    clearInterval(this.refreshInterval);
                    this.refreshInterval = null;
                }
            },

            get uniqueProfiles() {
                return [...new Set(this.sessions.map(s => s.profile))].sort();
            },

            get filteredSessions() {
                return this.sessions
                    .filter(session => {
                        const matchesSearch = !this.searchQuery || 
                            session.username.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                            session.ip.includes(this.searchQuery) ||
                            session.mac.toLowerCase().includes(this.searchQuery.toLowerCase());
                        
                        const matchesProfile = !this.profileFilter || session.profile === this.profileFilter;
                        const matchesStatus = !this.statusFilter || session.status === this.statusFilter;
                        
                        return matchesSearch && matchesProfile && matchesStatus;
                    })
                    .sort((a, b) => {
                        switch (this.sortBy) {
                            case 'username':
                                return a.username.localeCompare(b.username);
                            case 'data_usage':
                                return (b.download + b.upload) - (a.download + a.upload);
                            case 'session_time':
                                return b.sessionTime - a.sessionTime;
                            default: // startTime
                                return new Date(b.startTime) - new Date(a.startTime);
                        }
                    });
            },

            async refreshSessions() {
                if (this.isRefreshing) return;
                
                this.isRefreshing = true;
                try {
                    const response = await fetch(this.urls.refresh);
                    if (!response.ok) throw new Error('Failed to refresh sessions');
                    
                    const data = await response.json();
                    this.sessions = data.sessions;
                    this.stats = data.stats;
                    this.lastUpdated = new Date().toLocaleString();
                    this.showNotification('Sessions refreshed successfully', 'success');
                } catch (error) {
                    this.showNotification('Failed to refresh sessions: ' + error.message, 'error');
                } finally {
                    this.isRefreshing = false;
                }
            },

            viewSession(session) {
                this.selectedSession = session;
                this.showSessionModal = true;
            },

            async disconnectSession(sessionId) {
                if (!confirm('Are you sure you want to disconnect this session?')) {
                    return;
                }

                try {
                    const response = await fetch(this.urls.disconnect.replace(':id', sessionId), {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    if (!response.ok) throw new Error('Failed to disconnect session');
                    
                    this.sessions = this.sessions.filter(s => s.id !== sessionId);
                    this.showSessionModal = false;
                    this.showNotification('Session disconnected successfully', 'success');
                } catch (error) {
                    this.showNotification('Failed to disconnect session: ' + error.message, 'error');
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
                    const response = await fetch(this.urls.bulkDisconnect, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            ids: Array.from(this.selectedSessions)
                        })
                    });

                    if (!response.ok) throw new Error('Failed to disconnect sessions');
                    
                    this.sessions = this.sessions.filter(s => !this.selectedSessions.has(s.id));
                    this.selectedSessions.clear();
                    this.showNotification('Selected sessions disconnected successfully', 'success');
                } catch (error) {
                    this.showNotification('Failed to disconnect sessions: ' + error.message, 'error');
                }
            },

            openMessageDialog(sessionId = null) {
                this.messageSessionId = sessionId;
                this.messageText = '';
                this.messageDuration = '30';
                this.showMessageModal = true;
            },

            async sendMessageAndClose() {
                if (!this.messageText.trim()) {
                    this.showNotification('Please enter a message', 'warning');
                    return;
                }

                try {
                    if (this.messageSessionId) {
                        await this.sendMessage(this.messageSessionId, this.messageText, this.messageDuration);
                    } else {
                        await this.sendBulkMessage(this.messageText, this.messageDuration);
                    }
                    this.showMessageModal = false;
                } catch (error) {
                    this.showNotification('Failed to send message: ' + error.message, 'error');
                }
            },

            async sendMessage(sessionId, message, duration) {
                const response = await fetch(this.urls.sendMessage.replace(':id', sessionId), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ message, duration })
                });

                if (!response.ok) throw new Error('Failed to send message');
                
                this.showNotification('Message sent successfully', 'success');
            },

            async sendBulkMessage(message, duration) {
                if (this.selectedSessions.size === 0) {
                    throw new Error('No sessions selected');
                }

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

                if (!response.ok) throw new Error('Failed to send messages');
                
                this.showNotification('Messages sent successfully', 'success');
                this.selectedSessions.clear();
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

            exportSessions() {
                window.location.href = this.urls.export;
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

            formatDate(dateString) {
                return new Date(dateString).toLocaleString();
            },

            getStatusColor(status) {
                const colors = {
                    active: 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200',
                    idle: 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200',
                    blocked: 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200'
                };
                return colors[status] || '';
            },

            getProfileColor(profile) {
                const colors = {
                    '1hour': 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200',
                    '1day': 'bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200',
                    '1week': 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200',
                    '1month': 'bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200'
                };
                return colors[profile] || 'bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200';
            },

            showNotification(message, type = 'info') {
                const event = new CustomEvent('show-notification', {
                    detail: { message, type }
                });
                window.dispatchEvent(event);
            }
        }));
    });
</script>
@endpush