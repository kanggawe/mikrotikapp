@extends('layouts.app')

@section('title', 'PPP Users - MikroTik RADIUS Management')
@section('page_title', 'PPP Users')
@section('page_subtitle', 'Manage PPP user accounts and connections')

@section('content')
<div class="content-section p-8">
    <div class="text-center">
        <div class="w-24 h-24 mx-auto bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mb-6">
            <i class="fas fa-network-wired text-blue-600 dark:text-blue-400 text-4xl"></i>
        </div>
        <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">PPP Users</h3>
        <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">
            PPP user management system will be implemented here. Manage Point-to-Point Protocol user accounts and connections.
        </p>
        <div class="flex justify-center space-x-4">
            <button class="btn-primary">
                <i class="fas fa-plus mr-2"></i>
                Add PPP User
            </button>
            <button class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                <i class="fas fa-eye mr-2"></i>
                View Connections
            </button>
        </div>
    </div>
</div>
@endsection 