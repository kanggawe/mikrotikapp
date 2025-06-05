@extends('layouts.app')

@section('title', 'PPP Users - MikroTik RADIUS Management')
@section('page_title', 'PPP Users')
@section('page_subtitle', 'Manage PPP/PPPoE user accounts')

@section('content')
<div class="content-section">
    <!-- Header with Actions -->
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">PPP User Management</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Manage PPP/PPPoE user accounts and credentials</p>
            </div>
            
            <div class="flex items-center space-x-3">
                <button onclick="addUser()" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <i class="fas fa-user-plus mr-2"></i>
                    Add User
                </button>
                <button onclick="importUsers()" class="btn-secondary">
                    <i class="fas fa-upload mr-2"></i>
                    Import
                </button>
                <button onclick="exportUsers()" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
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
                        <i class="fas fa-users text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-blue-900 dark:text-blue-100">156</h3>
                        <p class="text-blue-600 dark:text-blue-300 text-sm">Total Users</p>
                    </div>
                </div>
            </div>

            <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-green-900 dark:text-green-100">89</h3>
                        <p class="text-green-600 dark:text-green-300 text-sm">Active</p>
                    </div>
                </div>
            </div>

            <div class="bg-orange-50 dark:bg-orange-900/20 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-orange-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-wifi text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-orange-900 dark:text-orange-100">45</h3>
                        <p class="text-orange-600 dark:text-orange-300 text-sm">Online Now</p>
                    </div>
                </div>
            </div>

            <div class="bg-red-50 dark:bg-red-900/20 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-red-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-ban text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-red-900 dark:text-red-100">12</h3>
                        <p class="text-red-600 dark:text-red-300 text-sm">Disabled</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filters -->
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-64">
                <input type="text" id="searchUsers" placeholder="Search users by username or email..." 
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            </div>
            
            <select id="statusFilter" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="disabled">Disabled</option>
                <option value="expired">Expired</option>
            </select>
            
            <select id="profileFilter" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                <option value="">All Profiles</option>
                <option value="basic">Basic</option>
                <option value="premium">Premium</option>
                <option value="business">Business</option>
            </select>
            
            <select id="groupFilter" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                <option value="">All Groups</option>
                <option value="residential">Residential</option>
                <option value="corporate">Corporate</option>
                <option value="trial">Trial</option>
            </select>
        </div>
    </div>
    
    <!-- Users Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        <input type="checkbox" id="selectAll" class="rounded border-gray-300 dark:border-gray-600">
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        User Information
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Profile & Group
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Bandwidth
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Last Login
                    </th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody id="usersTableBody" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                <!-- Users will be populated by JavaScript -->
            </tbody>
        </table>
    </div>
    
    <!-- Table Footer -->
    <div class="px-6 py-3 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700 dark:text-gray-300">
                Showing <span id="showingCount">0</span> users
            </div>
            <div class="flex items-center space-x-2">
                <button onclick="bulkAction('enable')" class="btn-secondary text-sm">
                    <i class="fas fa-check mr-1"></i>
                    Enable Selected
                </button>
                <button onclick="bulkAction('disable')" class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1 rounded text-sm">
                    <i class="fas fa-pause mr-1"></i>
                    Disable Selected
                </button>
                <button onclick="bulkAction('delete')" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                    <i class="fas fa-trash mr-1"></i>
                    Delete Selected
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit User Modal -->
<div id="userModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-10 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 id="modalTitle" class="text-lg font-medium text-gray-900 dark:text-white">Add New User</h3>
                <button onclick="closeModal('userModal')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="userForm">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Information -->
                    <div class="space-y-4">
                        <h4 class="font-semibold text-gray-900 dark:text-white">Basic Information</h4>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Username *</label>
                            <input type="text" id="username" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password *</label>
                            <div class="relative">
                                <input type="password" id="password" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white pr-10">
                                <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <i class="fas fa-eye text-gray-400" id="passwordToggle"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                            <input type="email" id="email" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full Name</label>
                            <input type="text" id="fullName" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                    </div>
                    
                    <!-- Configuration -->
                    <div class="space-y-4">
                        <h4 class="font-semibold text-gray-900 dark:text-white">Configuration</h4>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Profile</label>
                            <select id="userProfile" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="basic">Basic</option>
                                <option value="premium">Premium</option>
                                <option value="business">Business</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Group</label>
                            <select id="userGroup" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="residential">Residential</option>
                                <option value="corporate">Corporate</option>
                                <option value="trial">Trial</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">IP Address (Optional)</label>
                            <input type="text" id="staticIp" placeholder="Auto assign if empty" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Expiry Date</label>
                            <input type="date" id="expiryDate" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" id="isActive" checked class="rounded border-gray-300 dark:border-gray-600 mr-2">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Account Active</label>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('userModal')" class="btn-secondary">Cancel</button>
                    <button type="button" onclick="saveUser()" class="btn-primary">Save User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let users = [];
    let selectedUsers = new Set();
    let currentUserId = null;
    let isEdit = false;

    // Sample user data
    const sampleUsers = [
        {
            id: 1,
            username: 'user001',
            email: 'user001@example.com',
            fullName: 'John Doe',
            profile: 'basic',
            group: 'residential',
            status: 'active',
            bandwidth: '10M/5M',
            lastLogin: '2024-01-16 09:30:00',
            staticIp: '192.168.1.100',
            expiryDate: '2024-12-31'
        },
        {
            id: 2,
            username: 'corp001',
            email: 'admin@company.com',
            fullName: 'Jane Smith',
            profile: 'business',
            group: 'corporate',
            status: 'active',
            bandwidth: '100M/50M',
            lastLogin: '2024-01-16 10:15:00',
            staticIp: null,
            expiryDate: '2024-12-31'
        },
        {
            id: 3,
            username: 'trial001',
            email: 'trial@test.com',
            fullName: 'Test User',
            profile: 'premium',
            group: 'trial',
            status: 'expired',
            bandwidth: '50M/25M',
            lastLogin: '2024-01-10 14:20:00',
            staticIp: null,
            expiryDate: '2024-01-15'
        }
    ];

    document.addEventListener('DOMContentLoaded', function() {
        users = [...sampleUsers];
        renderUsers();
        setupEventListeners();
    });

    function setupEventListeners() {
        // Search and filters
        document.getElementById('searchUsers').addEventListener('input', filterUsers);
        document.getElementById('statusFilter').addEventListener('change', filterUsers);
        document.getElementById('profileFilter').addEventListener('change', filterUsers);
        document.getElementById('groupFilter').addEventListener('change', filterUsers);
        
        // Select all checkbox
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.user-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
                const userId = parseInt(checkbox.dataset.userId);
                if (this.checked) {
                    selectedUsers.add(userId);
                } else {
                    selectedUsers.delete(userId);
                }
            });
        });
    }

    function renderUsers() {
        const tbody = document.getElementById('usersTableBody');
        const filteredUsers = getFilteredUsers();
        
        tbody.innerHTML = '';
        
        filteredUsers.forEach(user => {
            const row = createUserRow(user);
            tbody.appendChild(row);
        });
        
        document.getElementById('showingCount').textContent = filteredUsers.length;
    }

    function createUserRow(user) {
        const row = document.createElement('tr');
        row.className = 'hover:bg-gray-50 dark:hover:bg-gray-700';
        
        const statusColors = {
            active: 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200',
            disabled: 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200',
            expired: 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200'
        };
        
        const profileColors = {
            basic: 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200',
            premium: 'bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200',
            business: 'bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200'
        };
        
        row.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap">
                <input type="checkbox" class="user-checkbox rounded border-gray-300 dark:border-gray-600" 
                       data-user-id="${user.id}" onchange="toggleUserSelection(${user.id})">
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-gray-900 dark:text-white">${user.username}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">${user.email || 'No email'}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">${user.fullName || 'No name'}</div>
                    </div>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="space-y-1">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${profileColors[user.profile]}">
                        ${user.profile}
                    </span>
                    <div class="text-xs text-gray-500 dark:text-gray-400">${user.group}</div>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                ${user.bandwidth}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${statusColors[user.status]}">
                    ${user.status.charAt(0).toUpperCase() + user.status.slice(1)}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                <div>${user.lastLogin}</div>
                ${user.staticIp ? `<div class="text-xs">IP: ${user.staticIp}</div>` : ''}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-center">
                <div class="flex justify-center space-x-2">
                    <button onclick="editUser(${user.id})" class="p-1 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded" title="Edit User">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button onclick="toggleUserStatus(${user.id})" class="p-1 text-yellow-600 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 rounded" title="Toggle Status">
                        <i class="fas ${user.status === 'active' ? 'fa-pause' : 'fa-play'}"></i>
                    </button>
                    <button onclick="resetPassword(${user.id})" class="p-1 text-green-600 hover:bg-green-50 dark:hover:bg-green-900/20 rounded" title="Reset Password">
                        <i class="fas fa-key"></i>
                    </button>
                    <button onclick="deleteUser(${user.id})" class="p-1 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded" title="Delete User">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>
        `;
        
        return row;
    }

    function getFilteredUsers() {
        const search = document.getElementById('searchUsers').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value;
        const profileFilter = document.getElementById('profileFilter').value;
        const groupFilter = document.getElementById('groupFilter').value;
        
        return users.filter(user => {
            const matchesSearch = user.username.toLowerCase().includes(search) || 
                                (user.email && user.email.toLowerCase().includes(search)) ||
                                (user.fullName && user.fullName.toLowerCase().includes(search));
            const matchesStatus = !statusFilter || user.status === statusFilter;
            const matchesProfile = !profileFilter || user.profile === profileFilter;
            const matchesGroup = !groupFilter || user.group === groupFilter;
            
            return matchesSearch && matchesStatus && matchesProfile && matchesGroup;
        });
    }

    function filterUsers() {
        renderUsers();
    }

    function toggleUserSelection(userId) {
        if (selectedUsers.has(userId)) {
            selectedUsers.delete(userId);
        } else {
            selectedUsers.add(userId);
        }
    }

    function addUser() {
        isEdit = false;
        currentUserId = null;
        document.getElementById('modalTitle').textContent = 'Add New User';
        document.getElementById('userForm').reset();
        document.getElementById('isActive').checked = true;
        document.getElementById('userModal').classList.remove('hidden');
    }

    function editUser(userId) {
        const user = users.find(u => u.id === userId);
        if (!user) return;
        
        isEdit = true;
        currentUserId = userId;
        document.getElementById('modalTitle').textContent = 'Edit User';
        
        // Populate form
        document.getElementById('username').value = user.username;
        document.getElementById('email').value = user.email || '';
        document.getElementById('fullName').value = user.fullName || '';
        document.getElementById('userProfile').value = user.profile;
        document.getElementById('userGroup').value = user.group;
        document.getElementById('staticIp').value = user.staticIp || '';
        document.getElementById('expiryDate').value = user.expiryDate;
        document.getElementById('isActive').checked = user.status === 'active';
        
        document.getElementById('userModal').classList.remove('hidden');
    }

    function saveUser() {
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        
        if (!username || (!isEdit && !password)) {
            showNotification('Please fill in required fields', 'error');
            return;
        }
        
        const userData = {
            username: username,
            email: document.getElementById('email').value,
            fullName: document.getElementById('fullName').value,
            profile: document.getElementById('userProfile').value,
            group: document.getElementById('userGroup').value,
            staticIp: document.getElementById('staticIp').value,
            expiryDate: document.getElementById('expiryDate').value,
            status: document.getElementById('isActive').checked ? 'active' : 'disabled'
        };
        
        if (isEdit) {
            const index = users.findIndex(u => u.id === currentUserId);
            if (index !== -1) {
                users[index] = { ...users[index], ...userData };
                showNotification('User updated successfully!', 'success');
            }
        } else {
            const newUser = {
                id: users.length + 1,
                ...userData,
                bandwidth: getBandwidthByProfile(userData.profile),
                lastLogin: 'Never'
            };
            users.unshift(newUser);
            showNotification('User added successfully!', 'success');
        }
        
        renderUsers();
        closeModal('userModal');
    }

    function getBandwidthByProfile(profile) {
        const profiles = {
            basic: '10M/5M',
            premium: '50M/25M',
            business: '100M/50M'
        };
        return profiles[profile] || '10M/5M';
    }

    function toggleUserStatus(userId) {
        const user = users.find(u => u.id === userId);
        if (!user) return;
        
        user.status = user.status === 'active' ? 'disabled' : 'active';
        renderUsers();
        showNotification(`User ${user.username} ${user.status}!`, 'success');
    }

    function resetPassword(userId) {
        const user = users.find(u => u.id === userId);
        if (!user) return;
        
        if (confirm(`Reset password for user "${user.username}"?`)) {
            showNotification(`Password reset for ${user.username}`, 'success');
        }
    }

    function deleteUser(userId) {
        const user = users.find(u => u.id === userId);
        if (!user) return;
        
        if (confirm(`Are you sure you want to delete user "${user.username}"?`)) {
            users = users.filter(u => u.id !== userId);
            renderUsers();
            showNotification('User deleted successfully!', 'success');
        }
    }

    function bulkAction(action) {
        if (selectedUsers.size === 0) {
            showNotification('Please select users first', 'warning');
            return;
        }
        
        if (action === 'enable') {
            users.forEach(user => {
                if (selectedUsers.has(user.id)) {
                    user.status = 'active';
                }
            });
            showNotification(`${selectedUsers.size} users enabled!`, 'success');
        } else if (action === 'disable') {
            users.forEach(user => {
                if (selectedUsers.has(user.id)) {
                    user.status = 'disabled';
                }
            });
            showNotification(`${selectedUsers.size} users disabled!`, 'success');
        } else if (action === 'delete') {
            if (confirm(`Delete ${selectedUsers.size} selected users?`)) {
                users = users.filter(u => !selectedUsers.has(u.id));
                selectedUsers.clear();
                showNotification('Selected users deleted!', 'success');
            }
        }
        
        renderUsers();
    }

    function importUsers() {
        showNotification('Import functionality will be implemented', 'info');
    }

    function exportUsers() {
        showNotification('Exporting users...', 'info');
        setTimeout(() => {
            showNotification('Export completed! File downloaded.', 'success');
        }, 2000);
    }

    function togglePassword() {
        const passwordField = document.getElementById('password');
        const toggleIcon = document.getElementById('passwordToggle');
        
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            toggleIcon.className = 'fas fa-eye-slash text-gray-400';
        } else {
            passwordField.type = 'password';
            toggleIcon.className = 'fas fa-eye text-gray-400';
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
        const modal = document.getElementById('userModal');
        if (event.target === modal) {
            closeModal('userModal');
        }
    });
</script>
@endpush 