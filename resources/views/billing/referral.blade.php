@extends('layouts.app')

@section('title', 'Referral Program - MikroTik RADIUS Management')
@section('page_title', 'Referral Program')
@section('page_subtitle', 'Manage customer referral system and rewards')

@section('content')
<div class="content-section p-8">
    <div class="text-center">
        <div class="w-24 h-24 mx-auto bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mb-6">
            <i class="fas fa-users-cog text-blue-600 dark:text-blue-400 text-4xl"></i>
        </div>
        <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">Referral Program</h3>
        <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">
            Referral program functionality will be implemented here. Manage customer referrals, track rewards, and monitor performance.
        </p>
        <div class="flex justify-center space-x-4">
            <button class="btn-primary">
                <i class="fas fa-plus mr-2"></i>
                Create Campaign
            </button>
            <button class="btn-secondary">
                <i class="fas fa-chart-line mr-2"></i>
                View Analytics
            </button>
        </div>
    </div>
</div>
@endsection 