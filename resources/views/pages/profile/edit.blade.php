@extends('layouts.app')

@section('content')
<!-- ===== Main Content Start ===== -->
<main>
    <div class="py-4 mx-auto w-full md:py-4">
        <!-- Header Section -->
        <div class="flex px-6 flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Edit Profile</h1>
                <p class="text-gray-600 dark:text-gray-400">Modify your profile details.</p>
            </div>
        </div>

        <!-- Form Section -->
        <div class="border-gray-100 p-5 dark:border-gray-800 sm:p-6">
            <div class="rounded-2xl px-6 pb-8 pt-4 border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <form action="{{ route('be.user.profile.update', $user->username) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Image Profile -->
                    <div class="mt-4 flex flex-col items-center"
                        x-data="{
                            imagePreview: '{{ getUserImageProfilePath(Auth::user()) }}',
                            defaultImage: '{{ Avatar::create(Auth::user()->name)->toBase64() }}',
                            removeImage: false
                        }">

                        <div class="flex flex-col items-center gap-3">
                        <!-- Image Preview -->
                        <div class="relative">
                            <img :src="imagePreview"
                                @click="$refs.imageInput.click()"
                                alt="Profile Image"
                                class="w-32 h-32 rounded-full object-cover cursor-pointer transition duration-300 hover:opacity-80">

                            @if ($user->image)
                                <!-- Hidden input to track image removal -->
                                <input type="hidden" name="remove_image" :value="removeImage ? 1 : 0">

                                <!-- Remove Button -->
                                <template x-if="imagePreview !== defaultImage">
                                    <button type="button"
                                        class="absolute top-0 right-0 bg-red-500 text-white text-xs px-2 py-1 rounded-full shadow-lg hover:bg-red-600 transition"
                                        @click="imagePreview = defaultImage; removeImage = true; $refs.imageInput.value = ''">
                                        X
                                    </button>
                                </template>
                            @endif
                        </div>

                        <!-- Hidden File Input -->
                        <input type="file" id="image" name="image" class="hidden"
                            x-ref="imageInput"
                            @change="let file = $event.target.files[0];
                                        if (file) {
                                            let reader = new FileReader();
                                            reader.onload = (e) => imagePreview = e.target.result;
                                            reader.readAsDataURL(file);
                                        }">
                        </div>
                    </div>

                    <!-- Name -->
                    <div class="mt-4">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Name <span class="text-error-500">*</span>
                        </label>
                        <div x-data="{ hasError: {{ session('errors') && session('errors')->has('name') ? 'true' : 'false' }} }">
                            <input
                                type="text"
                                id="name"
                                name="name"
                                placeholder="Enter your name"
                                value="{{ old('name', $user->name) }}"
                                :class="hasError
                                    ? 'border-red-500 dark:border-red-500'
                                    : 'border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-500'"
                                class="h-11 w-full text-sm mt-1 px-4 py-2.5 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 placeholder:text-gray-400 dark:placeholder:text-white/30"
                                >
                            <span class="text-xs mt-1 font-medium text-red-500 dark:text-red-500" x-show="hasError">
                                @error('name') * {{ $message }} @enderror
                            </span>
                        </div>
                    </div>

                    <!-- Userame -->
                    <div class="mt-4">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Username <span class="text-error-500">*</span>
                        </label>
                        <div x-data="{ hasError: {{ session('errors') && session('errors')->has('username') ? 'true' : 'false' }} }">
                            <input
                                type="text"
                                id="username"
                                name="username"
                                placeholder="Enter your username"
                                value="{{ old('username', $user->username) }}"
                                :class="hasError
                                    ? 'border-red-500 dark:border-red-500'
                                    : 'border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-500'"
                                class="h-11 w-full text-sm mt-1 px-4 py-2.5 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 placeholder:text-gray-400 dark:placeholder:text-white/30"
                                >
                            <span class="text-xs mt-1 font-medium text-red-500 dark:text-red-500" x-show="hasError">
                                @error('username') * {{ $message }} @enderror
                            </span>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mt-4">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Email <span class="text-error-500">*</span>
                        </label>
                        <div x-data="{ hasError: {{ session('errors') && session('errors')->has('email') ? 'true' : 'false' }} }">
                            <input
                                type="text"
                                id="email"
                                name="email"
                                placeholder="Enter your email"
                                value="{{ old('email', $user->email) }}"
                                :class="hasError
                                    ? 'border-red-500 dark:border-red-500'
                                    : 'border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-500'"
                                class="h-11 w-full text-sm mt-1 px-4 py-2.5 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 placeholder:text-gray-400 dark:placeholder:text-white/30"
                                >
                            <span class="text-xs mt-1 font-medium text-red-500 dark:text-red-500" x-show="hasError">
                                @error('email') * {{ $message }} @enderror
                            </span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end mt-6">
                        <button type="submit"
                            class="flex items-center gap-2 h-[42px] px-4 py-2.5 rounded-lg border border-blue-500 bg-blue-600 text-white font-medium transition-all hover:bg-blue-700 hover:border-blue-600 focus:ring focus:ring-blue-300 dark:bg-blue-700 dark:border-blue-600 dark:hover:bg-blue-800">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Header Section -->
        <div class="flex px-6 flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Change Password</h1>
                <p class="text-gray-600 dark:text-gray-400">Modify your current password.</p>
            </div>
        </div>

        <!-- Form Section -->
        <div class="border-gray-100 p-5 dark:border-gray-800 sm:p-6">
            <div class="rounded-2xl px-6 pb-8 pt-4 border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <form action="{{ route('be.user.profile.update.password', $user->username) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Old Password -->
                    <div class="mt-4">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Current Password <span class="text-error-500">*</span>
                        </label>
                        <div x-data="{ hasError: {{ session('errors') && session('errors')->has('current_password') ? 'true' : 'false' }} }">
                            <input
                                type="password"
                                id="current_password"
                                name="current_password"
                                placeholder="Enter your current password"
                                :class="hasError
                                    ? 'border-red-500 dark:border-red-500'
                                    : 'border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-500'"
                                class="h-11 w-full text-sm mt-1 px-4 py-2.5 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 placeholder:text-gray-400 dark:placeholder:text-white/30"
                                >
                            <span class="text-xs mt-1 font-medium text-red-500 dark:text-red-500" x-show="hasError">
                                @error('current_password') * {{ $message }} @enderror
                            </span>
                        </div>
                    </div>

                    <!-- New Password -->
                    <div class="mt-4">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            New Password <span class="text-error-500">*</span>
                        </label>
                        <div x-data="{ hasError: {{ session('errors') && session('errors')->has('new_password') ? 'true' : 'false' }} }">
                            <input
                                type="password"
                                id="new_password"
                                name="new_password"
                                placeholder="Enter your new password"
                                :class="hasError
                                    ? 'border-red-500 dark:border-red-500'
                                    : 'border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-500'"
                                class="h-11 w-full text-sm mt-1 px-4 py-2.5 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 placeholder:text-gray-400 dark:placeholder:text-white/30"
                                >
                            <span class="text-xs mt-1 font-medium text-red-500 dark:text-red-500" x-show="hasError">
                                @error('new_password') * {{ $message }} @enderror
                            </span>
                        </div>
                    </div>

                    <!-- New Password Confirmation -->
                    <div class="mt-4">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            New Password Confirmation <span class="text-error-500">*</span>
                        </label>
                        <div x-data="{ hasError: {{ session('errors') && session('errors')->has('new_password_confirmation') ? 'true' : 'false' }} }">
                            <input
                                type="password"
                                id="new_password_confirmation"
                                name="new_password_confirmation"
                                placeholder="Re-enter your new password"
                                :class="hasError
                                    ? 'border-red-500 dark:border-red-500'
                                    : 'border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-500'"
                                class="h-11 w-full text-sm mt-1 px-4 py-2.5 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 placeholder:text-gray-400 dark:placeholder:text-white/30"
                                >
                            <span class="text-xs mt-1 font-medium text-red-500 dark:text-red-500" x-show="hasError">
                                @error('new_password_confirmation') * {{ $message }} @enderror
                            </span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end mt-6">
                        <button type="submit"
                            class="flex items-center gap-2 h-[42px] px-4 py-2.5 rounded-lg border border-blue-500 bg-blue-600 text-white font-medium transition-all hover:bg-blue-700 hover:border-blue-600 focus:ring focus:ring-blue-300 dark:bg-blue-700 dark:border-blue-600 dark:hover:bg-blue-800">
                            Change Password
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
