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
        <!-- Light mode logo -->
        <div class="flex items-center space-x-2 dark:hidden">
          <img
              class="h-10 w-auto rounded"
              src="{{ asset('logo/iamelse-logo-1.png') }}"
              alt="Logo"
          />
          <span class="ps-1 text-3xl font-bold text-gray-900 dark:text-white">
            Iamelse
          </span>
        </div>

        <!-- Dark mode logo -->
        <div class="flex items-center space-x-2 hidden dark:flex">
          <img
              class="h-10 w-auto rounded"
              src="{{ asset('logo/iamelse-logo-1.png') }}"
              alt="Logo"
          />
          <span class="ps-1 text-3xl font-bold text-gray-900 dark:text-white">
            Iamelse
          </span>
        </div>
      </span>

      <!-- Logo icon when sidebar is toggled -->
      <img
          class="logo-icon hidden lg:block rounded h-10 w-10"
          :class="{ 'lg:block': sidebarToggle, 'lg:hidden': !sidebarToggle }"
          src="{{ asset('logo/iamelse-logo-1.png') }}"
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
                    'title' => 'Content Management',
                    'order' => 2,
                    'children' => [
                        [
                            'order' => 1,
                            'active' => [
                                'be.post.index',
                                'be.post.create',
                                'be.post.edit'
                            ],
                            'exact' => true,
                            'route' => 'be.post.index',
                            'icon' => 'bx-news',
                            'label' => 'Posts',
                            'permission' => PermissionEnum::READ_POST
                        ],
                        [
                            'order' => 2,
                            'active' => 'be.post-category',
                            'route' => 'be.post-category.index',
                            'icon' => 'bx-category',
                            'label' => 'Categories',
                            'permission' => PermissionEnum::READ_POST_CATEGORY
                        ],
                    ]
                ],
                [
                    'title' => 'Homepage Builder',
                    'order' => 3,
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
                            'order' => 4,
                            'active' => 'be.home.footer',
                            'route' => 'be.home.footer.index',
                            'icon' => 'bx-dock-bottom',
                            'label' => 'Footer',
                            'permission' => PermissionEnum::UPDATE_HOME_FOOTER
                        ],
                    ]
                ],
                [
                    'title' => 'About',
                    'order' => 4,
                    'children' => [
                        [
                            'order' => 1,
                            'active' => 'be.about',
                            'route' => 'be.about.index',
                            'icon' => 'bx-bulb',
                            'label' => 'About',
                            'permission' => PermissionEnum::UPDATE_ABOUT
                        ],
                    ]
                ],
                [
                    'title' => 'Resume',
                    'order' => 5,
                    'children' => [
                        [
                            'order' => 1,
                            'active' => 'be.resume',
                            'route' => 'be.resume.index',
                            'icon' => 'bx-file',
                            'label' => 'Resume',
                            'permission' => PermissionEnum::UPDATE_RESUME
                        ],
                    ]
                ],
                [
                    'title' => 'Master Data',
                    'order' => 6,
                    'children' => [
                        [
                            'order' => 1,
                            'active' => 'be.social-media',
                            'route' => 'be.social-media.index',
                            'icon' => 'bx-group',
                            'label' => 'Social Media',
                            'permission' => PermissionEnum::READ_SOCIAL_MEDIA
                        ],
                        [
                            'order' => 2,
                            'active' => 'be.skill',
                            'route' => 'be.skill.index',
                            'icon' => 'bx-code-alt',
                            'label' => 'Skill',
                            'permission' => PermissionEnum::READ_SKILL
                        ],
                        [
                            'order' => 3,
                            'active' => [
                                'be.quick-link.index',
                                'be.quick-link.create',
                                'be.quick-link.edit'
                            ],
                            'exact' => true,
                            'route' => 'be.quick-link.index',
                            'icon' => 'bx bx-link',
                            'label' => 'Quick Link',
                            'permission' => PermissionEnum::READ_QUICK_LINK
                        ],
                    ]
                ],
                [
                    'title' => 'Settings',
                    'order' => 99,
                    'children' => [
                        [
                            'order' => 1,
                            'active' => 'be.role.and.permission',
                            'route' => 'be.role.and.permission.index',
                            'icon' => 'bx-lock-open',
                            'label' => 'Role & Permissions',
                            'permission' => PermissionEnum::READ_ROLE
                        ],
                        [
                            'order' => 2,
                            'active' => [
                                'be.user.index',
                                'be.user.create',
                                'be.user.edit'
                            ],
                            'exact' => true,
                            'route' => 'be.user.index',
                            'icon' => 'bx bx-user',
                            'label' => 'Users',
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

         <div class="mt-5 lg:mt-0">
            @foreach ($filteredMenus as $menu)
               <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
                  {{ $menu['title'] }}
               </h3>
               <ul class="flex flex-col gap-4 mb-6">
                  @foreach ($menu['children'] as $child)
                     @php
                           $isActive = is_array($child['active'])
                              ? collect($child['active'])->some(fn($route) => request()->routeIs($route . ($child['exact'] ?? false ? '' : '*')))
                              : request()->routeIs($child['active'] . ($child['exact'] ?? false ? '' : '*'));
                     @endphp
                     <li>
                        <a href="{{ route($child['route']) }}"
                           class="menu-item group {{ $isActive ? 'menu-item-active' : 'menu-item-inactive' }}">
                           <i class="bx bx-sm {{ $child['icon'] }}"></i>
                           {{ $child['label'] }}
                        </a>
                     </li>
                  @endforeach
               </ul>
            @endforeach
         </div>
      </div>
      <!-- Menu Group -->
   </nav>
   <!-- Sidebar Menu -->
</div>
</aside>
<!-- ===== Sidebar End ===== -->
