<?php

namespace App\Http\Controllers;

use App\Models\RadCheck;
use App\Models\RadReply;
use App\Models\RadUserGroup;
use Illuminate\Http\Request;

class RadiusController extends Controller
{
    public function index()
    {
        // Gabungkan data dari radcheck, radreply, radusergroup, radgroupcheck, radgroupreply
        $usernames = \App\Models\RadCheck::select('username')->distinct()->get()->pluck('username');
        $data = [];
        foreach ($usernames as $username) {
            $password = \App\Models\RadCheck::where('username', $username)->where('attribute', 'Cleartext-Password')->value('value');
            $bandwidth = \App\Models\RadReply::where('username', $username)->where('attribute', 'Mikrotik-Rate-Limit')->value('value');
            $groupname = \App\Models\RadUserGroup::where('username', $username)->value('groupname');
            // Ambil groupcheck dan groupreply berdasarkan groupname
            $groupcheck = null;
            $groupreply = null;
            if ($groupname) {
                $groupcheck = \App\Models\RadGroupCheck::where('groupname', $groupname)->pluck('attribute', 'value')->toArray();
                $groupreply = \App\Models\RadGroupReply::where('groupname', $groupname)->pluck('attribute', 'value')->toArray();
            }
            $data[] = [
                'username' => $username,
                'password' => $password,
                'bandwidth' => $bandwidth,
                'groupname' => $groupname,
                'groupcheck' => $groupcheck ? json_encode($groupcheck) : '-',
                'groupreply' => $groupreply ? json_encode($groupreply) : '-',
            ];
        }
        return view('radius.index', compact('data'));
    }

    public function create()
    {
        // Ambil data NAS untuk dropdown
        $nasList = \App\Models\Nas::all();

        return view('radius.create', compact('nasList'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'bandwidth' => 'required|string|max:255',
            'groupname' => 'required|string|max:255',
            // 'nas' tidak wajib, defaultnya ALL jika tidak diisi
        ]);

        // Simpan ke radcheck
        RadCheck::create([
            'username' => $request->username,
            'attribute' => 'Cleartext-Password',
            'op' => ':=',
            'value' => $request->password,
        ]);

        // Simpan ke radreply
        RadReply::create([
            'username' => $request->username,
            'attribute' => 'Mikrotik-Rate-Limit',
            'op' => '=',
            'value' => $request->bandwidth,
        ]);

        // Simpan ke radusergroup
        RadUserGroup::create([
            'username' => $request->username,
            'groupname' => $request->groupname,
            'priority' => 1,
        ]);

        // Simpan ke user_nas (relasi user dengan NAS)
        if ($request->filled('nas')) {
            foreach ($request->nas as $nas_id) {
                \App\Models\UserNas::create([
                    'username' => $request->username,
                    'nas_id' => $nas_id,
                ]);
            }
        } else {
            // Jika tidak dipilih, simpan relasi dengan nas_id = null (artinya ALL NAS)
            \App\Models\UserNas::create([
                'username' => $request->username,
                'nas_id' => null,
            ]);
        }

        return redirect()->route('radius.index')->with('success', 'User added');
    }

    public function destroy($username)
    {
        RadCheck::where('username', $username)->delete();
        RadReply::where('username', $username)->delete();
        RadUserGroup::where('username', $username)->delete();

        return redirect()->route('radius.index')->with('success', 'User deleted');
    }

    public function profile($username)
    {
        // Ambil data user
        $password = \App\Models\RadCheck::where('username', $username)->where('attribute', 'Cleartext-Password')->value('value');
        $bandwidth = \App\Models\RadReply::where('username', $username)->where('attribute', 'Mikrotik-Rate-Limit')->value('value');
        $groupname = \App\Models\RadUserGroup::where('username', $username)->value('groupname');
        $groupcheck = $groupname ? json_encode(\App\Models\RadGroupCheck::where('groupname', $groupname)->pluck('attribute', 'value')->toArray()) : '-';
        $groupreply = $groupname ? json_encode(\App\Models\RadGroupReply::where('groupname', $groupname)->pluck('attribute', 'value')->toArray()) : '-';
        $user = [
            'username' => $username,
            'password' => $password,
            'bandwidth' => $bandwidth,
            'groupname' => $groupname,
            'groupcheck' => $groupcheck,
            'groupreply' => $groupreply,
        ];
        // Ambil sesi aktif user dari radacct (jika ada tabelnya)
        $sessions = [];
        if (\Schema::hasTable('radacct')) {
            $sessions = \DB::table('radacct')
                ->where('username', $username)
                ->orderByDesc('acctstarttime')
                ->limit(10)
                ->get()
                ->map(function($row) {
                    return [
                        'nasip' => $row->nasipaddress ?? '-',
                        'start' => $row->acctstarttime ?? '-',
                        'stop' => $row->acctstoptime ?? null,
                    ];
                })->toArray();
        }
        return view('radius.profile', compact('user', 'sessions'));
    }

    public function edit($username)
    {
        $password = \App\Models\RadCheck::where('username', $username)->where('attribute', 'Cleartext-Password')->value('value');
        $bandwidth = \App\Models\RadReply::where('username', $username)->where('attribute', 'Mikrotik-Rate-Limit')->value('value');
        $groupname = \App\Models\RadUserGroup::where('username', $username)->value('groupname');
        // Ambil data NAS untuk dropdown dan relasi user
        $nasList = \App\Models\Nas::all();
        $userNas = \App\Models\UserNas::where('username', $username)->pluck('nas_id')->toArray();
        $user = [
            'username' => $username,
            'password' => $password,
            'bandwidth' => $bandwidth,
            'groupname' => $groupname,
        ];
        return view('radius.edit', compact('user', 'nasList', 'userNas'));
    }

    public function update(Request $request, $username)
    {
        $request->validate([
            'password' => 'required|string|max:255',
            'bandwidth' => 'required|string|max:255',
            'groupname' => 'required|string|max:255',
        ]);
        \App\Models\RadCheck::where('username', $username)->where('attribute', 'Cleartext-Password')->update(['value' => $request->password]);
        \App\Models\RadReply::where('username', $username)->where('attribute', 'Mikrotik-Rate-Limit')->update(['value' => $request->bandwidth]);
        \App\Models\RadUserGroup::where('username', $username)->update(['groupname' => $request->groupname]);

        // Update relasi user dengan NAS
        \App\Models\UserNas::where('username', $username)->delete();
        if ($request->filled('nas')) {
            foreach ($request->nas as $nas_id) {
                \App\Models\UserNas::create([
                    'username' => $username,
                    'nas_id' => $nas_id,
                ]);
            }
        } else {
            \App\Models\UserNas::create([
                'username' => $username,
                'nas_id' => null,
            ]);
        }

        return redirect()->route('radius.profile', $username)->with('success', 'User updated');
    }
}
