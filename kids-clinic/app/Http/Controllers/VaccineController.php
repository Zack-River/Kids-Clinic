<?php

namespace App\Http\Controllers;

use App\Models\Vaccine;
use Illuminate\Http\Request;

class VaccineController extends Controller
{
    public function index()
    {
        $vaccines = Vaccine::latest()->paginate(15);
        return view('vaccines.index', compact('vaccines'));
    }

    public function create()
    {
        return view('vaccines.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:vaccines,name',
            'category' => 'nullable|string|max:100',
            'manufacturer' => 'nullable|string|max:100',
        ]);

        Vaccine::create($validated);

        return redirect()->route('vaccines.index')->with('success', 'تمت إضافة التطعيم بنجاح.');
    }

    public function edit(Vaccine $vaccine)
    {
        return view('vaccines.edit', compact('vaccine'));
    }

    public function update(Request $request, Vaccine $vaccine)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:vaccines,name,' . $vaccine->id,
            'category' => 'nullable|string|max:100',
            'manufacturer' => 'nullable|string|max:100',
        ]);

        $vaccine->update($validated);

        return redirect()->route('vaccines.index')->with('success', 'تم تحديث التطعيم بنجاح.');
    }

    public function destroy(Vaccine $vaccine)
    {
        $vaccine->delete();
        return redirect()->route('vaccines.index')->with('success', 'تم حذف التطعيم بنجاح.');
    }
}
