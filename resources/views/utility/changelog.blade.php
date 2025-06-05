@extends('layouts.app')

@section('title', 'Changelog - MikroTik RADIUS Management')
@section('page_title', 'Changelog')
@section('page_subtitle', 'View application updates and version history')

@section('content')
<div class="content-section p-8">
    <div class="text-center">
        <div class="w-24 h-24 mx-auto bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mb-6">
            <i class="fas fa-list-alt text-indigo-600 dark:text-indigo-400 text-4xl"></i>
        </div>
        <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">Changelog</h3>
        <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">
            Application changelog will be displayed here. Track new features, bug fixes, and system improvements across versions.
        </p>
        <div class="flex justify-center space-x-4">
            <button class="btn-primary">
                <i class="fas fa-eye mr-2"></i>
                View All Updates
            </button>
            <button class="btn-secondary">
                <i class="fas fa-bell mr-2"></i>
                Subscribe to Updates
            </button>
        </div>
    </div>
</div>
@endsection 