<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>About | Internship Portal</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans text-gray-800">

  <!-- Header -->
  <x-navbar />

  <!-- Hero / Page Title -->
  <section class="bg-blue-100 text-center py-16 px-4">
    <h2 class="text-4xl font-bold mb-4 text-blue-700">About the Internship Placement Portal</h2>
    <p class="text-lg text-gray-700 max-w-2xl mx-auto">
      Learn more about how this platform helps students manage, track, and complete their internship placement efficiently.
    </p>
  </section>

  <!-- Purpose Section -->
  <section class="py-16 px-4 bg-white">
    <div class="max-w-5xl mx-auto text-center">
      <h3 class="text-3xl font-semibold text-blue-700 mb-8">Our Purpose</h3>
      <div class="grid md:grid-cols-3 gap-8 text-left">
        <div class="bg-blue-50 p-6 rounded-lg shadow">
          <div class="text-4xl text-blue-600 mb-3">🎯</div>
          <h4 class="text-xl font-bold mb-2">Centralized Submission</h4>
          <p>Provide a single, user-friendly platform where students can submit internship details securely and easily.</p>
        </div>
        <div class="bg-blue-50 p-6 rounded-lg shadow">
          <div class="text-4xl text-blue-600 mb-3">💡</div>
          <h4 class="text-xl font-bold mb-2">Efficient Tracking</h4>
          <p>Allow academic supervisors and administrators to monitor student placements in real time.</p>
        </div>
        <div class="bg-blue-50 p-6 rounded-lg shadow">
          <div class="text-4xl text-blue-600 mb-3">📚</div>
          <h4 class="text-xl font-bold mb-2">Improved Communication</h4>
          <p>Facilitate smooth coordination between institutions, students, and internship organizations.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- How It Works Section -->
  <section class="bg-blue-50 py-16 px-4">
    <div class="max-w-5xl mx-auto text-center">
      <h3 class="text-3xl font-semibold text-blue-700 mb-10">How It Works</h3>
      <div class="grid md:grid-cols-4 gap-8">
        <div class="bg-white p-6 rounded-lg shadow">
          <div class="text-4xl mb-3">📝</div>
          <h4 class="text-xl font-bold mb-2">Step 1</h4>
          <p>Students log in and fill out their internship details accurately.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
          <div class="text-4xl mb-3">📤</div>
          <h4 class="text-xl font-bold mb-2">Step 2</h4>
          <p>Submit the information for verification by the supervisor.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
          <div class="text-4xl mb-3">🔍</div>
          <h4 class="text-xl font-bold mb-2">Step 3</h4>
          <p>Track your internship progress and receive announcements.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
          <div class="text-4xl mb-3">🎓</div>
          <h4 class="text-xl font-bold mb-2">Step 4</h4>
          <p>Complete your internship and receive confirmation through the portal.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Benefits Section -->
  <section class="py-16 px-4 bg-white">
    <div class="max-w-6xl mx-auto text-center">
      <h3 class="text-3xl font-semibold text-blue-700 mb-10">Benefits of Using the Portal</h3>
      <div class="grid md:grid-cols-3 gap-8">
        <div class="bg-blue-50 p-6 rounded-lg shadow hover:shadow-lg transition">
          <h4 class="text-xl font-bold mb-2 text-blue-700">Saves Time</h4>
          <p>All processes from submission to approval are done online — no paperwork!</p>
        </div>
        <div class="bg-blue-50 p-6 rounded-lg shadow hover:shadow-lg transition">
          <h4 class="text-xl font-bold mb-2 text-blue-700">Real-Time Updates</h4>
          <p>Get notified instantly about announcements, deadlines, and status changes.</p>
        </div>
        <div class="bg-blue-50 p-6 rounded-lg shadow hover:shadow-lg transition">
          <h4 class="text-xl font-bold mb-2 text-blue-700">Transparency</h4>
          <p>Students and supervisors can both access accurate, up-to-date information anytime.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Team / Contact Info -->
  <section class="bg-blue-50 py-16 px-4">
    <div class="max-w-4xl mx-auto text-center">
      <h3 class="text-3xl font-semibold text-blue-700 mb-8">Meet the Team</h3>
      <div class="grid md:grid-cols-2 gap-8">
        <div class="bg-white p-6 rounded-lg shadow">
          <h4 class="font-bold text-xl mb-2 text-blue-700">Admin Office</h4>
          <p>Handles internship verification, organization approvals, and student support.</p>
          <p class="mt-3 text-sm text-gray-600">Email: admin@internshipportal.com</p>
          <p class="text-sm text-gray-600">Phone: +256 700 123456</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
          <h4 class="font-bold text-xl mb-2 text-blue-700">Technical Support</h4>
          <p>Ensures the portal runs smoothly and securely for all users.</p>
          <p class="mt-3 text-sm text-gray-600">Email: support@internshipportal.com</p>
          <p class="text-sm text-gray-600">Phone: +256 701 654321</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <x-footer />

</body>
</html>
