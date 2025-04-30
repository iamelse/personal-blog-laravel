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
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Manage Role Permissions</h1>
            <p class="text-gray-600 dark:text-gray-400">View and assign permissions for the "{{ $role->name }}" role.</p>
         </div>
      </div>

      <div class="border-gray-100 p-5 dark:border-gray-800 sm:p-6">
         <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <form class="mt-5" action="{{ route('be.role.and.permission.update.permissions', $role->slug) }}" method="POST">
               @csrf
               @method('PUT')

               <div x-data="{
                  selectedPermissions: @json($role->permissions->pluck('id')),
                  groupSelected: {},
                  get allSelected() {
                      return Object.values(this.groupSelected).flat().length > 0 &&
                             Object.values(this.groupSelected).flat().every(id => this.selectedPermissions.includes(id));
                  },
                  set allSelected(value) {
                      if (value) {
                          this.selectedPermissions = Object.values(this.groupSelected).flat();
                      } else {
                          this.selectedPermissions = [];
                      }
                  }
              }"
              x-init="groupSelected = {
                  @foreach($groupedPermissions as $group => $permissions)
                      '{{ $group }}': {{ json_encode($permissions->pluck('id')->toArray()) }},
                  @endforeach
              }"
              class="space-y-6">

                  <!-- Select All Checkbox -->
                  @can(PermissionEnum::UPDATE_ROLE_PERMISSION->value, $role)
                  <div class="flex items-center gap-3 mb-4">
                      <input type="checkbox"
                          x-model="allSelected"
                          class="form-checkbox rounded-md border-gray-400 h-5 w-5 text-blue-600 focus:ring focus:ring-blue-300 dark:border-gray-600 dark:focus:ring-blue-500">
                      <span class="text-md font-semibold text-gray-900 dark:text-gray-200">Select All</span>
                  </div>
                  @endcan

                  @foreach($groupedPermissions as $group => $permissions)
                  <div class="flex flex-col gap-4">
                        @php
                            $groupAliases = [
                                'Social' => 'Social Media',
                                'Quick' => 'Quick Link',
                                'Post' => 'Post Categories'
                            ];
                        @endphp

                        <div class="flex items-center gap-3">
                            <!-- Group Select All Checkbox -->
                            @can(PermissionEnum::UPDATE_ROLE_PERMISSION->value, $role)
                                <input type="checkbox"
                                    :checked="groupSelected['{{ $group }}'].every(id => selectedPermissions.includes(id))"
                                    @click="let allChecked = groupSelected['{{ $group }}'].every(id => selectedPermissions.includes(id));
                                            groupSelected['{{ $group }}'].forEach(id => {
                                                if (allChecked) {
                                                    selectedPermissions = selectedPermissions.filter(p => p !== id);
                                                } else if (!selectedPermissions.includes(id)) {
                                                    selectedPermissions.push(id);
                                                }
                                            })"
                                    class="form-checkbox rounded-md border-gray-400 h-5 w-5 text-blue-600 focus:ring focus:ring-blue-300 dark:focus:ring-blue-500">
                            @endcan
                            <span class="text-md font-semibold text-gray-900 dark:text-gray-200">
                                {{ $groupAliases[$group] ?? ucfirst($group) }}
                            </span>
                        </div>

                        <!-- Permissions List -->
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 ml-7">
                            @foreach($permissions as $permission)
                                <label class="flex items-center space-x-3 cursor-pointer">
                                    @can(PermissionEnum::UPDATE_ROLE_PERMISSION->value, $role)
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                        x-model="selectedPermissions"
                                        class="form-checkbox rounded-md border-gray-400 h-5 w-5 text-blue-600 focus:ring focus:ring-blue-300 dark:border-gray-600 dark:focus:ring-blue-500"
                                        {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                                    @endcan
                                    <span class="text-gray-800 dark:text-gray-300 text-sm">{{ $permission->name }}</span>
                                </label>
                            @endforeach
                        </div>
                  </div>
                  @endforeach

                  @can(PermissionEnum::UPDATE_ROLE_PERMISSION->value, $role)
                      <div class="flex justify-end mt-8">
                          <button type="submit"
                              class="flex items-center gap-2 h-[42px] px-4 py-2.5 rounded-lg border border-blue-500 bg-blue-600 text-white font-medium transition-all hover:bg-blue-700 hover:border-blue-600 focus:ring focus:ring-blue-300 dark:bg-blue-700 dark:border-blue-600 dark:hover:bg-blue-800">
                              Update Permissions
                          </button>
                      </div>
                  @endcan
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
