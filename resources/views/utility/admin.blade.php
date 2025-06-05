@extends('layouts.app')

@section('title', 'Admin Management - MikroTik RADIUS Management')
@section('page_title', 'Admin Management')
@section('page_subtitle', 'Manage administrator accounts and permissions')

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
                <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">Utility</span>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">Admin</span>
            </div>
        </li>
    </ol>
</nav>
@endsection

@section('content')
<div class="content-section p-8">
    <div class="text-center">
        <div class="w-24 h-24 mx-auto bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center mb-6">
            <i class="fas fa-user-shield text-red-600 dark:text-red-400 text-4xl"></i>
        </div>
        <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">Admin Management</h3>
        <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">
            Administrator management system will be implemented here. Manage admin accounts, roles, and access permissions.
        </p>
        <div class="flex justify-center space-x-4">
            <button class="btn-primary">
                <i class="fas fa-plus mr-2"></i>
                Add Admin
            </button>
            <button class="btn-secondary">
                <i class="fas fa-shield-alt mr-2"></i>
                Manage Roles
            </button>
        </div>
    </div>
</div>
@endsection 