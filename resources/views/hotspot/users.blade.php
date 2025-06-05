@extends('layouts.app')

@section('title', 'Hotspot Users & Vouchers - MikroTik RADIUS Management')
@section('page_title', 'Hotspot Users & Vouchers')
@section('page_subtitle', 'Manage hotspot users and generate vouchers')

@section('content')
<div class="content-section">
    <!-- Header with Actions -->
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">User & Voucher Management</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Manage hotspot users and generate access vouchers</p>
            </div>
            
            <div class="flex items-center space-x-3">
                <button onclick="addUser()" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200 btn-secondary">
                    <i class="fas fa-user-plus mr-2"></i>
                    Add User
                </button>
                <button onclick="generateVouchers()" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200 btn-primary">
                    <i class="fas fa-ticket-alt mr-2"></i>
                    Generate Vouchers
                </button>
                <button onclick="printSelected()" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200 btn-secondary">
                    <i class="fas fa-print mr-2"></i>
                    Print Selected
                </button>
            </div>
        </div>
    </div>
    
    <!-- Tabs -->
    <div class="border-b border-gray-200 dark:border-gray-700">
        <nav class="-mb-px flex space-x-8 px-6">
            <button onclick="switchTab('users')" id="usersTab" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200 py-4 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600 dark:text-blue-400">
                <i class="fas fa-users mr-2"></i>
                Users
            </button>
            <button onclick="switchTab('vouchers')" id="vouchersTab" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200 py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                <i class="fas fa-ticket-alt mr-2"></i>
                Vouchers
            </button>
        </nav>
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
                        <h3 class="text-xl font-bold text-blue-900 dark:text-blue-100">45</h3>
                        <p class="text-blue-600 dark:text-blue-300 text-sm">Total Users</p>
                    </div>
                </div>
            </div>

            <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-wifi text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-green-900 dark:text-green-100">23</h3>
                        <p class="text-green-600 dark:text-green-300 text-sm">Online Now</p>
                    </div>
                </div>
            </div>

            <div class="bg-orange-50 dark:bg-orange-900/20 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-orange-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-ticket-alt text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-orange-900 dark:text-orange-100">128</h3>
                        <p class="text-orange-600 dark:text-orange-300 text-sm">Active Vouchers</p>
                    </div>
                </div>
            </div>

            <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-purple-900 dark:text-purple-100">89</h3>
                        <p class="text-purple-600 dark:text-purple-300 text-sm">Used Today</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filters -->
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-64">
                <input type="text" id="searchInput" placeholder="Search users or vouchers..." 
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            </div>
            
            <select id="typeFilter" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                <option value="">All Types</option>
                <option value="user">Regular Users</option>
                <option value="voucher">Voucher Users</option>
            </select>
            
            <select id="statusFilter" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="disabled">Disabled</option>
                <option value="expired">Expired</option>
            </select>
            
            <select id="profileFilter" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                <option value="">All Profiles</option>
                <option value="1hour">1 Hour</option>
                <option value="1day">1 Day</option>
                <option value="1week">1 Week</option>
                <option value="1month">1 Month</option>
            </select>
        </div>
    </div>
    
    <!-- Users Content -->
    <div id="usersContent">
        <!-- Users Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            <input type="checkbox" id="selectAll" class="rounded border-gray-300 dark:border-gray-600">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            User/Voucher
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Type
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Profile
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Created/Used
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody id="tableBody" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    <!-- Content will be populated by JavaScript -->
                </tbody>
            </table>
        </div>
        
        <!-- Table Footer -->
        <div class="px-6 py-3 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700 dark:text-gray-300">
                    Showing <span id="showingCount">0</span> items
                </div>
                <div class="flex items-center space-x-2">
                    <button onclick="bulkAction('print')" class="btn-secondary text-sm">
                        <i class="fas fa-print mr-1"></i>
                        Print Selected
                    </button>
                    <button onclick="bulkAction('delete')" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                        <i class="fas fa-trash mr-1"></i>
                        Delete Selected
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div id="addUserModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Add New User</h3>
                <button onclick="closeModal('addUserModal')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="addUserForm">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Username</label>
                        <input type="text" id="newUsername" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password</label>
                        <input type="password" id="newPassword" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Profile</label>
                        <select id="newProfile" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="1hour">1 Hour</option>
                            <option value="1day">1 Day</option>
                            <option value="1week">1 Week</option>
                            <option value="1month">1 Month</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Comment (Optional)</label>
                        <input type="text" id="newComment" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('addUserModal')" class="btn-secondary">Cancel</button>
                    <button type="button" onclick="saveUser()" class="btn-primary">Add User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Generate Vouchers Modal -->
