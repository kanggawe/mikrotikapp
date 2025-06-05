@extends('layouts.app')

@section('title', 'DHCP Profiles - MikroTik RADIUS Management')
@section('page_title', 'DHCP Profiles')
@section('page_subtitle', 'Manage DHCP server profiles and IP pool configurations')

@section('content')
<div class="content-section">
    <!-- Header with Actions -->
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">DHCP Profile Management</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Configure DHCP server profiles and IP address pools</p>
            </div>
            
            <div class="flex items-center space-x-3">
                <button onclick="addProfile()" class="btn-primary">
                    <i class="fas fa-plus mr-2"></i>
                    Add Profile
                </button>
                <button onclick="importProfiles()" class="btn-secondary">
                    <i class="fas fa-upload mr-2"></i>
                    Import
                </button>
                <button onclick="exportProfiles()" class="btn-secondary">
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
                        <i class="fas fa-server text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-blue-900 dark:text-blue-100">8</h3>
                        <p class="text-blue-600 dark:text-blue-300 text-sm">Total Profiles</p>
                    </div>
                </div>
            </div>

            <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-green-900 dark:text-green-100">6</h3>
                        <p class="text-green-600 dark:text-green-300 text-sm">Active</p>
                    </div>
                </div>
            </div>

            <div class="bg-orange-50 dark:bg-orange-900/20 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-orange-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-network-wired text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-orange-900 dark:text-orange-100">1,024</h3>
                        <p class="text-orange-600 dark:text-orange-300 text-sm">Total IPs</p>
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
                <input type="text" id="searchProfiles" placeholder="Search profiles by name or network..." 
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            </div>
            
            <select id="statusFilter" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="disabled">Disabled</option>
            </select>
            
            <select id="interfaceFilter" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                <option value="">All Interfaces</option>
                <option value="bridge1">bridge1</option>
                <option value="ether1">ether1</option>
                <option value="wlan1">wlan1</option>
            </select>
        </div>
    </div>
    
    <!-- Profiles Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Profile Name
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Network & Pool
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Interface & Gateway
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        DNS Servers
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Lease Settings
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody id="profilesTableBody" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                <!-- Profiles will be populated by JavaScript -->
            </tbody>
        </table>
    </div>
    
    <!-- Table Footer -->
    <div class="px-6 py-3 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700 dark:text-gray-300">
                Showing <span id="showingCount">0</span> profiles
            </div>
            <div class="text-sm text-gray-500 dark:text-gray-400">
                <i class="fas fa-info-circle mr-1"></i>
                DHCP profiles define server configurations and IP pools
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Profile Modal -->
<div id="profileModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-10 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 id="modalTitle" class="text-lg font-medium text-gray-900 dark:text-white">Add New Profile</h3>
                <button onclick="closeModal('profileModal')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="profileForm">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Basic Settings -->
                    <div class="space-y-4">
                        <h4 class="font-semibold text-gray-900 dark:text-white">Basic Settings</h4>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Profile Name *</label>
                            <input type="text" id="profileName" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Interface *</label>
                            <select id="interface" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="bridge1">bridge1</option>
                                <option value="ether1">ether1</option>
                                <option value="wlan1">wlan1</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Network Address *</label>
                            <input type="text" id="networkAddress" placeholder="192.168.1.0/24" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Gateway *</label>
                            <input type="text" id="gateway" placeholder="192.168.1.1" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Comment</label>
                            <textarea id="comment" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white"></textarea>
                        </div>
                    </div>
                    
                    <!-- IP Pool Settings -->
                    <div class="space-y-4">
                        <h4 class="font-semibold text-gray-900 dark:text-white">IP Pool Settings</h4>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pool Start *</label>
                            <input type="text" id="poolStart" placeholder="192.168.1.100" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pool End *</label>
                            <input type="text" id="poolEnd" placeholder="192.168.1.200" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Netmask</label>
                            <input type="text" id="netmask" placeholder="255.255.255.0" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Domain Name</label>
                            <input type="text" id="domainName" placeholder="local.domain" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">NTP Server</label>
                            <input type="text" id="ntpServer" placeholder="pool.ntp.org" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                    </div>
                    
                    <!-- DNS & Lease Settings -->
                    <div class="space-y-4">
                        <h4 class="font-semibold text-gray-900 dark:text-white">DNS & Lease Settings</h4>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Primary DNS</label>
                            <input type="text" id="dnsPrimary" placeholder="8.8.8.8" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Secondary DNS</label>
                            <input type="text" id="dnsSecondary" placeholder="8.8.4.4" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Lease Time</label>
                            <select id="leaseTime" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="1h">1 Hour</option>
                                <option value="12h">12 Hours</option>
                                <option value="1d">1 Day</option>
                                <option value="7d">7 Days</option>
                                <option value="30d">30 Days</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">WINS Server</label>
                            <input type="text" id="winsServer" placeholder="192.168.1.1" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input type="checkbox" id="authoritative" class="rounded border-gray-300 dark:border-gray-600 mr-2">
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Authoritative</label>
                            </div>
                            
                            <div class="flex items-center">
                                <input type="checkbox" id="addArp" class="rounded border-gray-300 dark:border-gray-600 mr-2">
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Add ARP</label>
                            </div>
                            
                            <div class="flex items-center">
                                <input type="checkbox" id="useRadius" class="rounded border-gray-300 dark:border-gray-600 mr-2">
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Use RADIUS</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('profileModal')" class="btn-secondary">Cancel</button>
                    <button type="button" onclick="saveProfile()" class="btn-primary">Save Profile</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let profiles = [];
    let currentProfileId = null;
    let isEdit = false;

    // Sample profile data
    const sampleProfiles = [
        {
            id: 1,
            name: 'LAN_DHCP',
            interface: 'bridge1',
            networkAddress: '192.168.1.0/24',
            gateway: '192.168.1.1',
            poolStart: '192.168.1.100',
            poolEnd: '192.168.1.200',
            netmask: '255.255.255.0',
            dnsPrimary: '8.8.8.8',
            dnsSecondary: '8.8.4.4',
            leaseTime: '1d',
            domainName: 'local.lan',
            ntpServer: 'pool.ntp.org',
            winsServer: '',
            authoritative: true,
            addArp: true,
            useRadius: false,
            status: 'active',
            comment: 'Main LAN DHCP server',
            poolSize: 101,
            usedIps: 67
        },
        {
            id: 2,
            name: 'GUEST_DHCP',
            interface: 'wlan1',
            networkAddress: '192.168.10.0/24',
            gateway: '192.168.10.1',
            poolStart: '192.168.10.50',
            poolEnd: '192.168.10.150',
            netmask: '255.255.255.0',
            dnsPrimary: '1.1.1.1',
            dnsSecondary: '1.0.0.1',
            leaseTime: '12h',
            domainName: 'guest.local',
            ntpServer: 'time.cloudflare.com',
            winsServer: '',
            authoritative: true,
            addArp: false,
            useRadius: true,
            status: 'active',
            comment: 'Guest network DHCP',
            poolSize: 101,
            usedIps: 23
        },
        {
            id: 3,
            name: 'OFFICE_DHCP',
            interface: 'ether1',
            networkAddress: '10.0.0.0/24',
            gateway: '10.0.0.1',
            poolStart: '10.0.0.100',
            poolEnd: '10.0.0.200',
            netmask: '255.255.255.0',
            dnsPrimary: '10.0.0.1',
            dnsSecondary: '8.8.8.8',
            leaseTime: '7d',
            domainName: 'office.local',
            ntpServer: '10.0.0.1',
            winsServer: '10.0.0.1',
            authoritative: true,
            addArp: true,
            useRadius: false,
            status: 'disabled',
            comment: 'Office network DHCP server',
            poolSize: 101,
            usedIps: 0
        }
    ];

    document.addEventListener('DOMContentLoaded', function() {
        profiles = [...sampleProfiles];
        renderProfiles();
        setupEventListeners();
    });

    function setupEventListeners() {
        // Search and filters
        document.getElementById('searchProfiles').addEventListener('input', filterProfiles);
        document.getElementById('statusFilter').addEventListener('change', filterProfiles);
        document.getElementById('interfaceFilter').addEventListener('change', filterProfiles);
    }

    function renderProfiles() {
        const tbody = document.getElementById('profilesTableBody');
        const filteredProfiles = getFilteredProfiles();
        
        tbody.innerHTML = '';
        
        filteredProfiles.forEach(profile => {
            const row = createProfileRow(profile);
            tbody.appendChild(row);
        });
        
        document.getElementById('showingCount').textContent = filteredProfiles.length;
    }

    function createProfileRow(profile) {
        const row = document.createElement('tr');
        row.className = 'hover:bg-gray-50 dark:hover:bg-gray-700';
        
        const statusColors = {
            active: 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200',
            disabled: 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200'
        };
        
        const usagePercent = Math.round((profile.usedIps / profile.poolSize) * 100);
        const usageColor = usagePercent > 80 ? 'bg-red-500' : usagePercent > 60 ? 'bg-yellow-500' : 'bg-green-500';
        
        row.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-server text-white"></i>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-gray-900 dark:text-white">${profile.name}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">${profile.comment || 'No description'}</div>
                    </div>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm">
                <div class="text-gray-900 dark:text-white">${profile.networkAddress}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">Pool: ${profile.poolStart} - ${profile.poolEnd}</div>
                <div class="flex items-center mt-1">
                    <div class="${usageColor} h-2 rounded-full" style="width: ${usagePercent}%"></div>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm">
                <div class="text-gray-900 dark:text-white">Interface: ${profile.interface}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">Gateway: ${profile.gateway}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">Netmask: ${profile.netmask}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm">
                <div class="text-gray-900 dark:text-white">Primary: ${profile.dnsPrimary}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">Secondary: ${profile.dnsSecondary}</div>
                ${profile.domainName ? `<div class="text-xs text-gray-500 dark:text-gray-400">Domain: ${profile.domainName}</div>` : ''}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm">
                <div class="text-gray-900 dark:text-white">Lease: ${profile.leaseTime}</div>
                ${profile.ntpServer ? `<div class="text-xs text-gray-500 dark:text-gray-400">NTP: ${profile.ntpServer}</div>` : ''}
                <div class="flex space-x-1 mt-1">
                    ${profile.authoritative ? '<span class="inline-flex items-center px-1 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">Auth</span>' : ''}
                    ${profile.addArp ? '<span class="inline-flex items-center px-1 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">ARP</span>' : ''}
                    ${profile.useRadius ? '<span class="inline-flex items-center px-1 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">RADIUS</span>' : ''}
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${statusColors[profile.status]}">
                    ${profile.status.charAt(0).toUpperCase() + profile.status.slice(1)}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-center">
                <div class="flex justify-center space-x-2">
                    <button onclick="editProfile(${profile.id})" class="p-1 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded" title="Edit Profile">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button onclick="duplicateProfile(${profile.id})" class="p-1 text-green-600 hover:bg-green-50 dark:hover:bg-green-900/20 rounded" title="Duplicate Profile">
                        <i class="fas fa-copy"></i>
                    </button>
                    <button onclick="toggleProfileStatus(${profile.id})" class="p-1 text-yellow-600 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 rounded" title="Toggle Status">
                        <i class="fas ${profile.status === 'active' ? 'fa-pause' : 'fa-play'}"></i>
                    </button>
                    <button onclick="deleteProfile(${profile.id})" class="p-1 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded" title="Delete Profile">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>
        `;
        
        return row;
    }

    function getFilteredProfiles() {
        const search = document.getElementById('searchProfiles').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value;
        const interfaceFilter = document.getElementById('interfaceFilter').value;
        
        return profiles.filter(profile => {
            const matchesSearch = profile.name.toLowerCase().includes(search) || 
                                profile.networkAddress.toLowerCase().includes(search) ||
                                (profile.comment && profile.comment.toLowerCase().includes(search));
            const matchesStatus = !statusFilter || profile.status === statusFilter;
            const matchesInterface = !interfaceFilter || profile.interface === interfaceFilter;
            
            return matchesSearch && matchesStatus && matchesInterface;
        });
    }

    function filterProfiles() {
        renderProfiles();
    }

    function addProfile() {
        isEdit = false;
        currentProfileId = null;
        document.getElementById('modalTitle').textContent = 'Add New Profile';
        clearForm();
        document.getElementById('profileModal').classList.remove('hidden');
    }

    function editProfile(profileId) {
        isEdit = true;
        currentProfileId = profileId;
        const profile = profiles.find(p => p.id === profileId);
        
        if (!profile) return;
        
        document.getElementById('modalTitle').textContent = 'Edit Profile';
        populateForm(profile);
        document.getElementById('profileModal').classList.remove('hidden');
    }

    function clearForm() {
        document.getElementById('profileForm').reset();
        document.getElementById('interface').value = 'bridge1';
        document.getElementById('leaseTime').value = '1d';
    }

    function populateForm(profile) {
        document.getElementById('profileName').value = profile.name;
        document.getElementById('interface').value = profile.interface;
        document.getElementById('networkAddress').value = profile.networkAddress;
        document.getElementById('gateway').value = profile.gateway;
        document.getElementById('poolStart').value = profile.poolStart;
        document.getElementById('poolEnd').value = profile.poolEnd;
        document.getElementById('netmask').value = profile.netmask;
        document.getElementById('dnsPrimary').value = profile.dnsPrimary;
        document.getElementById('dnsSecondary').value = profile.dnsSecondary;
        document.getElementById('leaseTime').value = profile.leaseTime;
        document.getElementById('domainName').value = profile.domainName || '';
        document.getElementById('ntpServer').value = profile.ntpServer || '';
        document.getElementById('winsServer').value = profile.winsServer || '';
        document.getElementById('comment').value = profile.comment || '';
        document.getElementById('authoritative').checked = profile.authoritative;
        document.getElementById('addArp').checked = profile.addArp;
        document.getElementById('useRadius').checked = profile.useRadius;
    }

    function saveProfile() {
        const name = document.getElementById('profileName').value;
        const networkAddress = document.getElementById('networkAddress').value;
        const gateway = document.getElementById('gateway').value;
        const poolStart = document.getElementById('poolStart').value;
        const poolEnd = document.getElementById('poolEnd').value;
        
        if (!name || !networkAddress || !gateway || !poolStart || !poolEnd) {
            showNotification('Please fill in required fields', 'error');
            return;
        }
        
        const profileData = {
            name: name,
            interface: document.getElementById('interface').value,
            networkAddress: networkAddress,
            gateway: gateway,
            poolStart: poolStart,
            poolEnd: poolEnd,
            netmask: document.getElementById('netmask').value,
            dnsPrimary: document.getElementById('dnsPrimary').value,
            dnsSecondary: document.getElementById('dnsSecondary').value,
            leaseTime: document.getElementById('leaseTime').value,
            domainName: document.getElementById('domainName').value,
            ntpServer: document.getElementById('ntpServer').value,
            winsServer: document.getElementById('winsServer').value,
            comment: document.getElementById('comment').value,
            authoritative: document.getElementById('authoritative').checked,
            addArp: document.getElementById('addArp').checked,
            useRadius: document.getElementById('useRadius').checked
        };
        
        if (isEdit) {
            const index = profiles.findIndex(p => p.id === currentProfileId);
            if (index !== -1) {
                profiles[index] = { ...profiles[index], ...profileData };
                showNotification('Profile updated successfully!', 'success');
            }
        } else {
            const newProfile = {
                id: profiles.length + 1,
                ...profileData,
                status: 'active',
                poolSize: calculatePoolSize(poolStart, poolEnd),
                usedIps: 0
            };
            profiles.unshift(newProfile);
            showNotification('Profile added successfully!', 'success');
        }
        
        renderProfiles();
        closeModal('profileModal');
    }

    function calculatePoolSize(start, end) {
        // Simple calculation for demonstration
        const startParts = start.split('.');
        const endParts = end.split('.');
        const startNum = parseInt(startParts[3]);
        const endNum = parseInt(endParts[3]);
        return endNum - startNum + 1;
    }

    function duplicateProfile(profileId) {
        const profile = profiles.find(p => p.id === profileId);
        if (!profile) return;
        
        const newProfile = {
            ...profile,
            id: profiles.length + 1,
            name: profile.name + '_copy',
            usedIps: 0
        };
        
        profiles.unshift(newProfile);
        renderProfiles();
        showNotification(`Profile "${profile.name}" duplicated successfully!`, 'success');
    }

    function toggleProfileStatus(profileId) {
        const profile = profiles.find(p => p.id === profileId);
        if (!profile) return;
        
        profile.status = profile.status === 'active' ? 'disabled' : 'active';
        if (profile.status === 'disabled') {
            profile.usedIps = 0; // Clear usage when disabled
        }
        renderProfiles();
        showNotification(`Profile "${profile.name}" ${profile.status}!`, 'success');
    }

    function deleteProfile(profileId) {
        const profile = profiles.find(p => p.id === profileId);
        if (!profile) return;
        
        if (profile.usedIps > 0) {
            showNotification('Cannot delete profile with active leases', 'error');
            return;
        }
        
        if (confirm(`Are you sure you want to delete profile "${profile.name}"?`)) {
            profiles = profiles.filter(p => p.id !== profileId);
            renderProfiles();
            showNotification('Profile deleted successfully!', 'success');
        }
    }

    function importProfiles() {
        showNotification('Import functionality will be implemented', 'info');
    }

    function exportProfiles() {
        showNotification('Exporting profiles...', 'info');
        
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
        const modal = document.getElementById('profileModal');
        if (event.target === modal) {
            closeModal('profileModal');
        }
    });
</script>
@endpush 