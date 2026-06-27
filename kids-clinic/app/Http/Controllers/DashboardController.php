<?php

namespace App\Http\Controllers;

use App\Models\Kid;
use App\Models\User;
use App\Models\Reservation;
use App\Models\Consultation;
use App\Models\VaccineRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     */
    public function index()
    {
        $today = Carbon::today();
        
        $totalKids = Kid::count();
        $todayReservations = Reservation::whereDate('visit_date', $today)->count();
        $todayConsultations = Consultation::whereDate('created_at', $today)->count();
        $todayVaccines = VaccineRecord::whereDate('administered_date', $today)->count();

        return view('dashboard.index', compact(
            'totalKids',
            'todayReservations',
            'todayConsultations',
            'todayVaccines'
        ));
    }

    /**
     * Handle global navbar search queries.
     */
    public function globalSearch(Request $request)
    {
        $query = $request->input('q');
        
        if (empty(trim($query))) {
            return response()->json([]);
        }

        $results = [];

        // 1. Search Kids (Patients) - Available to all authenticated users
        $kids = Kid::where('full_name', 'like', "%{$query}%")
                    ->orWhere('contact_phone', 'like', "%{$query}%")
                    ->take(5)
                    ->get();
                    
        foreach ($kids as $kid) {
            $results[] = [
                'type' => 'مريض (طفل)',
                'name' => $kid->full_name,
                'url'  => route('kids.show', $kid->id),
                'icon' => 'child_care'
            ];
        }

        // 2. Search Users (Staff) - Available ONLY to Admin and Mod roles
        if (in_array(auth()->user()->role->name, ['Admin', 'Mod'])) {
            $users = User::where('name', 'like', "%{$query}%")
                        ->orWhere('username', 'like', "%{$query}%")
                        ->take(5)
                        ->get();
                        
            foreach ($users as $u) {
                $results[] = [
                    'type' => 'مستخدم (' . ($u->role->name ?? 'مستخدم') . ')',
                    'name' => $u->name,
                    'url'  => route('users.edit', $u->id),
                    'icon' => 'person'
                ];
            }
        }

        return response()->json($results);
    }
}
