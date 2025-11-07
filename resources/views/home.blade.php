<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Internship Portal | Home</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans text-gray-800">

  <!-- Header -->
{{--  <header class="bg-blue-600 text-white">--}}
{{--    --}}
{{--  </header>--}}

  <x-navbar />


  <!-- Hero Section -->
  <section class="bg-blue-100 text-center py-16 px-4">
    <h2 class="text-4xl font-bold mb-4">Welcome to the Internship Submission Portal</h2>
    <p class="text-lg text-gray-700 mb-6">Submit your internship details and stay updated with important announcements.</p>
    <button class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">Get Started</button>
  </section>


  <!-- How It Works -->
  <section class="bg-blue-50 py-16 px-4">
    <h3 class="text-3xl font-semibold text-center text-blue-700 mb-10">How It Works</h3>
    <div class="grid md:grid-cols-4 gap-6 max-w-5xl mx-auto">
      <div class="bg-white p-6 rounded-lg shadow text-center">
        <h4 class="text-xl font-bold mb-2">Step 1</h4>
        <p>Fill in your internship details accurately.</p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow text-center">
        <h4 class="text-xl font-bold mb-2">Step 2</h4>
        <p>Submit the form for verification.</p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow text-center">
        <h4 class="text-xl font-bold mb-2">Step 3</h4>
        <p>Track announcements and updates on the portal.</p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow text-center">
        <h4 class="text-xl font-bold mb-2">Step 4</h4>
        <p>Await supervisor approval and feedback.</p>
      </div>
    </div>
  </section>

  <!-- Internship Submission Form -->
  <section class="py-16 px-4 bg-white">
    <div class="max-w-3xl mx-auto bg-gray-50 shadow-md rounded-lg p-8">
      <h3 class="text-2xl font-semibold text-center mb-6 text-blue-700">Internship Submission Form</h3>
      <form class="space-y-4" action="{{ route('student.save') }}" method="POST">
        @csrf
        <div>
          <label class="block text-sm font-medium mb-1">Full Name</label>
          <input type="text" name="full_name" class="w-full border rounded-md px-3 py-2 focus:outline-blue-500" placeholder="John Doe" required>
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Registration Number</label>
          <input name="reg_number" type="text" class="w-full border rounded-md px-3 py-2 focus:outline-blue-500" placeholder="REG12345" required>
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Program / Course</label>
          <input name="course" type="text" class="w-full border rounded-md px-3 py-2 focus:outline-blue-500" placeholder="BSc Computer Science" required>
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Organization Name</label>
          <input name="organization_name" type="text" class="w-full border rounded-md px-3 py-2 focus:outline-blue-500" placeholder="ICEA LION" required>
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Student Contact</label>
          <input type="text" name="student_contact" class="w-full border rounded-md px-3 py-2 focus:outline-blue-500" placeholder="+256 700 000000" required>
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Student Email</label>
          <input type="email" name="student_email" class="w-full border rounded-md px-3 py-2 focus:outline-blue-500" placeholder="john.doe@example.com" required>
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Notes (Optional)</label>
          <textarea name="notes" class="w-full border rounded-md px-3 py-2 focus:outline-blue-500" placeholder="Additional information..."></textarea>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition">
          Submit
        </button>
      </form>
    </div>
  </section>

  <!-- Announcements / News -->
  <section class="py-16 px-4 bg-white">
    <h3 class="text-3xl font-semibold text-center text-blue-700 mb-10">Announcements</h3>
    <div class="max-w-4xl mx-auto space-y-4">
      <div class="border-l-4 border-blue-600 bg-blue-50 p-4 rounded">
        <h4 class="font-semibold text-blue-700">Deadline for Internship Submissions</h4>
        <p class="text-sm">All students must submit details by <strong>30th November 2025</strong>.</p>
      </div>
      <div class="border-l-4 border-green-600 bg-green-50 p-4 rounded">
        <h4 class="font-semibold text-green-700">New Partner Organization</h4>
        <p class="text-sm">We’re excited to announce a new collaboration with <strong>Planetaria Tech</strong>.</p>
      </div>
    </div>
  </section>

  <!-- FAQ Section -->
  <section class="bg-blue-50 py-16 px-4">
    <h3 class="text-3xl font-semibold text-center text-blue-700 mb-10">Frequently Asked Questions</h3>
    <div class="max-w-3xl mx-auto space-y-4">
      <details class="bg-white p-4 rounded-lg shadow">
        <summary class="font-semibold cursor-pointer">When is the submission deadline?</summary>
        <p class="mt-2 text-gray-700">The submission deadline is 30th November 2025.</p>
      </details>
      <details class="bg-white p-4 rounded-lg shadow">
        <summary class="font-semibold cursor-pointer">Can I edit my submission later?</summary>
        <p class="mt-2 text-gray-700">Yes, you can log in to edit your internship details anytime before the deadline.</p>
      </details>
    </div>
  </section>

  <!-- Testimonials -->
  <section class="py-16 px-4 bg-white">
    <h3 class="text-3xl font-semibold text-center text-blue-700 mb-10">Success Stories</h3>
    <div class="max-w-5xl mx-auto grid md:grid-cols-3 gap-6">
      <div class="bg-blue-50 p-6 rounded-lg shadow text-center">
        <p class="italic">"This portal made my internship process seamless and organized!"</p>
        <h4 class="font-bold mt-4">— Sarah, Computer Science</h4>
      </div>
      <div class="bg-blue-50 p-6 rounded-lg shadow text-center">
        <p class="italic">"Easy to use and keeps you updated with everything you need."</p>
        <h4 class="font-bold mt-4">— Brian, IT Student</h4>
      </div>
      <div class="bg-blue-50 p-6 rounded-lg shadow text-center">
        <p class="italic">"Loved the reminders and updates — great experience overall."</p>
        <h4 class="font-bold mt-4">— Lydia, Software Engineering</h4>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <x-footer />

</body>
</html>
