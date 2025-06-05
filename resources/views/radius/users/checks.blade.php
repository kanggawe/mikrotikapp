@extends('layouts.app')

@section('title', 'User Checks - MikroTik RADIUS Management')
@section('page_title', 'User Authentication Checks')
@section('page_subtitle', 'Manage user authentication parameters')

@section('content')
<div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-md">
    <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">User Authentication Checks</h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
            Configure authentication parameters for users
        </p>
    </div>
    
    <div class="text-center py-12">
        <i class="fas fa-user-check text-gray-400 dark:text-gray-500 text-6xl mb-4"></i>
        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No user checks configured</h3>
        <p class="text-gray-500 dark:text-gray-400">User authentication parameters will be displayed here.</p>
    </div>
</div>
@endsection 