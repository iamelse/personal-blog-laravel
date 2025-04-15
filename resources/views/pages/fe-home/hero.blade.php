@php
    use App\Enums\PermissionEnum;
@endphp

@extends('layouts.app')

@section('content')
<!-- ===== Main Content Start ===== -->
<main>
    <div class="p-4 mx-auto max-w-screen-2xl md:p-6">
        <!-- Header Section -->
        <div class="flex px-6 flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                    Hero Section
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    Personalize your Hero Section to make a strong first impression.
                </p>
            </div>

            <!-- Shortcut to Skills Page -->
            <a href="{{ route('be.skill.index') }}" class="flex items-center gap-2 px-4 py-2 text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg transition">
                <i class="bx bx-grid-alt text-lg"></i> <!-- Boxicon icon -->
                Manage Skills
            </a>
        </div>

        <!-- Hero Section Form -->
        <div class="border-gray-100 p-5 dark:border-gray-800 sm:p-6">
            <div class="rounded-2xl px-6 pb-8 pt-4 border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <form action="{{ route('be.home.hero.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    @php
                        $content = json_decode($hero->content ?? '{}', true);
                    @endphp

                    <!-- Hero Title -->
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Title <span class="text-error-500">*</span>
                        </label>
                        <div x-data="{ hasError: @json(session('errors') && session('errors')->has('content.title')) }">
                            <input
                                type="text"
                                id="title"
                                name="content[title]"
                                placeholder="Enter title"
                                value="{{ old('content.title', $content['title'] ?? '') }}"
                                :class="hasError
                                    ? 'border-red-500 dark:border-red-500 focus:ring-2 focus:ring-red-500 dark:focus:ring-red-500'
                                    : 'border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-500'"
                                class="h-11 w-full mt-1 px-4 py-2.5 border rounded-lg placeholder:text-gray-400 dark:placeholder:text-white/30"
                            >
                            <span class="text-xs mt-1 font-medium text-red-500 dark:text-red-500" x-show="hasError">
                                @error('content.title') * {{ $message }} @enderror
                            </span>
                        </div>
                    </div>

                    <!-- Hero Description -->
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Description <span class="text-error-500">*</span>
                        </label>
                        <div x-data="{ hasError: @json(session('errors') && session('errors')->has('content.description')) }">
                            <textarea
                                id="description"
                                name="content[description]"
                                rows="4"
                                :class="hasError
                                    ? 'border-red-500 dark:border-red-500 focus:ring-2 focus:ring-red-500 dark:focus:ring-red-500'
                                    : 'border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 focus:ring-2 focus:ring-blue-500'"
                                class="mt-1 block w-full rounded-lg"
                            >{{ old('content.description', $content['description'] ?? '') }}</textarea>
                            <span class="text-xs mt-1 font-medium text-red-500 dark:text-red-500" x-show="hasError">
                                @error('content.description') * {{ $message }} @enderror
                            </span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<!-- ===== Main Content End ===== -->
@endsection

@section('bottom-scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if(session('success'))
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "success",
                    title: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'bg-white dark:bg-gray-800 shadow-lg',
                        title: 'font-normal text-base text-gray-800 dark:text-gray-200'
                    }
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "error",
                    title: "{{ session('error') }}",
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'bg-white dark:bg-gray-800 shadow-lg',
                        title: 'font-normal text-base text-gray-800 dark:text-gray-200'
                    }
                });
            @endif
        });
    </script>
@endsection
