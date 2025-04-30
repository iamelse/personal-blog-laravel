@extends('layouts.app')

@section('content')
    <!-- ===== Main Content Start ===== -->
    <main>
        <div class="p-4 mx-auto max-w-screen-2xl md:p-6">

            <!-- Header Section -->
            <div class="flex px-6 flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Create a Post Category</h1>
                    <p class="text-gray-600 dark:text-gray-400">Add a new post category to the system.</p>
                </div>
            </div>

            <!-- Form Section -->
            <div class="border-gray-100 p-5 dark:border-gray-800 sm:p-6">
                <div class="rounded-2xl px-6 pb-8 pt-4 border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <form action="{{ route('be.post-category.store') }}" method="POST" x-data="{ name: '', slug: '' }">
                        @csrf

                        <!-- Role Name -->
                        <div class="mt-4">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Category Name <span class="text-error-500">*</span>
                            </label>
                            <div x-data="{ hasError: {{ session('errors') && session('errors')->has('name') ? 'true' : 'false' }} }">
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    x-model="name"
                                    @input="slug = name.toLowerCase().trim().replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '')"
                                    placeholder="Enter post category name"
                                    :class="hasError
                                    ? 'border-red-500 dark:border-red-500 focus:ring-2 focus:ring-red-500 dark:focus:ring-red-500'
                                    : 'border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-500'"
                                    class="h-11 w-full text-sm mt-1 px-4 py-2.5 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 placeholder:text-gray-400 dark:placeholder:text-white/30"
                                    required>
                                <span class="text-xs mt-1 font-medium text-red-500 dark:text-red-500" x-show="hasError">
                                @error('name') * {{ $message }} @enderror
                            </span>
                            </div>
                        </div>

                        <!-- Slug (Read-only) -->
                        <div class="mt-4">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Slug <span class="text-error-500">*</span>
                            </label>
                            <div x-data="{ hasError: {{ session('errors') && session('errors')->has('slug') ? 'true' : 'false' }} }">
                                <input
                                    type="text"
                                    id="slug"
                                    name="slug"
                                    value="{{ old('slug') }}"
                                    x-model="slug"
                                    placeholder="Slug is auto generated"
                                    :class="hasError
                                    ? 'border-red-500 dark:border-red-500 focus:ring-2 focus:ring-red-500 dark:focus:ring-red-500'
                                    : 'border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-500'"
                                    class="h-11 w-full text-sm mt-1 px-4 py-2.5 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 placeholder:text-gray-400 dark:placeholder:text-white/30"
                                    readonly>
                                <span class="text-xs mt-1 font-medium text-red-500 dark:text-red-500" x-show="hasError">
                                @error('slug') * {{ $message }} @enderror
                            </span>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end mt-6">
                            <button type="submit"
                                    class="flex items-center gap-2 h-[42px] px-4 py-2.5 rounded-lg border border-blue-500 bg-blue-600 text-white font-medium transition-all hover:bg-blue-700 hover:border-blue-600 focus:ring focus:ring-blue-300 dark:bg-blue-700 dark:border-blue-600 dark:hover:bg-blue-800">
                                Create Category
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
