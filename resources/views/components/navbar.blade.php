<header class="bg-white border-b">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="flex h-16 items-center justify-between">
      <!-- Brand -->
      <div class="flex items-center gap-3">
        <a href="{{ route('home.page') }}" class="block">
          <span class="text-xl font-bold tracking-wide text-blue-700">STUDENT INTERNSHIP PORTAL</span>
        </a>
      </div>

      <!-- Primary Nav -->
      <div class="hidden md:block">
        <nav aria-label="Global">
          <ul class="flex items-center gap-6 text-sm">
            <li>
              <a class="text-gray-700 hover:text-blue-700 transition" href="{{ route('home.page') }}"> Home </a>
            </li>
            <li>
              <a class="text-gray-700 hover:text-blue-700 transition" href="{{ url('/about') }}"> About </a>
            </li>
            <li>
              <a class="text-gray-700 hover:text-blue-700 transition" href="{{ url('/contact') }}"> Contact </a>
            </li>
          </ul>
        </nav>
      </div>

      <!-- Auth / Actions -->
      <div class="flex items-center gap-4">
        @if (Route::has('login'))
          @auth
            <a href="{{ url('/dashboard') }}" class="hidden sm:inline-block rounded-md bg-teal-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-teal-700">Dashboard</a>
            <form method="POST" action="{{ route('logout') }}" class="hidden sm:inline-block">
              @csrf
              <button type="submit" class="rounded-md bg-gray-100 px-5 py-2.5 text-sm font-medium text-gray-800 hover:bg-gray-200">Log out</button>
            </form>
          @else
            <a href="{{ route('login') }}" class="rounded-md bg-blue-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-700">Login</a>
            @if (Route::has('register'))
              <a href="{{ route('register') }}" class="hidden sm:inline-block rounded-md bg-gray-100 px-5 py-2.5 text-sm font-medium text-blue-700 hover:bg-gray-200">Register</a>
            @endif
          @endauth
        @endif

        <!-- Mobile menu button placeholder (not functional) -->
        <div class="md:hidden">
          <button class="rounded-sm bg-gray-100 p-2 text-gray-600 transition hover:text-gray-800" aria-label="Open menu">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>
</header>
