<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultationController extends Controller
{
    public function index()
    {
        $consultations = Consultation::with(['reservation.kid', 'user'])->latest()->paginate(15);
        return view('consultations.index', compact('consultations'));
    }

    public function create()
    {
        // For a simple CRUD, we can just list recent reservations without consultations
        $reservations = Reservation::whereDoesntHave('consultation')->with('kid')->get();
        return view('consultations.create', compact('reservations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reservation_id' => 'required|exists:reservations,id|unique:consultations,reservation_id',
            'diagnosis_notes' => 'nullable|string'
        ]);

        $validated['user_id'] = Auth::id();

        Consultation::create($validated);

        return redirect()->route('consultations.index')->with('success', 'تمت إضافة الاستشارة بنجاح.');
    }

    public function edit(Consultation $consultation)
    {
        $reservations = Reservation::where('id', $consultation->reservation_id)->with('kid')->get();
        return view('consultations.edit', compact('consultation', 'reservations'));
    }

    public function update(Request $request, Consultation $consultation)
    {
        $validated = $request->validate([
            'diagnosis_notes' => 'nullable|string'
        ]);

        $consultation->update($validated);

        return redirect()->route('consultations.index')->with('success', 'تم تحديث الاستشارة بنجاح.');
    }

    public function destroy(Consultation $consultation)
    {
        $consultation->delete();
        return redirect()->route('consultations.index')->with('success', 'تم حذف الاستشارة بنجاح.');
    }
}
