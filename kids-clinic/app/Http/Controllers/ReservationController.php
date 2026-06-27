<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Kid;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Reservation::with(['kid', 'user'])->latest('visit_date');

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $reservations = $query->get();
        return view('reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $kids = Kid::orderBy('full_name')->get();
        $selectedKidId = $request->get('kid_id');
        
        return view('reservations.create', compact('kids', 'selectedKidId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kid_id' => 'required|exists:kids,id',
            'visit_date' => 'required|date',
            'fee' => 'required|numeric|min:0',
            'notes' => 'nullable|string'
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'Scheduled';
        $validated['payment_status'] = 'Pending';

        Reservation::create($validated);

        return redirect()->route('reservations.index')
            ->with('success', 'تم تسجيل الحجز بنجاح.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        $reservation->load(['kid', 'user']);
        return view('reservations.show', compact('reservation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        $kids = Kid::orderBy('full_name')->get();
        return view('reservations.edit', compact('reservation', 'kids'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'kid_id' => 'required|exists:kids,id',
            'visit_date' => 'required|date',
            'fee' => 'required|numeric|min:0',
            'status' => 'required|in:Scheduled,Completed,Cancelled',
            'payment_status' => 'required|in:Pending,Paid',
            'notes' => 'nullable|string'
        ]);

        $reservation->update($validated);

        return redirect()->route('reservations.index')
            ->with('success', 'تم تحديث بيانات الحجز بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()->route('reservations.index')
            ->with('success', 'تم إلغاء السجل بنجاح.');
    }
}
