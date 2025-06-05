@extends('layouts.app')

@section('title', 'Backup Management - MikroTik RADIUS Management')
@section('page_title', 'Backup Management')
@section('page_subtitle', 'Create and manage system backups')

@section('content')
<div class="content-section p-8">
    <div class="text-center">
        <div class="w-24 h-24 mx-auto bg-teal-100 dark:bg-teal-900 rounded-full flex items-center justify-center mb-6">
            <i class="fas fa-cloud-download-alt text-teal-600 dark:text-teal-400 text-4xl"></i>
        </div>
        <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">Backup Management</h3>
        <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">
            Backup management functionality will be implemented here. Create, schedule, and restore system backups automatically.
        </p>
        <div class="flex justify-center space-x-4">
            <button class="btn-primary">
                <i class="fas fa-save mr-2"></i>
                Create Backup
            </button>
            <button class="btn-secondary">
                <i class="fas fa-history mr-2"></i>
                View History
            </button>
        </div>
    </div>
</div>
@endsection 