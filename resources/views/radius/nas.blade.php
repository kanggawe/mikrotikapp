@extends('layouts.app')

@section('title', 'NAS Devices - MikroTik RADIUS Management')
@section('page_title', 'NAS Devices')
@section('page_subtitle', 'Manage Network Access Server devices')

@section('breadcrumb')
<nav class="flex" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                <i class="fas fa-home mr-2"></i>
                Dashboard
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">NAS Devices</span>
            </div>
        </li>
    </ol>
</nav>
@endsection

@section('content')
<!-- Page Header with Actions -->
<div class="mb-6">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">NAS Devices</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Manage your Network Access Server devices and their configurations
            </p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-4 sm:flex sm:space-x-3">
            <button type="button" onclick="exportDevices()" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                <i class="fas fa-download mr-2"></i>
                Export
            </button>
            <a href="{{ route('nas.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>
                Add NAS Device
            </a>
        </div>
    </div>
</div>

<!-- Stats Overview -->
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
    <!-- Total NAS Devices -->
    <div class="content-section p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-600 rounded-md flex items-center justify-center">
                    <i class="fas fa-server text-white text-sm"></i>
                </div>
            </div>
            <div class="ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Devices</dt>
                    <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $nas->count() }}</dd>
                </dl>
            </div>
        </div>
    </div>

    <!-- Active Devices -->
    <div class="content-section p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-green-600 rounded-md flex items-center justify-center">
                    <i class="fas fa-check-circle text-white text-sm"></i>
                </div>
            </div>
            <div class="ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Active</dt>
                    <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $nas->count() }}</dd>
                </dl>
            </div>
        </div>
    </div>

    <!-- Router Types -->
    <div class="content-section p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-purple-600 rounded-md flex items-center justify-center">
                    <i class="fas fa-network-wired text-white text-sm"></i>
                </div>
            </div>
            <div class="ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Device Types</dt>
                    <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $nas->pluck('type')->unique()->count() }}</dd>
                </dl>
            </div>
        </div>
    </div>

    <!-- Last Update -->
    <div class="content-section p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-yellow-600 rounded-md flex items-center justify-center">
                    <i class="fas fa-clock text-white text-sm"></i>
                </div>
            </div>
            <div class="ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Last Update</dt>
                    <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $nas->max('updated_at') ? $nas->max('updated_at')->diffForHumans() : 'Never' }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter -->
<div class="content-section mb-6">
    <div class="px-6 py-4">
        <div class="sm:flex sm:items-center sm:justify-between">
            <div class="flex-1 min-w-0">
                <div class="flex flex-col sm:flex-row gap-4">
                    <!-- Search -->
                    <div class="flex-1 max-w-lg">
                        <label for="search" class="sr-only">Search NAS devices</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400 text-sm"></i>
                            </div>
                            <input type="text" 
                                   name="search" 
                                   id="search" 
                                   class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-md leading-5 bg-white dark:bg-gray-700 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                                   placeholder="Search NAS devices by name, IP, or type...">
                        </div>
                    </div>
                    
                    <!-- Filter by Type -->
                    <div class="sm:w-48">
                        <select id="type-filter" 
                                class="block w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">All Types</option>
                            @foreach($nas->pluck('type')->unique() as $type)
                                <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Status Filter -->
                    <div class="sm:w-32">
                        <select id="status-filter" 
                                class="block w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- NAS Devices Table -->
