@extends('layouts.app')

@section('title', 'RADIUS Server Config - MikroTik RADIUS Management')
@section('page_title', 'RADIUS Server Configuration')
@section('page_subtitle', 'Configure RADIUS server settings and parameters')

@section('content')
<div class="content-section p-8">
    <div class="text-center">
        <div class="w-24 h-24 mx-auto bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mb-6">
            <i class="fas fa-server text-blue-600 dark:text-blue-400 text-4xl"></i>
        </div>
        <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">RADIUS Server Configuration</h3>
        <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">
            RADIUS server configuration will be implemented here. Configure authentication settings, database connections, and server parameters.
        </p>
        <div class="flex justify-center space-x-4">
            <button class="btn-primary">
                <i class="fas fa-cog mr-2"></i>
                Server Settings
            </button>
            <button class="btn-secondary">
                <i class="fas fa-database mr-2"></i>
                Database Config
            </button>
        </div>
    </div>
</div>
@endsection 