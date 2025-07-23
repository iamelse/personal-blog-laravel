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
    <!-- Post Section -->
    <section id="post" class="py-16 lg:py-32 bg-white dark:bg-gray-900 transition-colors">
        <div class="mx-auto max-w-[1030px] px-4 sm:px-8 xl:px-0">
            <div class="mx-auto max-w-[770px] text-center">
                <h1 class="mb-5 text-2xl font-bold text-gray-800 dark:text-white sm:text-3xl md:text-4xl">
                    {{ $post->title }}
                </h1>
                <p class="mb-4 text-base text-gray-600 dark:text-white">
                    {{ $post->excerpt }}
                </p>

                <div class="mt-6 flex flex-col justify-center gap-3 sm:flex-row sm:items-center">
                    <div class="flex h-10 w-10 overflow-hidden rounded-full">
                        <img
                            alt="{{ $post->user->name }}"
                            loading="lazy"
                            width="40"
                            height="40"
                            src="{{ getAuthorPostImagePath($post->user) }}"
                        />
                    </div>

                    <div class="flex flex-wrap items-center gap-4">
                        <div class="flex flex-wrap items-center gap-2.5">
                            <h4 class="text-sm font-medium text-gray-700 dark:text-white">{{ $post->user->name }}</h4>
                            <i class="bx bxs-circle text-gray-700 dark:text-white text-[6px] mx-3"></i>
                            <div class="inline-flex items-center gap-2 text-gray-700 dark:text-white">
                                <i class="bx bx-calendar text-sm"></i>
                                <p class="text-sm font-medium">{{ $post->formatted_published_at }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full max-w-[1010px] mx-auto">
                <img
                    alt="What's New in TailAdmin V2.0: A Complete Redesign &amp; Big Upgrades!"
                    loading="lazy"
                    width="1030"
                    height="613"
                    decoding="async"
                    class="my-10 w-full overflow-hidden rounded-[20px]"
                    style="color: transparent;"
                    src="{{ $post->cover }}"
                />
            </div>

            <div class="mx-auto max-w-[770px]">
                <p class="mb-4 text-base text-gray-600 dark:text-white">
                    {!! $post->body !!}
                </p>
                {!! $post->body !!}
            </div>
        </div>
    </section>
@endsection
