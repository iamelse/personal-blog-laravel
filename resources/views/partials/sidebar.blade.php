<!-- ===== Sidebar Start ===== -->
<aside
:class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
class="sidebar fixed left-0 top-0 z-40 flex h-screen w-[290px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 dark:border-gray-800 dark:bg-black lg:static lg:translate-x-0"
>
<!-- SIDEBAR HEADER -->
<div
   :class="sidebarToggle ? 'justify-center' : 'justify-between'"
   class="flex items-center gap-2 pt-8 sidebar-header pb-7"
   >
   <a href="{{ route('be.dashboard.index') }}">
   <span class="logo" :class="sidebarToggle ? 'hidden' : ''">
   <img class="dark:hidden" src="{{ asset('tailadmin/images/logo/logo.svg') }}" alt="Logo" />
   <img
      class="hidden dark:block"
      src="{{ asset('tailadmin/images/logo/logo-dark.svg') }}"
      alt="Logo"
      />
   </span>
   <img
      class="logo-icon"
      :class="sidebarToggle ? 'lg:block' : 'hidden'"
      src="{{ asset('tailadmin/images/logo/logo-icon.svg') }}"
      alt="Logo"
      />
   </a>
</div>
<!-- SIDEBAR HEADER -->
<div
   class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar"
   >
   <!-- Sidebar Menu -->
   <nav>
      <!-- Menu Group -->
      <div>
         @php
            use App\Enums\PermissionEnum;

            $menus = collect([
               [
                  'title' => 'Main',
                  'order' => 1,
                  'children' => [
                     [
                        'order' => 1, 
                        'active' => 'be.dashboard', 
                        'route' => 'be.dashboard.index', 
                        'icon' => 'bx-line-chart', 
                        'label' => 'Dashboard', 
                        'permission' => PermissionEnum::READ_DASHBOARD
                     ],
                  ]
               ],
               [
                  'title' => 'Home',
                  'order' => 2,
                  'children' => [
                     [
                        'order' => 1, 
                        'active' => 'be.home.hero', 
                        'route' => 'be.home.hero.index', 
                        'icon' => 'bx bx-image', 
                        'label' => 'Hero', 
                        'permission' => PermissionEnum::UPDATE_HOME_HERO
                     ],
                     [
                        'order' => 2, 
                        'active' => 'be.home.about', 
                        'route' => 'be.home.about.index', 
                        'icon' => 'bx-id-card', 
                        'label' => 'About Me', 
                        'permission' => PermissionEnum::UPDATE_HOME_ABOUT
                     ],
                     [
                        'order' => 3, 
                        'active' => 'be.home.cta', 
                        'route' => 'be.home.cta.index', 
                        'icon' => 'bx-rocket', 
                        'label' => 'Call To Action', 
                        'permission' => PermissionEnum::UPDATE_HOME_CTA
                     ],
                     [
                        'order' => 3, 'active' => 'be.home.footer', 
                        'route' => 'be.home.footer.index', 
                        'icon' => 'bx-dock-bottom', 
                        'label' => 'Footer', 
                        'permission' => PermissionEnum::UPDATE_HOME_FOOTER
                     ],
                     
                  ]
               ],
               [
                  'title' => 'Management',
                  'order' => 3,
                  'children' => [
                     [
                        'order' => 1, 
                        'active' => 'be.skill', 
                        'route' => 'be.skill.index', 
                        'icon' => 'bx-code-alt', 
                        'label' => 'Skill', 
                        'permission' => PermissionEnum::READ_SKILL
                     ],
                     [
                        'order' => 2, 
                        'active' => 'be.role.and.permission', 
                        'route' => 'be.role.and.permission.index', 
                        'icon' => 'bx-lock-open', 
                        'label' => 'Role and Permission', 
                        'permission' => PermissionEnum::READ_ROLE
                     ],
                     [
                        'order' => 3, 
                        'active' => 'be.user', 'route' => 
                        'be.user.index', 
                        'icon' => 'bx bx-user', 
                        'label' => 'User', 
                        'permission' => PermissionEnum::READ_USER
                     ],
                  ]
               ]
            ]);

            $userPermissions = Auth::user()->permissions;

            // Filter and sort menus based on user permissions
            $filteredMenus = $menus->map(function ($menu) use ($userPermissions) {
               $menu['children'] = collect($menu['children'])
                  ->filter(fn($child) => Auth::user()->can($child['permission'], $userPermissions))
                  ->sortBy('order'); // Sort children
               return $menu;
            })->filter(fn($menu) => $menu['children']->isNotEmpty()) // Remove empty parents
            ->sortBy('order'); // Sort parents
         @endphp

         <div>
            @foreach ($filteredMenus as $menu)
               <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
                  {{ $menu['title'] }}
               </h3>
               <ul class="flex flex-col gap-4 mb-6">
                  @foreach ($menu['children'] as $child)
                     <li>
                        <a href="{{ route($child['route']) }}" 
                           class="menu-item group {{ request()->routeIs($child['active'] . '*') ? 'menu-item-active' : 'menu-item-inactive' }}">
                           <i class="bx bx-sm {{ $child['icon'] }}"></i>
                           {{ $child['label'] }}
                        </a>
                     </li>
                  @endforeach
               </ul>
            @endforeach
         </div>
      </div>
   </nav>
   <!-- Sidebar Menu -->
</div>
</aside>
<!-- ===== Sidebar End ===== -->