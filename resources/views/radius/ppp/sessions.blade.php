@extends('layouts.app')

@section('title', 'PPP Sessions - MikroTik RADIUS Management')
@section('page_title', 'PPP Sessions')
@section('page_subtitle', 'Monitor active PPP/PPPoE sessions and connections')

@section('content')
<div class="content-section">
    <!-- Header with Actions -->
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">PPP Session Monitoring</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Real-time monitoring of PPP/PPPoE user sessions</p>
            </div>
            
            <div class="flex items-center space-x-3">
                <button onclick="refreshSessions()" class="btn-primary">
                    <i class="fas fa-sync-alt mr-2"></i>
                    Refresh
                </button>
                <button onclick="exportSessions()" class="btn-secondary">
                    <i class="fas fa-download mr-2"></i>
                    Export
                </button>
                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="autoRefresh" checked class="rounded border-gray-300 dark:border-gray-600">
                    <label class="text-sm text-gray-700 dark:text-gray-300">Auto Refresh (30s)</label>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Stats Cards -->
    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
            <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-blue-900 dark:text-blue-100">45</h3>
                        <p class="text-blue-600 dark:text-blue-300 text-sm">Total Sessions</p>
                    </div>
                </div>
            </div>

            <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-wifi text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-green-900 dark:text-green-100">38</h3>
                        <p class="text-green-600 dark:text-green-300 text-sm">Active</p>
                    </div>
                </div>
            </div>

            <div class="bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-yellow-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-pause text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-yellow-900 dark:text-yellow-100">7</h3>
                        <p class="text-yellow-600 dark:text-yellow-300 text-sm">Idle</p>
                    </div>
                </div>
            </div>

            <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-line text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-purple-900 dark:text-purple-100">2.5GB</h3>
                        <p class="text-purple-600 dark:text-purple-300 text-sm">Total Traffic</p>
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
        </div>
    </div>
    
    <!-- Filters -->
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-64">
                <input type="text" id="searchSessions" placeholder="Search by username, IP, or MAC..." 
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            </div>
            
            <select id="statusFilter" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="idle">Idle</option>
                <option value="blocked">Blocked</option>
            </select>
            
            <select id="profileFilter" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                <option value="">All Profiles</option>
                <option value="basic">Basic</option>
                <option value="premium">Premium</option>
                <option value="business">Business</option>
            </select>
            
            <select id="nasFilter" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                <option value="">All NAS</option>
                <option value="mikrotik-01">MikroTik-01</option>
                <option value="mikrotik-02">MikroTik-02</option>
            </select>
        </div>
    </div>
    
    <!-- Sessions Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        User Information
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Connection Details
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Session Time
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Data Usage
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        NAS Device
                    </th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody id="sessionsTableBody" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                <!-- Sessions will be populated by JavaScript -->
            </tbody>
        </table>
    </div>
    
    <!-- Table Footer -->
    <div class="px-6 py-3 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700 dark:text-gray-300">
                Showing <span id="showingCount">0</span> sessions
                <span class="ml-4 text-gray-500">Last updated: <span id="lastUpdated">--</span></span>
            </div>
            <div class="flex items-center space-x-2">
                <button onclick="bulkDisconnect()" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                    <i class="fas fa-power-off mr-1"></i>
                    Disconnect Selected
                </button>
                <button onclick="bulkMessage()" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                    <i class="fas fa-comment mr-1"></i>
                    Send Message
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Session Details Modal -->
<div id="sessionModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-10 mx-auto p-5 border w-full max-w-3xl shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 id="modalTitle" class="text-lg font-medium text-gray-900 dark:text-white">Session Details</h3>
                <button onclick="closeModal('sessionModal')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div id="sessionDetails" class="space-y-4">
                <!-- Session details will be populated by JavaScript -->
            </div>
            
            <div class="mt-6 flex justify-end space-x-3">
                <button onclick="closeModal('sessionModal')" class="btn-secondary">Close</button>
                <button onclick="disconnectSession()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                    <i class="fas fa-power-off mr-2"></i>
                    Disconnect Session
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Send Message Modal -->
<div id="messageModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-10 mx-auto p-5 border w-full max-w-lg shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Send Message to User</h3>
                <button onclick="closeModal('messageModal')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="messageForm">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Message</label>
                        <textarea id="messageText" rows="4" placeholder="Enter your message..." 
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white"></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Display Duration</label>
                        <select id="messageDuration" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="10">10 seconds</option>
                            <option value="30">30 seconds</option>
                            <option value="60">1 minute</option>
                            <option value="300">5 minutes</option>
                        </select>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('messageModal')" class="btn-secondary">Cancel</button>
                    <button type="button" onclick="sendMessage()" class="btn-primary">Send Message</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let sessions = [];
    let selectedSessions = new Set();
    let currentSessionId = null;
    let autoRefreshInterval = null;

    // Sample session data
    const sampleSessions = [
        {
            id: 1,
            username: 'user001',
            ipAddress: '192.168.1.100',
            macAddress: '00:11:22:33:44:55',
            profile: 'basic',
            status: 'active',
            sessionTime: '02:45:30',
            startTime: '2024-01-16 09:30:00',
            uploadBytes: 125000000,
            downloadBytes: 850000000,
            uploadSpeed: '2.5 Mbps',
            downloadSpeed: '8.2 Mbps',
            nasDevice: 'mikrotik-01',
            callingStationId: 'pppoe-user001',
            framedProtocol: 'PPP'
        },
        {
            id: 2,
            username: 'corp001',
            ipAddress: '192.168.2.50',
            macAddress: '00:AA:BB:CC:DD:EE',
            profile: 'business',
            status: 'active',
            sessionTime: '05:12:45',
            startTime: '2024-01-16 07:15:00',
            uploadBytes: 450000000,
            downloadBytes: 2100000000,
            uploadSpeed: '15.8 Mbps',
            downloadSpeed: '45.2 Mbps',
            nasDevice: 'mikrotik-02',
            callingStationId: 'pppoe-corp001',
            framedProtocol: 'PPP'
        },
        {
            id: 3,
            username: 'premium001',
            ipAddress: '192.168.3.25',
            macAddress: '00:FF:EE:DD:CC:BB',
            profile: 'premium',
            status: 'idle',
            sessionTime: '01:30:15',
            startTime: '2024-01-16 11:00:00',
            uploadBytes: 85000000,
            downloadBytes: 320000000,
            uploadSpeed: '0.1 Mbps',
            downloadSpeed: '0.3 Mbps',
            nasDevice: 'mikrotik-01',
            callingStationId: 'pppoe-premium001',
            framedProtocol: 'PPP'
        }
    ];

    document.addEventListener('DOMContentLoaded', function() {
        sessions = [...sampleSessions];
        renderSessions();
        setupEventListeners();
        startAutoRefresh();
        updateLastUpdated();
    });

    function setupEventListeners() {
        // Search and filters
        document.getElementById('searchSessions').addEventListener('input', filterSessions);
        document.getElementById('statusFilter').addEventListener('change', filterSessions);
        document.getElementById('profileFilter').addEventListener('change', filterSessions);
        document.getElementById('nasFilter').addEventListener('change', filterSessions);
        
        // Auto refresh toggle
        document.getElementById('autoRefresh').addEventListener('change', function() {
            if (this.checked) {
                startAutoRefresh();
            } else {
                stopAutoRefresh();
            }
        });
    }

    function renderSessions() {
        const tbody = document.getElementById('sessionsTableBody');
        const filteredSessions = getFilteredSessions();
        
        tbody.innerHTML = '';
        
        filteredSessions.forEach(session => {
            const row = createSessionRow(session);
            tbody.appendChild(row);
        });
        
        document.getElementById('showingCount').textContent = filteredSessions.length;
    }

    function createSessionRow(session) {
        const row = document.createElement('tr');
        row.className = 'hover:bg-gray-50 dark:hover:bg-gray-700';
        
        const statusColors = {
            active: 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200',
            idle: 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200',
            blocked: 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200'
        };
        
        const profileColors = {
            basic: 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200',
            premium: 'bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200',
            business: 'bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200'
        };
        
        row.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                    <input type="checkbox" class="session-checkbox rounded border-gray-300 dark:border-gray-600 mr-3" 
                           data-session-id="${session.id}" onchange="toggleSessionSelection(${session.id})">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-gray-900 dark:text-white">${session.username}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">${session.callingStationId}</div>
                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium ${profileColors[session.profile]}">
                            ${session.profile}
                        </span>
                    </div>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm">
                <div class="text-gray-900 dark:text-white">IP: ${session.ipAddress}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">MAC: ${session.macAddress}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">Protocol: ${session.framedProtocol}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm">
                <div class="text-gray-900 dark:text-white font-mono">${session.sessionTime}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">Started: ${session.startTime}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm">
                <div class="text-gray-900 dark:text-white">
                    ↓ ${formatBytes(session.downloadBytes)}
                </div>
                <div class="text-gray-500 dark:text-gray-400">
                    ↑ ${formatBytes(session.uploadBytes)}
                </div>
                <div class="text-xs text-gray-500 dark:text-gray-400">
                    ${session.downloadSpeed} / ${session.uploadSpeed}
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${statusColors[session.status]}">
                    <span class="w-2 h-2 mr-1 rounded-full ${session.status === 'active' ? 'bg-green-400 animate-pulse' : session.status === 'idle' ? 'bg-yellow-400' : 'bg-red-400'}"></span>
                    ${session.status.charAt(0).toUpperCase() + session.status.slice(1)}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                ${session.nasDevice}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-center">
                <div class="flex justify-center space-x-2">
                    <button onclick="viewSession(${session.id})" class="p-1 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded" title="View Details">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button onclick="sendUserMessage(${session.id})" class="p-1 text-green-600 hover:bg-green-50 dark:hover:bg-green-900/20 rounded" title="Send Message">
                        <i class="fas fa-comment"></i>
                    </button>
                    <button onclick="disconnectUserSession(${session.id})" class="p-1 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded" title="Disconnect">
                        <i class="fas fa-power-off"></i>
                    </button>
                </div>
            </td>
        `;
        
        return row;
    }

    function getFilteredSessions() {
        const search = document.getElementById('searchSessions').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value;
        const profileFilter = document.getElementById('profileFilter').value;
        const nasFilter = document.getElementById('nasFilter').value;
        
        return sessions.filter(session => {
            const matchesSearch = session.username.toLowerCase().includes(search) || 
                                session.ipAddress.includes(search) ||
                                session.macAddress.toLowerCase().includes(search);
            const matchesStatus = !statusFilter || session.status === statusFilter;
            const matchesProfile = !profileFilter || session.profile === profileFilter;
            const matchesNas = !nasFilter || session.nasDevice === nasFilter;
            
            return matchesSearch && matchesStatus && matchesProfile && matchesNas;
        });
    }

    function filterSessions() {
        renderSessions();
    }

    function toggleSessionSelection(sessionId) {
        if (selectedSessions.has(sessionId)) {
            selectedSessions.delete(sessionId);
        } else {
            selectedSessions.add(sessionId);
        }
    }

    function viewSession(sessionId) {
        const session = sessions.find(s => s.id === sessionId);
        if (!session) return;
        
        currentSessionId = sessionId;
        
        const details = `
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <h4 class="font-semibold text-gray-900 dark:text-white">User Information</h4>
                    <div class="space-y-2">
                        <div><span class="font-medium">Username:</span> ${session.username}</div>
                        <div><span class="font-medium">Profile:</span> ${session.profile}</div>
                        <div><span class="font-medium">Calling Station ID:</span> ${session.callingStationId}</div>
                        <div><span class="font-medium">Framed Protocol:</span> ${session.framedProtocol}</div>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <h4 class="font-semibold text-gray-900 dark:text-white">Connection Details</h4>
                    <div class="space-y-2">
                        <div><span class="font-medium">IP Address:</span> ${session.ipAddress}</div>
                        <div><span class="font-medium">MAC Address:</span> ${session.macAddress}</div>
                        <div><span class="font-medium">NAS Device:</span> ${session.nasDevice}</div>
                        <div><span class="font-medium">Status:</span> <span class="capitalize">${session.status}</span></div>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <h4 class="font-semibold text-gray-900 dark:text-white">Session Statistics</h4>
                    <div class="space-y-2">
                        <div><span class="font-medium">Session Time:</span> ${session.sessionTime}</div>
                        <div><span class="font-medium">Start Time:</span> ${session.startTime}</div>
                        <div><span class="font-medium">Download:</span> ${formatBytes(session.downloadBytes)}</div>
                        <div><span class="font-medium">Upload:</span> ${formatBytes(session.uploadBytes)}</div>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <h4 class="font-semibold text-gray-900 dark:text-white">Current Speed</h4>
                    <div class="space-y-2">
                        <div><span class="font-medium">Download Speed:</span> ${session.downloadSpeed}</div>
                        <div><span class="font-medium">Upload Speed:</span> ${session.uploadSpeed}</div>
                        <div><span class="font-medium">Total Traffic:</span> ${formatBytes(session.downloadBytes + session.uploadBytes)}</div>
                    </div>
                </div>
            </div>
        `;
        
        document.getElementById('sessionDetails').innerHTML = details;
        document.getElementById('sessionModal').classList.remove('hidden');
    }

    function sendUserMessage(sessionId) {
        currentSessionId = sessionId;
        document.getElementById('messageText').value = '';
        document.getElementById('messageModal').classList.remove('hidden');
    }

    function sendMessage() {
        const message = document.getElementById('messageText').value;
        const duration = document.getElementById('messageDuration').value;
        
        if (!message.trim()) {
            showNotification('Please enter a message', 'error');
            return;
        }
        
        const session = sessions.find(s => s.id === currentSessionId);
        if (session) {
            showNotification(`Message sent to ${session.username}`, 'success');
            closeModal('messageModal');
        }
    }

    function disconnectUserSession(sessionId) {
        const session = sessions.find(s => s.id === sessionId);
        if (!session) return;
        
        if (confirm(`Disconnect session for user "${session.username}"?`)) {
            sessions = sessions.filter(s => s.id !== sessionId);
            renderSessions();
            showNotification(`Session for ${session.username} disconnected`, 'success');
        }
    }

    function disconnectSession() {
        if (currentSessionId) {
            disconnectUserSession(currentSessionId);
            closeModal('sessionModal');
        }
    }

    function bulkDisconnect() {
        if (selectedSessions.size === 0) {
            showNotification('Please select sessions first', 'warning');
            return;
        }
        
        if (confirm(`Disconnect ${selectedSessions.size} selected sessions?`)) {
            sessions = sessions.filter(s => !selectedSessions.has(s.id));
            selectedSessions.clear();
            renderSessions();
            showNotification('Selected sessions disconnected', 'success');
        }
    }

    function bulkMessage() {
        if (selectedSessions.size === 0) {
            showNotification('Please select sessions first', 'warning');
            return;
        }
        
        currentSessionId = null; // Bulk message
        document.getElementById('messageText').value = '';
        document.getElementById('messageModal').classList.remove('hidden');
    }

    function refreshSessions() {
        // Simulate session updates
        sessions.forEach(session => {
            // Update session time
            const timeParts = session.sessionTime.split(':');
            let totalSeconds = parseInt(timeParts[0]) * 3600 + parseInt(timeParts[1]) * 60 + parseInt(timeParts[2]);
            totalSeconds += Math.floor(Math.random() * 60); // Add random seconds
            
            const hours = Math.floor(totalSeconds / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = totalSeconds % 60;
            
            session.sessionTime = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            
            // Update data usage
            session.downloadBytes += Math.floor(Math.random() * 1000000);
            session.uploadBytes += Math.floor(Math.random() * 500000);
        });
        
        renderSessions();
        updateLastUpdated();
        showNotification('Sessions refreshed', 'success');
    }

    function exportSessions() {
        showNotification('Exporting sessions...', 'info');
        setTimeout(() => {
            showNotification('Export completed! File downloaded.', 'success');
        }, 2000);
    }

    function startAutoRefresh() {
        if (autoRefreshInterval) {
            clearInterval(autoRefreshInterval);
        }
        
        autoRefreshInterval = setInterval(() => {
            refreshSessions();
        }, 30000); // 30 seconds
    }

    function stopAutoRefresh() {
        if (autoRefreshInterval) {
            clearInterval(autoRefreshInterval);
            autoRefreshInterval = null;
        }
    }

    function updateLastUpdated() {
        const now = new Date();
        document.getElementById('lastUpdated').textContent = now.toLocaleTimeString();
    }

    function formatBytes(bytes) {
        if (bytes === 0) return '0 B';
        const k = 1024;
        const sizes = ['B', 'KB', 'MB', 'GB', 'TB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    function showNotification(message, type = 'info') {
        const colors = {
            success: 'bg-green-500',
            error: 'bg-red-500',
            info: 'bg-blue-500',
            warning: 'bg-yellow-500'
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

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        const sessionModal = document.getElementById('sessionModal');
        const messageModal = document.getElementById('messageModal');
        
        if (event.target === sessionModal) {
            closeModal('sessionModal');
        }
        if (event.target === messageModal) {
            closeModal('messageModal');
        }
    });
</script>
@endpush 