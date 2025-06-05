@extends('layouts.app')

@section('title', 'User Groups - MikroTik RADIUS Management')
@section('page_title', 'User Group Associations')
@section('page_subtitle', 'Manage user group memberships')

@section('content')
<div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-md">
    <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">User Group Memberships</h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
            View and manage which users belong to which groups
        </p>
    </div>
    
    <div class="text-center py-12">
        <i class="fas fa-users-cog text-gray-400 dark:text-gray-500 text-6xl mb-4"></i>
        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No user group associations</h3>
        <p class="text-gray-500 dark:text-gray-400">User group memberships will be displayed here.</p>
    </div>
</div>
@endsection 