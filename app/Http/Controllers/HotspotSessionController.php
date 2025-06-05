<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RadAcct;
use App\Models\Nas;
use App\Traits\RadiusConnection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;

class HotspotSessionController extends Controller
{
    use RadiusConnection;

    public function index()
    {
        // Get active hotspot sessions
        $sessions = RadAcct::where('acctstoptime', null)
            ->where('nasporttype', 'Wireless-802.11')
            ->orderBy('acctstarttime', 'desc')
            ->get()
            ->map(function ($session) {
                return [
                    'id' => $session->radacctid,
                    'username' => $session->username,
                    'profile' => $session->groupname ?? '1hour', // Default profile if not set
                    'ip' => $session->framedipaddress,
                    'mac' => $session->callingstationid,
                    'nasPort' => $session->nasportid,
                    'sessionId' => $session->acctsessionid,
                    'startTime' => Carbon::parse($session->acctstarttime)->format('Y-m-d H:i:s'),
                    'download' => $session->acctoutputoctets,
                    'upload' => $session->acctinputoctets,
                    'sessionTime' => $session->acctsessiontime,
                    'status' => $this->getSessionStatus($session),
                    'lastActivity' => Carbon::parse($session->acctupdatetime)->format('Y-m-d H:i:s'),
                ];
            });

        // Get session statistics
        $stats = [
            'total' => $sessions->count(),
            'active' => $sessions->where('status', 'active')->count(),
            'idle' => $sessions->where('status', 'idle')->count(),
            'data_usage' => $sessions->sum(function ($session) {
                return $session['download'] + $session['upload'];
            }),
            'average_time' => $sessions->avg('sessionTime')
        ];

        return view('hotspot.sessions', compact('sessions', 'stats'));
    }

    private function getSessionStatus($session)
    {
        if (!$session->acctupdatetime) {
            return 'blocked';
        }

        $lastUpdate = Carbon::parse($session->acctupdatetime);
        $now = Carbon::now();
        $minutesSinceUpdate = $lastUpdate->diffInMinutes($now);

        if ($minutesSinceUpdate <= 5) {
            return 'active';
        }

        return 'idle';
    }

    public function disconnect(Request $request, $id)
    {
        try {
            $session = RadAcct::with('nas')->findOrFail($id);
            
            // First try to disconnect via MikroTik API
            $nasIpAddress = $session->nas->nasname ?? null;
            if ($nasIpAddress) {
                try {
                    $this->disconnectClient($nasIpAddress, $session->callingstationid);
                } catch (\Exception $e) {
                    Log::warning("Failed to disconnect client via API: " . $e->getMessage());
                }
            }
            
            // Update database record
            $session->acctstoptime = now();
            $session->save();

            return response()->json([
                'success' => true,
                'message' => 'Session disconnected successfully'
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to disconnect session: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to disconnect session'
            ], 500);
        }
    }

    public function bulkDisconnect(Request $request)
    {
        try {
            $ids = $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'numeric'
            ]);

            $sessions = RadAcct::with('nas')->whereIn('radacctid', $ids['ids'])->get();
            
            foreach ($sessions as $session) {
                $nasIpAddress = $session->nas->nasname ?? null;
                if ($nasIpAddress) {
                    try {
                        $this->disconnectClient($nasIpAddress, $session->callingstationid);
                    } catch (\Exception $e) {
                        Log::warning("Failed to disconnect client via API: " . $e->getMessage());
                    }
                }
            }

            // Update all sessions in database
            RadAcct::whereIn('radacctid', $ids['ids'])
                ->update(['acctstoptime' => now()]);

            return response()->json([
                'success' => true,
                'message' => 'Selected sessions disconnected successfully'
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to bulk disconnect sessions: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to disconnect sessions'
            ], 500);
        }
    }

    public function refresh()
    {
        // This will be handled by the index method
        return $this->index();
    }

    public function sendMessage(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'message' => 'required|string|max:255',
                'duration' => 'required|integer|min:1|max:60'
            ]);

            $session = RadAcct::with('nas')->findOrFail($id);
            $nasIpAddress = $session->nas->nasname ?? null;

            if (!$nasIpAddress) {
                throw new \Exception("NAS device not found for session");
            }

            $this->sendMessageToClient(
                $nasIpAddress,
                $session->callingstationid,
                $data['message'],
                $data['duration']
            );
            
            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully'
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to send message: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send message'
            ], 500);
        }
    }

    public function bulkMessage(Request $request)
    {
        try {
            $data = $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'numeric',
                'message' => 'required|string|max:255',
                'duration' => 'required|integer|min:1|max:60'
            ]);

            $sessions = RadAcct::with('nas')->whereIn('radacctid', $data['ids'])->get();
            $failed = 0;

            foreach ($sessions as $session) {
                try {
                    $nasIpAddress = $session->nas->nasname ?? null;
                    if ($nasIpAddress) {
                        $this->sendMessageToClient(
                            $nasIpAddress,
                            $session->callingstationid,
                            $data['message'],
                            $data['duration']
                        );
                    } else {
                        $failed++;
                    }
                } catch (\Exception $e) {
                    Log::warning("Failed to send message to client: " . $e->getMessage());
                    $failed++;
                }
            }

            $message = $failed === 0 ? 
                'Messages sent successfully' : 
                "Messages sent with {$failed} failure(s)";

            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to send bulk messages: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send messages'
            ], 500);
        }
    }

    public function export(Request $request)
    {
        $sessions = RadAcct::where('acctstoptime', null)
            ->where('nasporttype', 'Wireless-802.11')
            ->orderBy('acctstarttime', 'desc')
            ->get()
            ->map(function ($session) {
                return [
                    'Username' => $session->username,
                    'IP Address' => $session->framedipaddress,
                    'MAC Address' => $session->callingstationid,
                    'Start Time' => $session->acctstarttime,
                    'Session Time' => $this->formatSessionTime($session->acctsessiontime),
                    'Download' => $this->formatBytes($session->acctoutputoctets),
                    'Upload' => $this->formatBytes($session->acctinputoctets),
                    'Status' => $this->getSessionStatus($session)
                ];
            });

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="hotspot-sessions.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() use ($sessions) {
            $file = fopen('php://output', 'w');
            fputcsv($file, array_keys($sessions->first()));

            foreach ($sessions as $session) {
                fputcsv($file, $session);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    private function formatBytes($bytes)
    {
        if ($bytes === 0) return '0 B';
        $k = 1024;
        $sizes = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = floor(log($bytes) / log($k));
        return number_format($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
    }

    private function formatSessionTime($seconds)
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $secs = $seconds % 60;
        
        if ($hours > 0) {
            return sprintf('%dh %dm', $hours, $minutes);
        } else if ($minutes > 0) {
            return sprintf('%dm %ds', $minutes, $secs);
        } else {
            return sprintf('%ds', $secs);
        }
    }
}
