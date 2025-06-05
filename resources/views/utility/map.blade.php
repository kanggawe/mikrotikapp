@extends('layouts.app')

@section('title', 'Network Map - MikroTik RADIUS Management')
@section('page_title', 'Network Map')
@section('page_subtitle', 'Visualize network topology and device locations')

@section('content')
<div class="content-section">
    <!-- Map Controls -->
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Network Infrastructure Map</h3>
                <div class="flex items-center space-x-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                        <div class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1.5"></div>
                        12 Online
                    </span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200">
                        <div class="w-1.5 h-1.5 bg-red-400 rounded-full mr-1.5"></div>
                        2 Offline
                    </span>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <select id="mapLayer" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm">
                    <option value="street">Street Map</option>
                    <option value="satellite">Satellite</option>
                    <option value="terrain">Terrain</option>
                </select>
                
                <button onclick="refreshMap()" class="btn-secondary">
                    <i class="fas fa-sync-alt mr-2"></i>
                    Refresh
                </button>
                
                <button onclick="addDevice()" class="btn-primary">
                    <i class="fas fa-plus mr-2"></i>
                    Add Device
                </button>
            </div>
        </div>
    </div>
    
    <!-- Map Container -->
    <div class="relative">
        <div id="networkMap" class="w-full h-96 bg-gray-100 dark:bg-gray-700"></div>
        
        <!-- Map Legend -->
        <div class="absolute top-4 right-4 bg-white dark:bg-gray-800 p-4 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700">
            <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Device Types</h4>
            <div class="space-y-2 text-xs">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                    <span class="text-gray-700 dark:text-gray-300">Router</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                    <span class="text-gray-700 dark:text-gray-300">Access Point</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-orange-500 rounded-full mr-2"></div>
                    <span class="text-gray-700 dark:text-gray-300">Switch</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-purple-500 rounded-full mr-2"></div>
                    <span class="text-gray-700 dark:text-gray-300">Gateway</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Device Info Panel -->
    <div id="deviceInfo" class="hidden px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-router text-white"></i>
                </div>
                <div>
                    <h4 id="deviceName" class="text-lg font-semibold text-gray-900 dark:text-white">Device Name</h4>
                    <p id="deviceDetails" class="text-sm text-gray-600 dark:text-gray-400">IP: 192.168.1.1 | Status: Online | Type: Router</p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <button onclick="editDevice()" class="btn-secondary text-sm">
                    <i class="fas fa-edit mr-1"></i>
                    Edit
                </button>
                <button onclick="pingDevice()" class="btn-success text-sm">
                    <i class="fas fa-satellite-dish mr-1"></i>
                    Ping Test
                </button>
                <button onclick="closeDeviceInfo()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Add Device Modal -->
<div id="addDeviceModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Add Network Device</h3>
            <form id="addDeviceForm">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Device Name</label>
                    <input type="text" id="deviceNameInput" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">IP Address</label>
                    <input type="text" id="deviceIpInput" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Device Type</label>
                    <select id="deviceTypeInput" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="router">Router</option>
                        <option value="ap">Access Point</option>
                        <option value="switch">Switch</option>
                        <option value="gateway">Gateway</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Click on map to set location</label>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        Coordinates: <span id="selectedCoords">Not selected</span>
                    </div>
                </div>
                
                <div class="flex items-center space-x-3">
                    <button type="button" onclick="saveDevice()" class="btn-primary">
                        <i class="fas fa-save mr-2"></i>
                        Save Device
                    </button>
                    <button type="button" onclick="closeAddDeviceModal()" class="btn-secondary">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('styles')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
