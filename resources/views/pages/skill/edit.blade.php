@extends('layouts.app')

@section('content')
<!-- ===== Main Content Start ===== -->
<main>
    <div class="p-4 mx-auto max-w-screen-2xl md:p-6">
        <!-- Header Section -->
        <div class="flex px-6 flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Edit Skill</h1>
                <p class="text-gray-600 dark:text-gray-400">Update skill details.</p>
            </div>
        </div>

        <!-- Form Section -->
        <div x-data="slugGenerator('{{ old('name', $skill->name ?? '') }}', '{{ old('slug', $skill->slug ?? '') }}')" class="border-gray-100 p-5 dark:border-gray-800 sm:p-6">
            <div class="rounded-2xl px-6 pb-8 pt-4 border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <form action="{{ route('be.skill.update', $skill->slug) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <!-- Name -->
                    <div class="mt-4" x-data="{ hasError: {{ session('errors') && session('errors')->has('name') ? 'true' : 'false' }} }">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Name <span class="text-error-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            x-model="name"
                            placeholder="e.g., JavaScript, Python, PHP"
                            @input.debounce.300ms="updateSlug"
                            :class="hasError 
                                ? 'border-red-500 dark:border-red-500 focus:ring-red-500 focus:border-red-500' 
                                : 'border-gray-300 dark:border-gray-700 focus:ring-blue-500 focus:border-blue-500'"
                            class="h-11 w-full text-sm mt-1 px-4 py-2.5 border rounded-lg bg-white border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-700 dark:text-gray-300 placeholder:text-gray-400 dark:placeholder:text-white/30 focus:ring-2"
                            required>
                        @error('name')
                            <span class="text-xs mt-1 font-medium text-red-500 dark:text-red-500">* {{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div class="mt-4" x-data="{ hasError: {{ session('errors') && session('errors')->has('slug') ? 'true' : 'false' }} }">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Slug <span class="text-error-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="slug" 
                            name="slug" 
                            x-model="slug"
                            placeholder="Slug will be generated automatically from the name you provided."
                            :class="hasError 
                                ? 'border-red-500 dark:border-red-500 focus:ring-red-500 focus:border-red-500' 
                                : 'border-gray-300 dark:border-gray-700 focus:ring-blue-500 focus:border-blue-500'"
                            class="h-11 w-full text-sm mt-1 px-4 py-2.5 border rounded-lg bg-white border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-700 dark:text-gray-300 placeholder:text-gray-400 dark:placeholder:text-white/30 focus:ring-2"
                            readonly
                            required>
                        @error('slug')
                            <span class="text-xs mt-1 font-medium text-red-500 dark:text-red-500">* {{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Icon Class -->
                    <div class="mt-4">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Icon Class <span class="text-error-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="icon_class" 
                            name="icon_class" 
                            value="{{ old('icon_class', $skill->icon_class) }}"
                            placeholder="e.g., devicon-javascript-plain, devicon-php-plain"
                            class="h-11 w-full text-sm mt-1 px-4 py-2.5 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 placeholder:text-gray-400 dark:placeholder:text-white/30"
                            required>
                        @error('icon_class')
                            <span class="text-xs mt-1 font-medium text-red-500 dark:text-red-500">* {{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end mt-6">
                        <button type="submit" 
                            class="flex items-center gap-2 h-[42px] px-4 py-2.5 rounded-lg border border-blue-500 bg-blue-600 text-white font-medium transition-all hover:bg-blue-700 hover:border-blue-600 focus:ring focus:ring-blue-300 dark:bg-blue-700 dark:border-blue-600 dark:hover:bg-blue-800">
                            Update Skill
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
    <script>
        function slugGenerator(initialName = '', initialSlug = '') {
            return {
                name: initialName || '',
                slug: initialSlug || '',

                updateSlug() {
                    if (this.name.length > 0) {
                        fetch("{{ route('be.skill.generate.slug') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ name: this.name })
                        })
                        .then(response => response.json())
                        .then(data => {
                            this.slug = data.slug;
                        })
                        .catch(error => console.error('Slug generation error:', error));
                    } else {
                        this.slug = "";
                    }
                }
            };
        }
    </script>
@endsection