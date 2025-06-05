@extends('layouts.app')

@section('title', 'Groups - MikroTik RADIUS Management')
@section('page_title', 'Group Management')
@section('page_subtitle', 'Manage RADIUS user groups and their policies')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row gap-4">
    <a href="{{ route('groups.checks') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
        <i class="fas fa-check-circle mr-2"></i>
        Group Checks
    </a>
    <a href="{{ route('groups.replies') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
        <i class="fas fa-reply-all mr-2"></i>
        Group Replies
    </a>
</div>

<div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-md">
    <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">RADIUS Groups</h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
            Manage user groups and their authentication policies
        </p>
    </div>
    
    <div class="text-center py-12">
        <div class="w-24 h-24 mx-auto bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-layer-group text-gray-400 dark:text-gray-500 text-3xl"></i>
        </div>
        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No groups found</h3>
        <p class="text-gray-500 dark:text-gray-400 mb-6">Get started by creating your first user group.</p>
        <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <i class="fas fa-plus mr-2"></i>
            Add Group
        </button>
    </div>
</div>
@endsection 