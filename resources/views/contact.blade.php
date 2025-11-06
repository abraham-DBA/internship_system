<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact | Internship Portal</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans text-gray-800">

  <!-- Header -->
  <header class="bg-blue-600 text-white">
    <div class="container mx-auto flex items-center justify-between p-4">
      <h1 class="text-2xl font-bold">Internship Portal</h1>
      <nav>
        <ul class="flex space-x-6">
          <li><a href="/" class="hover:text-gray-200">Home</a></li>
          <li><a href="/about" class="hover:text-gray-200">About</a></li>
          <li><a href="/contact" class="hover:text-gray-200 font-semibold underline">Contact</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="bg-blue-100 text-center py-16 px-4">
    <h2 class="text-4xl font-bold mb-4 text-blue-700">Contact Us</h2>
    <p class="text-lg text-gray-700 max-w-2xl mx-auto">
      Have questions or need help with your internship process? We’re here to assist you!
    </p>
  </section>

  <!-- Contact Information Section -->
  <section class="py-16 px-4 bg-white">
    <div class="max-w-5xl mx-auto grid md:grid-cols-4 gap-8 text-center md:text-left">
      <div class="bg-blue-50 p-6 rounded-lg shadow">
        <div class="text-4xl text-blue-600 mb-3">📧</div>
        <h4 class="font-bold text-lg mb-2">Email</h4>
        <p>info@internshipportal.com</p>
      </div>
      <div class="bg-blue-50 p-6 rounded-lg shadow">
        <div class="text-4xl text-blue-600 mb-3">📞</div>
        <h4 class="font-bold text-lg mb-2">Phone</h4>
        <p>+256 700 000000</p>
      </div>
      <div class="bg-blue-50 p-6 rounded-lg shadow">
        <div class="text-4xl text-blue-600 mb-3">🏢</div>
        <h4 class="font-bold text-lg mb-2">Office Location</h4>
        <p>Main Campus ICT Building, Room 204</p>
      </div>
      <div class="bg-blue-50 p-6 rounded-lg shadow">
        <div class="text-4xl text-blue-600 mb-3">⏰</div>
        <h4 class="font-bold text-lg mb-2">Office Hours</h4>
        <p>Mon - Fri: 8:00 AM – 5:00 PM</p>
      </div>
    </div>
  </section>

  <!-- Contact Form -->
  <section class="bg-blue-50 py-16 px-4">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-8">
      <h3 class="text-2xl font-semibold text-center text-blue-700 mb-6">Send Us a Message</h3>
      <form class="space-y-4">
        <div>
          <label class="block text-sm font-medium mb-1">Full Name</label>
          <input type="text" class="w-full border rounded-md px-3 py-2 focus:outline-blue-500" placeholder="John Doe" required>
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Email</label>
          <input type="email" class="w-full border rounded-md px-3 py-2 focus:outline-blue-500" placeholder="you@example.com" required>
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Registration Number (Optional)</label>
          <input type="text" class="w-full border rounded-md px-3 py-2 focus:outline-blue-500" placeholder="REG12345">
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Subject</label>
          <input type="text" class="w-full border rounded-md px-3 py-2 focus:outline-blue-500" placeholder="Inquiry about internship" required>
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Message</label>
          <textarea rows="5" class="w-full border rounded-md px-3 py-2 focus:outline-blue-500" placeholder="Type your message here..." required></textarea>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition">
          Submit Message
        </button>
      </form>
    </div>
  </section>

  <!-- Optional Map Section -->
  <section class="py-16 px-4 bg-white">
    <div class="max-w-5xl mx-auto text-center">
      <h3 class="text-3xl font-semibold text-blue-700 mb-6">Our Office Location</h3>
      <div class="rounded-lg overflow-hidden shadow-lg">
        <iframe 
          class="w-full h-96"
          loading="lazy"
          allowfullscreen
          referrerpolicy="no-referrer-when-downgrade"
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.759665804368!2d32.58252077579973!3d0.34759676402147864!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x177dbb639f099999%3A0xabcdef1234567890!2sMain%20Campus%20ICT%20Building!5e0!3m2!1sen!2sug!4v1690000000000!5m2!1sen!2sug">
        </iframe>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-blue-600 text-white py-8">
    <div class="max-w-6xl mx-auto grid md:grid-cols-3 gap-6 text-center md:text-left px-4">
      <div>
        <h4 class="font-bold mb-2">About</h4>
        <p class="text-sm">The Internship Portal connects students, organizations, and universities efficiently for a seamless placement experience.</p>
      </div>
      <div>
        <h4 class="font-bold mb-2">Contact Info</h4>
        <p class="text-sm">Email: info@internshipportal.com</p>
        <p class="text-sm">Phone: +256 700 000000</p>
      </div>
      <div>
        <h4 class="font-bold mb-2">Follow Us</h4>
        <div class="flex justify-center md:justify-start space-x-4">
          <a href="#" class="hover:text-gray-200">Facebook</a>
          <a href="#" class="hover:text-gray-200">Twitter</a>
          <a href="#" class="hover:text-gray-200">LinkedIn</a>
        </div>
      </div>
    </div>
    <p class="text-center text-sm mt-6">© 2025 Internship Portal. All rights reserved.</p>
  </footer>

</body>
</html>