<div id="generateVouchersModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Generate Vouchers</h3>
                <button onclick="closeModal('generateVouchersModal')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="generateForm">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Number of Vouchers</label>
                        <input type="number" id="voucherCount" min="1" max="100" value="10" 
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Profile</label>
                        <select id="voucherProfile" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="1hour">1 Hour (Rp 5,000)</option>
                            <option value="1day">1 Day (Rp 15,000)</option>
                            <option value="1week">1 Week (Rp 50,000)</option>
                            <option value="1month">1 Month (Rp 150,000)</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Code Length</label>
                        <select id="codeLength" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="6">6 Characters</option>
                            <option value="8">8 Characters</option>
                            <option value="10">10 Characters</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Prefix (Optional)</label>
                        <input type="text" id="voucherPrefix" placeholder="e.g., WIFI-" maxlength="10"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    </div>
                    
                    <div class="bg-blue-50 dark:bg-blue-900/20 p-3 rounded-lg">
                        <div class="text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Total Cost:</span>
                                <span id="totalCost" class="font-semibold text-blue-600 dark:text-blue-400">Rp 50,000</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('generateVouchersModal')" class="btn-secondary">Cancel</button>
                    <button type="button" onclick="generateVoucherCodes()" class="btn-primary">Generate Vouchers</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Voucher Print Template Modal -->
