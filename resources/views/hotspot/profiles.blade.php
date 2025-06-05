@extends('layouts.app')

@section('title', 'Hotspot Profiles - MikroTik RADIUS Management')
@section('page_title', 'Hotspot Profiles')
@section('page_subtitle', 'Manage hotspot user profiles and limitations')

@section('content')
<div class="content-section">
    <!-- Header with Actions -->
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Profile Management</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Configure user profiles with bandwidth and time limitations</p>
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
                        <i class="fas fa-layer-group text-white"></i>
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
                        <i class="fas fa-users text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-orange-900 dark:text-orange-100">245</h3>
                        <p class="text-orange-600 dark:text-orange-300 text-sm">Users Assigned</p>
                    </div>
                </div>
            </div>

            <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-tachometer-alt text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-purple-900 dark:text-purple-100">10M</h3>
                        <p class="text-purple-600 dark:text-purple-300 text-sm">Avg Bandwidth</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filters -->
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-64">
                <input type="text" id="searchProfiles" placeholder="Search profiles by name..." 
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            </div>
            
            <select id="statusFilter" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="disabled">Disabled</option>
            </select>
            
            <select id="typeFilter" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                <option value="">All Types</option>
                <option value="time">Time-based</option>
                <option value="data">Data-based</option>
                <option value="unlimited">Unlimited</option>
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
                        Bandwidth Limit
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Time/Data Limit
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Users Count
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
                Profiles can be assigned to users and vouchers
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Profile Modal -->
<div id="profileModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-10 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 id="modalTitle" class="text-lg font-medium text-gray-900 dark:text-white">Add New Profile</h3>
                <button onclick="closeModal('profileModal')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="profileForm">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Settings -->
                    <div class="space-y-4">
                        <h4 class="font-semibold text-gray-900 dark:text-white">Basic Settings</h4>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Profile Name</label>
                            <input type="text" id="profileName" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                            <textarea id="profileDescription" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white"></textarea>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Profile Type</label>
                            <select id="profileType" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="time">Time-based</option>
                                <option value="data">Data-based</option>
                                <option value="unlimited">Unlimited</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Bandwidth Settings -->
                    <div class="space-y-4">
                        <h4 class="font-semibold text-gray-900 dark:text-white">Bandwidth Limits</h4>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Download Speed</label>
                            <div class="flex">
                                <input type="number" id="downloadSpeed" class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-l-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <select id="downloadUnit" class="px-3 py-2 border-l-0 border border-gray-300 dark:border-gray-600 rounded-r-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                    <option value="K">Kbps</option>
                                    <option value="M">Mbps</option>
                                </select>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Upload Speed</label>
                            <div class="flex">
                                <input type="number" id="uploadSpeed" class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-l-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <select id="uploadUnit" class="px-3 py-2 border-l-0 border border-gray-300 dark:border-gray-600 rounded-r-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                    <option value="K">Kbps</option>
                                    <option value="M">Mbps</option>
                                </select>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Priority</label>
                            <select id="priority" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="1">1 (Highest)</option>
                                <option value="2">2 (High)</option>
                                <option value="4">4 (Normal)</option>
                                <option value="6">6 (Low)</option>
                                <option value="8">8 (Lowest)</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Time/Data Limits -->
                    <div class="space-y-4">
                        <h4 class="font-semibold text-gray-900 dark:text-white">Time & Data Limits</h4>
                        
                        <div id="timeLimitSection">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Session Timeout</label>
                            <div class="flex">
                                <input type="number" id="sessionTimeout" class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-l-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <select id="timeoutUnit" class="px-3 py-2 border-l-0 border border-gray-300 dark:border-gray-600 rounded-r-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                    <option value="m">Minutes</option>
                                    <option value="h">Hours</option>
                                    <option value="d">Days</option>
                                </select>
                            </div>
                        </div>
                        
                        <div id="dataLimitSection" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Data Limit</label>
                            <div class="flex">
                                <input type="number" id="dataLimit" class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-l-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <select id="dataUnit" class="px-3 py-2 border-l-0 border border-gray-300 dark:border-gray-600 rounded-r-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                    <option value="MB">MB</option>
                                    <option value="GB">GB</option>
                                </select>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Idle Timeout</label>
                            <div class="flex">
                                <input type="number" id="idleTimeout" class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-l-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white" placeholder="0 = disabled">
                                <span class="px-3 py-2 border-l-0 border border-gray-300 dark:border-gray-600 rounded-r-md bg-gray-50 dark:bg-gray-600 text-gray-600 dark:text-gray-300">minutes</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Advanced Settings -->
                    <div class="space-y-4">
                        <h4 class="font-semibold text-gray-900 dark:text-white">Advanced Settings</h4>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Shared Users</label>
                            <input type="number" id="sharedUsers" min="1" value="1" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <p class="text-xs text-gray-500 mt-1">Maximum concurrent sessions per user</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">MAC Cookie Timeout</label>
                            <input type="number" id="macCookieTimeout" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white" placeholder="0 = disabled">
                            <p class="text-xs text-gray-500 mt-1">MAC address binding timeout (minutes)</p>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" id="keepaliveTimeout" class="rounded border-gray-300 dark:border-gray-600 mr-2">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Enable Keepalive Timeout</label>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" id="onlyOneAllowed" class="rounded border-gray-300 dark:border-gray-600 mr-2">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Only One User Allowed</label>
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
            name: '1hour',
            description: '1 Hour Internet Access',
            type: 'time',
            downloadSpeed: 10,
            downloadUnit: 'M',
            uploadSpeed: 5,
            uploadUnit: 'M',
            sessionTimeout: 1,
            timeoutUnit: 'h',
            priority: 4,
            sharedUsers: 1,
            status: 'active',
            usersCount: 45
        },
        {
            id: 2,
            name: '1day',
            description: '1 Day Internet Access',
            type: 'time',
            downloadSpeed: 15,
            downloadUnit: 'M',
            uploadSpeed: 10,
            uploadUnit: 'M',
            sessionTimeout: 1,
            timeoutUnit: 'd',
            priority: 4,
            sharedUsers: 2,
            status: 'active',
            usersCount: 89
        },
        {
            id: 3,
            name: '1week',
            description: '1 Week Internet Access',
            type: 'time',
            downloadSpeed: 20,
            downloadUnit: 'M',
            uploadSpeed: 15,
            uploadUnit: 'M',
            sessionTimeout: 7,
            timeoutUnit: 'd',
            priority: 2,
            sharedUsers: 1,
            status: 'active',
            usersCount: 67
        },
        {
            id: 4,
            name: 'data500mb',
            description: '500MB Data Package',
            type: 'data',
            downloadSpeed: 25,
            downloadUnit: 'M',
            uploadSpeed: 20,
            uploadUnit: 'M',
            dataLimit: 500,
            dataUnit: 'MB',
            priority: 4,
            sharedUsers: 1,
            status: 'active',
            usersCount: 23
        },
        {
            id: 5,
            name: 'unlimited',
            description: 'Unlimited Access',
            type: 'unlimited',
            downloadSpeed: 50,
            downloadUnit: 'M',
            uploadSpeed: 50,
            uploadUnit: 'M',
            priority: 1,
            sharedUsers: 1,
            status: 'disabled',
            usersCount: 0
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
        document.getElementById('typeFilter').addEventListener('change', filterProfiles);
        
        // Profile type change handler
        document.getElementById('profileType').addEventListener('change', function() {
            toggleLimitSections(this.value);
        });
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
        
        const typeColors = {
            time: 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200',
            data: 'bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200',
            unlimited: 'bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200'
        };
        
        let limitInfo = '';
        if (profile.type === 'time') {
            limitInfo = `${profile.sessionTimeout} ${profile.timeoutUnit === 'h' ? 'Hour(s)' : profile.timeoutUnit === 'd' ? 'Day(s)' : 'Min(s)'}`;
        } else if (profile.type === 'data') {
            limitInfo = `${profile.dataLimit} ${profile.dataUnit}`;
        } else {
            limitInfo = 'No Limit';
        }
        
        row.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-layer-group text-white"></i>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-gray-900 dark:text-white">${profile.name}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">${profile.description}</div>
                    </div>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900 dark:text-white">
                    ↓ ${profile.downloadSpeed}${profile.downloadUnit}bps
                </div>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    ↑ ${profile.uploadSpeed}${profile.uploadUnit}bps
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${typeColors[profile.type]}">
                    ${limitInfo}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                ${profile.usersCount}
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
        const typeFilter = document.getElementById('typeFilter').value;
        
        return profiles.filter(profile => {
            const matchesSearch = profile.name.toLowerCase().includes(search) || 
                                profile.description.toLowerCase().includes(search);
            const matchesStatus = !statusFilter || profile.status === statusFilter;
            const matchesType = !typeFilter || profile.type === typeFilter;
            
            return matchesSearch && matchesStatus && matchesType;
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
        document.getElementById('profileType').value = 'time';
        toggleLimitSections('time');
    }

    function populateForm(profile) {
        document.getElementById('profileName').value = profile.name;
        document.getElementById('profileDescription').value = profile.description;
        document.getElementById('profileType').value = profile.type;
        document.getElementById('downloadSpeed').value = profile.downloadSpeed;
        document.getElementById('downloadUnit').value = profile.downloadUnit;
        document.getElementById('uploadSpeed').value = profile.uploadSpeed;
        document.getElementById('uploadUnit').value = profile.uploadUnit;
        document.getElementById('priority').value = profile.priority;
        document.getElementById('sharedUsers').value = profile.sharedUsers;
        
        if (profile.sessionTimeout) {
            document.getElementById('sessionTimeout').value = profile.sessionTimeout;
            document.getElementById('timeoutUnit').value = profile.timeoutUnit;
        }
        
        if (profile.dataLimit) {
            document.getElementById('dataLimit').value = profile.dataLimit;
            document.getElementById('dataUnit').value = profile.dataUnit;
        }
        
        toggleLimitSections(profile.type);
    }

    function toggleLimitSections(type) {
        const timeSection = document.getElementById('timeLimitSection');
        const dataSection = document.getElementById('dataLimitSection');
        
        if (type === 'time') {
            timeSection.classList.remove('hidden');
            dataSection.classList.add('hidden');
        } else if (type === 'data') {
            timeSection.classList.add('hidden');
            dataSection.classList.remove('hidden');
        } else {
            timeSection.classList.add('hidden');
            dataSection.classList.add('hidden');
        }
    }

    function saveProfile() {
        const name = document.getElementById('profileName').value;
        const description = document.getElementById('profileDescription').value;
        const type = document.getElementById('profileType').value;
        
        if (!name) {
            showNotification('Please enter profile name', 'error');
            return;
        }
        
        const profileData = {
            name: name,
            description: description,
            type: type,
            downloadSpeed: parseInt(document.getElementById('downloadSpeed').value) || 0,
            downloadUnit: document.getElementById('downloadUnit').value,
            uploadSpeed: parseInt(document.getElementById('uploadSpeed').value) || 0,
            uploadUnit: document.getElementById('uploadUnit').value,
            priority: parseInt(document.getElementById('priority').value),
            sharedUsers: parseInt(document.getElementById('sharedUsers').value) || 1
        };
        
        if (type === 'time') {
            profileData.sessionTimeout = parseInt(document.getElementById('sessionTimeout').value);
            profileData.timeoutUnit = document.getElementById('timeoutUnit').value;
        } else if (type === 'data') {
            profileData.dataLimit = parseInt(document.getElementById('dataLimit').value);
            profileData.dataUnit = document.getElementById('dataUnit').value;
        }
        
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
                usersCount: 0
            };
            profiles.unshift(newProfile);
            showNotification('Profile added successfully!', 'success');
        }
        
        renderProfiles();
        closeModal('profileModal');
    }

    function duplicateProfile(profileId) {
        const profile = profiles.find(p => p.id === profileId);
        if (!profile) return;
        
        const newProfile = {
            ...profile,
            id: profiles.length + 1,
            name: profile.name + '_copy',
            usersCount: 0
        };
        
        profiles.unshift(newProfile);
        renderProfiles();
        showNotification(`Profile "${profile.name}" duplicated successfully!`, 'success');
    }

    function toggleProfileStatus(profileId) {
        const profile = profiles.find(p => p.id === profileId);
        if (!profile) return;
        
        profile.status = profile.status === 'active' ? 'disabled' : 'active';
        renderProfiles();
        showNotification(`Profile "${profile.name}" ${profile.status}!`, 'success');
    }

    function deleteProfile(profileId) {
        const profile = profiles.find(p => p.id === profileId);
        if (!profile) return;
        
        if (profile.usersCount > 0) {
            showNotification('Cannot delete profile with assigned users', 'error');
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