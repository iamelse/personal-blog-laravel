<!doctype html>
<html lang="en">
   <head>
      <meta charset="UTF-8" />
      <meta
         name="viewport"
         content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
         />
      <meta http-equiv="X-UA-Compatible" content="ie=edge" />
      <title>{{ $title ?? env('APP_NAME') }}</title>
      <link rel="icon" href="{{ asset('favicon/favicon.ico')  }}">
      <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

      <meta name="csrf-token" content="{{ csrf_token() }}">

      @php
         use Illuminate\Support\Facades\App;

         $environment = App::environment();
      @endphp

      @if ($environment === 'local')
         {{-- Use Vite Dev Server --}}
         @vite(['resources/css/app.css', 'resources/js/app.js'])
      @else
         {{-- Load Production or Staging Build --}}
         @php
            $manifestPath = public_path('build/manifest.json');
            $manifest = file_exists($manifestPath) ? json_decode(file_get_contents($manifestPath), true) : null;
         @endphp

         @if ($manifest && isset($manifest['resources/css/app.css'], $manifest['resources/js/app.js']))
            <link rel="stylesheet" href="{{ asset('build/' . $manifest['resources/css/app.css']['file']) }}" />
            <script type="module" src="{{ asset('build/' . $manifest['resources/js/app.js']['file']) }}"></script>
         @else
            {{-- Fallback if manifest.json is missing --}}
            <p style="color: red;">Error: Build files not found. Please run <code>npm run build</code>.</p>
         @endif
      @endif

      @stack('styles')
   </head>
   <body
      x-data="{ 'loaded': true, 'darkMode': false, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
      x-init="
      darkMode = JSON.parse(localStorage.getItem('darkMode'));
      $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
      :class="{'dark bg-gray-900': darkMode === true}"
   >

      <!-- ===== Preloader Start ===== -->
      <div
         x-show="loaded"
         x-init="window.addEventListener('DOMContentLoaded', () => { setTimeout(() => loaded = false, 500) })"
         class="fixed inset-0 z-50 flex items-center justify-center bg-white dark:bg-black"
      >
         <div
            class="h-16 w-16 animate-spin rounded-full border-4 border-solid border-blue-600 border-t-transparent"
            >
         </div>
      </div>
      <!-- ===== Preloader End ===== -->

      <!-- ===== Page Wrapper Start ===== -->
      <div class="flex h-screen overflow-hidden">
         @include('partials.sidebar')
         <!-- ===== Content Area Start ===== -->
         <div
            class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto"
            >
            <!-- Small Device Overlay Start -->
            <div
               @click="sidebarToggle = false"
               :class="sidebarToggle ? 'block lg:hidden' : 'hidden'"
               class="fixed w-full h-screen z-9 bg-gray-900/50"
               ></div>
            <!-- Small Device Overlay End -->
            @include('partials.header')

            <!-- Page content -->
            @yield('content')

            <!-- Page-Specific Scripts -->
            @yield('bottom-scripts')
         </div>
         <!-- ===== Content Area End ===== -->
      </div>
      <!-- ===== Page Wrapper End ===== -->
   </body>
</html>
