@extends('layouts.app')

@section('content')
    <!-- ===== Main Content Start ===== -->
    <main>
        <div class="py-4 mx-auto w-full md:py-4">

            <!-- Header Section -->
            <div class="flex px-6 flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Create a Post</h1>
                    <p class="text-gray-600 dark:text-gray-400">Add a new post to the system.</p>
                </div>
            </div>

            <!-- Form Section -->
            <div class="border-gray-100 p-5 dark:border-gray-800 sm:p-6">
                <div class="rounded-2xl px-6 pb-8 pt-4 border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <form action="{{ route('be.post.store') }}" method="POST" x-data="{ title: '', slug: '' }" enctype="multipart/form-data">
                        @csrf

                        <!-- Cover Image Upload -->
                        <div class="mt-4">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Cover <span class="text-error-500">*</span>
                            </label>

                            <div x-data="imageUploader()" x-init="hasError = {{ session('errors') && session('errors')->has('cover') ? 'true' : 'false' }}">
                                <label
                                    for="uploadFile1"
                                    class="relative bg-white text-slate-500 font-semibold text-base rounded aspect-[21/9] flex flex-col items-center justify-center cursor-pointer border-2 border-dashed overflow-hidden"
                                    :class="hasError
                                    ? 'border-red-500 dark:border-red-500'
                                    : 'border-gray-300 dark:border-gray-700'"
                                >
                                    <!-- Preview -->
                                    <template x-if="preview">
                                        <div class="absolute inset-0">
                                            <img :src="preview" alt="preview" class="w-full h-full object-cover" draggable="false" />
                                            <!-- Tombol X bulat dengan hover merah -->
                                            <button
                                                type="button"
                                                @click.prevent="remove()"
                                                class="absolute top-2 right-2 w-8 h-8 rounded-full flex items-center justify-center bg-white/90 hover:bg-red-100 border border-gray-300 hover:border-red-300 shadow transition-colors"
                                                title="Hapus"
                                            >
                                                <!-- Ikon X -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-700 hover:text-red-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </template>

                                    <!-- Default UI -->
                                    <template x-if="!preview">
                                        <div class="flex flex-col items-center z-10">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-11 mb-3 fill-gray-500" viewBox="0 0 32 32">
                                                <path
                                                    d="M23.75 11.044a7.99 7.99 0 0 0-15.5-.009A8 8 0 0 0 9 27h3a1 1 0 0 0 0-2H9a6 6 0 0 1-.035-12 1.038 1.038 0 0 0 1.1-.854 5.991 5.991 0 0 1 11.862 0A1.08 1.08 0 0 0 23 13a6 6 0 0 1 0 12h-3a1 1 0 0 0 0 2h3a8 8 0 0 0 .75-15.956z" />
                                                <path
                                                    d="M20.293 19.707a1 1 0 0 0 1.414-1.414l-5-5a1 1 0 0 0-1.414 0l-5 5a1 1 0 0 0 1.414 1.414L15 16.414V29a1 1 0 0 0 2 0V16.414z" />
                                            </svg>
                                            <div>Upload file</div>
                                        </div>
                                    </template>

                                    <input
                                        x-ref="input"
                                        @change="fileChosen"
                                        type="file"
                                        id="uploadFile1"
                                        name="cover"
                                        accept="image/*"
                                        class="hidden"
                                    />

                                    <!-- Info filename -->
                                    <div class="absolute bottom-3 text-center w-full z-10">
                                        <p class="text-xs font-medium text-slate-400">
                                            PNG, JPG, WEBP, SVG, GIF — Max: 5 MB
                                        </p>
                                        <template x-if="fileName">
                                            <p class="text-xs text-slate-600 mt-1">
                                                <span x-text="fileName"></span> — <span x-text="prettySize"></span>
                                            </p>
                                        </template>
                                    </div>
                                </label>

                                <!-- Error Message -->
                                <span class="text-xs mt-1 font-medium text-red-500 dark:text-red-500 block" x-show="hasError">
                                    @error('cover') * {{ $message }} @enderror
                                </span>
                            </div>
                        </div>

                        <!-- Post Title -->
                        <div class="mt-4">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Post Title <span class="text-error-500">*</span>
                            </label>
                            <div x-data="{ hasError: {{ session('errors') && session('errors')->has('title') ? 'true' : 'false' }} }">
                                <input
                                    type="text"
                                    id="title"
                                    name="title"
                                    value="{{ old('title') }}"
                                    x-model="title"
                                    @input="slug = title.toLowerCase().trim().replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '')"
                                    placeholder="Enter post title"
                                    :class="hasError
                                    ? 'border-red-500 dark:border-red-500 focus:ring-2 focus:ring-red-500 dark:focus:ring-red-500'
                                    : 'border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-500'"
                                    class="h-11 w-full text-sm mt-1 px-4 py-2.5 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 placeholder:text-gray-400 dark:placeholder:text-white/30"
                                >
                                <span class="text-xs mt-1 font-medium text-red-500 dark:text-red-500" x-show="hasError">
                                    @error('title') * {{ $message }} @enderror
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

                        <!-- Excerpt -->
                        <div class="mt-4">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Excerpt <span class="text-error-500">*</span>
                            </label>
                            <div x-data="{ hasError: {{ session('errors') && session('errors')->has('excerpt') ? 'true' : 'false' }} }">
                            <textarea
                                id="excerpt"
                                name="excerpt"
                                rows="3"
                                placeholder="Short summary of the post"
                                :class="hasError
                                ? 'border-red-500 dark:border-red-500 focus:ring-2 focus:ring-red-500 dark:focus:ring-red-500'
                                : 'border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-500'"
                                class="w-full text-sm mt-1 px-4 py-2.5 resize-none"
                                required>{{ old('excerpt') }}</textarea>
                                <span class="text-xs mt-1 font-medium text-red-500 dark:text-red-500" x-show="hasError">
                                    @error('excerpt') * {{ $message }} @enderror
                                </span>
                            </div>
                        </div>

                        <!-- Body WYSIWYG TipTap-->
                        <label class="mt-4 mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Body <span class="text-error-500">*</span>
                        </label>

                        <div class="w-full border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                            <div class="px-3 py-2 border-b border-gray-200 dark:border-gray-600">
                                <div class="flex flex-wrap items-center">
                                    <div class="flex items-center space-x-1 rtl:space-x-reverse flex-wrap">
                                        <button id="toggleBoldButton" data-tooltip-target="tooltip-bold" type="button" class="p-1.5 text-gray-500 rounded-sm cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5h4.5a3.5 3.5 0 1 1 0 7H8m0-7v7m0-7H6m2 7h6.5a3.5 3.5 0 1 1 0 7H8m0-7v7m0 0H6"/>
                                            </svg>
                                            <span class="sr-only">Bold</span>
                                        </button>
                                        <div id="tooltip-bold" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                            Toggle bold
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                        <button id="toggleItalicButton" data-tooltip-target="tooltip-italic" type="button" class="p-1.5 text-gray-500 rounded-sm cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8.874 19 6.143-14M6 19h6.33m-.66-14H18"/>
                                            </svg>
                                            <span class="sr-only">Italic</span>
                                        </button>
                                        <div id="tooltip-italic" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                            Toggle italic
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                        <button id="toggleUnderlineButton" data-tooltip-target="tooltip-underline" type="button" class="p-1.5 text-gray-500 rounded-sm cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M6 19h12M8 5v9a4 4 0 0 0 8 0V5M6 5h4m4 0h4"/>
                                            </svg>
                                            <span class="sr-only">Underline</span>
                                        </button>
                                        <div id="tooltip-underline" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                            Toggle underline
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                        <button id="toggleStrikeButton" data-tooltip-target="tooltip-strike" type="button" class="p-1.5 text-gray-500 rounded-sm cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 6.2V5h12v1.2M7 19h6m.2-14-1.677 6.523M9.6 19l1.029-4M5 5l6.523 6.523M19 19l-7.477-7.477"/>
                                            </svg>
                                            <span class="sr-only">Strike</span>
                                        </button>
                                        <div id="tooltip-strike" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                            Toggle strike
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                        <button id="toggleHighlightButton" data-tooltip-target="tooltip-highlight" type="button" class="p-1.5 text-gray-500 rounded-sm cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M9 19.2H5.5c-.3 0-.5-.2-.5-.5V16c0-.2.2-.4.5-.4h13c.3 0 .5.2.5.4v2.7c0 .3-.2.5-.5.5H18m-6-1 1.4 1.8h.2l1.4-1.7m-7-5.4L12 4c0-.1 0-.1 0 0l4 8.8m-6-2.7h4m-7 2.7h2.5m5 0H17"/>
                                            </svg>
                                            <span class="sr-only">Highlight</span>
                                        </button>
                                        <div id="tooltip-highlight" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                            Toggle highlight
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>

                                        <button id="toggleLinkButton" data-tooltip-target="tooltip-link" type="button" class="p-1.5 text-gray-500 rounded-sm cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.213 9.787a3.391 3.391 0 0 0-4.795 0l-3.425 3.426a3.39 3.39 0 0 0 4.795 4.794l.321-.304m-.321-4.49a3.39 3.39 0 0 0 4.795 0l3.424-3.426a3.39 3.39 0 0 0-4.794-4.795l-1.028.961"/>
                                            </svg>
                                            <span class="sr-only">Link</span>
                                        </button>
                                        <div id="tooltip-link" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                            Add link
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                        <button id="removeLinkButton" data-tooltip-target="tooltip-remove-link" type="button" class="p-1.5 text-gray-500 rounded-sm cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M13.2 9.8a3.4 3.4 0 0 0-4.8 0L5 13.2A3.4 3.4 0 0 0 9.8 18l.3-.3m-.3-4.5a3.4 3.4 0 0 0 4.8 0L18 9.8A3.4 3.4 0 0 0 13.2 5l-1 1m7.4 14-1.8-1.8m0 0L16 16.4m1.8 1.8 1.8-1.8m-1.8 1.8L16 20"/>
                                            </svg>
                                            <span class="sr-only">Remove link</span>
                                        </button>
                                        <div id="tooltip-remove-link" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                            Remove link
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                        <button id="toggleTextSizeButton" data-dropdown-toggle="textSizeDropdown" type="button" data-tooltip-target="tooltip-text-size" class="p-1.5 text-gray-500 rounded-sm cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6.2V5h11v1.2M8 5v14m-3 0h6m2-6.8V11h8v1.2M17 11v8m-1.5 0h3"/>
                                            </svg>
                                            <span class="sr-only">Text size</span>
                                        </button>
                                        <div id="tooltip-text-size" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                            Text size
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                        <div id="textSizeDropdown" class="z-10 hidden w-72 rounded-sm bg-white p-2 shadow-sm dark:bg-gray-700">
                                            <ul class="space-y-1 text-sm font-medium" aria-labelledby="toggleTextSizeButton">
                                                <li>
                                                    <button data-text-size="16px" type="button" class="flex justify-between items-center w-full text-base rounded-sm px-3 py-2 hover:bg-gray-100 text-gray-900 dark:hover:bg-gray-600 dark:text-white">16px (Default)
                                                    </button>
                                                </li>
                                                <li>
                                                    <button data-text-size="12px" type="button" class="flex justify-between items-center w-full text-xs rounded-sm px-3 py-2 hover:bg-gray-100 text-gray-900 dark:hover:bg-gray-600 dark:text-white">12px (Tiny)
                                                    </button>
                                                </li>
                                                <li>
                                                    <button data-text-size="14px" type="button" class="flex justify-between items-center w-full text-sm rounded-sm px-3 py-2 hover:bg-gray-100 text-gray-900 dark:hover:bg-gray-600 dark:text-white">14px (Small)
                                                    </button>
                                                </li>
                                                <li>
                                                    <button data-text-size="18px" type="button" class="flex justify-between items-center w-full text-lg rounded-sm px-3 py-2 hover:bg-gray-100 text-gray-900 dark:hover:bg-gray-600 dark:text-white">18px (Lead)
                                                    </button>
                                                </li>
                                                <li>
                                                    <button data-text-size="24px" type="button" class="flex justify-between items-center w-full text-2xl rounded-sm px-3 py-2 hover:bg-gray-100 text-gray-900 dark:hover:bg-gray-600 dark:text-white">24px (Large)
                                                    </button>
                                                </li>
                                                <li>
                                                    <button data-text-size="36px" type="button" class="flex justify-between items-center w-full text-4xl rounded-sm px-3 py-2 hover:bg-gray-100 text-gray-900 dark:hover:bg-gray-600 dark:text-white">36px (Huge)
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                        <button id="toggleTextColorButton" data-dropdown-toggle="textColorDropdown" type="button" data-tooltip-target="tooltip-text-color" class="p-1.5 text-gray-500 rounded-sm cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="25" height="24" fill="none" viewBox="0 0 25 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m6.532 15.982 1.573-4m-1.573 4h-1.1m1.1 0h1.65m-.077-4 2.725-6.93a.11.11 0 0 1 .204 0l2.725 6.93m-5.654 0H8.1m.006 0h5.654m0 0 .617 1.569m5.11 4.453c0 1.102-.854 1.996-1.908 1.996-1.053 0-1.907-.894-1.907-1.996 0-1.103 1.907-4.128 1.907-4.128s1.909 3.025 1.909 4.128Z"/>
                                            </svg>
                                            <span class="sr-only">Text color</span>
                                        </button>
                                        <div id="tooltip-text-color" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                            Text color
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                        <div id="textColorDropdown" class="z-10 hidden w-48 rounded-sm bg-white p-2 shadow-sm dark:bg-gray-700">
                                            <div class="grid grid-cols-6 gap-2 group mb-3 items-center p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">
                                                <input type="color" id="color" value="#e66465" class="border-gray-200 border bg-gray-50 dark:bg-gray-700 dark:border-gray-600 rounded-md p-px px-1 hover:bg-gray-50 group-hover:bg-gray-50 dark:group-hover:bg-gray-700 w-full h-8 col-span-3" />
                                                <label for="color" class="text-gray-500 dark:text-gray-400 text-sm font-medium col-span-3 group-hover:text-gray-900 dark:group-hover:text-white">Pick a color</label>
                                            </div>
                                            <div class="grid grid-cols-6 gap-1 mb-3">
                                                <button type="button" data-hex-color="#1A56DB" style="background-color: #1A56DB" class="w-6 h-6 rounded-md"><span class="sr-only">Blue</span></button>
                                                <button type="button" data-hex-color="#0E9F6E" style="background-color: #0E9F6E" class="w-6 h-6 rounded-md"><span class="sr-only">Green</span></button>
                                                <button type="button" data-hex-color="#FACA15" style="background-color: #FACA15" class="w-6 h-6 rounded-md"><span class="sr-only">Yellow</span></button>
                                                <button type="button" data-hex-color="#F05252" style="background-color: #F05252" class="w-6 h-6 rounded-md"><span class="sr-only">Red</span></button>
                                                <button type="button" data-hex-color="#FF8A4C" style="background-color: #FF8A4C" class="w-6 h-6 rounded-md"><span class="sr-only">Orange</span></button>
                                                <button type="button" data-hex-color="#0694A2" style="background-color: #0694A2" class="w-6 h-6 rounded-md"><span class="sr-only">Teal</span></button>
                                                <button type="button" data-hex-color="#B4C6FC" style="background-color: #B4C6FC" class="w-6 h-6 rounded-md"><span class="sr-only">Light indigo</span></button>
                                                <button type="button" data-hex-color="#8DA2FB" style="background-color: #8DA2FB" class="w-6 h-6 rounded-md"><span class="sr-only">Indigo</span></button>
                                                <button type="button" data-hex-color="#5145CD" style="background-color: #5145CD" class="w-6 h-6 rounded-md"><span class="sr-only">Purple</span></button>
                                                <button type="button" data-hex-color="#771D1D" style="background-color: #771D1D" class="w-6 h-6 rounded-md"><span class="sr-only">Brown</span></button>
                                                <button type="button" data-hex-color="#FCD9BD" style="background-color: #FCD9BD" class="w-6 h-6 rounded-md"><span class="sr-only">Light orange</span></button>
                                                <button type="button" data-hex-color="#99154B" style="background-color: #99154B" class="w-6 h-6 rounded-md"><span class="sr-only">Bordo</span></button>
                                                <button type="button" data-hex-color="#7E3AF2" style="background-color: #7E3AF2" class="w-6 h-6 rounded-md"><span class="sr-only">Dark Purple</span></button>
                                                <button type="button" data-hex-color="#CABFFD" style="background-color: #CABFFD" class="w-6 h-6 rounded-md"><span class="sr-only">Light</span></button>
                                                <button type="button" data-hex-color="#D61F69" style="background-color: #D61F69" class="w-6 h-6 rounded-md"><span class="sr-only">Dark Pink</span></button>
                                                <button type="button" data-hex-color="#F8B4D9" style="background-color: #F8B4D9" class="w-6 h-6 rounded-md"><span class="sr-only">Pink</span></button>
                                                <button type="button" data-hex-color="#F6C196" style="background-color: #F6C196" class="w-6 h-6 rounded-md"><span class="sr-only">Cream</span></button>
                                                <button type="button" data-hex-color="#A4CAFE" style="background-color: #A4CAFE" class="w-6 h-6 rounded-md"><span class="sr-only">Light Blue</span></button>
                                                <button type="button" data-hex-color="#5145CD" style="background-color: #5145CD" class="w-6 h-6 rounded-md"><span class="sr-only">Dark Blue</span></button>
                                                <button type="button" data-hex-color="#B43403" style="background-color: #B43403" class="w-6 h-6 rounded-md"><span class="sr-only">Orange Brown</span></button>
                                                <button type="button" data-hex-color="#FCE96A" style="background-color: #FCE96A" class="w-6 h-6 rounded-md"><span class="sr-only">Light Yellow</span></button>
                                                <button type="button" data-hex-color="#1E429F" style="background-color: #1E429F" class="w-6 h-6 rounded-md"><span class="sr-only">Navy Blue</span></button>
                                                <button type="button" data-hex-color="#768FFD" style="background-color: #768FFD" class="w-6 h-6 rounded-md"><span class="sr-only">Light Purple</span></button>
                                                <button type="button" data-hex-color="#BCF0DA" style="background-color: #BCF0DA" class="w-6 h-6 rounded-md"><span class="sr-only">Light Green</span></button>
                                                <button type="button" data-hex-color="#EBF5FF" style="background-color: #EBF5FF" class="w-6 h-6 rounded-md"><span class="sr-only">Sky Blue</span></button>
                                                <button type="button" data-hex-color="#16BDCA" style="background-color: #16BDCA" class="w-6 h-6 rounded-md"><span class="sr-only">Cyan</span></button>
                                                <button type="button" data-hex-color="#E74694" style="background-color: #E74694" class="w-6 h-6 rounded-md"><span class="sr-only">Pink</span></button>
                                                <button type="button" data-hex-color="#83B0ED" style="background-color: #83B0ED" class="w-6 h-6 rounded-md"><span class="sr-only">Darker Sky Blue</span></button>
                                                <button type="button" data-hex-color="#03543F" style="background-color: #03543F" class="w-6 h-6 rounded-md"><span class="sr-only">Forest Green</span></button>
                                                <button type="button" data-hex-color="#111928" style="background-color: #111928" class="w-6 h-6 rounded-md"><span class="sr-only">Black</span></button>
                                                <button type="button" data-hex-color="#4B5563" style="background-color: #4B5563" class="w-6 h-6 rounded-md"><span class="sr-only">Stone</span></button>
                                                <button type="button" data-hex-color="#6B7280" style="background-color: #6B7280" class="w-6 h-6 rounded-md"><span class="sr-only">Gray</span></button>
                                                <button type="button" data-hex-color="#D1D5DB" style="background-color: #D1D5DB" class="w-6 h-6 rounded-md"><span class="sr-only">Light Gray</span></button>
                                                <button type="button" data-hex-color="#F3F4F6" style="background-color: #F3F4F6" class="w-6 h-6 rounded-md"><span class="sr-only">Cloud Gray</span></button>
                                                <button type="button" data-hex-color="#F3F4F6" style="background-color: #F3F4F6" class="w-6 h-6 rounded-md"><span class="sr-only">Cloud Gray</span></button>
                                                <button type="button" data-hex-color="#F9FAFB" style="background-color: #F9FAFB" class="w-6 h-6 rounded-md"><span class="sr-only">Heaven Gray</span></button>
                                            </div>
                                            <button type="button" id="reset-color" class="py-1.5 text-sm font-medium text-gray-500 focus:outline-none bg-white rounded-lg hover:bg-gray-100 hover:text-gray-900 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-700 dark:text-gray-400 dark:hover:text-white w-full dark:hover:bg-gray-600">Reset color</button>
                                        </div>
                                        <button id="toggleFontFamilyButton" data-dropdown-toggle="fontFamilyDropdown" type="button" data-tooltip-target="tooltip-font-family" class="p-1.5 text-gray-500 rounded-sm cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m10.6 19 4.298-10.93a.11.11 0 0 1 .204 0L19.4 19m-8.8 0H9.5m1.1 0h1.65m7.15 0h-1.65m1.65 0h1.1m-7.7-3.985h4.4M3.021 16l1.567-3.985m0 0L7.32 5.07a.11.11 0 0 1 .205 0l2.503 6.945h-5.44Z"/>
                                            </svg>
                                            <span class="sr-only">Font family</span>
                                        </button>
                                        <div id="tooltip-font-family" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                            Font Family
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                        <div id="fontFamilyDropdown" class="z-10 hidden w-48 rounded-sm bg-white p-2 shadow-sm dark:bg-gray-700">
                                            <ul class="space-y-1 text-sm font-medium" aria-labelledby="toggleFontFamilyButton">
                                                <li>
                                                    <button data-font-family="Outfit, ui-sans-serif" type="button" class="flex justify-between items-center w-full text-sm font-sans rounded-sm px-3 py-2 hover:bg-gray-100 text-gray-900 dark:hover:bg-gray-600 dark:text-white">Default
                                                    </button>
                                                </li>
                                                <li>
                                                    <button data-font-family="Arial, sans-serif" type="button" class="flex justify-between items-center w-full text-sm rounded-sm px-3 py-2 hover:bg-gray-100 text-gray-900 dark:hover:bg-gray-600 dark:text-white" style="font-family: Arial, sans-serif;">Arial
                                                    </button>
                                                </li>
                                                <li>
                                                    <button data-font-family="'Courier New', monospace" type="button" class="flex justify-between items-center w-full text-sm rounded-sm px-3 py-2 hover:bg-gray-100 text-gray-900 dark:hover:bg-gray-600 dark:text-white" style="font-family: 'Courier New', monospace;">Courier New
                                                    </button>
                                                </li>
                                                <li>
                                                    <button data-font-family="Georgia, serif" type="button" class="flex justify-between items-center w-full text-sm rounded-sm px-3 py-2 hover:bg-gray-100 text-gray-900 dark:hover:bg-gray-600 dark:text-white" style="font-family: Georgia, serif;">Georgia
                                                    </button>
                                                </li>
                                                <li>
                                                    <button data-font-family="'Lucida Sans Unicode', sans-serif" type="button" class="flex justify-between items-center w-full text-sm rounded-sm px-3 py-2 hover:bg-gray-100 text-gray-900 dark:hover:bg-gray-600 dark:text-white" style="font-family: 'Lucida Sans Unicode', sans-serif;">Lucida Sans Unicode
                                                    </button>
                                                </li>
                                                <li>
                                                    <button data-font-family="Tahoma, sans-serif" type="button" class="flex justify-between items-center w-full text-sm rounded-sm px-3 py-2 hover:bg-gray-100 text-gray-900 dark:hover:bg-gray-600 dark:text-white" style="font-family: Tahoma, sans-serif;">Tahoma
                                                    </button>
                                                </li>
                                                <li>
                                                    <button data-font-family="'Times New Roman', serif;" type="button" class="flex justify-between items-center w-full text-sm rounded-sm px-3 py-2 hover:bg-gray-100 text-gray-900 dark:hover:bg-gray-600 dark:text-white" style="font-family: 'Times New Roman', serif;">Times New Roman
                                                    </button>
                                                </li>
                                                <li>
                                                    <button data-font-family="'Trebuchet MS', sans-serif" type="button" class="flex justify-between items-center w-full text-sm rounded-sm px-3 py-2 hover:bg-gray-100 text-gray-900 dark:hover:bg-gray-600 dark:text-white" style="font-family: 'Trebuchet MS', sans-serif;">Trebuchet MS
                                                    </button>
                                                </li>
                                                <li>
                                                    <button data-font-family="Verdana, sans-serif" type="button" class="flex justify-between items-center w-full text-sm rounded-sm px-3 py-2 hover:bg-gray-100 text-gray-900 dark:hover:bg-gray-600 dark:text-white" style="font-family: Verdana, sans-serif;">Verdana
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="px-1">
                                            <span class="block w-px h-4 bg-gray-300 dark:bg-gray-600"></span>
                                        </div>
                                        <button id="toggleLeftAlignButton" type="button" data-tooltip-target="tooltip-left-align" class="p-1.5 text-gray-500 rounded-sm cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6h8m-8 4h12M6 14h8m-8 4h12"/>
                                            </svg>
                                            <span class="sr-only">Align left</span>
                                        </button>
                                        <div id="tooltip-left-align" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                            Align left
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                        <button id="toggleCenterAlignButton" type="button" data-tooltip-target="tooltip-center-align" class="p-1.5 text-gray-500 rounded-sm cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 6h8M6 10h12M8 14h8M6 18h12"/>
                                            </svg>
                                            <span class="sr-only">Align center</span>
                                        </button>
                                        <div id="tooltip-center-align" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                            Align center
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                        <button id="toggleRightAlignButton" type="button" data-tooltip-target="tooltip-right-align" class="p-1.5 text-gray-500 rounded-sm cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 6h-8m8 4H6m12 4h-8m8 4H6"/>
                                            </svg>
                                            <span class="sr-only">Align right</span>
                                        </button>
                                        <div id="tooltip-right-align" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                            Align right
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                        <button id="toggleJustifyAlignButton" type="button" data-tooltip-target="tooltip-justify-align" class="p-1.5 text-gray-500 rounded-sm cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                            </svg>
                                            <span class="sr-only">Align justify</span>
                                        </button>
                                        <div id="tooltip-justify-align" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                            Align justify
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 pt-2 flex-wrap">
                                    <button id="typographyDropdownButton" data-dropdown-toggle="typographyDropdown" class="flex items-center justify-center rounded-lg bg-gray-100 px-3 py-1.5 text-sm font-medium text-gray-500 hover:bg-gray-200 hover:text-gray-900 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-50 dark:bg-gray-600 dark:text-gray-400 dark:hover:bg-gray-500 dark:hover:text-white dark:focus:ring-gray-600" type="button">
                                        Format
                                        <svg class="-me-0.5 ms-1.5 h-3.5 w-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <div class="ps-1.5">
                                        <span class="block w-px h-4 bg-gray-300 dark:bg-gray-600"></span>
                                    </div>
                                    <!-- Heading Dropdown -->
                                    <div id="typographyDropdown" class="z-10 hidden w-72 rounded-sm bg-white p-2 shadow-sm dark:bg-gray-700">
                                        <ul class="space-y-1 text-sm font-medium" aria-labelledby="typographyDropdownButton">
                                            <li>
                                                <button id="toggleParagraphButton" type="button" class="flex justify-between items-center w-full text-base rounded-sm px-3 py-2 hover:bg-gray-100 text-gray-900 dark:hover:bg-gray-600 dark:text-white">Paragraph
                                                    <div class="space-x-1.5">
                                                        <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">Cmd</kbd>
                                                        <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">Alt</kbd>
                                                        <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">0</kbd>
                                                    </div>
                                                </button>
                                            </li>
                                            <li>
                                                <button id="heading1" data-heading-level="1" type="button" class="flex justify-between items-center w-full text-base rounded-sm px-3 py-2 hover:bg-gray-100 text-gray-900 dark:hover:bg-gray-600 dark:text-white">Heading 1
                                                    <div class="space-x-1.5">
                                                        <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">Cmd</kbd>
                                                        <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">Alt</kbd>
                                                        <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">1</kbd>
                                                    </div>
                                                </button>
                                            </li>
                                            <li>
                                                <button id="heading2" data-heading-level="2" type="button" class="flex justify-between items-center w-full text-base rounded-sm px-3 py-2 hover:bg-gray-100 text-gray-900 dark:hover:bg-gray-600 dark:text-white">Heading 2
                                                    <div class="space-x-1.5">
                                                        <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">Cmd</kbd>
                                                        <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">Alt</kbd>
                                                        <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">2</kbd>
                                                    </div>
                                                </button>
                                            </li>
                                            <li>
                                                <button id="heading3" data-heading-level="3" type="button" class="flex justify-between items-center w-full text-base rounded-sm px-3 py-2 hover:bg-gray-100 text-gray-900 dark:hover:bg-gray-600 dark:text-white">Heading 3
                                                    <div class="space-x-1.5">
                                                        <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">Cmd</kbd>
                                                        <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">Alt</kbd>
                                                        <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">3</kbd>
                                                    </div>
                                                </button>
                                            </li>
                                            <li>
                                                <button id="heading4" data-heading-level="4" type="button" class="flex justify-between items-center w-full text-base rounded-sm px-3 py-2 hover:bg-gray-100 text-gray-900 dark:hover:bg-gray-600 dark:text-white">Heading 4
                                                    <div class="space-x-1.5">
                                                        <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">Cmd</kbd>
                                                        <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">Alt</kbd>
                                                        <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">4</kbd>
                                                    </div>
                                                </button>
                                            </li>
                                            <li>
                                                <button id="heading5" data-heading-level="5" type="button" class="flex justify-between items-center w-full text-base rounded-sm px-3 py-2 hover:bg-gray-100 text-gray-900 dark:hover:bg-gray-600 dark:text-white">Heading 5
                                                    <div class="space-x-1.5">
                                                        <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">Cmd</kbd>
                                                        <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">Alt</kbd>
                                                        <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">5</kbd>
                                                    </div>
                                                </button>
                                            </li>
                                            <li>
                                                <button id="heading6" data-heading-level="6" type="button" class="flex justify-between items-center w-full text-base rounded-sm px-3 py-2 hover:bg-gray-100 text-gray-900 dark:hover:bg-gray-600 dark:text-white">Heading 6
                                                    <div class="space-x-1.5">
                                                        <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">Cmd</kbd>
                                                        <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">Alt</kbd>
                                                        <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">6</kbd>
                                                    </div>
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- File Manager Button (folder) -->
                                    <button id="lfmImageButton"
                                            type="button"
                                            data-tooltip-target="tooltip-lfm"
                                            class="p-1.5 rounded-sm text-gray-500 hover:text-gray-900 hover:bg-gray-100
                                                dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600
                                                  inline-flex items-center">
                                        <i class="bx bx-image-add text-xl leading-none"></i>
                                        <span class="sr-only">Add image</span>
                                    </button>
                                    <div id="tooltip-lfm" role="tooltip"
                                         class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white
                                                bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                        Add image
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                    <button id="addImageButton" type="button" data-tooltip-target="tooltip-image" class="p-1.5 text-gray-500 rounded-sm cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M13 10a1 1 0 0 1 1-1h.01a1 1 0 1 1 0 2H14a1 1 0 0 1-1-1Z" clip-rule="evenodd"/>
                                            <path fill-rule="evenodd" d="M2 6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12c0 .556-.227 1.06-.593 1.422A.999.999 0 0 1 20.5 20H4a2.002 2.002 0 0 1-2-2V6Zm6.892 12 3.833-5.356-3.99-4.322a1 1 0 0 0-1.549.097L4 12.879V6h16v9.95l-3.257-3.619a1 1 0 0 0-1.557.088L11.2 18H8.892Z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="sr-only">Embed image</span>
                                    </button>
                                    <div id="tooltip-image" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                        Embed image
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                    <button id="addVideoButton" type="button" data-tooltip-target="tooltip-video" class="p-1.5 text-gray-500 rounded-sm cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M9 7V2.221a2 2 0 0 0-.5.365L4.586 6.5a2 2 0 0 0-.365.5H9Zm2 0V2h7a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9h5a2 2 0 0 0 2-2Zm-2 4a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2H9Zm0 2h2v2H9v-2Zm7.965-.557a1 1 0 0 0-1.692-.72l-1.268 1.218a1 1 0 0 0-.308.721v.733a1 1 0 0 0 .37.776l1.267 1.032a1 1 0 0 0 1.631-.776v-2.984Z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="sr-only">Embed video</span>
                                    </button>
                                    <div id="tooltip-video" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                        Embed video
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                    <button id="toggleListButton" type="button" data-tooltip-target="tooltip-list" class="p-1.5 text-gray-500 rounded-sm cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M9 8h10M9 12h10M9 16h10M4.99 8H5m-.02 4h.01m0 4H5"/>
                                        </svg>
                                        <span class="sr-only">Toggle list</span>
                                    </button>
                                    <div id="tooltip-list" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                        Toggle list
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                    <button id="toggleOrderedListButton" type="button" data-tooltip-target="tooltip-ordered-list" class="p-1.5 text-gray-500 rounded-sm cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6h8m-8 6h8m-8 6h8M4 16a2 2 0 1 1 3.321 1.5L4 20h5M4 5l2-1v6m-2 0h4"/>
                                        </svg>
                                        <span class="sr-only">Toggle ordered list</span>
                                    </button>
                                    <div id="tooltip-ordered-list" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                        Toggle ordered list
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                    <button id="toggleBlockquoteButton" type="button" data-tooltip-target="tooltip-blockquote-list" class="p-1.5 text-gray-500 rounded-sm cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M6 6a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h3a3 3 0 0 1-3 3H5a1 1 0 1 0 0 2h1a5 5 0 0 0 5-5V8a2 2 0 0 0-2-2H6Zm9 0a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h3a3 3 0 0 1-3 3h-1a1 1 0 1 0 0 2h1a5 5 0 0 0 5-5V8a2 2 0 0 0-2-2h-3Z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="sr-only">Toggle blockquote</span>
                                    </button>
                                    <div id="tooltip-blockquote-list" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                        Toggle blockquote
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                    <button id="toggleHRButton" type="button" data-tooltip-target="tooltip-hr-list" class="p-1.5 text-gray-500 rounded-sm cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 12h14"/>
                                            <path stroke="currentColor" stroke-linecap="round" d="M6 9.5h12m-12 9h12M6 7.5h12m-12 9h12M6 5.5h12m-12 9h12"/>
                                        </svg>
                                        <span class="sr-only">Toggle Horizontal Rule</span>
                                    </button>
                                    <div id="tooltip-hr-list" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                        Toggle Horizontal Rule
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 py-2 bg-white rounded-b-lg dark:bg-gray-800">
                                <label for="wysiwyg-example" class="sr-only">Publish post</label>
                                <div id="wysiwyg-example"class="block w-full px-0 text-sm text-gray-800 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400"></div>
                            </div>
                            <textarea id="hidden-textarea" name="body" class="hidden">{{ old('body') ?? '' }}</textarea>
                        </div>

                        <!-- Post Category -->
                        <div class="mt-4">
                            <label for="post_category_id"
                                   class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Category <span class="text-error-500">*</span>
                            </label>
                            <div x-data="{ hasError: {{ $errors->has('post_category_id') ? 'true' : 'false' }} }">
                                <select
                                    id="post_category_id"
                                    name="post_category_id"
                                    :class="hasError
                                            ? 'border-red-500 dark:border-red-500 focus:ring-2 focus:ring-red-500 dark:focus:ring-red-500'
                                            : 'border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-500'"
                                    class="h-11 w-full text-sm mt-1 px-4 py-2.5"
                                    required>
                                    <option value="">Select a category</option>
                                    @foreach ($postCategories as $category)
                                        <option value="{{ $category->id }}" {{ old('post_category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('post_category_id')
                                    <span class="text-xs mt-1 font-medium text-red-500 dark:text-red-500" x-show="hasError">
                                        * {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="mt-4">
                            <label for="status"
                                   class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Status <span class="text-error-500">*</span>
                            </label>
                            <div x-data="{ hasError: {{ $errors->has('status') ? 'true' : 'false' }} }">
                                <select
                                    id="status"
                                    name="status"
                                    :class="hasError
                                            ? 'border-red-500 dark:border-red-500 focus:ring-2 focus:ring-red-500 dark:focus:ring-red-500'
                                            : 'border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-500'"
                                    class="h-11 w-full text-sm mt-1 px-4 py-2.5"
                                    required>
                                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                                </select>
                                @error('status')
                                    <span class="text-xs mt-1 font-medium text-red-500 dark:text-red-500" x-show="hasError">
                                        * {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end mt-6">
                            <button type="submit"
                                    class="flex items-center gap-2 h-[42px] px-4 py-2.5 rounded-lg border border-blue-500 bg-blue-600 text-white font-medium transition-all hover:bg-blue-700 hover:border-blue-600 focus:ring focus:ring-blue-300 dark:bg-blue-700 dark:border-blue-600 dark:hover:bg-blue-800">
                                Create Post
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <!-- ===== Main Content End ===== -->

    <!-- Backdrop + Modal -->
    <div id="imgOptionsModal"
         class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">
        <!-- Modal box -->
        <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-[400px] mx-auto mt-20">

            <!-- Close Button -->
            <button id="closeImgOptionsBtn"
                    data-modal-hide="imgOptionsModal"
                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-900 dark:hover:text-white">
                <i class="bx bx-x text-2xl"></i>
                <span class="sr-only">Close</span>
            </button>

            <!-- Modal Content -->
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">
                Picture
                <span id="imgOptionsUrl"
                      class="block text-xs font-normal text-gray-500 dark:text-gray-400 break-all mt-1">
                            <!-- Selected image URL will appear here -->
                        </span>
            </h2>

            <form id="imgOptionsForm" class="space-y-4">

                <!-- Width & Height -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">
                            Width
                        </label>
                        <input name="width" type="text" placeholder="px / %"
                               class="w-full rounded-md border-gray-300 dark:border-gray-600
                                           focus:border-blue-500 focus:ring-blue-500 text-sm
                                           dark:bg-gray-700 dark:text-gray-200">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            Set the image width in pixels (e.g., 300) or percentage (e.g., 50%). Leave empty for auto width.
                        </p>
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">
                            Height
                        </label>
                        <input name="height" type="text" placeholder="px / %"
                               class="w-full rounded-md border-gray-300 dark:border-gray-600
                                           focus:border-blue-500 focus:ring-blue-500 text-sm
                                           dark:bg-gray-700 dark:text-gray-200">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            Set the image height in pixels or percentage. Leave empty for auto height.
                        </p>
                    </div>
                </div>

                <!-- Alt Text -->
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Alt text
                    </label>
                    <input name="alt" type="text"
                           class="w-full rounded-md border-gray-300 dark:border-gray-600
                                       focus:border-blue-500 focus:ring-blue-500 text-sm
                                       dark:bg-gray-700 dark:text-gray-200">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Describe the image for accessibility and SEO purposes.
                    </p>
                </div>

                <!-- CSS Class -->
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">
                        CSS class
                    </label>
                    <input name="class" type="text"
                           class="w-full rounded-md border-gray-300 dark:border-gray-600
                                       focus:border-blue-500 focus:ring-blue-500 text-sm
                                       dark:bg-gray-700 dark:text-gray-200">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Add optional custom CSS classes (e.g., <code>rounded-lg</code>, <code>shadow-md</code>).
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-3 mt-4">
                    <button type="button"
                            id="cancelImgOptionsBtn"
                            data-modal-hide="imgOptionsModal"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg
                                        hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                        Cancel
                    </button>

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Insert
                    </button>
                </div>
            </form>
        </div>
    </div>
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
    <script src="https://unpkg.com/flowbite@latest/dist/flowbite.min.js"></script>
    <!-- Inject content into JS -->
    <script>
        window.__postBody = {!! json_encode(old('body', '')) !!};
    </script>
    <script type="module">
        import { Editor } from 'https://esm.sh/@tiptap/core@2.6.6';
        import StarterKit from 'https://esm.sh/@tiptap/starter-kit@2.6.6';
        import Highlight from 'https://esm.sh/@tiptap/extension-highlight@2.6.6';
        import Underline from 'https://esm.sh/@tiptap/extension-underline@2.6.6';
        import Link from 'https://esm.sh/@tiptap/extension-link@2.6.6';
        import TextAlign from 'https://esm.sh/@tiptap/extension-text-align@2.6.6';
        import Image from 'https://esm.sh/@tiptap/extension-image@2.6.6';
        import YouTube from 'https://esm.sh/@tiptap/extension-youtube@2.6.6';
        import TextStyle from 'https://esm.sh/@tiptap/extension-text-style@2.6.6';
        import FontFamily from 'https://esm.sh/@tiptap/extension-font-family@2.6.6';
        import { Color } from 'https://esm.sh/@tiptap/extension-color@2.6.6';

        import Paragraph from 'https://esm.sh/@tiptap/extension-paragraph@2.6.6';
        import BulletList from 'https://esm.sh/@tiptap/extension-bullet-list@2.6.6';
        import OrderedList from 'https://esm.sh/@tiptap/extension-ordered-list@2.6.6';
        import ListItem from 'https://esm.sh/@tiptap/extension-list-item@2.6.6';
        import Blockquote from 'https://esm.sh/@tiptap/extension-blockquote@2.6.6';
        import Code from 'https://esm.sh/@tiptap/extension-code@2.6.6';
        import Bold from 'https://esm.sh/@tiptap/extension-bold@2.6.6';
        import Heading from 'https://esm.sh/@tiptap/extension-heading@2.6.6';

        window.addEventListener('load', function () {
            const editorElement = document.getElementById("wysiwyg-example");
            const textarea = document.getElementById("hidden-textarea");

            if (!editorElement || !textarea) return;

            const ImageWithSize = Image.extend({
                addAttributes() {
                    return {
                        ...this.parent?.(),
                        src: { default: null },
                        alt: {
                            default: '',
                            parseHTML: element => element.getAttribute('alt'),
                            renderHTML: attributes => {
                                if (!attributes.alt) return {};
                                return { alt: attributes.alt };
                            },
                        },
                        style: {
                            default: null,
                            parseHTML: element => element.getAttribute('style'),
                            renderHTML: attributes => {
                                if (!attributes.style) return {};
                                return { style: attributes.style };
                            },
                        },
                        class: {
                            default: 'rounded-lg shadow-sm max-w-full h-auto bg-gray-100 dark:bg-gray-800',
                            parseHTML: element => element.getAttribute('class'),
                            renderHTML: attributes => {
                                if (!attributes.class) return {};
                                return { class: attributes.class };
                            },
                        },
                        width: {
                            default: null,
                            parseHTML: element => element.getAttribute('width'),
                            renderHTML: attributes => {
                                if (!attributes.width) return {};
                                return { width: attributes.width };
                            },
                        },
                        height: {
                            default: null,
                            parseHTML: element => element.getAttribute('height'),
                            renderHTML: attributes => {
                                if (!attributes.height) return {};
                                return { height: attributes.height };
                            },
                        },
                    };
                },
            });

            const FontSizeTextStyle = TextStyle.extend({
                addAttributes() {
                    return {
                        fontSize: {
                            default: null,
                            parseHTML: element => element.style.fontSize,
                            renderHTML: attributes => {
                                if (!attributes.fontSize) return {};
                                return { style: 'font-size: ' + attributes.fontSize };
                            },
                        },
                    };
                },
            });

            // Custom Extensions with Tailwind Classes
            const CustomBold = Bold.extend({
                renderHTML({ HTMLAttributes }) {
                    return ['strong', { ...HTMLAttributes }, 0];
                },
            });

            const CustomParagraph = Paragraph.extend({
                renderHTML({ HTMLAttributes }) {
                    return ['p', {
                        ...HTMLAttributes,
                        class: `${HTMLAttributes.class || ''}
                m-0 mb-4 text-base text-gray-600 dark:text-gray-300`.trim(),
                    }, 0];
                },
            });

            const CustomBulletList = BulletList.extend({
                renderHTML({ HTMLAttributes }) {
                    return ['ul', {
                        ...HTMLAttributes,
                        class: `${HTMLAttributes.class || ''}
                mb-4 text-base text-gray-600 dark:text-gray-300 list-disc pl-6`.trim(),
                    }, 0];
                },
            });

            const CustomOrderedList = OrderedList.extend({
                renderHTML({ HTMLAttributes }) {
                    return ['ol', {
                        ...HTMLAttributes,
                        class: `${HTMLAttributes.class || ''}
                mb-4 text-base text-gray-600 dark:text-gray-300 list-decimal pl-6`.trim(),
                    }, 0];
                },
            });

            const CustomListItem = ListItem.extend({
                renderHTML({ HTMLAttributes }) {
                    return ['li', {
                        ...HTMLAttributes,
                        class: `${HTMLAttributes.class || ''}
                text-base text-gray-600 dark:text-gray-300`.trim(),
                    }, 0];
                },
            });

            const CustomBlockquote = Blockquote.extend({
                renderHTML({ HTMLAttributes }) {
                    return ['blockquote', {
                        ...HTMLAttributes,
                        class: `${HTMLAttributes.class || ''}
                mb-4 border-l-4 border-gray-300 dark:border-gray-600
                pl-4 italic text-base text-gray-600 dark:text-gray-300`.trim(),
                    }, 0];
                },
            });

            const CustomCode = Code.extend({
                renderHTML({ HTMLAttributes }) {
                    return ['code', {
                        ...HTMLAttributes,
                        class: `${HTMLAttributes.class || ''}
                text-sm bg-gray-100 dark:bg-gray-800
                text-red-600 dark:text-red-400
                font-mono px-1.5 py-0.5 rounded`.trim(),
                    }, 0];
                },
            });

            const CustomLink = Link.extend({
                addOptions() {
                    return {
                        ...this.parent?.(),
                        openOnClick: false,
                        autolink: true,
                        defaultProtocol: 'https',
                    };
                },
                renderHTML({ HTMLAttributes }) {
                    return ['a', {
                        ...HTMLAttributes,
                        class: `${HTMLAttributes.class || ''}
                text-blue-600 dark:text-blue-400
                underline hover:text-blue-800 dark:hover:text-blue-300 transition`.trim(),
                    }, 0];
                },
            });

            const CustomHeading = Heading.extend({
                renderHTML({ node, HTMLAttributes }) {
                    const level = this.options.levels.includes(node.attrs.level)
                        ? node.attrs.level
                        : this.options.levels[0];

                    return [
                        'h' + level,
                        {
                            ...HTMLAttributes,
                            class: `${HTMLAttributes.class || ''}
                    font-bold mb-3 text-gray-800 dark:text-gray-100`.trim(),
                        },
                        0,
                    ];
                },
            });

            const editor = new Editor({
                element: editorElement,
                content: window.__postBody || '',
                extensions: [
                    StarterKit.configure({
                        heading: false,
                        paragraph: false,
                        bulletList: false,
                        orderedList: false,
                        listItem: false,
                        textStyle: false,
                        bold: false,
                        marks: { bold: false },
                    }),
                    CustomHeading,
                    CustomBold,
                    CustomParagraph,
                    CustomBulletList,
                    CustomOrderedList,
                    CustomListItem,
                    CustomBlockquote,
                    CustomCode,
                    CustomLink,
                    FontSizeTextStyle,
                    FontFamily,
                    Color,
                    Highlight,
                    Underline,
                    TextAlign.configure({ types: ['heading', 'paragraph'] }),
                    Image,
                    ImageWithSize,
                    YouTube,
                ],
                editorProps: {
                    attributes: {
                        class: 'format lg:format-lg dark:format-invert focus:outline-none format-blue max-w-none text-base text-gray-600 dark:text-gray-300',
                    },
                },
                onUpdate({ editor }) {
                    textarea.value = editor.getHTML();
                    updateActiveButtons();
                },
                onSelectionUpdate({ editor }) {
                    updateActiveButtons();
                },
            });

            function updateActiveButtons() {
                const activeCheck = (id, isActive) => {
                    const el = document.getElementById(id);
                    if (!el) return;
                    el.classList.toggle('bg-blue-100', isActive);
                    el.classList.toggle('text-blue-800', isActive);
                };

                // Inline styles
                activeCheck('toggleBoldButton', editor.isActive('bold'));
                activeCheck('toggleItalicButton', editor.isActive('italic'));
                activeCheck('toggleUnderlineButton', editor.isActive('underline'));
                activeCheck('toggleStrikeButton', editor.isActive('strike'));
                activeCheck('toggleHighlightButton', editor.isActive('highlight'));
                activeCheck('toggleLinkButton', editor.isActive('link'));
                activeCheck('toggleCodeButton', editor.isActive('code'));

                // Alignment
                activeCheck('toggleLeftAlignButton', editor.isActive({ textAlign: 'left' }));
                activeCheck('toggleCenterAlignButton', editor.isActive({ textAlign: 'center' }));
                activeCheck('toggleRightAlignButton', editor.isActive({ textAlign: 'right' }));
                activeCheck('toggleJustifyAlignButton', editor.isActive({ textAlign: 'justify' }));

                // Block elements
                activeCheck('toggleListButton', editor.isActive('bulletList'));
                activeCheck('toggleOrderedListButton', editor.isActive('orderedList'));
                activeCheck('toggleBlockquoteButton', editor.isActive('blockquote'));

                // Heading levels
                for (let level = 1; level <= 6; level++) {
                    activeCheck(`heading${level}`, editor.isActive('heading', { level }));
                }

                // Paragraph
                activeCheck('toggleParagraphButton', editor.isActive('paragraph'));

                // Format status (optional)
                const status = [];
                if (editor.isActive('bold')) status.push('bold');
                if (editor.isActive('italic')) status.push('italic');
                if (editor.isActive('underline')) status.push('underline');
                if (editor.isActive('strike')) status.push('strike');
                if (editor.isActive('highlight')) status.push('highlight');
                if (editor.isActive('link')) status.push('link');
                if (editor.isActive('code')) status.push('code');
                if (editor.isActive('bulletList')) status.push('ul');
                if (editor.isActive('orderedList')) status.push('ol');
                if (editor.isActive('blockquote')) status.push('blockquote');
                for (let level = 1; level <= 6; level++) {
                    if (editor.isActive('heading', { level })) status.push(`h${level}`);
                }
                if (editor.isActive('paragraph')) status.push('paragraph');

                const statusBox = document.getElementById('formatStatus');
                if (statusBox) statusBox.textContent = status.join(' + ') || 'none';
            }

            // Sync content on form submission
            document.querySelector('form')?.addEventListener('submit', () => {
                textarea.value = editor.getHTML();
            });

            // Button handlers (unchanged from your code)
            document.getElementById('toggleBoldButton')?.addEventListener('click', () => editor.chain().focus().toggleBold().run());
            document.getElementById('toggleItalicButton')?.addEventListener('click', () => editor.chain().focus().toggleItalic().run());
            document.getElementById('toggleUnderlineButton')?.addEventListener('click', () => editor.chain().focus().toggleUnderline().run());
            document.getElementById('toggleStrikeButton')?.addEventListener('click', () => editor.chain().focus().toggleStrike().run());
            document.getElementById('toggleHighlightButton')?.addEventListener('click', () => {
                const isHighlighted = editor.isActive('highlight');
                editor.chain().focus().toggleHighlight({ color: isHighlighted ? undefined : '#ffc078' }).run();
            });
            document.getElementById('toggleLinkButton')?.addEventListener('click', () => {
                let url = window.prompt('Enter a URL:', 'https://');

                if (!url) return;

                url = url.trim();

                // Remove duplicate protocols (e.g., "https://https://")
                url = url.replace(/^(https?:\/\/)+/i, '');

                // Default to https://
                url = 'https://' + url;

                try {
                    const parsedUrl = new URL(url);

                    // Allow only http or https protocols
                    if (!['http:', 'https:'].includes(parsedUrl.protocol)) {
                        alert('Only http and https protocols are allowed.');
                        return;
                    }

                    // Require a valid domain with at least one dot
                    if (!parsedUrl.hostname.includes('.')) {
                        alert('URL must include a valid domain, e.g., example.com.');
                        return;
                    }

                    // Disallow any spaces in the URL
                    if (/\s/.test(parsedUrl.href)) {
                        alert('URL must not contain spaces.');
                        return;
                    }

                    // Optional: remove trailing slash for consistency
                    url = parsedUrl.href.replace(/\/$/, '');

                    // Set the link in the editor
                    editor.chain().focus().extendMarkRange('link').setLink({ href: url }).run();
                } catch (e) {
                    alert('Invalid URL format.');
                }
            });
            document.getElementById('removeLinkButton')?.addEventListener('click', () => editor.chain().focus().unsetLink().run());
            document.getElementById('toggleCodeButton')?.addEventListener('click', () => editor.chain().focus().toggleCode().run());

            document.getElementById('toggleLeftAlignButton')?.addEventListener('click', () => editor.chain().focus().setTextAlign('left').run());
            document.getElementById('toggleCenterAlignButton')?.addEventListener('click', () => editor.chain().focus().setTextAlign('center').run());
            document.getElementById('toggleRightAlignButton')?.addEventListener('click', () => editor.chain().focus().setTextAlign('right').run());
            document.getElementById('toggleJustifyAlignButton')?.addEventListener('click', () => editor.chain().focus().setTextAlign('justify').run());
            document.getElementById('toggleListButton')?.addEventListener('click', () => editor.chain().focus().toggleBulletList().run());
            document.getElementById('toggleOrderedListButton')?.addEventListener('click', () => editor.chain().focus().toggleOrderedList().run());
            document.getElementById('toggleBlockquoteButton')?.addEventListener('click', () => editor.chain().focus().toggleBlockquote().run());
            document.getElementById('toggleHRButton')?.addEventListener('click', () => editor.chain().focus().setHorizontalRule().run());

            /* helper buka File-Manager */
            function lfm(callback, type = 'image', prefix = '/admin/laravel-filemanager') {
                const w = 900, h = 600
                const x = (innerWidth - w) / 2
                const y = (innerHeight - h) / 2
                window.open(`${prefix}?type=${type}`, 'FileManager',
                    `scrollbars=yes,width=${w},height=${h},top=${y},left=${x}`)
                window.SetUrl = callback
            }

            /* tombol Open File-Manager */
            document.getElementById('lfmImageButton')?.addEventListener('click', () => {
                lfm((items) => {
                    const { url, width: origW, height: origH } =
                        Array.isArray(items) ? items[0] : items

                    /* Isi default modal */
                    const modalEl   = document.getElementById('imgOptionsModal')
                    modalEl.querySelector('[name="width"]').value  = origW || ''
                    modalEl.querySelector('[name="height"]').value = origH || ''
                    modalEl.querySelector('[name="alt"]').value    = ''
                    modalEl.querySelector('[name="class"]').value  = ''
                    modalEl.dataset.imgUrl = url                  // simpan URL
                    document.getElementById('imgOptionsUrl').textContent = url

                    /* Tampilkan modal (Flowbite) */
                    const modal = FlowbiteInstances.getInstance('Modal', 'imgOptionsModal')
                        ?? new Modal(modalEl)
                    modal.show()
                })
            })

            /* submit modal → insert image */
            document.getElementById('imgOptionsForm')?.addEventListener('submit', (e) => {
                e.preventDefault()
                const modalEl = document.getElementById('imgOptionsModal')
                const url   = modalEl.dataset.imgUrl
                const data  = Object.fromEntries(new FormData(e.target).entries())

                const attrs = { src: url }
                if (data.alt)   attrs.alt   = data.alt
                if (data.class) attrs.class = data.class

                const styleParts = []
                if (data.width)  styleParts.push(`width:${data.width}`)
                if (data.height) styleParts.push(`height:${data.height}`)
                if (styleParts.length) attrs.style = styleParts.join(';') + ';'

                editor.chain().focus().setImage(attrs).run()

                /* tutup modal */
                const modal = FlowbiteInstances.getInstance('Modal', 'imgOptionsModal')
                modal?.hide()
            })

            /** Tutup Modal **/
            document.getElementById('closeImgOptionsBtn')?.addEventListener('click', () => {
                const modal = FlowbiteInstances.getInstance('Modal', 'imgOptionsModal')
                modal?.hide()
            })

            document.getElementById('cancelImgOptionsBtn')?.addEventListener('click', () => {
                const modal = FlowbiteInstances.getInstance('Modal', 'imgOptionsModal')
                modal?.hide()
            })

            document.getElementById('addImageButton')?.addEventListener('click', () => {
                const url = window.prompt('Enter image URL:', 'https://placehold.co/600x400');
                if (url) editor.chain().focus().setImage({ src: url }).run();
            });

            document.getElementById('addVideoButton')?.addEventListener('click', () => {
                const url = window.prompt('Enter YouTube URL:', 'https://www.youtube.com/watch?v=KaLxCiilHns');
                if (url) {
                    editor.commands.setYoutubeVideo({ src: url, width: 640, height: 480 });
                }
            });

            const typographyDropdown = FlowbiteInstances.getInstance('Dropdown', 'typographyDropdown');
            document.getElementById('toggleParagraphButton')?.addEventListener('click', () => {
                editor.chain().focus().setParagraph().run();
                typographyDropdown.hide();
            });

            document.querySelectorAll('[data-heading-level]').forEach((button) => {
                button.addEventListener('click', () => {
                    const level = button.getAttribute('data-heading-level');
                    editor.chain().focus().toggleHeading({ level: parseInt(level) }).run();
                    typographyDropdown.hide();
                });
            });

            const textSizeDropdown = FlowbiteInstances.getInstance('Dropdown', 'textSizeDropdown');
            document.querySelectorAll('[data-text-size]').forEach((button) => {
                button.addEventListener('click', () => {
                    const fontSize = button.getAttribute('data-text-size');
                    editor.chain().focus().setMark('textStyle', { fontSize }).run();
                    textSizeDropdown.hide();
                });
            });

            const colorPicker = document.getElementById('color');
            colorPicker?.addEventListener('input', (e) => {
                editor.chain().focus().setColor(e.target.value).run();
            });

            document.querySelectorAll('[data-hex-color]').forEach((button) => {
                button.addEventListener('click', () => {
                    const selectedColor = button.getAttribute('data-hex-color');
                    editor.chain().focus().setColor(selectedColor).run();
                });
            });

            document.getElementById('reset-color')?.addEventListener('click', () => editor.commands.unsetColor());

            const fontFamilyDropdown = FlowbiteInstances.getInstance('Dropdown', 'fontFamilyDropdown');
            document.querySelectorAll('[data-font-family]').forEach((button) => {
                button.addEventListener('click', () => {
                    const fontFamily = button.getAttribute('data-font-family');
                    editor.chain().focus().setFontFamily(fontFamily).run();
                    fontFamilyDropdown.hide();
                });
            });
        });
    </script>

    <script>
        function imageUploader() {
            return {
                preview: null,
                fileName: '',
                fileSize: 0,
                hasError: false,
                maxSize: 5 * 1024 * 1024, // 5MB
                get prettySize() {
                    if (!this.fileSize) return '';
                    const kb = this.fileSize / 1024;
                    return kb > 1024 ? (kb / 1024).toFixed(2) + ' MB' : Math.round(kb) + ' KB';
                },
                fileChosen(event) {
                    const input = event.target;
                    const f = input.files && input.files[0];
                    if (!f) return;

                    if (!f.type.startsWith('image/')) {
                        alert('File harus berupa gambar.');
                        input.value = '';
                        this.hasError = true;
                        return;
                    }

                    if (f.size > this.maxSize) {
                        alert('Maksimum ukuran file 5 MB');
                        input.value = '';
                        this.hasError = true;
                        return;
                    }

                    this.fileName = f.name;
                    this.fileSize = f.size;
                    this.hasError = false;

                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.preview = e.target.result;
                    };
                    reader.readAsDataURL(f);
                },
                remove() {
                    this.preview = null;
                    this.fileName = '';
                    this.fileSize = 0;
                    this.hasError = false;
                    this.$refs.input.value = '';
                }
            };
        }
    </script>
@endsection