.leaflet-popup-content-wrapper {
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.leaflet-popup-content {
    margin: 16px;
    line-height: 1.4;
    font-size: 13px;
    font-family: inherit;
}

.device-marker {
    border: 2px solid white;
    border-radius: 50%;
    box-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.device-marker.online {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
    70% { box-shadow: 0 0 0 10px rgba(34, 197, 94, 0); }
    100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
}
</style>
@endpush

@push('scripts')
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
let map;
let deviceMarkers = [];
let selectedLatLng = null;

// Initialize map
document.addEventListener('DOMContentLoaded', function() {
    initializeMap();
    loadNetworkDevices();
});

function initializeMap() {
    // Initialize map centered on Indonesia
    map = L.map('networkMap').setView([-6.2088, 106.8456], 10);
    
    // Add default tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    
    // Map click handler for adding devices
    map.on('click', function(e) {
        if (document.getElementById('addDeviceModal').classList.contains('hidden')) {
            return;
        }
        
        selectedLatLng = e.latlng;
        document.getElementById('selectedCoords').textContent = 
            `${e.latlng.lat.toFixed(6)}, ${e.latlng.lng.toFixed(6)}`;
    });
}

function loadNetworkDevices() {
    // Sample network devices data
    const devices = [
        {
            name: 'Main Router',
            ip: '192.168.1.1',
            type: 'router',
            status: 'online',
            lat: -6.2088,
            lng: 106.8456,
            description: 'Primary gateway router'
        },
        {
            name: 'AP-Building-A',
            ip: '192.168.1.10',
            type: 'ap',
            status: 'online',
            lat: -6.2050,
            lng: 106.8400,
            description: 'Building A access point'
        },
        {
            name: 'Switch-Floor-2',
            ip: '192.168.1.20',
            type: 'switch',
            status: 'offline',
            lat: -6.2100,
            lng: 106.8500,
            description: 'Second floor switch'
        },
        {
            name: 'Backup Gateway',
            ip: '192.168.1.2',
            type: 'gateway',
            status: 'online',
            lat: -6.2120,
            lng: 106.8420,
            description: 'Backup internet gateway'
        }
    ];
    
    devices.forEach(device => {
        addDeviceMarker(device);
    });
}

function addDeviceMarker(device) {
    const colors = {
        router: '#3b82f6',
        ap: '#10b981',
        switch: '#f59e0b',
        gateway: '#8b5cf6'
    };
    
    const icons = {
        router: 'fa-router',
        ap: 'fa-wifi',
        switch: 'fa-network-wired',
        gateway: 'fa-server'
    };
    
    const color = colors[device.type] || '#6b7280';
    const iconClass = icons[device.type] || 'fa-question';
    
    // Create custom icon
    const customIcon = L.divIcon({
        html: `<div class="device-marker ${device.status}" style="
            width: 24px; 
            height: 24px; 
            background-color: ${color}; 
            border-radius: 50%; 
            display: flex; 
            align-items: center; 
            justify-content: center;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.3);
        ">
            <i class="fas ${iconClass}" style="color: white; font-size: 10px;"></i>
        </div>`,
        className: 'custom-div-icon',
        iconSize: [24, 24],
        iconAnchor: [12, 12]
    });
    
    const marker = L.marker([device.lat, device.lng], {
        icon: customIcon
    }).addTo(map);
    
    // Create popup content
    const popupContent = `
        <div class="text-center">
            <h4 class="font-semibold text-gray-900 mb-2">${device.name}</h4>
            <div class="text-sm text-gray-600 space-y-1">
                <div><strong>IP:</strong> ${device.ip}</div>
                <div><strong>Type:</strong> ${device.type.toUpperCase()}</div>
                <div><strong>Status:</strong> 
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium ${device.status === 'online' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                        ${device.status}
                    </span>
                </div>
                <div class="mt-2 text-xs">${device.description}</div>
            </div>
            <div class="mt-3 flex justify-center space-x-2">
                <button onclick="showDeviceInfo('${device.name}', '${device.ip}', '${device.type}', '${device.status}')" 
                        class="px-2 py-1 bg-blue-500 text-white text-xs rounded hover:bg-blue-600">
                    Details
                </button>
                <button onclick="pingDevice('${device.ip}')" 
                        class="px-2 py-1 bg-green-500 text-white text-xs rounded hover:bg-green-600">
                    Ping
                </button>
            </div>
        </div>
    `;
    
    marker.bindPopup(popupContent);
    deviceMarkers.push({marker, device});
}

function showDeviceInfo(name, ip, type, status) {
    document.getElementById('deviceName').textContent = name;
    document.getElementById('deviceDetails').textContent = `IP: ${ip} | Status: ${status} | Type: ${type.toUpperCase()}`;
    document.getElementById('deviceInfo').classList.remove('hidden');
}

function closeDeviceInfo() {
    document.getElementById('deviceInfo').classList.add('hidden');
}

function addDevice() {
    document.getElementById('addDeviceModal').classList.remove('hidden');
    selectedLatLng = null;
    document.getElementById('selectedCoords').textContent = 'Not selected';
    document.getElementById('addDeviceForm').reset();
}

function closeAddDeviceModal() {
    document.getElementById('addDeviceModal').classList.add('hidden');
}

function saveDevice() {
    const name = document.getElementById('deviceNameInput').value;
    const ip = document.getElementById('deviceIpInput').value;
    const type = document.getElementById('deviceTypeInput').value;
    
    if (!name || !ip || !selectedLatLng) {
        alert('Please fill all fields and select location on map');
        return;
    }
    
    const newDevice = {
        name: name,
        ip: ip,
        type: type,
        status: 'online',
        lat: selectedLatLng.lat,
        lng: selectedLatLng.lng,
        description: `${type.toUpperCase()} device at ${ip}`
    };
    
    addDeviceMarker(newDevice);
    closeAddDeviceModal();
    
    // Show success message
    showNotification('Device added successfully!', 'success');
}

function refreshMap() {
    deviceMarkers.forEach(item => {
        map.removeLayer(item.marker);
    });
    deviceMarkers = [];
    loadNetworkDevices();
    showNotification('Map refreshed!', 'info');
}

function editDevice() {
    showNotification('Edit functionality will be implemented here', 'info');
}

function pingDevice(ip = null) {
    const targetIp = ip || 'selected device';
    showNotification(`Pinging ${targetIp}... (Demo mode)`, 'info');
    
    // Simulate ping result
    setTimeout(() => {
        showNotification(`Ping to ${targetIp}: 4 packets transmitted, 4 received, 0% packet loss`, 'success');
    }, 2000);
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

// Map layer switcher
document.getElementById('mapLayer').addEventListener('change', function(e) {
    const layers = {
        street: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        satellite: 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
        terrain: 'https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png'
    };
    
    map.eachLayer(function(layer) {
        if (layer instanceof L.TileLayer) {
            map.removeLayer(layer);
        }
    });
    
    L.tileLayer(layers[e.target.value], {
        attribution: '© Map contributors'
    }).addTo(map);
});
</script>
@endpush 