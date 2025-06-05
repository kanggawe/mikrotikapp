@extends('layouts.app')

@section('title', 'Documentation - MikroTik RADIUS Management')
@section('page_title', 'Documentation')
@section('page_subtitle', 'Learn how to use the MikroTik RADIUS Management System')

@section('content')
<div class="content-section">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Getting Started</h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
            Complete guide to using the MikroTik RADIUS Management System
        </p>
    </div>
    
    <div class="p-6">
        <div class="prose dark:prose-invert max-w-none">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Welcome to MikroTik RADIUS Management</h2>
            <p class="text-gray-600 dark:text-gray-400 mb-6">This system helps you manage Network Access Server (NAS) devices and RADIUS authentication for your MikroTik infrastructure.</p>
            
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Quick Start Guide</h3>
            <ol class="list-decimal list-inside space-y-2 text-gray-600 dark:text-gray-400 mb-6">
                <li>Add your MikroTik devices as NAS devices</li>
                <li>Create user groups with authentication policies</li>
                <li>Add users and assign them to groups</li>
                <li>Monitor accounting and authentication logs</li>
            </ol>
            
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Main Features</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                    <h4 class="font-semibold text-blue-900 dark:text-blue-100 mb-2">
                        <i class="fas fa-server mr-2"></i>NAS Device Management
                    </h4>
                    <p class="text-blue-700 dark:text-blue-300 text-sm">Manage your MikroTik devices and network access servers</p>
                </div>
                
                <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                    <h4 class="font-semibold text-green-900 dark:text-green-100 mb-2">
                        <i class="fas fa-users mr-2"></i>User Authentication Control
                    </h4>
                    <p class="text-green-700 dark:text-green-300 text-sm">Control user access and authentication policies</p>
                </div>
                
                <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg">
                    <h4 class="font-semibold text-purple-900 dark:text-purple-100 mb-2">
                        <i class="fas fa-layer-group mr-2"></i>Group-based Policies
                    </h4>
                    <p class="text-purple-700 dark:text-purple-300 text-sm">Organize users into groups with specific access rules</p>
                </div>
                
                <div class="bg-orange-50 dark:bg-orange-900/20 p-4 rounded-lg">
                    <h4 class="font-semibold text-orange-900 dark:text-orange-100 mb-2">
                        <i class="fas fa-chart-bar mr-2"></i>Session Accounting
                    </h4>
                    <p class="text-orange-700 dark:text-orange-300 text-sm">Monitor and track user sessions and usage</p>
                </div>
            </div>

            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">System Modules</h3>
            <div class="space-y-4">
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">📊 Dashboard</h4>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Account management, FTTH infrastructure monitoring</p>
                </div>
                
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">🌐 RADIUS</h4>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">NAS devices, PPP-DHCP users/groups, Hotspot management, RADIUS settings</p>
                </div>
                
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">💰 Billing</h4>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Member management, invoicing, transactions, reports, payment channels</p>
                </div>
                
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">🔧 Utility</h4>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Admin management, WhatsApp integration, backup, network mapping</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 