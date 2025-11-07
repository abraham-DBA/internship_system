<?php

namespace App\Http\Controllers;

use App\Events\StudentRegistered as StudentRegisteredEvent;
use App\Mail\StudentRegistered as StudentRegisteredMail;
use App\Mail\StudentApproved as StudentApprovedMail;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::query()
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $analytics = [
            [ 'title' => 'Total Students', 'count' => Student::count(), 'icon' => 'users', 'unit' => '', 'detailLink' => url('/dashboard') ],
            [ 'title' => 'Pending', 'count' => Student::where('status', 'pending')->count(), 'icon' => 'clock', 'unit' => '', 'detailLink' => url('/dashboard') ],
            [ 'title' => 'Approved', 'count' => Student::where('status', 'approved')->count(), 'icon' => 'check-circle', 'unit' => '', 'detailLink' => url('/dashboard') ],
        ];

        $supervisors = $this->supervisors();

        return view('dashboard', compact('students', 'analytics', 'supervisors'));
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
        $validated = $request->validate([
            'full_name' => ['required','string','max:255'],
            'reg_number' => ['required','string','max:100'],
            'course' => ['required','string','max:150'],
            'organization_name' => ['nullable','string','max:255'],
            'student_contact' => ['nullable','string','max:100'],
            'student_email' => ['required','email','max:255'],
            'notes' => ['nullable','string','max:1000'],
        ]);

        // ensure default status pending
        $validated['status'] = 'pending';
        // DB columns may be non-nullable in some environments; coerce null optionals to empty strings
        foreach (['organization_name','student_contact','notes'] as $field) {
            if (!array_key_exists($field, $validated) || $validated[$field] === null) {
                $validated[$field] = '';
            }
        }

        $student = Student::create($validated);

        event(new StudentRegisteredEvent($student));

        // Send a notification to the Student immediately (no queue dependency)
        if (!empty($student->student_email)) {
            Mail::to($student->student_email)->send(
                new StudentRegisteredMail($student)
            );
        }

        return redirect()->route('dashboard')
            ->with('success', 'Student registered successfully!');
    }

    /**
     * Approve the specified student and assign supervisor.
     */
    public function approve(Request $request, Student $student)
    {
        $data = $request->validate([
            'supervisor_key' => ['required','string'],
        ]);

        $supervisors = $this->supervisors();
        if (!array_key_exists($data['supervisor_key'], $supervisors)) {
            return back()->withErrors(['supervisor_key' => 'Invalid supervisor selected.']);
        }
        $sup = $supervisors[$data['supervisor_key']];

        $student->status = 'approved';
        $student->supervisor_name = $sup['name'];
        $student->supervisor_email = $sup['email'];
        $student->save();

        if (!empty($student->student_email)) {
            // Send approval email with attachment
            Mail::to($student->student_email)->send(new StudentApprovedMail($student));
        }

        return redirect()->route('students.show', $student)->with('success', 'Student approved and supervisor assigned.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        $supervisors = $this->supervisors();
        return view('students.show', compact('student', 'supervisors'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'full_name' => ['required','string','max:255'],
            'reg_number' => ['required','string','max:100'],
            'course' => ['required','string','max:150'],
            'organization_name' => ['nullable','string','max:255'],
            'student_contact' => ['nullable','string','max:100'],
            'student_email' => ['nullable','email','max:255'],
            'notes' => ['nullable','string','max:1000'],
        ]);

        $student->update($validated);

        return redirect()->route('dashboard')->with('success', 'Student updated successfully.');
//        dd('update'); sanity check to see if the update is working
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('dashboard')->with('success', 'Student deleted successfully.');
    }

    private function supervisors(): array
    {
        return [
            // key => [name,email]
            'sup_1' => ['name' => 'Dr. Jane Doe', 'email' => 'jane.doe@example.com'],
            'sup_2' => ['name' => 'Mr. John Smith', 'email' => 'john.smith@example.com'],
            'sup_3' => ['name' => 'Prof. Alice Johnson', 'email' => 'alice.johnson@example.com'],
        ];
    }
}
