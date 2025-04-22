@php
    $footerContent = json_decode($footer->content ?? '{}', true);
@endphp

<!-- Footer Section -->
<footer class="bg-white text-gray-800 dark:bg-gray-900 dark:text-gray-300 py-12 border-t border-gray-200 dark:border-gray-700 transition-colors">
  <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-8">
    <!-- Left Column: Social Media & About -->
    <div>
      <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $footerContent['title'] }}</h3>
      <p class="mt-3 text-gray-500 dark:text-gray-400">
        {{ $footerContent['description'] }}
      </p>

      <h3 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Follow Me</h3>
      <!-- Social Media Links -->
      <div class="mt-3 flex flex-wrap gap-4 justify-start">
        @foreach ($socialMedia as $social)
            <a href="{{ $social->url }}" class="text-gray-900 dark:text-gray-400 hover:text-blue-600 dark:hover:text-white transition">
                <i class="bx {{ $social->icon }} text-2xl"></i>
            </a>
        @endforeach
      </div>
    </div>

    <!-- Right Column: Quick Links -->
    <div>
      <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Quick Links</h3>
      @if ($quickLinks->count() <= 6)</a>
        <ul class="mt-4 grid grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-4">
          @forelse ($quickLinks as $quickLink)
          <li>
            <a href="{{ $quickLink->url }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition">
              {{ $quickLink->name }}
            </a>
          </li>
          @empty

          @endforelse
        </ul>
      @else
        <ul class="mt-4 grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4">
          @forelse ($quickLinks as $quickLink)
          <li>
            <a href="{{ $quickLink->url }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition">
              {{ $quickLink->name }}
            </a>
          </li>
          @empty

          @endforelse
        </ul>
      @endif
    </div>

  </div>

  <!-- Divider -->
  <div class="mx-auto mt-15 border-t border-gray-200 dark:border-gray-700"></div>

  <!-- Bottom Copyright -->
  <div class="mt-8 text-gray-500 dark:text-gray-400 max-w-6xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center">
    <!-- Left: Copyright -->
    <div class="text-center md:text-left">
      © 2025 Lana Septiana. All rights reserved.
    </div>

    <!-- Right: Made with Love -->
    <div class="mt-2 md:mt-0 flex items-center space-x-2">
      <span>Made with</span>
      <i class="bx bxs-heart text-red-500 dark:text-red-400 text-xl"></i>
      <span>by Lana Septiana</span>
    </div>
  </div>
</footer>
