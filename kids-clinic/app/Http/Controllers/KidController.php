<?php

namespace App\Http\Controllers;

use App\Models\Kid;
use Illuminate\Http\Request;

class KidController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Kid::latest();

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where('full_name', 'like', "%{$searchTerm}%")
                  ->orWhere('contact_phone', 'like', "%{$searchTerm}%");
        }

        $kids = $query->get();
        return view('kids.index', compact('kids'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kids.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'full_name.required' => 'اسم الطفل مطلوب ولا يمكن تركه فارغاً.',
            'full_name.string' => 'اسم الطفل يجب أن يتكون من أحرف فقط.',
            'full_name.max' => 'اسم الطفل يجب ألا يتجاوز 150 حرفاً.',
            'date_of_birth.required' => 'تاريخ الميلاد مطلوب لحساب العمر بدقة.',
            'date_of_birth.date' => 'صيغة تاريخ الميلاد غير صحيحة.',
            'date_of_birth.before_or_equal' => 'عمر الطفل يجب أن يكون شهراً على الأقل.',
            'gender.required' => 'تحديد جنس الطفل مطلوب.',
            'gender.in' => 'الجنس المحدد غير صالح.',
            'parent_name.string' => 'اسم ولي الأمر يجب أن يتكون من أحرف فقط.',
            'parent_name.max' => 'اسم ولي الأمر يجب ألا يتجاوز 150 حرفاً.',
            'contact_phone.regex' => 'رقم التليفون المدخل غير صالح (يجب أن يكون رقماً دولياً صحيحاً).',
            'contact_phone.max' => 'رقم التليفون يجب ألا يتجاوز 20 رقماً.',
        ];

        $validated = $request->validate([
            'full_name' => 'required|string|max:150',
            'date_of_birth' => 'required|date|before_or_equal:-1 month',
            'gender' => 'required|in:Male,Female',
            'parent_name' => 'nullable|string|max:150',
            'contact_phone' => ['nullable', 'string', 'max:20', 'regex:/^\+?[1-9]\d{1,14}$/'],
        ], $messages);

        Kid::create($validated);

        return redirect()->route('kids.index')
            ->with('success', 'تم تسجيل بيانات الطفل بنجاح.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kid $kid)
    {
        return view('kids.show', compact('kid'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kid $kid)
    {
        return view('kids.edit', compact('kid'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kid $kid)
    {
        $messages = [
            'full_name.required' => 'اسم الطفل مطلوب ولا يمكن تركه فارغاً.',
            'full_name.string' => 'اسم الطفل يجب أن يتكون من أحرف فقط.',
            'full_name.max' => 'اسم الطفل يجب ألا يتجاوز 150 حرفاً.',
            'date_of_birth.required' => 'تاريخ الميلاد مطلوب لحساب العمر بدقة.',
            'date_of_birth.date' => 'صيغة تاريخ الميلاد غير صحيحة.',
            'date_of_birth.before_or_equal' => 'عمر الطفل يجب أن يكون شهراً على الأقل.',
            'gender.required' => 'تحديد جنس الطفل مطلوب.',
            'gender.in' => 'الجنس المحدد غير صالح.',
            'parent_name.string' => 'اسم ولي الأمر يجب أن يتكون من أحرف فقط.',
            'parent_name.max' => 'اسم ولي الأمر يجب ألا يتجاوز 150 حرفاً.',
            'contact_phone.regex' => 'رقم التليفون المدخل غير صالح (يجب أن يكون رقماً دولياً صحيحاً).',
            'contact_phone.max' => 'رقم التليفون يجب ألا يتجاوز 20 رقماً.',
        ];

        $validated = $request->validate([
            'full_name' => 'required|string|max:150',
            'date_of_birth' => 'required|date|before_or_equal:-1 month',
            'gender' => 'required|in:Male,Female',
            'parent_name' => 'nullable|string|max:150',
            'contact_phone' => ['nullable', 'string', 'max:20', 'regex:/^\+?[1-9]\d{1,14}$/'],
        ], $messages);

        $kid->update($validated);

        return redirect()->route('kids.index')
            ->with('success', 'تم تحديث بيانات الطفل بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kid $kid)
    {
        try {
            $kid->delete();
            return redirect()->route('kids.index')
                ->with('success', 'تم حذف السجل بنجاح.');
        } catch (\Exception $e) {
            return redirect()->route('kids.index')
                ->with('error', 'لا يمكن حذف هذا السجل لارتباطه ببيانات طبية.');
        }
    }
}
