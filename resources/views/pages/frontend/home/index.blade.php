@extends('layouts.frontend.app')

@section('content')
  @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/devicon.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  @endpush

  @push('scripts')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
      document.addEventListener("DOMContentLoaded", function() {
        AOS.init({
          duration: 1000,
          once: true,
        });
      });
    </script>
  @endpush

  @php
    $heroContent = json_decode($hero->content ?? '{}', true);
    $aboutContent = json_decode($about->content ?? '{}', true);
    $CTAContent = json_decode($callToAction->content ?? '{}', true);
  @endphp

  <!-- Hero Section -->
  <section class="py-28 md:py-52 lg:py-56 text-center bg-gray-50 dark:bg-gray-900 transition-colors" data-aos="fade-up">
    <div class="max-w-6xl mx-auto px-6">
      <h1 class="text-3xl sm:text-4xl md:text-4xl lg:text-5xl font-bold leading-tight text-gray-900 dark:text-white">
        {{ $heroContent['title'] }}
      </h1>
      <p class="mt-6 text-base sm:text-lg text-gray-500 dark:text-gray-400 max-w-3xl mx-auto">
        {{ $heroContent['description'] }}
      </p>

      <!-- Tech Stack Icons -->
      <div class="mt-10 flex flex-wrap justify-center gap-6">
          @forelse ($skills as $skill)
            <div class="flex flex-col items-center">
                <div class="p-2 sm:p-3 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center w-12 sm:w-16 h-12 sm:h-16">
                    <i class="{{ $skill->icon_class }} text-xl sm:text-3xl"></i>
                </div>
                <span class="mt-2 text-xs font-medium text-gray-500 dark:text-white">{{ $skill->name }}</span>
            </div>
          @empty
              <p class="font-medium text-gray-500 dark:text-white">No Data</p>
          @endforelse
      </div>

      <!-- Buttons -->
      <div class="mt-15 flex flex-wrap justify-center gap-3.5" data-aos="fade-up">
          <a class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-6 py-3 text-base font-medium text-white shadow-xs duration-200 hover:bg-blue-700 w-full sm:w-auto dark:bg-blue-700 dark:hover:bg-blue-600 dark:text-white" href="#post">
              View Project
          </a>
          <a target="_blank" class="inline-flex items-center justify-center gap-2 rounded-lg border border-stroke-tertiary bg-white px-6 py-3 text-base font-medium text-text-color shadow-xs duration-200 hover:bg-gray-50 hover:text-gray-800 w-full sm:w-auto dark:bg-gray-800 dark:border-stroke-tertiary dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white" href="https://demo.tailadmin.com">
              View Post
          </a>
      </div>
    </div>
  </section>

  <!-- About Section -->
  <section id="about" class="py-16 lg:py-32 text-center bg-white dark:bg-gray-800 transition-colors">
    <div class="max-w-6xl mx-auto px-6">
      <h2 data-aos="fade-up" class="py-2 lg:py-10 text-3xl sm:text-4xl md:text-4xl lg:text-5xl font-bold leading-tight text-gray-900 dark:text-white">
        {{ $aboutContent['title'] }}
      </h2>

      <div class="mt-10 flex flex-col lg:flex-row items-center justify-between gap-10">
        <!-- Image on the left -->
        <div data-aos="fade-right" class="w-full lg:w-1/2 flex justify-center items-stretch">
          <!-- Preview Image -->
          <div class="w-full max-w-md aspect-square rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700">
              <img
                  src="{{ getAboutMeImageSection($aboutContent) }}"
                  class="w-full h-full object-cover"
                  alt="Image Preview"
              >
          </div>
        </div>

        <!-- Text on the right -->
        <div class="w-full lg:w-1/2 text-left flex items-stretch">
          <div data-aos="fade-left" class="flex flex-col justify-between h-full">
            <p class="text-base sm:text-lg text-gray-500 dark:text-white">
              {!! nl2br(e($aboutContent['description'])) !!}
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Services Section -->
  <section id="services" class="py-16 lg:py-32 bg-gray-50 dark:bg-gray-800 transition-colors">
      <div class="max-w-6xl mx-auto px-6">
          <h2 class="text-center text-3xl sm:text-4xl md:text-4xl lg:text-5xl font-bold leading-tight text-gray-900 dark:text-white"
              data-aos="fade-up">
              My Services
          </h2>
          <p class="mt-4 text-center text-base sm:text-lg text-gray-600 dark:text-gray-400"
             data-aos="fade-up" data-aos-delay="200">
              Focused backend solutions crafted with Laravel — secure, maintainable, and scalable.
          </p>

          <div class="mt-12 grid md:grid-cols-2 lg:grid-cols-3 gap-6">

              <!-- Laravel Web Development Card -->
              <div class="border border-gray-200 dark:border-gray-700 rounded-3xl p-6 bg-white dark:bg-gray-700 shadow-sm hover:shadow-md transition-shadow duration-300"
                   data-aos="zoom-in" data-aos-delay="200">
                  <div class="flex items-center justify-center w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900 mb-4">
                      <i class="bx bx-code text-blue-600 dark:text-blue-400 text-2xl"></i>
                  </div>
                  <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                      Laravel Web Development
                  </h3>
                  <p class="text-gray-600 dark:text-white">
                      Build robust, backend-driven web applications with Laravel and Blade templating — no frontend frameworks needed.
                  </p>
              </div>

              <!-- Code Refactoring & Maintenance Card -->
              <div class="border border-gray-200 dark:border-gray-700 rounded-3xl p-6 bg-white dark:bg-gray-700 shadow-sm hover:shadow-md transition-shadow duration-300"
                   data-aos="zoom-in" data-aos-delay="400">
                  <div class="flex items-center justify-center w-12 h-12 rounded-full bg-yellow-100 dark:bg-yellow-900 mb-4">
                      <i class="bx bx-refresh text-yellow-600 dark:text-yellow-400 text-2xl"></i>
                  </div>
                  <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                      Code Refactoring & Maintenance
                  </h3>
                  <p class="text-gray-600 dark:text-white">
                      Clean up and optimize your Laravel codebase for performance, security, and long-term maintainability.
                  </p>
              </div>

              <!-- New Feature Card -->
              <div class="border border-gray-200 dark:border-gray-700 rounded-3xl p-6 bg-white dark:bg-gray-700 shadow-sm hover:shadow-md transition-shadow duration-300"
                   data-aos="zoom-in" data-aos-delay="800">
                  <div class="flex items-center justify-center w-12 h-12 rounded-full bg-green-100 dark:bg-green-900 mb-4">
                      <i class="bx bx-up-arrow-alt text-green-600 dark:text-green-400 text-2xl"></i>
                  </div>
                  <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                      New Feature Implementation
                  </h3>
                  <p class="text-gray-600 dark:text-white">
                      Bring new capabilities to your existing system by adding features tailored to your needs.
                  </p>
              </div>

              <!-- RESTful API Development Card -->
              <div class="border border-gray-200 dark:border-gray-700 rounded-3xl p-6 bg-white dark:bg-gray-700 shadow-sm hover:shadow-md transition-shadow duration-300"
                   data-aos="zoom-in" data-aos-delay="600">
                  <div class="flex items-center justify-center w-12 h-12 rounded-full bg-red-100 dark:bg-red-900 mb-4">
                      <i class="bx bx-cloud text-red-600 dark:text-red-400 text-2xl"></i>
                  </div>
                  <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                      RESTful API Development
                  </h3>
                  <p class="text-gray-600 dark:text-white">
                      Design and implement clean, secure APIs powered by Laravel — perfect for mobile apps, third-party integrations, or SPAs.
                  </p>
              </div>

              <!-- UI/UX Design Card -->
              <div class="border border-gray-200 dark:border-gray-700 rounded-3xl p-6 bg-white dark:bg-gray-700 shadow-sm hover:shadow-md transition-shadow duration-300"
                   data-aos="zoom-in" data-aos-delay="1000">
                  <div class="flex items-center justify-center w-12 h-12 rounded-full bg-purple-100 dark:bg-purple-900 mb-4">
                      <i class="bx bx-palette text-purple-600 dark:text-purple-400 text-2xl"></i>
                  </div>
                  <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                      UI/UX Design
                  </h3>
                  <p class="text-gray-600 dark:text-white">
                      Create intuitive and visually appealing user interfaces with seamless user experiences that engage and delight your audience.
                  </p>
              </div>

          </div>
      </div>
  </section>

  <!-- Projects Section -->
  <section id="projects" class="py-16 lg:py-32 bg-white dark:bg-gray-900 transition-colors">
      <div class="max-w-6xl mx-auto px-6 text-center">
          <h2 class="text-3xl sm:text-4xl md:text-4xl lg:text-5xl font-bold leading-tight text-gray-900 dark:text-white" data-aos="fade-up">
              My Projects
          </h2>
          <p class="mt-4 text-lg text-gray-600 dark:text-gray-400 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
              A collection of backend-focused projects showcasing Laravel craftsmanship and architectural thinking.
          </p>
      </div>

      <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto px-6">

          <!-- Project Card 1 -->
          <div class="border border-gray-200 dark:border-gray-700 rounded-3xl p-6 bg-white dark:bg-gray-700 shadow-sm hover:shadow-md transition-shadow duration-300"
               data-aos="fade-up" data-aos-delay="300">
              <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Portfolio CMS</h3>
              <p class="text-gray-600 dark:text-white">
                  A Laravel-powered CMS with role-based authentication and clean modular structure.
              </p>
          </div>

          <!-- Project Card 2 -->
          <div class="border border-gray-200 dark:border-gray-700 rounded-3xl p-6 bg-white dark:bg-gray-700 shadow-sm hover:shadow-md transition-shadow duration-300"
               data-aos="fade-up" data-aos-delay="400">
              <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Knowledge Management System</h3>
              <p class="text-gray-600 dark:text-white">
                  Smart Laravel-based solution using case-based reasoning for internal decision workflows.
              </p>
          </div>

          <!-- Project Card 3 -->
          <div class="border border-gray-200 dark:border-gray-700 rounded-3xl p-6 bg-white dark:bg-gray-700 shadow-sm hover:shadow-md transition-shadow duration-300"
               data-aos="fade-up" data-aos-delay="500">
              <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Legal Firm API</h3>
              <p class="text-gray-600 dark:text-white">
                  Headless API with Strapi, powering legal firm’s mobile and client dashboard apps.
              </p>
          </div>

      </div>
  </section>

  <!-- Post Section -->
  <section id="posts" class="py-16 lg:py-32 bg-gray-50 dark:bg-gray-800 transition-colors">
    <div class="max-w-6xl mx-auto px-6">
      <h2 class="text-center text-3xl sm:text-4xl md:text-4xl lg:text-5xl font-bold leading-tight text-gray-900 dark:text-white"
          data-aos="fade-up">
        Latest Posts
      </h2>
      <p class="mt-4 text-center text-base sm:text-lg text-gray-500 dark:text-gray-400"
         data-aos="fade-up" data-aos-delay="200">
        Explore my latest articles covering web development, Laravel, and more.
      </p>
      <div class="mt-10 grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Post Card -->
        <div class="border border-gray-200 dark:border-gray-700 rounded-3xl p-2.5 bg-white dark:bg-gray-700 flex flex-col"
             data-aos="zoom-in" data-aos-delay="{{ 200 }}">
          <img src="https://picsum.photos/400/250?random=1" alt="Post Image"
               class="w-full rounded-2xl aspect-[16/9] object-cover">
          <div class="flex flex-col flex-grow p-3">
            <h3 class="text-2xl py-2 font-semibold">
              <a href="#" class="text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition">
                Understanding Laravel Eloquent Relationships
              </a>
            </h3>
            <p class="my-2 text-gray-500 dark:text-gray-400 flex-grow">
              Learn how to work with Laravel Eloquent relationships effectively for better database management.
              Learn how to work with Laravel Eloquent relationships effectively for better database management.
            </p>
            <div class="mt-4">
              <a href="#" class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-6 py-3 text-base font-medium text-white shadow-xs duration-200 hover:bg-blue-700 w-full sm:w-auto dark:bg-blue-700 dark:hover:bg-blue-600 dark:text-white">
                Read More
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
              </a>
            </div>
          </div>
        </div>

        <!-- Post Card -->
        <div class="border border-gray-200 dark:border-gray-700 rounded-3xl p-2.5 bg-white dark:bg-gray-700 flex flex-col"
             data-aos="zoom-in" data-aos-delay="{{ 2 * 300 }}">
          <img src="https://picsum.photos/400/250?random=2" alt="Post Image"
               class="w-full rounded-2xl aspect-[16/9] object-cover">
          <div class="flex flex-col flex-grow p-3">
            <h3 class="text-2xl py-2 font-semibold">
              <a href="#" class="text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition">
                Understanding Laravel Eloquent Relationships
              </a>
            </h3>
            <p class="my-2 text-gray-500 dark:text-gray-400 flex-grow">
              Learn how to work with Laravel Eloquent relationships effectively for better database management.
              Learn how to work with Laravel Eloquent relationships effectively for better database management.
            </p>
            <div class="mt-4">
              <a href="#" class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-6 py-3 text-base font-medium text-white shadow-xs duration-200 hover:bg-blue-700 w-full sm:w-auto dark:bg-blue-700 dark:hover:bg-blue-600 dark:text-white">
                Read More
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
              </a>
            </div>
          </div>
        </div>

        <!-- Post Card -->
        <div class="border border-gray-200 dark:border-gray-700 rounded-3xl p-2.5 bg-white dark:bg-gray-700 flex flex-col"
             data-aos="zoom-in" data-aos-delay="{{ 3 * 300 }}">
          <img src="https://picsum.photos/400/250?random=3" alt="Post Image"
               class="w-full rounded-2xl aspect-[16/9] object-cover">
          <div class="flex flex-col flex-grow p-3">
            <h3 class="text-2xl py-2 font-semibold">
              <a href="#" class="text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition">
                Understanding Laravel Eloquent Relationships
              </a>
            </h3>
            <p class="my-2 text-gray-500 dark:text-gray-400 flex-grow">
              Learn how to work with Laravel Eloquent relationships effectively for better database management.
              Learn how to work with Laravel Eloquent relationships effectively for better database management.
            </p>
            <div class="mt-4">
              <a href="#" class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-6 py-3 text-base font-medium text-white shadow-xs duration-200 hover:bg-blue-700 w-full sm:w-auto dark:bg-blue-700 dark:hover:bg-blue-600 dark:text-white">
                Read More
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
              </a>
            </div>
          </div>
        </div>
        <!-- Repeat for other post cards with different `data-aos` effects -->
      </div>
    </div>
  </section>

  <!-- Collaborate With Me Section -->
  <section id="collaborate" class="py-16 lg:py-32 bg-blue-600 text-white">
    <div class="max-w-6xl mx-auto px-6">
      <div class="flex flex-col md:flex-row items-center justify-between gap-6 bg-blue-700 p-8 rounded-3xl shadow-lg" data-aos="fade-up">
        <!-- Text Content -->
        <div class="flex-1 text-center md:text-left" data-aos="fade-right">
          <h2 class="text-3xl sm:text-4xl md:text-4xl lg:text-5xl font-bold leading-tight">
            {{ $CTAContent['title'] }}
          </h2>
          <p class="mt-3 text-lg text-blue-200">
            {!! nl2br(e($CTAContent['description'])) !!}
          </p>
        </div>

        <!-- Call-to-Action Button -->
        <div class="flex-shrink-0" data-aos="zoom-in">
          <a href="#contact" class="inline-flex items-center gap-2 bg-white text-blue-600 px-6 py-3 rounded-xl text-lg font-medium shadow-md hover:bg-gray-100 transition">
            Get in Touch
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section id="contact" class="py-16 lg:py-32 bg-white dark:bg-gray-900 transition-colors">
    <div class="max-w-6xl mx-auto px-6">
      <h2 class="text-center text-3xl sm:text-4xl md:text-4xl lg:text-5xl font-bold leading-tight text-gray-900 dark:text-white"
          data-aos="fade-up">
        Get in Touch
      </h2>

      <p class="mt-4 text-center text-lg text-gray-600 dark:text-gray-400"
        data-aos="fade-up" data-aos-delay="200">
        Feel free to reach out for collaborations or just a friendly chat.
      </p>

      <div class="mt-10 gap-10">
        <!-- Contact Form -->
        <div class="p-6 rounded-3xl max-w-3xl mx-auto" data-aos="zoom-in">
          <form action="#" method="POST" class="space-y-6">
            <div class="relative" data-aos="fade-right">
              <input type="text" id="name" name="name" required
                    class="peer w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400">
              <label for="name"
                    class="absolute left-4 top-3 text-gray-500 dark:text-gray-400 text-sm transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-2 peer-focus:text-sm peer-focus:text-blue-600 dark:peer-focus:text-blue-400">
                Your Name
              </label>
            </div>

            <div class="relative" data-aos="fade-left" data-aos-delay="100">
              <input type="email" id="email" name="email" required
                    class="peer w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400">
              <label for="email"
                    class="absolute left-4 top-3 text-gray-500 dark:text-gray-400 text-sm transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-2 peer-focus:text-sm peer-focus:text-blue-600 dark:peer-focus:text-blue-400">
                Your Email
              </label>
            </div>

            <div class="relative" data-aos="fade-right" data-aos-delay="200">
              <textarea id="message" name="message" rows="4" required
                        class="peer w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400"></textarea>
              <label for="message"
                    class="absolute left-4 top-3 text-gray-500 dark:text-gray-400 text-sm transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-focus:top-2 peer-focus:text-sm peer-focus:text-blue-600 dark:peer-focus:text-blue-400">
                Your Message
              </label>
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-600 text-white font-semibold py-3 rounded-lg transition duration-200"
                    data-aos="zoom-in" data-aos-delay="300">
              Send Message
            </button>
          </form>
        </div>
      </div>
    </div>
  </section>
@endsection
