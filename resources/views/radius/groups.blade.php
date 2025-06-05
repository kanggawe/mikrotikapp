@extends('layouts.app')

@section('title', 'RADIUS Groups - MikroTik RADIUS Management')
@section('page_title', 'RADIUS Groups')
@section('page_subtitle', 'Manage RADIUS user groups and policies')

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
                <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">Groups</span>
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
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">RADIUS Groups</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Manage user groups and their access policies
            </p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-4 sm:flex sm:space-x-3">
            <button type="button" class="btn-secondary">
                <i class="fas fa-download mr-2"></i>
                Export Groups
            </button>
            <button class="btn-primary">
                <i class="fas fa-plus mr-2"></i>
                Add Group
            </button>
        </div>
    </div>
</div>

<!-- Stats Overview -->
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
    <div class="content-section p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-purple-600 rounded-md flex items-center justify-center">
                    <i class="fas fa-layer-group text-white text-sm"></i>
                </div>
            </div>
            <div class="ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Groups</dt>
                    <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ $groups->count() }}</dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="content-section p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-600 rounded-md flex items-center justify-center">
                    <i class="fas fa-users text-white text-sm"></i>
                </div>
            </div>
            <div class="ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Active Users</dt>
                    <dd class="text-lg font-medium text-gray-900 dark:text-white">1,245</dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="content-section p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-green-600 rounded-md flex items-center justify-center">
                    <i class="fas fa-check-circle text-white text-sm"></i>
                </div>
            </div>
            <div class="ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Active Groups</dt>
                    <dd class="text-lg font-medium text-gray-900 dark:text-white">12</dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="content-section p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-yellow-600 rounded-md flex items-center justify-center">
                    <i class="fas fa-cog text-white text-sm"></i>
                </div>
            </div>
            <div class="ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Policies</dt>
                    <dd class="text-lg font-medium text-gray-900 dark:text-white">48</dd>
                </dl>
            </div>
        </div>
    </div>
</div>

<!-- Groups Table -->
<div class="content-section">
    @if($groups->count() > 0)
        <div class="overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Group Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Members
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Policies
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
                    @foreach($groups as $group)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center shadow-md">
                                            <i class="fas fa-layer-group text-white text-sm"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ $group->groupname }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-500">
                                            Created: {{ now()->subDays(rand(1, 30))->format('M d, Y') }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ rand(10, 150) }} users
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ rand(2, 8) }} policies
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                    <div class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1.5"></div>
                                    Active
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <button class="inline-flex items-center p-2 text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-md transition-colors duration-200" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="inline-flex items-center p-2 text-yellow-600 dark:text-yellow-400 hover:text-yellow-900 dark:hover:text-yellow-300 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 rounded-md transition-colors duration-200" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="inline-flex items-center p-2 text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300 hover:bg-green-50 dark:hover:bg-green-900/20 rounded-md transition-colors duration-200" title="Manage Policies">
                                        <i class="fas fa-cogs"></i>
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
    @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="w-24 h-24 mx-auto bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-6">
                <i class="fas fa-layer-group text-gray-400 dark:text-gray-500 text-4xl"></i>
            </div>
            <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">No groups found</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">
                Create your first RADIUS group to organize users and define access policies.
            </p>
            <button class="btn-primary">
                <i class="fas fa-plus mr-2"></i>
                Create Your First Group
            </button>
        </div>
    @endif
</div>
@endsection 