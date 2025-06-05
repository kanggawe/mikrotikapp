@extends('layouts.app')

@section('title', 'Hotspot Sessions - MikroTik RADIUS Management')
@section('page_title', 'Hotspot Sessions')
@section('page_subtitle', 'Monitor active hotspot sessions and user connections')

@section('content')
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
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Active Sessions</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Monitor and manage active user sessions
                    <span class="text-xs text-gray-500">(Last updated: <span x-text="lastUpdated"></span>)</span>
                </p>
            </div>
            
            <div class="flex items-center space-x-3">
                <button @click="refreshSessions" class="btn-secondary" :disabled="isRefreshing">
                    <i class="fas fa-sync-alt mr-2" :class="{ 'animate-spin': isRefreshing }"></i>
                    Refresh
                </button>
                <button onclick="disconnectSelected()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    <i class="fas fa-sign-out-alt mr-2"></i>
                    Disconnect Selected
                </button>
                <button onclick="exportSessions()" class="btn-secondary">
                    <i class="fas fa-download mr-2"></i>
                    Export
                </button>
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
                        <h3 class="text-xl font-bold text-blue-900 dark:text-blue-100" x-text="stats.total">0</h3>
                        <p class="text-blue-600 dark:text-blue-300 text-sm">Total Sessions</p>
                    </div>
                </div>
            </div>
            
            <!-- Active Sessions -->
            <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-signal text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-green-900 dark:text-green-100" x-text="stats.active">0</h3>
                        <p class="text-green-600 dark:text-green-300 text-sm">Active Sessions</p>
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
                        <h3 class="text-xl font-bold text-yellow-900 dark:text-yellow-100" x-text="stats.idle">0</h3>
                        <p class="text-yellow-600 dark:text-yellow-300 text-sm">Idle Sessions</p>
                    </div>
                </div>
            </div>

            <!-- Data Usage -->
            <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-bar text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-purple-900 dark:text-purple-100" x-text="formatBytes(stats.data_usage)">0 B</h3>
                        <p class="text-purple-600 dark:text-purple-300 text-sm">Total Data Usage</p>
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
                        <h3 class="text-xl font-bold text-orange-900 dark:text-orange-100" x-text="formatSessionTime(stats.average_time)">0s</h3>
                        <p class="text-orange-600 dark:text-orange-300 text-sm">Average Session Time</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
                        <h3 class="text-xl font-bold text-green-900 dark:text-green-100">23</h3>
                        <p class="text-green-600 dark:text-green-300 text-sm">Active Sessions</p>
                    </div>
                </div>
            </div>

            <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-arrow-down text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-blue-900 dark:text-blue-100">2.4GB</h3>
                        <p class="text-blue-600 dark:text-blue-300 text-sm">Total Download</p>
                    </div>
                </div>
            </div>

            <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-arrow-up text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-purple-900 dark:text-purple-100">890MB</h3>
                        <p class="text-purple-600 dark:text-purple-300 text-sm">Total Upload</p>
                    </div>
                </div>
            </div>

            <div class="bg-orange-50 dark:bg-orange-900/20 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-orange-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-orange-900 dark:text-orange-100">4h 32m</h3>
                        <p class="text-orange-600 dark:text-orange-300 text-sm">Avg Session</p>
                    </div>
                </div>
            </div>

            <div class="bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-yellow-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-tachometer-alt text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-yellow-900 dark:text-yellow-100">15Mbps</h3>
                        <p class="text-yellow-600 dark:text-yellow-300 text-sm">Avg Speed</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filters -->
    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label for="searchSessions" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Search</label>
                <input type="text" id="searchSessions" x-model="searchQuery" 
                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 
                              shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                       placeholder="Search by username, IP, or MAC...">
            </div>

            <!-- Profile Filter -->
            <div>
                <label for="profileFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Profile</label>
                <select id="profileFilter" x-model="profileFilter" 
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 
                               shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Profiles</option>
                    <option value="1hour">1 Hour</option>
                    <option value="1day">1 Day</option>
                    <option value="1week">1 Week</option>
                    <option value="1month">1 Month</option>
                </select>
            </div>

            <!-- Status Filter -->
            <div>
                <label for="statusFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                <select id="statusFilter" x-model="statusFilter" 
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 
                               shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="idle">Idle</option>
                    <option value="blocked">Blocked</option>
                </select>
            </div>

            <!-- Sort By -->
            <div>
                <label for="sortBy" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sort By</label>
                <select id="sortBy" x-model="sortBy" 
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 
                               shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="startTime">Start Time</option>
                    <option value="username">Username</option>
                    <option value="data_usage">Data Usage</option>
                    <option value="session_time">Session Time</option>
                </select>
            </div>
        </div>
    </div>
    
    <!-- Sessions Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        <div class="flex items-center">
                            <input type="checkbox" @click="toggleSelectAll" 
                                   :checked="selectedSessions.size === filteredSessions.length && filteredSessions.length > 0"
                                   class="rounded border-gray-300 dark:border-gray-600">
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">User</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Connection</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Data Usage</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Session Info</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                <template x-for="session in filteredSessions" :key="session.id">
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                        <td class="px-6 py-4">
                            <input type="checkbox" 
                                   :checked="selectedSessions.has(session.id)"
                                   @change="toggleSessionSelection(session.id)"
                                   class="rounded border-gray-300 dark:border-gray-600">
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 flex-shrink-0">
                                    <div class="w-full h-full rounded-full bg-blue-600 flex items-center justify-center">
                                        <i class="fas" :class="session.username.startsWith('WIFI-') ? 'fa-ticket-alt' : 'fa-user'" class="text-white"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white" x-text="session.username"></div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium"
                                              :class="{
                                                '1hour': 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200',
                                                '1day': 'bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200',
                                                '1week': 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200',
                                                '1month': 'bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200'
                                              }[session.profile]"
                                              x-text="session.profile">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 dark:text-white" x-text="'IP: ' + session.ip"></div>
                            <div class="text-sm text-gray-500 dark:text-gray-400" x-text="'MAC: ' + session.mac"></div>
                            <div class="text-sm text-gray-500 dark:text-gray-400" x-text="'Port: ' + session.nasPort"></div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 dark:text-white" x-text="'↓ ' + formatBytes(session.download)"></div>
                            <div class="text-sm text-gray-500 dark:text-gray-400" x-text="'↑ ' + formatBytes(session.upload)"></div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 dark:text-white" x-text="formatSessionTime(session.sessionTime)"></div>
                            <div class="text-sm text-gray-500 dark:text-gray-400" x-text="'Started: ' + session.startTime"></div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" 
                                  :class="{
                                      'active': 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200',
                                      'idle': 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200',
                                      'blocked': 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200'
                                  }[session.status]">
                                <div class="w-1.5 h-1.5 rounded-full mr-1.5"
                                     :class="{
                                         'active': 'bg-green-400 animate-pulse',
                                         'idle': 'bg-yellow-400',
                                         'blocked': 'bg-red-400'
                                     }[session.status]">
                                </div>
                                <span x-text="session.status.charAt(0).toUpperCase() + session.status.slice(1)"></span>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center space-x-2">
                                <button @click="$dispatch('view-session', session)" 
                                        class="p-1 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button @click="$dispatch('send-message', session)"
                                        class="p-1 text-green-600 hover:bg-green-50 dark:hover:bg-green-900/20 rounded">
                                    <i class="fas fa-comment"></i>
                                </button>
                                <button @click="disconnectSession(session.id)"
                                        class="p-1 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded">
                                    <i class="fas fa-power-off"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>

    <!-- Session Details Modal -->
    <div x-show="$store.modals.sessionDetails.show" 
         class="fixed inset-0 z-50 overflow-y-auto" 
         x-cloak>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-black/50"></div>
            <div class="relative bg-white dark:bg-gray-800 rounded-lg max-w-2xl w-full shadow-xl">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Session Details</h3>
                        <button @click="$store.modals.sessionDetails.close()" class="text-gray-400 hover:text-gray-500">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="space-y-6" x-html="$store.modals.sessionDetails.content"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Message Modal -->
    <div x-show="$store.modals.message.show"
         class="fixed inset-0 z-50 overflow-y-auto"
         x-cloak>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-black/50"></div>
            <div class="relative bg-white dark:bg-gray-800 rounded-lg max-w-md w-full shadow-xl">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white" x-text="$store.modals.message.title"></h3>
                        <button @click="$store.modals.message.close()" class="text-gray-400 hover:text-gray-500">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label for="messageText" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Message</label>
                            <textarea id="messageText" x-model="$store.modals.message.form.message" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 
                                           shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        </div>
                        <div>
                            <label for="messageDuration" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Duration (seconds)</label>
                            <input type="number" id="messageDuration" x-model="$store.modals.message.form.duration" min="1" max="60"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 
                                          shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div class="flex justify-end space-x-3 mt-6">
                            <button @click="$store.modals.message.close()" class="btn-secondary">Cancel</button>
                            <button @click="$store.modals.message.send()" class="btn-primary">Send Message</button>
                        </div>
                    </div>
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

