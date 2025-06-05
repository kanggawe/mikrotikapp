@extends('layouts.app')

@section('title', 'Member Management - MikroTik RADIUS Management')
@section('page_title', 'Member Management')
@section('page_subtitle', 'Manage customer accounts and memberships')

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
                <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">Billing</span>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">Member</span>
            </div>
        </li>
    </ol>
</nav>
@endsection

@section('content')
<div class="content-section p-8">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-blue-50 dark:bg-blue-900/20 p-6 rounded-lg border border-blue-200 dark:border-blue-800">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-blue-900 dark:text-blue-100">1,245</h3>
                    <p class="text-blue-600 dark:text-blue-300 text-sm">Total Members</p>
                </div>
            </div>
        </div>

        <div class="bg-green-50 dark:bg-green-900/20 p-6 rounded-lg border border-green-200 dark:border-green-800">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-green-900 dark:text-green-100">1,189</h3>
                    <p class="text-green-600 dark:text-green-300 text-sm">Active</p>
                </div>
            </div>
        </div>

        <div class="bg-yellow-50 dark:bg-yellow-900/20 p-6 rounded-lg border border-yellow-200 dark:border-yellow-800">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-yellow-900 dark:text-yellow-100">32</h3>
                    <p class="text-yellow-600 dark:text-yellow-300 text-sm">Pending</p>
                </div>
            </div>
        </div>

        <div class="bg-red-50 dark:bg-red-900/20 p-6 rounded-lg border border-red-200 dark:border-red-800">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-red-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-ban text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-red-900 dark:text-red-100">24</h3>
                    <p class="text-red-600 dark:text-red-300 text-sm">Suspended</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Member Management Content -->
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Customer Members</h3>
                <div class="flex space-x-3">
                    <button class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200 btn-secondary">
                        <i class="fas fa-download mr-2"></i>
                        Export
                    </button>
                    <button class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-white dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200 btn-primary">
                        <i class="fas fa-plus mr-2"></i>
                        Add Member
                    </button>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <div class="text-center py-12">
                <div class="w-24 h-24 mx-auto bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-users text-blue-600 dark:text-blue-400 text-4xl"></i>
                </div>
                <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">Member Management</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">
                    Customer member management system will be implemented here. Manage customer accounts, subscriptions, and membership details.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection 