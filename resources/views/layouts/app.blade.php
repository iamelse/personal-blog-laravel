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
      <link rel="icon" href="{{ asset('tailadmin/images/favicon.ico') }}">
      <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
      @vite('resources/css/app.css')
   </head>
   <body
      x-data="{ page: 'ecommerce', 'loaded': true, 'darkMode': false, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
      x-init="
      darkMode = JSON.parse(localStorage.getItem('darkMode'));
      $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
      :class="{'dark bg-gray-900': darkMode === true}"
      >
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
            @yield('content')
         </div>
         <!-- ===== Content Area End ===== -->
      </div>
      <!-- ===== Page Wrapper End ===== -->
      <!-- First, load Alpine.js -->
      @vite('resources/js/app.js')
   </body>
</html>