@push('scripts')
<script>
    // Store for notifications
document.addEventListener('alpine:init', () => {
    Alpine.store('notifications', {
        items: [],
        nextId: 1,
        show(message, type = 'info') {
            const id = this.nextId++;
            const notification = {
                id,
                message,
                type,
                show: true
            };
            
            this.items.push(notification);

            setTimeout(() => {
                this.remove(id);
            }, 5000);
        },
        remove(id) {
            const index = this.items.findIndex(n => n.id === id);
            if (index > -1) {
                this.items[index].show = false;
                setTimeout(() => {
                    this.items = this.items.filter(n => n.id !== id);
                }, 300);
            }
        }
    });

    Alpine.store('modals', {
        sessionDetails: {
            show: false,
            content: '',
            open(session) {
                this.content = `
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <h4 class="font-semibold text-gray-900 dark:text-white">User Information</h4>
                            <div class="space-y-2">
                                <div><span class="font-medium">Username:</span> ${session.username}</div>
                                <div><span class="font-medium">Profile:</span> ${session.profile}</div>
                                <div><span class="font-medium">Session ID:</span> ${session.sessionId}</div>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <h4 class="font-semibold text-gray-900 dark:text-white">Connection Details</h4>
                            <div class="space-y-2">
                                <div><span class="font-medium">IP Address:</span> ${session.ip}</div>
                                <div><span class="font-medium">MAC Address:</span> ${session.mac}</div>
                                <div><span class="font-medium">NAS Port:</span> ${session.nasPort}</div>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <h4 class="font-semibold text-gray-900 dark:text-white">Session Statistics</h4>
                            <div class="space-y-2">
                                <div><span class="font-medium">Download:</span> ${formatBytes(session.download)}</div>
                                <div><span class="font-medium">Upload:</span> ${formatBytes(session.upload)}</div>
                                <div><span class="font-medium">Session Time:</span> ${formatSessionTime(session.sessionTime)}</div>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <h4 class="font-semibold text-gray-900 dark:text-white">Timestamps</h4>
                            <div class="space-y-2">
                                <div><span class="font-medium">Start Time:</span> ${session.startTime}</div>
                                <div><span class="font-medium">Last Activity:</span> ${session.lastActivity}</div>
                            </div>
                        </div>
                    </div>
                `;
                this.show = true;
            },
            close() {
                this.show = false;
                this.content = '';
            }
        },
        message: {
            show: false,
            title: 'Send Message',
            sessionId: null,
            bulk: false,
            form: {
                message: '',
                duration: 30
            },
            open({ sessionId = null, bulk = false } = {}) {
                this.sessionId = sessionId;
                this.bulk = bulk;
                this.title = bulk ? 'Send Bulk Message' : 'Send Message';
                this.form.message = '';
                this.form.duration = 30;
                this.show = true;
            },
            close() {
                this.show = false;
                this.sessionId = null;
                this.bulk = false;
                this.form.message = '';
                this.form.duration = 30;
            },
            async send() {
                if (!this.form.message) {
                    Alpine.store('notifications').show('Please enter a message', 'error');
                    return;
                }

                const success = this.bulk 
                    ? await Alpine.$data.bulkMessage(this.form.message, this.form.duration)
                    : await Alpine.$data.sendMessage(this.sessionId, this.form.message, this.form.duration);

                if (success) {
                    this.close();
                }
            }
        }
    });
});

