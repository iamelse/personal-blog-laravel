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
                    About Section
                </h1>                
                <p class="text-gray-600 dark:text-gray-400">
                    Customize your About Section to share your story, vision, and values in a compelling way.
                </p>
            </div>            
        </div>

        <!-- Hero Section Form -->
        <div class="border-gray-100 p-5 dark:border-gray-800 sm:p-6">
            <div class="rounded-2xl px-6 pb-8 pt-4 border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <form action="{{ route('be.home.about.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @php
                        $content = json_decode($about->content ?? '{}', true);
                    @endphp
    
                    <!-- Hero Image Upload -->
                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Upload Image
                        </label>
                        <div x-data="{ 
                                hasError: {{ json_encode(session('errors') && session('errors')->has('content.image')) }},
                                previewUrl: {{ json_encode(getAboutMeImageSection($content) ?? '') }}
                            }">

                            <!-- Preview Image -->
                            <div x-show="previewUrl" class="my-2 w-full max-w-md aspect-square rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700">
                                <img 
                                    :src="previewUrl" 
                                    class="w-full h-full object-cover"
                                    alt="Image Preview"
                                >
                            </div>

                            <input 
                                type="file" 
                                id="image" 
                                name="content[image]" 
                                accept="image/*"
                                @change="let file = $event.target.files[0]; 
                                        if (file) { 
                                            let reader = new FileReader(); 
                                            reader.onload = (e) => previewUrl = e.target.result;
                                            reader.readAsDataURL(file);
                                        }"
                                class="h-11 w-full text-sm mt-1 px-4 py-2.5 border rounded-lg placeholder:text-gray-400 dark:placeholder:text-white/30"
                                :class="hasError 
                                    ? 'border-red-500 dark:border-red-500 focus:ring-2 focus:ring-red-500 dark:focus:ring-red-500' 
                                    : 'border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-500'"
                            >

                            <!-- Error Message -->
                            <span class="text-xs mt-1 font-medium text-red-500 dark:text-red-500">
                                @error('content.image') * {{ $message }} @enderror
                            </span>
                        </div>
                    </div>

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
                                class="h-11 w-full text-sm mt-1 px-4 py-2.5 border rounded-lg placeholder:text-gray-400 dark:placeholder:text-white/30"
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
                        <div x-data="{ 
                                hasError: @json(session('errors') && session('errors')->has('content.description')),
                                resize() { 
                                    $refs.textarea.style.height = 'auto';
                                    $refs.textarea.style.height = $refs.textarea.scrollHeight + 'px';
                                }
                            }" 
                            x-init="resize()"
                        >
                            <textarea 
                                id="description" 
                                name="content[description]" 
                                x-ref="textarea"
                                @input="resize()"
                                :class="hasError 
                                    ? 'border-red-500 dark:border-red-500 focus:ring-2 focus:ring-red-500 dark:focus:ring-red-500' 
                                    : 'border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-500'"
                                class="mt-1 block w-full rounded-lg overflow-hidden resize-none"
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