<div id="printTemplateModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-10 mx-auto p-5 border w-4/5 max-w-4xl shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Voucher Print Template</h3>
                <div class="flex space-x-2">
                    <button onclick="actualPrint()" class="btn-primary">
                        <i class="fas fa-print mr-2"></i>
                        Print
                    </button>
                    <button onclick="closeModal('printTemplateModal')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            <div id="printContent" class="bg-white p-8">
                <!-- Print content will be inserted here -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let allItems = [];
    let selectedItems = new Set();
    let currentTab = 'users';

    // Sample data
    const sampleUsers = [
        { id: 1, type: 'user', username: 'user001', profile: '1day', status: 'active', created: '2024-01-15 10:30', comment: 'Regular user' },
        { id: 2, type: 'user', username: 'admin', profile: '1month', status: 'active', created: '2024-01-10 09:15', comment: 'Administrator' },
        { id: 3, type: 'voucher', username: 'WIFI-ABC123', profile: '1hour', status: 'active', created: '2024-01-16 14:20', usedAt: null },
        { id: 4, type: 'voucher', username: 'WIFI-DEF456', profile: '1day', status: 'used', created: '2024-01-14 11:30', usedAt: '2024-01-15 08:45' },
        { id: 5, type: 'voucher', username: 'WIFI-GHI789', profile: '1week', status: 'expired', created: '2024-01-12 16:00', usedAt: null }
    ];

    document.addEventListener('DOMContentLoaded', function() {
        allItems = [...sampleUsers];
        renderTable();
        setupEventListeners();
        updateTotalCost();
    });

    function setupEventListeners() {
        // Search and filters
        document.getElementById('searchInput').addEventListener('input', filterTable);
        document.getElementById('typeFilter').addEventListener('change', filterTable);
        document.getElementById('statusFilter').addEventListener('change', filterTable);
        document.getElementById('profileFilter').addEventListener('change', filterTable);
        
        // Select all checkbox
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.item-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
                const itemId = parseInt(checkbox.dataset.itemId);
                if (this.checked) {
                    selectedItems.add(itemId);
                } else {
                    selectedItems.delete(itemId);
                }
            });
        });
        
        // Update total cost when inputs change
        ['voucherCount', 'voucherProfile'].forEach(id => {
            document.getElementById(id).addEventListener('change', updateTotalCost);
        });
    }

    function switchTab(tab) {
        currentTab = tab;
        
        // Update tab styles
        document.getElementById('usersTab').className = tab === 'users' 
            ? 'py-4 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600 dark:text-blue-400'
            : 'py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300';
            
        document.getElementById('vouchersTab').className = tab === 'vouchers' 
            ? 'py-4 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600 dark:text-blue-400'
            : 'py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300';
        
        filterTable();
    }

    function renderTable() {
        const tbody = document.getElementById('tableBody');
        const filteredItems = getFilteredItems();
        
        tbody.innerHTML = '';
        
        filteredItems.forEach(item => {
            const row = createTableRow(item);
            tbody.appendChild(row);
        });
        
        document.getElementById('showingCount').textContent = filteredItems.length;
    }

    function createTableRow(item) {
        const row = document.createElement('tr');
        row.className = 'hover:bg-gray-50 dark:hover:bg-gray-700';
        
        const statusColors = {
            active: 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200',
            used: 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200',
            disabled: 'bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200',
            expired: 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200'
        };
        
        const typeColors = {
            user: 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200',
            voucher: 'bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200'
        };
        
        row.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap">
                <input type="checkbox" class="item-checkbox rounded border-gray-300 dark:border-gray-600" 
                       data-item-id="${item.id}" onchange="toggleSelection(${item.id})">
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                    <div class="w-10 h-10 ${item.type === 'user' ? 'bg-blue-500' : 'bg-orange-500'} rounded-lg flex items-center justify-center mr-3">
                        <i class="fas ${item.type === 'user' ? 'fa-user' : 'fa-ticket-alt'} text-white"></i>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-gray-900 dark:text-white ${item.type === 'voucher' ? 'font-mono' : ''}">${item.username}</div>
                        ${item.comment ? `<div class="text-xs text-gray-500 dark:text-gray-400">${item.comment}</div>` : ''}
                    </div>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${typeColors[item.type]}">
                    ${item.type === 'user' ? 'User' : 'Voucher'}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200">
                    ${item.profile}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${statusColors[item.status]}">
                    ${item.status.charAt(0).toUpperCase() + item.status.slice(1)}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                <div>${item.created}</div>
                ${item.usedAt ? `<div class="text-xs text-green-600">Used: ${item.usedAt}</div>` : ''}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-center">
                <div class="flex justify-center space-x-2">
                    <button onclick="viewItem(${item.id})" class="p-1 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded" title="View Details">
                        <i class="fas fa-eye"></i>
                    </button>
                    ${item.type === 'voucher' ? `
                        <button onclick="printVoucher(${item.id})" class="p-1 text-green-600 hover:bg-green-50 dark:hover:bg-green-900/20 rounded" title="Print Voucher">
                            <i class="fas fa-print"></i>
                        </button>
                    ` : `
                        <button onclick="editUser(${item.id})" class="p-1 text-yellow-600 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 rounded" title="Edit User">
                            <i class="fas fa-edit"></i>
                        </button>
                    `}
                    <button onclick="deleteItem(${item.id})" class="p-1 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded" title="Delete">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>
        `;
        
        return row;
    }

    function getFilteredItems() {
        const search = document.getElementById('searchInput').value.toLowerCase();
        const typeFilter = document.getElementById('typeFilter').value;
        const statusFilter = document.getElementById('statusFilter').value;
        const profileFilter = document.getElementById('profileFilter').value;
        
        return allItems.filter(item => {
            const matchesSearch = item.username.toLowerCase().includes(search) || 
                                (item.comment && item.comment.toLowerCase().includes(search));
            const matchesType = !typeFilter || item.type === typeFilter;
            const matchesStatus = !statusFilter || item.status === statusFilter;
            const matchesProfile = !profileFilter || item.profile === profileFilter;
            const matchesTab = currentTab === 'users' ? true : (currentTab === 'vouchers' ? item.type === 'voucher' : true);
            
            return matchesSearch && matchesType && matchesStatus && matchesProfile && matchesTab;
        });
    }

    function filterTable() {
        renderTable();
    }

    function toggleSelection(itemId) {
        if (selectedItems.has(itemId)) {
            selectedItems.delete(itemId);
        } else {
            selectedItems.add(itemId);
        }
    }

    function addUser() {
        document.getElementById('addUserModal').classList.remove('hidden');
    }

    function saveUser() {
        const username = document.getElementById('newUsername').value;
        const password = document.getElementById('newPassword').value;
        const profile = document.getElementById('newProfile').value;
        const comment = document.getElementById('newComment').value;
        
        if (!username || !password) {
            showNotification('Please fill in username and password', 'error');
            return;
        }
        
        const newUser = {
            id: allItems.length + 1,
            type: 'user',
            username: username,
            profile: profile,
            status: 'active',
            created: new Date().toLocaleString('sv-SE').replace('T', ' ').slice(0, 16),
            comment: comment
        };
        
        allItems.unshift(newUser);
        renderTable();
        closeModal('addUserModal');
        showNotification('User added successfully!', 'success');
    }

    function generateVouchers() {
        document.getElementById('generateVouchersModal').classList.remove('hidden');
    }

    function updateTotalCost() {
        const count = parseInt(document.getElementById('voucherCount').value) || 0;
        const profile = document.getElementById('voucherProfile').value;
        
        const prices = {
            '1hour': 5000,
            '1day': 15000,
            '1week': 50000,
            '1month': 150000
        };
        
        const total = count * prices[profile];
        document.getElementById('totalCost').textContent = `Rp ${total.toLocaleString('id-ID')}`;
    }

    function generateVoucherCodes() {
        const count = parseInt(document.getElementById('voucherCount').value);
        const profile = document.getElementById('voucherProfile').value;
        const length = parseInt(document.getElementById('codeLength').value);
        const prefix = document.getElementById('voucherPrefix').value;
        
        showNotification(`Generating ${count} vouchers...`, 'info');
        
        setTimeout(() => {
            for (let i = 0; i < count; i++) {
                const code = prefix + generateRandomCode(length);
                const newVoucher = {
                    id: allItems.length + i + 1,
                    type: 'voucher',
                    username: code,
                    profile: profile,
                    status: 'active',
                    created: new Date().toLocaleString('sv-SE').replace('T', ' ').slice(0, 16),
                    usedAt: null
                };
                allItems.unshift(newVoucher);
            }
            
            renderTable();
            closeModal('generateVouchersModal');
            showNotification(`Successfully generated ${count} vouchers!`, 'success');
        }, 1500);
    }

    function generateRandomCode(length) {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let result = '';
        for (let i = 0; i < length; i++) {
            result += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        return result;
    }

    function printVoucher(itemId) {
        const item = allItems.find(i => i.id === itemId);
        if (!item || item.type !== 'voucher') return;
        
        createVoucherTemplate([item]);
        document.getElementById('printTemplateModal').classList.remove('hidden');
    }

    function printSelected() {
        const selectedVouchers = allItems.filter(item => 
            selectedItems.has(item.id) && item.type === 'voucher'
        );
        
        if (selectedVouchers.length === 0) {
            showNotification('Please select vouchers to print', 'warning');
            return;
        }
        
        createVoucherTemplate(selectedVouchers);
        document.getElementById('printTemplateModal').classList.remove('hidden');
    }

    function createVoucherTemplate(vouchers) {
        const printContent = document.getElementById('printContent');
        
        let html = `
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-800">WiFi Access Vouchers</h1>
                <p class="text-gray-600">MikroTik RADIUS Management System</p>
                <hr class="my-4">
            </div>
            
            <div class="grid grid-cols-2 gap-4">
        `;
        
        vouchers.forEach(voucher => {
            html += `
                <div class="border-2 border-dashed border-gray-300 p-4 text-center">
                    <div class="mb-3">
                        <div class="text-lg font-bold text-blue-600">WiFi Access Code</div>
                        <div class="text-2xl font-mono font-bold text-gray-800 bg-gray-100 p-2 rounded mt-2">${voucher.username}</div>
                    </div>
                    
                    <div class="text-sm space-y-1">
                        <div><strong>Duration:</strong> ${voucher.profile}</div>
                        <div><strong>Valid Until:</strong> ${new Date(Date.now() + 24*60*60*1000).toLocaleDateString()}</div>
                        <div><strong>Created:</strong> ${voucher.created}</div>
                    </div>
                    
                    <div class="mt-3 text-xs text-gray-500">
                        <p>Scan QR Code or enter code manually</p>
                        <p>Support: +62 821-2657-7254</p>
                    </div>
                    
                    <div class="mt-2 text-xs">
                        <div class="w-16 h-16 bg-gray-200 mx-auto">QR</div>
                    </div>
                </div>
            `;
        });
        
        html += '</div>';
        
        printContent.innerHTML = html;
    }

    function actualPrint() {
        const printContent = document.getElementById('printContent').innerHTML;
        const newWindow = window.open('', '_blank');
        newWindow.document.write(`
            <html>
                <head>
                    <title>Voucher Print</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 20px; }
                        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
                        .border-dashed { border: 2px dashed #ccc; padding: 15px; text-align: center; }
                        .text-center { text-align: center; }
                        .font-bold { font-weight: bold; }
                        .text-lg { font-size: 1.2em; }
                        .text-2xl { font-size: 1.5em; }
                        .font-mono { font-family: monospace; }
                        .bg-gray-100 { background-color: #f5f5f5; padding: 8px; border-radius: 4px; }
                        .text-blue-600 { color: #2563eb; }
                        .text-gray-600 { color: #6b7280; }
                        .text-gray-500 { color: #9ca3af; }
                        .text-xs { font-size: 0.8em; }
                        .text-sm { font-size: 0.9em; }
                        .mt-2 { margin-top: 8px; }
                        .mt-3 { margin-top: 12px; }
                        .mb-3 { margin-bottom: 12px; }
                        .space-y-1 > * + * { margin-top: 4px; }
                        hr { margin: 16px 0; }
                    </style>
                </head>
                <body>${printContent}</body>
            </html>
        `);
        newWindow.document.close();
        newWindow.print();
        newWindow.close();
    }

    function viewItem(itemId) {
        const item = allItems.find(i => i.id === itemId);
        showNotification(`Viewing ${item.type}: ${item.username}`, 'info');
    }

    function editUser(itemId) {
        showNotification('Edit user functionality will be implemented', 'info');
    }

    function deleteItem(itemId) {
        if (confirm('Are you sure you want to delete this item?')) {
            allItems = allItems.filter(i => i.id !== itemId);
            renderTable();
            showNotification('Item deleted successfully!', 'success');
        }
    }

    function bulkAction(action) {
        if (selectedItems.size === 0) {
            showNotification('Please select items first', 'warning');
            return;
        }
        
        if (action === 'print') {
            printSelected();
        } else if (action === 'delete') {
            if (confirm(`Are you sure you want to delete ${selectedItems.size} items?`)) {
                allItems = allItems.filter(i => !selectedItems.has(i.id));
                selectedItems.clear();
                renderTable();
                showNotification('Selected items deleted successfully!', 'success');
            }
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

    // Close modals when clicking outside
    window.addEventListener('click', function(event) {
        const modals = ['addUserModal', 'generateVouchersModal', 'printTemplateModal'];
        modals.forEach(modalId => {
            const modal = document.getElementById(modalId);
            if (event.target === modal) {
                closeModal(modalId);
            }
        });
    });
</script>
@endpush