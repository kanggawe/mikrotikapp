@extends('layouts.app')

@section('title', 'Add NAS Device - MikroTik RADIUS Management')
@section('page_title', 'Add NAS Device')
@section('page_subtitle', 'Configure a new Network Access Server device')

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
                <a href="{{ route('nas.index') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">NAS Devices</a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">Add Device</span>
            </div>
        </li>
    </ol>
</nav>
@endsection

@section('content')
<div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-md">
    <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">NAS Device Configuration</h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
            Add a new Network Access Server device to your RADIUS configuration
        </p>
    </div>
    
    <form action="{{ route('nas.store') }}" method="POST" class="p-6">
        @csrf
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <!-- NAS Name -->
            <div>
                <label for="nasname" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    NAS IP Address *
                </label>
                <input type="text" name="nasname" id="nasname" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white sm:text-sm"
                       placeholder="192.168.1.1">
            </div>

            <!-- Short Name -->
            <div>
                <label for="shortname" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Short Name
                </label>
                <input type="text" name="shortname" id="shortname"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white sm:text-sm"
                       placeholder="router1">
            </div>

            <!-- Type -->
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Device Type
                </label>
                <select name="type" id="type"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white sm:text-sm">
                    <option value="mikrotik">MikroTik</option>
                    <option value="cisco">Cisco</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <!-- Ports -->
            <div>
                <label for="ports" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Ports
                </label>
                <input type="text" name="ports" id="ports"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white sm:text-sm"
                       placeholder="1812,1813">
            </div>

            <!-- Secret -->
            <div>
                <label for="secret" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Shared Secret *
                </label>
                <input type="password" name="secret" id="secret" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white sm:text-sm"
                       placeholder="Enter shared secret">
            </div>

            <!-- Server -->
            <div>
                <label for="server" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Server
                </label>
                <input type="text" name="server" id="server"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white sm:text-sm"
                       placeholder="radius.example.com">
            </div>

            <!-- Community -->
            <div>
                <label for="community" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Community
                </label>
                <input type="text" name="community" id="community"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white sm:text-sm"
                       placeholder="public">
            </div>

            <!-- Description -->
            <div class="sm:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Description
                </label>
                <textarea name="description" id="description" rows="3"
                          class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white sm:text-sm"
                          placeholder="Enter device description..."></textarea>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="mt-6 flex items-center justify-end space-x-3">
            <a href="{{ route('nas.index') }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Cancel
            </a>
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="fas fa-save mr-2"></i>
                Save Device
            </button>
        </div>
    </form>
</div>
@endsection 