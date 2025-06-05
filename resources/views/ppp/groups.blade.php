@extends('layouts.app')

@section('title', 'PPP Groups - MikroTik RADIUS Management')
@section('page_title', 'PPP Groups')
@section('page_subtitle', 'Manage PPP user groups and policies')

@section('content')
<div class="content-section p-8">
    <div class="text-center">
        <div class="w-24 h-24 mx-auto bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center mb-6">
            <i class="fas fa-layer-group text-purple-600 dark:text-purple-400 text-4xl"></i>
        </div>
        <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">PPP Groups</h3>
        <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">
            PPP group management system will be implemented here. Organize PPP users into groups and manage access policies.
        </p>
        <div class="flex justify-center space-x-4">
            <button class="btn-primary">
                <i class="fas fa-plus mr-2"></i>
                Add Group
            </button>
            <button class="btn-secondary">
                <i class="fas fa-cogs mr-2"></i>
                Manage Policies
            </button>
        </div>
    </div>
</div>
@endsection 