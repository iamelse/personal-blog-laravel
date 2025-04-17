@php
    use App\Enums\PermissionEnum;
@endphp

@extends('layouts.app')

@push('styles')
    <style>
        .cke_notifications_area {
            display: none !important;
        }
    </style>
@endpush

@section('content')
    <!-- ===== Main Content Start ===== -->
    <main>
        <div class="p-4 mx-auto max-w-screen-2xl md:p-6">
            <!-- Header Section -->
            <div class="flex px-6 flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                        About
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400">
                        Customize your About to share your story, vision, and values in a compelling way.
                    </p>
                </div>
            </div>

            <!-- Hero Section Form -->
            <div class="border-gray-100 p-5 dark:border-gray-800 sm:p-6">
                <div class="rounded-2xl px-6 pb-8 pt-4 border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <form action="{{ route('be.about.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="block mb-4 text-sm font-medium text-gray-700 dark:text-gray-300">
                                Description <span class="text-error-500">*</span>
                            </label>
                            <div x-data="{
                                hasError: @json(session('errors') && session('errors')->has('description')),
                                resize() {
                                    $refs.textarea.style.height = 'auto';
                                    $refs.textarea.style.height = $refs.textarea.scrollHeight + 'px';
                                }
                            }"
                                 x-init="resize()"
                            >
                            <textarea
                                id="description"
                                name="description"
                                x-ref="textarea"
                                @input="resize()"
                                :class="hasError
                                    ? 'border-red-500 dark:border-red-500 focus:ring-2 focus:ring-red-500 dark:focus:ring-red-500'
                                    : 'border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-500'"
                                class="mt-1 block w-full rounded-lg overflow-hidden resize-none"
                            >
                                {!! old('description', $about->content['description'] ?? '') !!}
                            </textarea>

                                <span class="text-xs mt-1 font-medium text-red-500 dark:text-red-500" x-show="hasError">
                                @error('description') * {{ $message }} @enderror
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
    <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
    <script>
        // Maintainable array of custom colors
        const customColors = [
            { hex: '2563eb', label: 'Blue 600' },
            { hex: 'ef4444', label: 'Red 500' },
            { hex: '22c55e', label: 'Green 500' },
            { hex: 'facc15', label: 'Yellow 400' },
            { hex: '8b5cf6', label: 'Purple 500' },
            { hex: '0ea5e9', label: 'Sky 500' }
        ];

        // Use custom colors for the TextColor button
        const colorButtonColors = customColors.map(c => c.hex).join(',');

        // Define custom inline styles using span with Tailwind classes
        CKEDITOR.stylesSet.add('custom_styles', customColors.map(color => ({
            name: color.label,
            element: 'span',
            attributes: {
                'class': `text-[${color.hex}]` // Dynamically applies Tailwind color class
            }
        })));

        // CKEditor config
        const options = {
            colorButton_colors: colorButtonColors,  // Register colors
            stylesSet: 'custom_styles',  // Add custom styles
            toolbar: [
                { name: 'tools', items: ['Maximize'] },
                { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'Undo', 'Redo'] },
                { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Link'] },
                { name: 'paragraph', items: ['NumberedList', 'BulletedList', 'Blockquote'] },
                { name: 'align', items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
                { name: 'styles', items: ['Format', 'FontSize'] },
                { name: 'colors', items: ['TextColor'] }
            ],
            format_tags: 'p;h1;h2;h3;h4;h5;h6',
        };

        // Initialize CKEditor with the custom options
        CKEDITOR.replace('description', options);

        // Tailwind-style classes for paragraph and heading elements
        const paragraphClasses = 'text-base sm:text-lg text-gray-600 dark:text-gray-300';
        const heading1Classes = 'text-3xl sm:text-4xl md:text-5xl font-bold text-gray-900 dark:text-gray-100';
        const heading2Classes = 'text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-gray-100';
        const heading3Classes = 'text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 dark:text-gray-100';
        const heading4Classes = 'text-lg sm:text-xl md:text-2xl font-bold text-gray-900 dark:text-gray-100';
        const heading5Classes = 'text-base sm:text-lg md:text-xl font-bold text-gray-900 dark:text-gray-100';
        const heading6Classes = 'text-sm sm:text-base md:text-lg font-bold text-gray-900 dark:text-gray-100';
        const olClasses = 'costume-ol list-decimal list-inside space-y-2 text-base text-gray-800 dark:text-gray-200';
        const ulClasses = 'costume-ul list-disc list-inside space-y-2 text-base text-gray-800 dark:text-gray-200';
        const blockquoteClasses = 'border-l-4 border-gray-300 dark:border-gray-600 ml-4 pl-4 italic text-gray-700 dark:text-gray-300';

        // Helper to apply classes to elements
        function applyClasses(classes) {
            return function (el) {
                el.addClass(classes);
            };
        }

        // On instance ready, apply formatting rules to HTML elements
        CKEDITOR.instances.description.on('instanceReady', function () {
            this.dataProcessor.htmlFilter.addRules({
                elements: {
                    p: applyClasses(paragraphClasses),
                    h1: applyClasses(heading1Classes),
                    h2: applyClasses(heading2Classes),
                    h3: applyClasses(heading3Classes),
                    h4: applyClasses(heading4Classes),
                    h5: applyClasses(heading5Classes),
                    h6: applyClasses(heading6Classes),
                    ul: applyClasses(ulClasses),
                    ol: applyClasses(olClasses),
                    blockquote: applyClasses(blockquoteClasses)
                }
            });
        });
    </script>
@endsection
