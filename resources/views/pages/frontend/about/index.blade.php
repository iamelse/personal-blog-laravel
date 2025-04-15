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

  <!-- About Section -->
  <section id="about" class="py-16 lg:py-32 bg-white dark:bg-gray-900 transition-colors">
    <div class="max-w-6xl mx-auto px-6">
      <div class="mt-10 lg:mt-0 flex flex-col lg:flex-row items-center gap-10">
        <!-- Bio Content -->
        <article class="w-full lg:w-3/4 text-left">
          <div data-aos="fade-left" class="space-y-3 lg:space-y-4">
              {!! $about->content['description'] ?? '' !!}
          </div>
        </article>
      </div>
    </div>
  </section>
@endsection
