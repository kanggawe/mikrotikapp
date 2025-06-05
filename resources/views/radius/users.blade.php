@extends('layouts.app')

@section('title', 'RADIUS Users - MikroTik RADIUS Management')
@section('page_title', 'RADIUS Users')
@section('page_subtitle', 'Manage RADIUS user authentication')

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
                <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">RADIUS</span>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">Users</span>
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
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">RADIUS Users</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Manage user authentication and access credentials
            </p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-4 sm:flex sm:space-x-3">
            <button type="button" class="btn-secondary">
                <i class="fas fa-download mr-2"></i>
                Export Users
            </button>
            <button class="btn-primary">
                <i class="fas fa-user-plus mr-2"></i>
                Add User
            </button>
        </div>
    </div>
</div>

<!-- Stats Overview -->
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
    <!-- Total Users -->
    <div class="content-section p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-600 rounded-md flex items-center justify-center">
                    <i class="fas fa-users text-white text-sm"></i>
                </div>
            </div>
            <div class="ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Users</dt>
                    <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $users->count() }}</dd>
                </dl>
            </div>
        </div>
    </div>

    <!-- Active Sessions -->
    <div class="content-section p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-green-600 rounded-md flex items-center justify-center">
                    <i class="fas fa-check-circle text-white text-sm"></i>
                </div>
            </div>
            <div class="ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Active Sessions</dt>
                    <dd class="text-lg font-medium text-gray-900 dark:text-white">142</dd>
                </dl>
            </div>
        </div>
    </div>

    <!-- Blocked Users -->
    <div class="content-section p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-red-600 rounded-md flex items-center justify-center">
                    <i class="fas fa-ban text-white text-sm"></i>
                </div>
            </div>
            <div class="ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Blocked</dt>
                    <dd class="text-lg font-medium text-gray-900 dark:text-white">8</dd>
                </dl>
            </div>
        </div>
    </div>

    <!-- Recent Logins -->
    <div class="content-section p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-purple-600 rounded-md flex items-center justify-center">
                    <i class="fas fa-sign-in-alt text-white text-sm"></i>
                </div>
            </div>
            <div class="ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Recent Logins</dt>
                    <dd class="text-lg font-medium text-gray-900 dark:text-white">24</dd>
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
                        <label for="search" class="sr-only">Search users</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400 text-sm"></i>
                            </div>
                            <input type="text" 
                                   name="search" 
                                   id="search" 
                                   class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-md leading-5 bg-white dark:bg-gray-700 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                                   placeholder="Search users by username or attribute...">
                        </div>
                    </div>
                    
                    <!-- Filter by Attribute -->
                    <div class="sm:w-48">
                        <select id="attribute-filter" 
                                class="block w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">All Attributes</option>
                            <option value="Cleartext-Password">Password</option>
                            <option value="User-Name">Username</option>
                            <option value="Framed-IP-Address">IP Address</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Users Table -->
<div class="content-section">
    @if($users->count() > 0)
        <div class="overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            User Information
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Attribute
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Operator
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Value
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($users as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center shadow-md">
                                            <i class="fas fa-user text-white text-sm"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ $user->username }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-500">
                                            ID: #{{ $user->id }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                    {{ $user->attribute }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                <code class="bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded text-xs">{{ $user->op }}</code>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                @if($user->attribute == 'Cleartext-Password')
                                    <span class="text-gray-400">••••••••</span>
                                @else
                                    {{ Str::limit($user->value, 30) }}
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <button class="inline-flex items-center p-2 text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-md transition-colors duration-200" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="inline-flex items-center p-2 text-yellow-600 dark:text-yellow-400 hover:text-yellow-900 dark:hover:text-yellow-300 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 rounded-md transition-colors duration-200" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="inline-flex items-center p-2 text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300 hover:bg-green-50 dark:hover:bg-green-900/20 rounded-md transition-colors duration-200" title="Test Auth">
                                        <i class="fas fa-key"></i>
                                    </button>
                                    <button class="inline-flex items-center p-2 text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-md transition-colors duration-200" title="Delete">
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
                    Showing <span class="font-medium">{{ $users->count() }}</span> user records
                </div>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    <i class="fas fa-info-circle mr-1"></i>
                    Authentication attributes configured
                </div>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="w-24 h-24 mx-auto bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-6">
                <i class="fas fa-users text-gray-400 dark:text-gray-500 text-4xl"></i>
            </div>
            <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">No users found</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">
                Start by creating your first RADIUS user. Configure authentication attributes and access policies.
            </p>
            <button class="btn-primary">
                <i class="fas fa-user-plus mr-2"></i>
                Add Your First User
            </button>
        </div>
    @endif
</div>
@endsection 