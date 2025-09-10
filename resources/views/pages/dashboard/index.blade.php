@extends('layouts.app')

@section('content')
<!-- ===== Main Content Start ===== -->
<main>
    <div class="py-4 mx-auto w-full md:py-4">
        <!-- Header Section -->
        <div class="flex px-6 flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                    {{ getGreeting() }}, {{ getFirstName(Auth::user()->name) }}
                </h1>
                <p class="text-gray-600 dark:text-gray-400">Welcome to your dashboard!</p>
            </div>
        </div>

       <!-- Form Section -->
       <div class="border-gray-100 p-5 dark:border-gray-800 sm:p-6">
            <div class="rounded-2xl px-6 pb-8 pt-4 border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

            </div>
        </div>
    </div>
</main>
<!-- ===== Main Content End ===== -->
@endsection
