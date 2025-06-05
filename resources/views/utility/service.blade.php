@extends('layouts.app')

@section('title', 'Service Management - MikroTik RADIUS Management')
@section('page_title', 'Service Management')
@section('page_subtitle', 'Manage system services and processes')

@section('content')
<div class="content-section p-8">
    <div class="text-center">
        <div class="w-24 h-24 mx-auto bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center mb-6">
            <i class="fas fa-tools text-purple-600 dark:text-purple-400 text-4xl"></i>
        </div>
        <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">Service Management</h3>
        <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">
            Service management functionality will be implemented here. Monitor and control system services, processes, and automated tasks.
        </p>
        <div class="flex justify-center space-x-4">
            <button class="btn-primary">
                <i class="fas fa-play mr-2"></i>
                Start Services
            </button>
            <button class="btn-secondary">
                <i class="fas fa-chart-line mr-2"></i>
                Monitor Status
            </button>
        </div>
    </div>
</div>
@endsection 