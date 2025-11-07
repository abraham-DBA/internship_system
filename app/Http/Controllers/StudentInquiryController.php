<?php

namespace App\Http\Controllers;

use App\Models\StudentInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use App\Mail\StaffInquiryNotification;
use App\Mail\InquiryResolvedMail;

class StudentInquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(StudentInquiry $studentInquiry)
    {
        $inquiries = StudentInquiry::latest()->paginate(10);
        return view('inquiries.index', compact('inquiries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => ['required','string','max:255'],
            'email' => ['required','email','max:255'],
            'reg_number' => ['nullable','string','max:255'],
            'subject' => ['required','string','max:255'],
            'message' => ['required','string','max:5000'],
        ]);

        $data['status'] = 'pending';
        $inquiry = StudentInquiry::create($data);

        // Notify Staff Cohort 2025 via email
        $recipients = Config::get('staff.cohort_2025_emails', []);
        foreach ($recipients as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                Mail::to($email)->send(new StaffInquiryNotification($inquiry));
            }
        }

        return back()->with('success', 'Your inquiry has been submitted successfully. Our team will contact you shortly.');
    }

    /**
     * Display the specified resource.
     */
    public function show(StudentInquiry $studentInquiry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StudentInquiry $studentInquiry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StudentInquiry $studentInquiry)
    {
        $request->validate([
            'status' => ['nullable','in:pending,resolved,completed']
        ]);

        $newStatus = $request->input('status', 'resolved');
        $studentInquiry->update(['status' => $newStatus]);

        // Notify the student upon completion/resolution
        if (in_array($newStatus, ['resolved','completed'])) {
            Mail::to($studentInquiry->email)->send(new InquiryResolvedMail($studentInquiry));
        }

        return redirect()->route('inquiries.index')->with('success', 'Inquiry status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentInquiry $studentInquiry)
    {
        $studentInquiry->delete();
        return redirect()->route('inquiries.index')->with('success', 'Inquiry deleted successfully.');
    }
}