// Event handlers
window.addEventListener('view-session', (event) => {
    Alpine.store('modals').sessionDetails.open(event.detail);
});
window.addEventListener('open-message-modal', (event) => {
    Alpine.store('modals').message.open(event.detail);
});
</script>
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('hotspotSessions', () => ({
        sessions: [],
        filteredSessions: [],
        selectedSessions: new Set(),
        stats: {
            total: 0,
            active: 0,
            idle: 0,
            data_usage: 0,
            average_time: 0
        },
        lastUpdated: '',
        isRefreshing: false,
        searchQuery: '',
        profileFilter: '',
        statusFilter: '',
        sortBy: 'startTime',

        init() {
            this.refreshSessions();
        },

        async refreshSessions() {
            this.isRefreshing = true;
            try {
                const response = await fetch('{{ route("hotspot.sessions.refresh") }}');
                if (!response.ok) throw new Error('Failed to refresh sessions');

                const result = await response.json();
                this.sessions = result.sessions;
                this.stats = result.stats;
                this.lastUpdated = new Date().toLocaleString();
                this.showNotification('Sessions refreshed successfully', 'success');
            } catch (error) {
                this.showNotification('Failed to refresh sessions: ' + error.message, 'error');
            } finally {
                this.isRefreshing = false;
            }
        },

        exportSessions() {
            window.location.href = '{{ route("hotspot.sessions.export") }}';
        },

        disconnectSession(id) {
            if (!confirm('Are you sure you want to disconnect this session?')) {
                return;
            }

            fetch(this.urls.disconnect.replace(':id', id), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Failed to disconnect session');

                this.sessions = this.sessions.filter(s => s.id !== id);
                this.showNotification('Session disconnected successfully', 'success');
            })
            .catch(error => {
                this.showNotification('Failed to disconnect session: ' + error.message, 'error');
            });
        },

        bulkDisconnect() {
            if (this.selectedSessions.size === 0) {
                this.showNotification('Please select sessions to disconnect', 'warning');
                return;
            }

            if (!confirm(`Are you sure you want to disconnect ${this.selectedSessions.size} sessions?`)) {
                return;
            }

            fetch('{{ route("hotspot.sessions.bulkDisconnect") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    ids: Array.from(this.selectedSessions)
                })
            })
            .then(response => {
                if (!response.ok) throw new Error('Failed to disconnect sessions');

                this.sessions = this.sessions.filter(s => !this.selectedSessions.has(s.id));
                this.selectedSessions.clear();
                this.showNotification('Selected sessions disconnected successfully', 'success');
            })
            .catch(error => {
                this.showNotification('Failed to disconnect sessions: ' + error.message, 'error');
            });
        },

        sendMessage(id, message, duration) {
            fetch(this.urls.sendMessage.replace(':id', id), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ message, duration })
            })
            .then(response => {
                if (!response.ok) throw new Error('Failed to send message');

                this.showNotification('Message sent successfully', 'success');
            })
            .catch(error => {
                this.showNotification('Failed to send message: ' + error.message, 'error');
            });
        },

        bulkMessage(message, duration) {
            if (this.selectedSessions.size === 0) {
                this.showNotification('Please select sessions to send message to', 'warning');
                return;
            }

            fetch('{{ route("hotspot.sessions.bulkMessage") }}', {
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
            })
            .then(response => {
                if (!response.ok) throw new Error('Failed to send messages');

                this.showNotification('Messages sent successfully', 'success');
                this.selectedSessions.clear();
            })
            .catch(error => {
                this.showNotification('Failed to send messages: ' + error.message, 'error');
            });
        },

        toggleSelectAll() {
            if (this.selectedSessions.size === this.filteredSessions.length) {
                this.selectedSessions.clear();
            } else {
                this.filteredSessions.forEach(session => this.selectedSessions.add(session.id));
            }
        },

        toggleSessionSelection(id) {
            if (this.selectedSessions.has(id)) {
                this.selectedSessions.delete(id);
            } else {
                this.selectedSessions.add(id);
            }
        },

        showNotification(message, type = 'info') {
            const colors = {
                success: 'bg-green-500',
                error: 'bg-red-500',
                warning: 'bg-yellow-500',
                info: 'bg-blue-500'
            };

            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 ${colors[type]} text-white px-4 py-2 rounded-lg shadow-lg z-50 transform transition-transform duration-300`;
            notification.textContent = message;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }
    }));
});
</script>
@endpush
@endsection