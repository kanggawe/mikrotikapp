@extends('layouts.app')

@section('title', 'DHCP Sessions - MikroTik RADIUS Management')
@section('page_title', 'DHCP Sessions')
@section('page_subtitle', 'Monitor active DHCP leases and client connections')

@section('content')
<div class="content-section">
    <!-- Header with Actions -->
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">DHCP Session Monitoring</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Real-time monitoring of DHCP client sessions and lease status</p>
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
                        <i class="fas fa-network-wired text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-blue-900 dark:text-blue-100">89</h3>
                        <p class="text-blue-600 dark:text-blue-300 text-sm">Active Leases</p>
                    </div>
                </div>
            </div>

            <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-green-900 dark:text-green-100">67</h3>
                        <p class="text-green-600 dark:text-green-300 text-sm">Bound</p>
                    </div>
                </div>
            </div>

            <div class="bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-yellow-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-yellow-900 dark:text-yellow-100">15</h3>
                        <p class="text-yellow-600 dark:text-yellow-300 text-sm">Waiting</p>
                    </div>
                </div>
            </div>

            <div class="bg-red-50 dark:bg-red-900/20 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-red-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-times-circle text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-red-900 dark:text-red-100">7</h3>
                        <p class="text-red-600 dark:text-red-300 text-sm">Expired</p>
                    </div>
                </div>
            </div>

            <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-percentage text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-purple-900 dark:text-purple-100">67%</h3>
                        <p class="text-purple-600 dark:text-purple-300 text-sm">Pool Usage</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filters -->
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-64">
                <input type="text" id="searchSessions" placeholder="Search by IP, MAC, or hostname..." 
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            </div>
            
            <select id="statusFilter" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                <option value="">All Status</option>
                <option value="bound">Bound</option>
                <option value="waiting">Waiting</option>
                <option value="expired">Expired</option>
            </select>
            
            <select id="serverFilter" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                <option value="">All Servers</option>
                <option value="dhcp-server1">DHCP Server 1</option>
                <option value="dhcp-server2">DHCP Server 2</option>
            </select>
            
            <select id="typeFilter" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                <option value="">All Types</option>
                <option value="static">Static</option>
                <option value="dynamic">Dynamic</option>
            </select>
        </div>
    </div>
    
    <!-- Sessions Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Device Information
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Network Details
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Lease Information
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Server & Type
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Activity
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
                <button onclick="bulkRelease()" class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1 rounded text-sm">
                    <i class="fas fa-unlock mr-1"></i>
                    Release Selected
                </button>
                <button onclick="bulkRenew()" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                    <i class="fas fa-redo mr-1"></i>
                    Renew Selected
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
                <button onclick="renewLease()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                    <i class="fas fa-redo mr-2"></i>
                    Renew Lease
                </button>
                <button onclick="releaseLease()" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded">
                    <i class="fas fa-unlock mr-2"></i>
                    Release Lease
                </button>
            </div>
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
            hostname: 'laptop-john',
            macAddress: '00:11:22:33:44:55',
            ipAddress: '192.168.1.100',
            clientId: 'john-laptop',
            status: 'bound',
            type: 'static',
            server: 'dhcp-server1',
            leaseTime: '1d',
            expiresAt: '2024-01-17 09:30:00',
            lastSeen: '2024-01-16 09:30:00',
            requestedAt: '2024-01-16 09:29:45',
            renewals: 3,
            vendor: 'Dell Inc.',
            interface: 'bridge1'
        },
        {
            id: 2,
            hostname: 'phone-jane',
            macAddress: '00:AA:BB:CC:DD:EE',
            ipAddress: '192.168.1.150',
            clientId: '',
            status: 'bound',
            type: 'dynamic',
            server: 'dhcp-server1',
            leaseTime: '12h',
            expiresAt: '2024-01-16 21:15:00',
            lastSeen: '2024-01-16 09:15:00',
            requestedAt: '2024-01-16 09:14:30',
            renewals: 1,
            vendor: 'Apple, Inc.',
            interface: 'wlan1'
        },
        {
            id: 3,
            hostname: 'printer-office',
            macAddress: '00:FF:EE:DD:CC:BB',
            ipAddress: '192.168.1.200',
            clientId: 'office-printer',
            status: 'waiting',
            type: 'static',
            server: 'dhcp-server2',
            leaseTime: 'infinite',
            expiresAt: 'Never',
            lastSeen: '2024-01-16 08:00:00',
            requestedAt: '2024-01-16 07:59:30',
            renewals: 0,
            vendor: 'HP Inc.',
            interface: 'ether1'
        },
        {
            id: 4,
            hostname: 'guest-device',
            macAddress: '00:12:34:56:78:90',
            ipAddress: '192.168.10.50',
            clientId: '',
            status: 'expired',
            type: 'dynamic',
            server: 'dhcp-server1',
            leaseTime: '2h',
            expiresAt: '2024-01-16 08:00:00',
            lastSeen: '2024-01-16 06:00:00',
            requestedAt: '2024-01-16 05:59:45',
            renewals: 0,
            vendor: 'Unknown',
            interface: 'wlan1'
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
        document.getElementById('serverFilter').addEventListener('change', filterSessions);
        document.getElementById('typeFilter').addEventListener('change', filterSessions);
        
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
            bound: 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200',
            waiting: 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200',
            expired: 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200'
        };
        
        const typeColors = {
            static: 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200',
            dynamic: 'bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200'
        };
        
        const timeRemaining = calculateTimeRemaining(session.expiresAt);
        
        row.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                    <input type="checkbox" class="session-checkbox rounded border-gray-300 dark:border-gray-600 mr-3" 
                           data-session-id="${session.id}" onchange="toggleSessionSelection(${session.id})">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-desktop text-white"></i>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-gray-900 dark:text-white">${session.hostname || 'Unknown'}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">MAC: ${session.macAddress}</div>
                        ${session.vendor ? `<div class="text-xs text-gray-500 dark:text-gray-400">${session.vendor}</div>` : ''}
                    </div>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm">
                <div class="text-gray-900 dark:text-white">IP: ${session.ipAddress}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">Interface: ${session.interface}</div>
                ${session.clientId ? `<div class="text-xs text-gray-500 dark:text-gray-400">Client ID: ${session.clientId}</div>` : ''}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm">
                <div class="text-gray-900 dark:text-white">Expires: ${session.expiresAt}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">Remaining: ${timeRemaining}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">Renewals: ${session.renewals}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm">
                <div class="text-gray-900 dark:text-white">${session.server}</div>
                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium ${typeColors[session.type]}">
                    ${session.type}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${statusColors[session.status]}">
                    <span class="w-2 h-2 mr-1 rounded-full ${session.status === 'bound' ? 'bg-green-400 animate-pulse' : session.status === 'waiting' ? 'bg-yellow-400' : 'bg-red-400'}"></span>
                    ${session.status.charAt(0).toUpperCase() + session.status.slice(1)}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm">
                <div class="text-gray-900 dark:text-white">Last seen: ${session.lastSeen}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">Requested: ${session.requestedAt}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-center">
                <div class="flex justify-center space-x-2">
                    <button onclick="viewSession(${session.id})" class="p-1 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded" title="View Details">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button onclick="renewSession(${session.id})" class="p-1 text-green-600 hover:bg-green-50 dark:hover:bg-green-900/20 rounded" title="Renew Lease">
                        <i class="fas fa-redo"></i>
                    </button>
                    <button onclick="releaseSession(${session.id})" class="p-1 text-yellow-600 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 rounded" title="Release Lease">
                        <i class="fas fa-unlock"></i>
                    </button>
                </div>
            </td>
        `;
        
        return row;
    }

    function getFilteredSessions() {
        const search = document.getElementById('searchSessions').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value;
        const serverFilter = document.getElementById('serverFilter').value;
        const typeFilter = document.getElementById('typeFilter').value;
        
        return sessions.filter(session => {
            const matchesSearch = session.ipAddress.includes(search) || 
                                session.macAddress.toLowerCase().includes(search) ||
                                (session.hostname && session.hostname.toLowerCase().includes(search));
            const matchesStatus = !statusFilter || session.status === statusFilter;
            const matchesServer = !serverFilter || session.server === serverFilter;
            const matchesType = !typeFilter || session.type === typeFilter;
            
            return matchesSearch && matchesStatus && matchesServer && matchesType;
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
                    <h4 class="font-semibold text-gray-900 dark:text-white">Device Information</h4>
                    <div class="space-y-2">
                        <div><span class="font-medium">Hostname:</span> ${session.hostname || 'Unknown'}</div>
                        <div><span class="font-medium">MAC Address:</span> ${session.macAddress}</div>
                        <div><span class="font-medium">IP Address:</span> ${session.ipAddress}</div>
                        <div><span class="font-medium">Client ID:</span> ${session.clientId || 'None'}</div>
                        <div><span class="font-medium">Vendor:</span> ${session.vendor || 'Unknown'}</div>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <h4 class="font-semibold text-gray-900 dark:text-white">Lease Details</h4>
                    <div class="space-y-2">
                        <div><span class="font-medium">Status:</span> <span class="capitalize">${session.status}</span></div>
                        <div><span class="font-medium">Type:</span> <span class="capitalize">${session.type}</span></div>
                        <div><span class="font-medium">Server:</span> ${session.server}</div>
                        <div><span class="font-medium">Interface:</span> ${session.interface}</div>
                        <div><span class="font-medium">Lease Time:</span> ${session.leaseTime}</div>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <h4 class="font-semibold text-gray-900 dark:text-white">Timing Information</h4>
                    <div class="space-y-2">
                        <div><span class="font-medium">Expires At:</span> ${session.expiresAt}</div>
                        <div><span class="font-medium">Last Seen:</span> ${session.lastSeen}</div>
                        <div><span class="font-medium">Requested At:</span> ${session.requestedAt}</div>
                        <div><span class="font-medium">Renewals:</span> ${session.renewals}</div>
                        <div><span class="font-medium">Time Remaining:</span> ${calculateTimeRemaining(session.expiresAt)}</div>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <h4 class="font-semibold text-gray-900 dark:text-white">Network Information</h4>
                    <div class="space-y-2">
                        <div><span class="font-medium">DHCP Server:</span> ${session.server}</div>
                        <div><span class="font-medium">Network Interface:</span> ${session.interface}</div>
                        <div><span class="font-medium">Assignment Type:</span> ${session.type}</div>
                        <div><span class="font-medium">Current Status:</span> ${session.status}</div>
                    </div>
                </div>
            </div>
        `;
        
        document.getElementById('sessionDetails').innerHTML = details;
        document.getElementById('sessionModal').classList.remove('hidden');
    }

    function renewSession(sessionId) {
        const session = sessions.find(s => s.id === sessionId);
        if (!session) return;
        
        session.renewals += 1;
        session.lastSeen = new Date().toLocaleString();
        
        // Extend expiry time
        if (session.expiresAt !== 'Never') {
            const now = new Date();
            const leaseTimeMap = {
                '1h': 1 * 60 * 60 * 1000,
                '12h': 12 * 60 * 60 * 1000,
                '1d': 24 * 60 * 60 * 1000,
                '2h': 2 * 60 * 60 * 1000
            };
            const newExpiry = new Date(now.getTime() + leaseTimeMap[session.leaseTime]);
            session.expiresAt = newExpiry.toLocaleString();
        }
        
        renderSessions();
        showNotification(`Lease renewed for ${session.hostname || session.ipAddress}`, 'success');
    }

    function releaseSession(sessionId) {
        const session = sessions.find(s => s.id === sessionId);
        if (!session) return;
        
        if (confirm(`Release lease for ${session.hostname || session.ipAddress}?`)) {
            session.status = 'expired';
            renderSessions();
            showNotification(`Lease released for ${session.hostname || session.ipAddress}`, 'success');
        }
    }

    function renewLease() {
        if (currentSessionId) {
            renewSession(currentSessionId);
            closeModal('sessionModal');
        }
    }

    function releaseLease() {
        if (currentSessionId) {
            releaseSession(currentSessionId);
            closeModal('sessionModal');
        }
    }

    function bulkRenew() {
        if (selectedSessions.size === 0) {
            showNotification('Please select sessions first', 'warning');
            return;
        }
        
        sessions.forEach(session => {
            if (selectedSessions.has(session.id)) {
                session.renewals += 1;
                session.lastSeen = new Date().toLocaleString();
            }
        });
        
        selectedSessions.clear();
        renderSessions();
        showNotification('Selected leases renewed', 'success');
    }

    function bulkRelease() {
        if (selectedSessions.size === 0) {
            showNotification('Please select sessions first', 'warning');
            return;
        }
        
        if (confirm(`Release ${selectedSessions.size} selected leases?`)) {
            sessions.forEach(session => {
                if (selectedSessions.has(session.id)) {
                    session.status = 'expired';
                }
            });
            selectedSessions.clear();
            renderSessions();
            showNotification('Selected leases released', 'success');
        }
    }

    function refreshSessions() {
        // Simulate session updates
        sessions.forEach(session => {
            if (session.status === 'bound' && Math.random() < 0.3) {
                session.lastSeen = new Date().toLocaleString();
            }
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

    function calculateTimeRemaining(expiresAt) {
        if (expiresAt === 'Never') return 'Never';
        
        const now = new Date();
        const expiry = new Date(expiresAt);
        const diff = expiry - now;
        
        if (diff <= 0) return 'Expired';
        
        const hours = Math.floor(diff / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        
        if (hours > 24) {
            const days = Math.floor(hours / 24);
            return `${days}d ${hours % 24}h`;
        } else if (hours > 0) {
            return `${hours}h ${minutes}m`;
        } else {
            return `${minutes}m`;
        }
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
        const modal = document.getElementById('sessionModal');
        if (event.target === modal) {
            closeModal('sessionModal');
        }
    });
</script>
@endpush 