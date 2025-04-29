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
   <div class="max-w-6xl mx-auto px-6">
      <h1 data-aos="fade-up" class="mt-10 lg:mt-0 text-3xl sm:text-4xl md:text-5xl font-bold leading-tight text-gray-900 dark:text-gray-100">
         My Post
      </h1>
      <p class="mt-5 text-base sm:text-lg text-gray-600 dark:text-gray-300">Discover a curated collection of insightful articles spanning diverse topics, thoughtfully crafted to inform, inspire, and engage readers. Explore now! </p>
      <!-- Alpine.js Setup -->
      <div x-data="{ open: false }">
         <div class="flex flex-wrap items-end justify-end gap-4 mt-7">
            <!-- Filter Button -->
            <button @click="open = true"
               class="w-1/3 md:w-1/6 lg:w-1/6 inline-flex items-center justify-center gap-2 rounded-lg px-6 py-3 text-base font-semibold text-white transition-all duration-200 ease-in-out bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 dark:bg-blue-500 dark:hover:bg-blue-600">
            <i class='bx bx-filter text-lg'></i> Filter
            </button>
         </div>
          <!-- Modal (Initially Hidden) -->
          <div x-show="open" x-transition.opacity x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
              <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md">
                  <!-- Modal Header -->
                  <div class="flex justify-between items-center mb-4">
                      <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Filter Options</h2>
                      <button @click="open = false" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                          <i class='bx bx-x text-2xl'></i>
                      </button>
                  </div>

                  <!-- Filter Form -->
                  <form method="GET" action="{{ route('fe.post.index') }}">
                      <div class="space-y-4">
                          <!-- Search Input -->
                          <div>
                              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Search</label>
                              <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Search..."
                                     class="w-full px-4 py-3 mt-2 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" />
                          </div>

                          <!-- Category Select -->
                          <div>
                              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                              <select name="category" class="w-full px-4 py-3 mt-2 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                  <option value="">All Categories</option>
                                  @foreach($postCategories as $category)
                                      <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                          {{ $category->name }}
                                      </option>
                                  @endforeach
                              </select>
                          </div>
                      </div>

                      <!-- Modal Footer -->
                      <div class="flex justify-end mt-5">
                          <button type="button" @click="open = false"
                                  class="px-4 py-2 text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white">
                              Cancel
                          </button>
                          <button type="submit"
                                  class="ml-3 px-6 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
                              Apply
                          </button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
      <div class="mt-10 flex flex-col lg:flex-row items-center gap-10">
         <!-- Post List -->
         <div class="w-full">
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
               @forelse($posts as $post)
                    <!-- Post Card -->
                    <div class="border border-gray-200 dark:border-gray-700 rounded-3xl p-2.5 bg-white dark:bg-gray-700 flex flex-col"
                         data-aos="zoom-in" data-aos-delay="{{ 200 + ($loop->index * 150) }}">
                    <img src="{{ $post->cover }}" alt="{{ $post->cover }}"
                             class="w-full rounded-2xl aspect-[16/9] object-cover">
                        <div class="flex flex-col flex-grow p-3">
                            <h3 class="text-2xl py-2 font-semibold">
                                <a href="{{ route('fe.post.show', $post->slug) }}" class="text-gray-900 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            <p class="my-2 text-gray-500 dark:text-gray-300 flex-grow">
                                {{ $post->excerpt }}
                            </p>
                            <div class="mt-4">
                                <a href="{{ route('fe.post.show', $post->slug) }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-6 py-3 text-base font-medium text-white shadow-xs duration-200 hover:bg-blue-700 w-full sm:w-auto dark:bg-blue-700 dark:hover:bg-blue-600 dark:text-gray-300">
                                    Read More
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Post Card -->
               @empty
               @endforelse
            </div>
         </div>
      </div>

      <div class="dark:border-gray-800">
           <div class="flex items-end justify-center gap-2 py-4 sm:justify-normal md:justify-end">
                   <!-- Previous Button -->
                   @if ($posts->onFirstPage())
                       <button disabled class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-400 cursor-not-allowed shadow-theme-xs sm:px-3.5 sm:py-2.5 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-600">
                           <span class="hidden sm:inline">Previous</span>
                           <span class="inline sm:hidden">
                        <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20"><path fill-rule="evenodd" clip-rule="evenodd" d="M2.58203 9.99868C2.58174 10.1909 2.6549 10.3833 2.80152 10.53L7.79818 15.5301C8.09097 15.8231 8.56584 15.8233 8.85883 15.5305C9.15183 15.2377 9.152 14.7629 8.85921 14.4699L5.13911 10.7472L16.6665 10.7472C17.0807 10.7472 17.4165 10.4114 17.4165 9.99715C17.4165 9.58294 17.0807 9.24715 16.6665 9.24715L5.14456 9.24715L8.85919 5.53016C9.15199 5.23717 9.15184 4.7623 8.85885 4.4695C8.56587 4.1767 8.09099 4.17685 7.79819 4.46984L2.84069 9.43049C2.68224 9.568 2.58203 9.77087 2.58203 9.99715Z"></path></svg>
                    </span>
                       </button>
                   @else
                       <a href="{{ $posts->previousPageUrl() }}" class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800 shadow-theme-xs sm:px-3.5 sm:py-2.5 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                           <span class="hidden sm:inline">Previous</span>
                           <span class="inline sm:hidden">
                        <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20"><path fill-rule="evenodd" clip-rule="evenodd" d="M2.58203 9.99868C2.58174 10.1909 2.6549 10.3833 2.80152 10.53L7.79818 15.5301C8.09097 15.8231 8.56584 15.8233 8.85883 15.5305C9.15183 15.2377 9.152 14.7629 8.85921 14.4699L5.13911 10.7472L16.6665 10.7472C17.0807 10.7472 17.4165 10.4114 17.4165 9.99715C17.4165 9.58294 17.0807 9.24715 16.6665 9.24715L5.14456 9.24715L8.85919 5.53016C9.15199 5.23717 9.15184 4.7623 8.85885 4.4695C8.56587 4.1767 8.09099 4.17685 7.79819 4.46984L2.84069 9.43049C2.68224 9.568 2.58203 9.77087 2.58203 9.99715Z"></path></svg>
                    </span>
                       </a>
                   @endif

                   <!-- Pagination Links -->
                   <ul class="hidden items-center gap-0.5 sm:flex">
                       @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                           @if ($page == $posts->currentPage())
                               <li>
                                   <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-600 text-sm font-medium text-white">{{ $page }}</span>
                               </li>
                           @elseif ($page >= $posts->currentPage() - 2 && $page <= $posts->currentPage() + 2)
                               <li>
                                   <a href="{{ $url }}" class="flex h-10 w-10 items-center justify-center rounded-lg text-sm font-medium text-gray-700 hover:bg-blue-600 hover:text-white dark:text-gray-400 dark:hover:text-white">{{ $page }}</a>
                               </li>
                           @endif
                       @endforeach
                   </ul>

                   <!-- Page Number for Small Devices -->
                   <span class="block text-sm self-center font-medium text-gray-700 dark:text-gray-400 sm:hidden">
                       Page {{ $posts->currentPage() }} of {{ $posts->lastPage() }}
                   </span>

                   <!-- Next Button -->
                   @if ($posts->hasMorePages())
                       <a href="{{ $posts->nextPageUrl() }}" class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800 shadow-theme-xs sm:px-3.5 sm:py-2.5 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                           <span class="hidden sm:inline">Next</span>
                           <span class="inline sm:hidden">
                        <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20"><path fill-rule="evenodd" clip-rule="evenodd" d="M17.4165 9.9986C17.4168 10.1909 17.3437 10.3832 17.197 10.53L12.2004 15.5301C11.9076 15.8231 11.4327 15.8233 11.1397 15.5305C10.8467 15.2377 10.8465 14.7629 11.1393 14.4699L14.8594 10.7472L3.33203 10.7472C2.91782 10.7472 2.58203 10.4114 2.58203 9.99715C2.58203 9.58294 2.91782 9.24715 3.33203 9.24715L14.854 9.24715L11.1393 5.53016C10.8465 5.23717 10.8467 4.7623 11.1397 4.4695C11.4327 4.1767 11.9075 4.17685 12.2003 4.46984L17.1578 9.43049C17.3163 9.568 17.4165 9.77087 17.4165 9.99715Z"></path></svg>
                    </span>
                       </a>
                   @else
                       <button disabled class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-400 cursor-not-allowed shadow-theme-xs sm:px-3.5 sm:py-2.5 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-600">
                           <span class="hidden sm:inline">Next</span>
                           <span class="inline sm:hidden">
                        <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20"><path fill-rule="evenodd" clip-rule="evenodd" d="M17.4165 9.9986C17.4168 10.1909 17.3437 10.3832 17.197 10.53L12.2004 15.5301C11.9076 15.8231 11.4327 15.8233 11.1397 15.5305C10.8467 15.2377 10.8465 14.7629 11.1393 14.4699L14.8594 10.7472L3.33203 10.7472C2.91782 10.7472 2.58203 10.4114 2.58203 9.99715C2.58203 9.58294 2.91782 9.24715 3.33203 9.24715L14.854 9.24715L11.1393 5.53016C10.8465 5.23717 10.8467 4.7623 11.1397 4.4695C11.4327 4.1767 11.9075 4.17685 12.2003 4.46984L17.1578 9.43049C17.3163 9.568 17.4165 9.77087 17.4165 9.99715Z"></path></svg>
                    </span>
                       </button>
                   @endif
               </div>
           </div>
      </div>
</section>
@endsection