<div class="content-section">
    @if($nas->count() > 0)
        <div class="overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Device Information
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Type & Configuration
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Network Details
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($nas as $device)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        <div class="h-12 w-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center shadow-md">
                                            <i class="fas fa-server text-white text-lg"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ $device->shortname ?: 'Unnamed Device' }}
                                        </div>
                                        <div class="text-sm text-gray-600 dark:text-gray-400">
                                            IP: {{ $device->nasname }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-500">
                                            ID: #{{ $device->id }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                        <i class="fas fa-microchip mr-1"></i>
                                        {{ ucfirst($device->type ?: 'Unknown') }}
                                    </span>
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    <i class="fas fa-ethernet mr-1"></i>
                                    Ports: {{ $device->ports ?: 'Not specified' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">
                                    <div class="flex items-center">
                                        <i class="fas fa-server mr-2 text-gray-400"></i>
                                        <span>{{ $device->server ?: 'Not configured' }}</span>
                                    </div>
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    <div class="flex items-center">
                                        <i class="fas fa-users mr-2 text-gray-400"></i>
                                        <span>{{ $device->community ?: 'Default' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                    <div class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1.5 animate-pulse"></div>
                                    Online
                                </span>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    Last seen: Just now
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <button onclick="viewDevice({{ $device->id }}, '{{ $device->shortname ?: 'Unnamed Device' }}', '{{ $device->nasname }}', '{{ $device->type }}', '{{ $device->ports }}', '{{ $device->server }}', '{{ $device->community }}', '{{ $device->description }}')" class="inline-flex items-center p-2 text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-md transition-colors duration-200" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button onclick="editDevice({{ $device->id }}, '{{ $device->shortname }}', '{{ $device->nasname }}', '{{ $device->type }}', '{{ $device->ports }}', '{{ $device->server }}', '{{ $device->community }}', '{{ $device->description }}')" class="inline-flex items-center p-2 text-yellow-600 dark:text-yellow-400 hover:text-yellow-900 dark:hover:text-yellow-300 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 rounded-md transition-colors duration-200" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="testConnection('{{ $device->nasname }}', '{{ $device->shortname ?: 'Device' }}')" class="inline-flex items-center p-2 text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300 hover:bg-green-50 dark:hover:bg-green-900/20 rounded-md transition-colors duration-200" title="Test Connection">
                                        <i class="fas fa-plug"></i>
                                    </button>
                                    <button onclick="confirmDelete({{ $device->id }}, '{{ $device->shortname ?: $device->nasname }}')" class="inline-flex items-center p-2 text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-md transition-colors duration-200" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Table Footer -->
        <div class="bg-gray-50 dark:bg-gray-800 px-6 py-3 border-t border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700 dark:text-gray-300">
                    Showing <span class="font-medium">{{ $nas->count() }}</span> of <span class="font-medium">{{ $nas->count() }}</span> devices
                </div>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    <i class="fas fa-info-circle mr-1"></i>
                    All devices are currently active
                </div>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="w-24 h-24 mx-auto bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-6">
                <i class="fas fa-server text-gray-400 dark:text-gray-500 text-4xl"></i>
            </div>
            <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">No NAS devices found</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">
                Get started by adding your first Network Access Server device. Configure your MikroTik routers and access points to work with RADIUS authentication.
            </p>
            <a href="{{ route('nas.create') }}" class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>
                Add Your First NAS Device
            </a>
        </div>
    @endif
</div>

<!-- Description Section -->
@if($nas->count() > 0)
<div class="content-section p-6 mt-6">
    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Device Descriptions</h3>
    <div class="space-y-4">
        @foreach($nas as $device)
            @if($device->description)
                <div class="border-l-4 border-blue-500 pl-4">
                    <div class="flex items-center">
                        <span class="font-medium text-gray-900 dark:text-white">{{ $device->shortname ?: $device->nasname }}</span>
                        <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">({{ $device->nasname }})</span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $device->description }}</p>
                </div>
            @endif
        @endforeach
    </div>
</div>
@endif

<!-- View Device Modal -->
<div id="viewDeviceModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Device Details</h3>
                <button onclick="closeModal('viewDeviceModal')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="space-y-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-server text-white"></i>
                    </div>
                    <div>
                        <h4 id="viewDeviceName" class="font-semibold text-gray-900 dark:text-white"></h4>
                        <p id="viewDeviceIp" class="text-sm text-gray-600 dark:text-gray-400"></p>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="font-medium text-gray-700 dark:text-gray-300">Type:</span>
                        <p id="viewDeviceType" class="text-gray-600 dark:text-gray-400"></p>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700 dark:text-gray-300">Ports:</span>
                        <p id="viewDevicePorts" class="text-gray-600 dark:text-gray-400"></p>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700 dark:text-gray-300">Server:</span>
                        <p id="viewDeviceServer" class="text-gray-600 dark:text-gray-400"></p>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700 dark:text-gray-300">Community:</span>
                        <p id="viewDeviceCommunity" class="text-gray-600 dark:text-gray-400"></p>
                    </div>
                </div>
                
                <div>
                    <span class="font-medium text-gray-700 dark:text-gray-300">Description:</span>
                    <p id="viewDeviceDescription" class="text-gray-600 dark:text-gray-400 mt-1"></p>
                </div>
            </div>
            
            <div class="mt-6 flex justify-end space-x-3">
                <button onclick="closeModal('viewDeviceModal')" class="btn-secondary">Close</button>
                <button onclick="closeModal('viewDeviceModal'); editDevice(currentDeviceId)" class="btn-primary">Edit Device</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Device Modal -->
<div id="editDeviceModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Edit Device</h3>
                <button onclick="closeModal('editDeviceModal')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="editDeviceForm">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Device Name</label>
                        <input type="text" id="editDeviceName" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">IP Address</label>
                        <input type="text" id="editDeviceIp" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Type</label>
                        <select id="editDeviceType" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="router">Router</option>
                            <option value="switch">Switch</option>
                            <option value="access-point">Access Point</option>
                            <option value="gateway">Gateway</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ports</label>
                        <input type="text" id="editDevicePorts" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                        <textarea id="editDeviceDescription" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white"></textarea>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('editDeviceModal')" class="btn-secondary">Cancel</button>
                    <button type="button" onclick="saveDeviceChanges()" class="btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteConfirmModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 dark:bg-red-900 rounded-full mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400 text-xl"></i>
            </div>
            
            <h3 class="text-lg font-medium text-gray-900 dark:text-white text-center mb-2">Delete Device</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 text-center mb-6">
                Are you sure you want to delete <span id="deleteDeviceName" class="font-semibold"></span>? This action cannot be undone.
            </p>
            
            <div class="flex justify-center space-x-3">
                <button onclick="closeModal('deleteConfirmModal')" class="btn-secondary">Cancel</button>
                <button onclick="deleteDevice()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">Delete</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let currentDeviceId = null;
    let deleteDeviceId = null;

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search');
        const typeFilter = document.getElementById('type-filter');
        const statusFilter = document.getElementById('status-filter');
        const tableRows = document.querySelectorAll('tbody tr');

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedType = typeFilter.value.toLowerCase();
            const selectedStatus = statusFilter.value.toLowerCase();

            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const typeCell = row.querySelector('.bg-blue-100')?.textContent.toLowerCase() || '';
                
                const matchesSearch = text.includes(searchTerm);
                const matchesType = selectedType === '' || typeCell.includes(selectedType);
                const matchesStatus = selectedStatus === '' || text.includes(selectedStatus);
                
                if (matchesSearch && matchesType && matchesStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
            
            updateTableFooter();
        }
        
        function updateTableFooter() {
            const visibleRows = Array.from(tableRows).filter(row => row.style.display !== 'none');
            const footerText = document.querySelector('.bg-gray-50 .text-sm');
            if (footerText) {
                footerText.innerHTML = `Showing <span class="font-medium">${visibleRows.length}</span> of <span class="font-medium">${tableRows.length}</span> devices`;
            }
        }

        searchInput.addEventListener('input', filterTable);
        typeFilter.addEventListener('change', filterTable);
        statusFilter.addEventListener('change', filterTable);
        
        // Add search placeholder animation
        let placeholderTexts = [
            'Search NAS devices by name, IP, or type...',
            'Try searching by IP address...',
            'Search by device name...',
            'Filter by device type...'
        ];
        let currentIndex = 0;
        
        setInterval(() => {
            if (searchInput.value === '') {
                searchInput.placeholder = placeholderTexts[currentIndex];
                currentIndex = (currentIndex + 1) % placeholderTexts.length;
            }
        }, 3000);
    });

    function viewDevice(id, name, ip, type, ports, server, community, description) {
        currentDeviceId = id;
        document.getElementById('viewDeviceName').textContent = name;
        document.getElementById('viewDeviceIp').textContent = ip;
        document.getElementById('viewDeviceType').textContent = type || 'Not specified';
        document.getElementById('viewDevicePorts').textContent = ports || 'Not specified';
        document.getElementById('viewDeviceServer').textContent = server || 'Not configured';
        document.getElementById('viewDeviceCommunity').textContent = community || 'Default';
        document.getElementById('viewDeviceDescription').textContent = description || 'No description available';
        
        document.getElementById('viewDeviceModal').classList.remove('hidden');
    }

    function editDevice(id, name, ip, type, ports, server, community, description) {
        currentDeviceId = id;
        document.getElementById('editDeviceName').value = name || '';
        document.getElementById('editDeviceIp').value = ip || '';
        document.getElementById('editDeviceType').value = type || 'router';
        document.getElementById('editDevicePorts').value = ports || '';
        document.getElementById('editDeviceDescription').value = description || '';
        
        document.getElementById('editDeviceModal').classList.remove('hidden');
    }

    function saveDeviceChanges() {
        const name = document.getElementById('editDeviceName').value;
        const ip = document.getElementById('editDeviceIp').value;
        const type = document.getElementById('editDeviceType').value;
        const ports = document.getElementById('editDevicePorts').value;
        const description = document.getElementById('editDeviceDescription').value;
        
        if (!name || !ip) {
            showNotification('Please fill in device name and IP address', 'error');
            return;
        }
        
        // Here you would normally send an AJAX request to update the device
        showNotification(`Device "${name}" updated successfully! (Demo mode)`, 'success');
        closeModal('editDeviceModal');
        
        // In a real application, you would reload the page or update the table row
        setTimeout(() => {
            location.reload();
        }, 2000);
    }

    function testConnection(ip, deviceName) {
        showNotification(`Testing connection to ${deviceName} (${ip})...`, 'info');
        
        // Simulate connection test
        setTimeout(() => {
            const success = Math.random() > 0.2; // 80% success rate
            if (success) {
                showNotification(`✅ Connection to ${deviceName} successful! Ping: 24ms`, 'success');
            } else {
                showNotification(`❌ Connection to ${deviceName} failed! Device may be offline.`, 'error');
            }
        }, 2000);
    }

    function confirmDelete(id, deviceName) {
        deleteDeviceId = id;
        document.getElementById('deleteDeviceName').textContent = deviceName;
        document.getElementById('deleteConfirmModal').classList.remove('hidden');
    }

    function deleteDevice() {
        if (deleteDeviceId) {
            // Here you would normally send an AJAX request to delete the device
            showNotification('Device deleted successfully! (Demo mode)', 'success');
            closeModal('deleteConfirmModal');
            
            // In a real application, you would remove the row from the table or reload
            setTimeout(() => {
                location.reload();
            }, 2000);
        }
    }

    function exportDevices() {
        showNotification('Exporting devices to CSV... (Demo mode)', 'info');
        
        // Simulate export
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
        }, 4000);
    }

    // Close modals when clicking outside
    window.addEventListener('click', function(event) {
        const modals = ['viewDeviceModal', 'editDeviceModal', 'deleteConfirmModal'];
        modals.forEach(modalId => {
            const modal = document.getElementById(modalId);
            if (event.target === modal) {
                closeModal(modalId);
            }
        });
    });
</script>
@endpush
