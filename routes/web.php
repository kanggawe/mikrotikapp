<?php

use App\Models\Nas;
use App\Models\RadCheck;
use App\Models\RadReply;
use App\Models\RadUserGroup;
use App\Models\RadGroupCheck;
use App\Models\RadGroupReply;
use App\Http\Controllers\NasController;
use App\Http\Controllers\RadiusController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HotspotSessionController;
use Illuminate\Support\Facades\Route;

// Dashboard/Home Route
Route::get('/', function () {
    return view('welcome');
})->name('dashboard');

// Alternative dashboard route
Route::get('/dashboard', function () {
    return view('welcome');
})->name('dashboard.home');

// NAS Device Routes - Use NasController
Route::resource('nas', NasController::class);

// User Management Routes
Route::get('/users', function () {
    $users = RadCheck::where('attribute', 'Cleartext-Password')->get();
    return view('radius.users', compact('users'));
})->name('users.index');

Route::get('/users/checks', function () {
    $checks = RadCheck::all();
    return view('radius.users-checks', compact('checks'));
})->name('users.checks');

Route::get('/users/replies', function () {
    $replies = RadReply::all();
    return view('radius.users-replies', compact('replies'));
})->name('users.replies');

Route::get('/users/groups', function () {
    $userGroups = RadUserGroup::all();
    return view('radius.users-groups', compact('userGroups'));
})->name('users.groups');

// Group Management Routes
Route::get('/groups', function () {
    $groups = RadGroupCheck::select('groupname')->distinct()->get();
    return view('radius.groups', compact('groups'));
})->name('groups.index');

Route::get('/groups/checks', function () {
    $groupChecks = RadGroupCheck::all();
    return view('radius.groups-checks', compact('groupChecks'));
})->name('groups.checks');

Route::get('/groups/replies', function () {
    $groupReplies = RadGroupReply::all();
    return view('radius.groups-replies', compact('groupReplies'));
})->name('groups.replies');

// Accounting Route
Route::get('/accounting', function () {
    $accounting = \App\Models\RadAcct::orderBy('acctstarttime', 'desc')->limit(100)->get();
    return view('radius.accounting', compact('accounting'));
})->name('accounting');

// Authentication Logs Route
Route::get('/auth-logs', function () {
    $authLogs = \App\Models\RadPostAuth::orderBy('created_at', 'desc')->limit(100)->get();
    return view('radius.auth-logs', compact('authLogs'));
})->name('auth-logs');

// Settings Route
Route::get('/settings', function () {
    return view('radius.settings');
})->name('settings');

// Documentation Route
Route::get('/documentation', function () {
    return view('radius.documentation');
})->name('documentation');

// Account Routes
Route::get('/account', function () {
    return view('account.index');
})->name('account.index');

// FTTH Routes
Route::get('/ftth', function () {
    return view('ftth.index');
})->name('ftth.index');

// PPP-DHCP Routes
Route::prefix('ppp')->name('ppp.')->group(function () {
    Route::get('/users', function () {
        return view('ppp.users');
    })->name('users');
    
    Route::get('/groups', function () {
        return view('ppp.groups');
    })->name('groups');
    
    Route::get('/accounting', function () {
        return view('ppp.accounting');
    })->name('accounting');
});

// Hotspot Routes
Route::prefix('hotspot')->name('hotspot.')->group(function () {
    Route::get('/users', function () {
        return view('hotspot.users');
    })->name('users');
    
    Route::get('/profiles', function () {
        return view('hotspot.profiles');
    })->name('profiles');
    
    Route::controller(HotspotSessionController::class)->group(function () {
        Route::get('/sessions', 'index')->name('sessions');
        Route::get('/sessions/refresh', 'refresh')->name('sessions.refresh');
        Route::get('/sessions/export', 'export')->name('sessions.export');
        Route::post('/sessions/{id}/disconnect', 'disconnect')->name('sessions.disconnect');
        Route::post('/sessions/bulk-disconnect', 'bulkDisconnect')->name('sessions.bulkDisconnect');
        Route::post('/sessions/{id}/message', 'sendMessage')->name('sessions.sendMessage');
        Route::post('/sessions/bulk-message', 'bulkMessage')->name('sessions.bulkMessage');
    });
});

// Billing Routes
Route::prefix('billing')->name('billing.')->group(function () {
    Route::get('/member', function () {
        return view('billing.member');
    })->name('member');
    
    Route::get('/invoice', function () {
        return view('billing.invoice');
    })->name('invoice');
    
    Route::get('/transaction', function () {
        return view('billing.transaction');
    })->name('transaction');
    
    Route::get('/referral', function () {
        return view('billing.referral');
    })->name('referral');
    
    Route::get('/settings', function () {
        return view('billing.settings');
    })->name('settings');
});

// Report Routes
Route::prefix('report')->name('report.')->group(function () {
    Route::get('/usage', function () {
        return view('report.usage');
    })->name('usage');
    
    Route::get('/financial', function () {
        return view('report.financial');
    })->name('financial');
    
    Route::get('/export', function () {
        return view('report.export');
    })->name('export');
});

// Payment Channel Routes
Route::prefix('payment')->name('payment.')->group(function () {
    Route::get('/ewallet', function () {
        return view('payment.ewallet');
    })->name('ewallet');
    
    Route::get('/bank', function () {
        return view('payment.bank');
    })->name('bank');
    
    Route::get('/retail', function () {
        return view('payment.retail');
    })->name('retail');
});

// Utility Routes
Route::prefix('utility')->name('utility.')->group(function () {
    Route::get('/admin', function () {
        return view('utility.admin');
    })->name('admin');
    
    Route::get('/whatsapp', function () {
        return view('utility.whatsapp');
    })->name('whatsapp');
    
    Route::get('/service', function () {
        return view('utility.service');
    })->name('service');
    
    Route::get('/backup', function () {
        return view('utility.backup');
    })->name('backup');
    
    Route::get('/map', function () {
        return view('utility.map');
    })->name('map');
    
    Route::get('/syslog', function () {
        return view('utility.syslog');
    })->name('syslog');
    
    Route::get('/changelog', function () {
        return view('utility.changelog');
    })->name('changelog');
});

// API Routes
Route::prefix('api')->name('api.')->group(function () {
    Route::get('/nas/status/{id}', function ($id) {
        // Return NAS device status
        return response()->json(['status' => 'online']);
    })->name('nas.status');

    Route::get('/stats', function () {
        // Return dashboard statistics
        return response()->json([
            'nas_count' => Nas::count(),
            'active_users' => 0, // Placeholder
            'user_groups' => RadUserGroup::select('groupname')->distinct()->count(),
            'system_status' => 'online'
        ]);
    })->name('stats');
});

// Auth Routes
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
