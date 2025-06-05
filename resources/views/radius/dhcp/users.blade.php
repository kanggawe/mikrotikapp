@extends('layouts.app')

@section('title', 'DHCP Users - MikroTik RADIUS Management')
@section('page_title', 'DHCP Users')
@section('page_subtitle', 'Manage DHCP leases and user assignments')

@section('content')
<div class="content-section">
    <!-- Header with Actions -->
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">DHCP User Management</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Manage DHCP leases and static assignments</p>
            </div>
            
            <div class="flex items-center space-x-3">
                <button onclick="addLease()" class="btn-primary">
                    <i class="fas fa-plus mr-2"></i>
                    Add Static Lease
                </button>
                <button onclick="refreshLeases()" class="btn-secondary">
                    <i class="fas fa-sync-alt mr-2"></i>
                    Refresh
                </button>
                <button onclick="exportLeases()" class="btn-secondary">
                    <i class="fas fa-download mr-2"></i>
                    Export
                </button>
            </div>
        </div>
    </div>
    
    <!-- Stats Cards -->
    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-network-wired text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-blue-900 dark:text-blue-100">89</h3>
                        <p class="text-blue-600 dark:text-blue-300 text-sm">Total Leases</p>
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
                        <p class="text-green-600 dark:text-green-300 text-sm">Active</p>
                    </div>
                </div>
            </div>

            <div class="bg-orange-50 dark:bg-orange-900/20 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-orange-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-lock text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-orange-900 dark:text-orange-100">22</h3>
                        <p class="text-orange-600 dark:text-orange-300 text-sm">Static</p>
                    </div>
                </div>
            </div>

            <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-purple-900 dark:text-purple-100">45</h3>
                        <p class="text-purple-600 dark:text-purple-300 text-sm">Dynamic</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filters -->
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-64">
                <input type="text" id="searchLeases" placeholder="Search by IP, MAC, or hostname..." 
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            </div>
            
            <select id="statusFilter" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                <option value="">All Status</option>
                <option value="bound">Bound</option>
                <option value="waiting">Waiting</option>
                <option value="expired">Expired</option>
            </select>
            
            <select id="typeFilter" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                <option value="">All Types</option>
                <option value="static">Static</option>
                <option value="dynamic">Dynamic</option>
            </select>
            
            <select id="serverFilter" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                <option value="">All Servers</option>
                <option value="dhcp-server1">DHCP Server 1</option>
                <option value="dhcp-server2">DHCP Server 2</option>
            </select>
        </div>
    </div>
    
    <!-- Leases Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        <input type="checkbox" id="selectAll" class="rounded border-gray-300 dark:border-gray-600">
                    </th>
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
                        Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Server
                    </th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody id="leasesTableBody" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                <!-- Leases will be populated by JavaScript -->
            </tbody>
        </table>
    </div>
    
    <!-- Table Footer -->
    <div class="px-6 py-3 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700 dark:text-gray-300">
                Showing <span id="showingCount">0</span> leases
            </div>
            <div class="flex items-center space-x-2">
                <button onclick="bulkAction('release')" class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1 rounded text-sm">
                    <i class="fas fa-unlock mr-1"></i>
                    Release Selected
                </button>
                <button onclick="bulkAction('delete')" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                    <i class="fas fa-trash mr-1"></i>
                    Delete Selected
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Lease Modal -->
<div id="leaseModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-10 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 id="modalTitle" class="text-lg font-medium text-gray-900 dark:text-white">Add Static Lease</h3>
                <button onclick="closeModal('leaseModal')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="leaseForm">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Device Information -->
                    <div class="space-y-4">
                        <h4 class="font-semibold text-gray-900 dark:text-white">Device Information</h4>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">MAC Address *</label>
                            <input type="text" id="macAddress" placeholder="00:11:22:33:44:55" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">IP Address *</label>
                            <input type="text" id="ipAddress" placeholder="192.168.1.100" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Hostname</label>
                            <input type="text" id="hostname" placeholder="device-name" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Client ID</label>
                            <input type="text" id="clientId" placeholder="Optional client identifier" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                    </div>
                    
                    <!-- Lease Configuration -->
                    <div class="space-y-4">
                        <h4 class="font-semibold text-gray-900 dark:text-white">Lease Configuration</h4>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">DHCP Server</label>
                            <select id="dhcpServer" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="dhcp-server1">DHCP Server 1</option>
                                <option value="dhcp-server2">DHCP Server 2</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Lease Time</label>
                            <select id="leaseTime" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="1h">1 Hour</option>
                                <option value="12h">12 Hours</option>
                                <option value="1d">1 Day</option>
                                <option value="7d">7 Days</option>
                                <option value="30d">30 Days</option>
                                <option value="infinite">Infinite</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Comment</label>
                            <textarea id="comment" rows="3" placeholder="Optional comment..." class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white"></textarea>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" id="isStatic" checked class="rounded border-gray-300 dark:border-gray-600 mr-2">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Static Lease</label>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" id="isBlocked" class="rounded border-gray-300 dark:border-gray-600 mr-2">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Block Access</label>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('leaseModal')" class="btn-secondary">Cancel</button>
                    <button type="button" onclick="saveLease()" class="btn-primary">Save Lease</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let leases = [];
    let selectedLeases = new Set();
    let currentLeaseId = null;
    let isEdit = false;

    // Sample lease data
    const sampleLeases = [
        {
            id: 1,
            macAddress: '00:11:22:33:44:55',
            ipAddress: '192.168.1.100',
            hostname: 'laptop-john',
            clientId: 'john-laptop',
            status: 'bound',
            type: 'static',
            server: 'dhcp-server1',
            leaseTime: '1d',
            expiresAt: '2024-01-17 09:30:00',
            lastSeen: '2024-01-16 09:30:00',
            comment: 'John\'s work laptop'
        },
        {
            id: 2,
            macAddress: '00:AA:BB:CC:DD:EE',
            ipAddress: '192.168.1.150',
            hostname: 'phone-jane',
            clientId: '',
            status: 'bound',
            type: 'dynamic',
            server: 'dhcp-server1',
            leaseTime: '12h',
            expiresAt: '2024-01-16 21:15:00',
            lastSeen: '2024-01-16 09:15:00',
            comment: ''
        },
        {
            id: 3,
            macAddress: '00:FF:EE:DD:CC:BB',
            ipAddress: '192.168.1.200',
            hostname: 'printer-office',
            clientId: 'office-printer',
            status: 'bound',
            type: 'static',
            server: 'dhcp-server2',
            leaseTime: 'infinite',
            expiresAt: 'Never',
            lastSeen: '2024-01-16 08:00:00',
            comment: 'Office network printer'
        }
    ];

    document.addEventListener('DOMContentLoaded', function() {
        leases = [...sampleLeases];
        renderLeases();
        setupEventListeners();
    });

    function setupEventListeners() {
        // Search and filters
        document.getElementById('searchLeases').addEventListener('input', filterLeases);
        document.getElementById('statusFilter').addEventListener('change', filterLeases);
        document.getElementById('typeFilter').addEventListener('change', filterLeases);
        document.getElementById('serverFilter').addEventListener('change', filterLeases);
        
        // Select all checkbox
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.lease-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
                const leaseId = parseInt(checkbox.dataset.leaseId);
                if (this.checked) {
                    selectedLeases.add(leaseId);
                } else {
                    selectedLeases.delete(leaseId);
                }
            });
        });
    }

    function renderLeases() {
        const tbody = document.getElementById('leasesTableBody');
        const filteredLeases = getFilteredLeases();
        
        tbody.innerHTML = '';
        
        filteredLeases.forEach(lease => {
            const row = createLeaseRow(lease);
            tbody.appendChild(row);
        });
        
        document.getElementById('showingCount').textContent = filteredLeases.length;
    }

    function createLeaseRow(lease) {
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
        
        row.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap">
                <input type="checkbox" class="lease-checkbox rounded border-gray-300 dark:border-gray-600" 
                       data-lease-id="${lease.id}" onchange="toggleLeaseSelection(${lease.id})">
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-desktop text-white"></i>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-gray-900 dark:text-white">${lease.hostname || 'Unknown'}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">MAC: ${lease.macAddress}</div>
                        ${lease.clientId ? `<div class="text-xs text-gray-500 dark:text-gray-400">ID: ${lease.clientId}</div>` : ''}
                    </div>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm">
                <div class="text-gray-900 dark:text-white">IP: ${lease.ipAddress}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">Server: ${lease.server}</div>
                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium ${typeColors[lease.type]}">
                    ${lease.type}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm">
                <div class="text-gray-900 dark:text-white">Expires: ${lease.expiresAt}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">Last seen: ${lease.lastSeen}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">Lease: ${lease.leaseTime}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${statusColors[lease.status]}">
                    ${lease.status.charAt(0).toUpperCase() + lease.status.slice(1)}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                ${lease.server}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-center">
                <div class="flex justify-center space-x-2">
                    <button onclick="editLease(${lease.id})" class="p-1 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded" title="Edit Lease">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button onclick="releaseLease(${lease.id})" class="p-1 text-yellow-600 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 rounded" title="Release Lease">
                        <i class="fas fa-unlock"></i>
                    </button>
                    <button onclick="deleteLease(${lease.id})" class="p-1 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded" title="Delete Lease">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>
        `;
        
        return row;
    }

    function getFilteredLeases() {
        const search = document.getElementById('searchLeases').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value;
        const typeFilter = document.getElementById('typeFilter').value;
        const serverFilter = document.getElementById('serverFilter').value;
        
        return leases.filter(lease => {
            const matchesSearch = lease.ipAddress.includes(search) || 
                                lease.macAddress.toLowerCase().includes(search) ||
                                (lease.hostname && lease.hostname.toLowerCase().includes(search));
            const matchesStatus = !statusFilter || lease.status === statusFilter;
            const matchesType = !typeFilter || lease.type === typeFilter;
            const matchesServer = !serverFilter || lease.server === serverFilter;
            
            return matchesSearch && matchesStatus && matchesType && matchesServer;
        });
    }

    function filterLeases() {
        renderLeases();
    }

    function toggleLeaseSelection(leaseId) {
        if (selectedLeases.has(leaseId)) {
            selectedLeases.delete(leaseId);
        } else {
            selectedLeases.add(leaseId);
        }
    }

    function addLease() {
        isEdit = false;
        currentLeaseId = null;
        document.getElementById('modalTitle').textContent = 'Add Static Lease';
        document.getElementById('leaseForm').reset();
        document.getElementById('isStatic').checked = true;
        document.getElementById('leaseModal').classList.remove('hidden');
    }

    function editLease(leaseId) {
        const lease = leases.find(l => l.id === leaseId);
        if (!lease) return;
        
        isEdit = true;
        currentLeaseId = leaseId;
        document.getElementById('modalTitle').textContent = 'Edit Lease';
        
        // Populate form
        document.getElementById('macAddress').value = lease.macAddress;
        document.getElementById('ipAddress').value = lease.ipAddress;
        document.getElementById('hostname').value = lease.hostname || '';
        document.getElementById('clientId').value = lease.clientId || '';
        document.getElementById('dhcpServer').value = lease.server;
        document.getElementById('leaseTime').value = lease.leaseTime;
        document.getElementById('comment').value = lease.comment || '';
        document.getElementById('isStatic').checked = lease.type === 'static';
        
        document.getElementById('leaseModal').classList.remove('hidden');
    }

    function saveLease() {
        const macAddress = document.getElementById('macAddress').value;
        const ipAddress = document.getElementById('ipAddress').value;
        
        if (!macAddress || !ipAddress) {
            showNotification('Please fill in required fields', 'error');
            return;
        }
        
        const leaseData = {
            macAddress: macAddress,
            ipAddress: ipAddress,
            hostname: document.getElementById('hostname').value,
            clientId: document.getElementById('clientId').value,
            server: document.getElementById('dhcpServer').value,
            leaseTime: document.getElementById('leaseTime').value,
            comment: document.getElementById('comment').value,
            type: document.getElementById('isStatic').checked ? 'static' : 'dynamic',
            status: 'bound'
        };
        
        if (isEdit) {
            const index = leases.findIndex(l => l.id === currentLeaseId);
            if (index !== -1) {
                leases[index] = { ...leases[index], ...leaseData };
                showNotification('Lease updated successfully!', 'success');
            }
        } else {
            const newLease = {
                id: leases.length + 1,
                ...leaseData,
                expiresAt: calculateExpiry(leaseData.leaseTime),
                lastSeen: new Date().toLocaleString()
            };
            leases.unshift(newLease);
            showNotification('Lease added successfully!', 'success');
        }
        
        renderLeases();
        closeModal('leaseModal');
    }

    function calculateExpiry(leaseTime) {
        if (leaseTime === 'infinite') return 'Never';
        
        const now = new Date();
        const timeMap = {
            '1h': 1 * 60 * 60 * 1000,
            '12h': 12 * 60 * 60 * 1000,
            '1d': 24 * 60 * 60 * 1000,
            '7d': 7 * 24 * 60 * 60 * 1000,
            '30d': 30 * 24 * 60 * 60 * 1000
        };
        
        const expiry = new Date(now.getTime() + timeMap[leaseTime]);
        return expiry.toLocaleString();
    }

    function releaseLease(leaseId) {
        const lease = leases.find(l => l.id === leaseId);
        if (!lease) return;
        
        if (confirm(`Release lease for ${lease.ipAddress} (${lease.hostname || 'Unknown'})?`)) {
            lease.status = 'expired';
            renderLeases();
            showNotification(`Lease for ${lease.ipAddress} released`, 'success');
        }
    }

    function deleteLease(leaseId) {
        const lease = leases.find(l => l.id === leaseId);
        if (!lease) return;
        
        if (confirm(`Are you sure you want to delete lease for ${lease.ipAddress}?`)) {
            leases = leases.filter(l => l.id !== leaseId);
            renderLeases();
            showNotification('Lease deleted successfully!', 'success');
        }
    }

    function bulkAction(action) {
        if (selectedLeases.size === 0) {
            showNotification('Please select leases first', 'warning');
            return;
        }
        
        if (action === 'release') {
            if (confirm(`Release ${selectedLeases.size} selected leases?`)) {
                leases.forEach(lease => {
                    if (selectedLeases.has(lease.id)) {
                        lease.status = 'expired';
                    }
                });
                showNotification(`${selectedLeases.size} leases released!`, 'success');
            }
        } else if (action === 'delete') {
            if (confirm(`Delete ${selectedLeases.size} selected leases?`)) {
                leases = leases.filter(l => !selectedLeases.has(l.id));
                selectedLeases.clear();
                showNotification('Selected leases deleted!', 'success');
            }
        }
        
        renderLeases();
    }

    function refreshLeases() {
        // Simulate lease updates
        leases.forEach(lease => {
            if (lease.status === 'bound' && Math.random() < 0.1) {
                lease.lastSeen = new Date().toLocaleString();
            }
        });
        
        renderLeases();
        showNotification('Leases refreshed', 'success');
    }

    function exportLeases() {
        showNotification('Exporting leases...', 'info');
        setTimeout(() => {
            showNotification('Export completed! File downloaded.', 'success');
        }, 2000);
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
        const modal = document.getElementById('leaseModal');
        if (event.target === modal) {
            closeModal('leaseModal');
        }
    });
</script>
@endpush 