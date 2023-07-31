<aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height=100%">
    <a href="" class="brand-link" style="background-color:#374f65">
        <img src="{{ asset('img/AdminLTELogo.png') }}" alt="Nectar Digit " class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">{{ @$sitesetting->name ?? env('APP_NAME') }}</span>
    </a>


    <div class="sidebar">
        <div class="user-panel mt-3 pb-0 mb-3 d-flex">
            <div class="image">
                <a href="" class="">
                    <img src="{{ asset('img/AdminLTELogo.png') }}" class="img-circle elevation-2" alt="User Image">
                </a>
            </div>

            <div class="info">
                <a href="{{ route('dashboard.index') }}" class="d-block">{{ @\Auth::user()->name['en'] }}<br>
                    <small>{{ request()->user()->roles->first()->name }}</small></a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-child-indent" data-widget="treeview"
                role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}"
                        class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            {{ request()->user()->roles->first()->name }} Dashboard
                        </p>
                    </a>
                </li>



                <li class="nav-header">WEB CONTENT</li>
                <li class="nav-item">
                    <a href="{{ route('index') }}" target="_blank" class="nav-link">
                        <i class="nav-icon fas fa-globe-asia"></i>
                        <p>Website</p>
                    </a>
                </li>
                <li
                    class="nav-item has-treeview {{ request()->is('admin/tag*') || request()->is('admin/blog*') || request()->is('admin/benefit*') || request()->is('admin/container*') || request()->is('admin/slider*') || request()->is('admin/clients*') || request()->is('admin/information*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->is('admin/tag*') || request()->is('admin/blog*') || request()->is('admin/benefit*') || request()->is('admin/container*') || request()->is('admin/slider*') || request()->is('admin/clients*') || request()->is('admin/information*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-globe"></i>
                        <p>
                            CMS Content
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if (in_array('slider', $app_content))
                            @canany(['slider-list', 'slider-create', 'slider-edit', 'slider-delete'])
                                <li class="nav-item">
                                    <a href="{{ route('slider.index') }}"
                                        class="nav-link {{ request()->is('admin/slider*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-sliders-h"></i>
                                        <p>Slider</p>
                                    </a>
                                </li>
                            @endcanany
                        @endif

                        @canany(['clients-list', 'clients-create', 'clients-edit', 'clients-delete'])
                            <li class="nav-item">
                                <a href="{{ route('clients.index') }}"
                                    class="nav-link {{ request()->is('admin/clients*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>Clients</p>
                                </a>
                            </li>
                        @endcanany
                        @if (in_array('information', $app_content))
                            @canany(['information-list', 'information-create', 'information-edit',
                                'information-delete'])
                                <li class="nav-item">
                                    <a href="{{ route('information.index') }}"
                                        class="nav-link {{ request()->is('admin/information*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-tools"></i>
                                        <p>Service</p>
                                    </a>
                                </li>
                            @endcanany
                        @endif

                        @canany(['container-list', 'container-create', 'container-edit', 'container-delete'])
                            <li class="nav-item">
                                <a href="{{ route('container.index') }}"
                                    class="nav-link {{ request()->is('admin/container*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-folder-plus"></i>
                                    <p>Container</p>
                                </a>
                            </li>
                        @endcanany
                        @if (in_array('blogs', $app_content))
                            @canany(['blog-list', 'blog-create', 'blog-edit', 'blog-delete'])
                                <li class="nav-item">
                                    <a href="{{ route('blog.index') }}"
                                        class="nav-link {{ request()->is('admin/blog*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-rss"></i>
                                        <p>Blogs</p>
                                    </a>
                                </li>
                            @endcanany
                        @endif
                        @canany(['tag-list', 'tag-create', 'tag-edit', 'tag-delete'])
                            <li class="nav-item">
                                <a href="{{ route('tag.index') }}"
                                    class="nav-link {{ request()->is('admin/tag*') ? 'active' : '' }}">
                                    <i class="fas fa-tag nav-icon"></i>
                                    <p>Blog Tag</p>
                                </a>
                            </li>
                        @endcanany
                        @canany(['category-list', 'category-create', 'category-edit', 'category-delete'])

                            <li class="nav-item">
                                <a href="{{ route('category.index') }}"
                                    class="nav-link {{ request()->is('admin/category*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-database"></i>
                                    <p>Blog Category</p>
                                </a>
                            </li>
                        @endcanany

                        @canany(['counter-list', 'counter-create', 'counter-edit', 'counter-delete'])
                            <li class="nav-item">
                                <a href="{{ route('counter.index') }}"
                                    class="nav-link {{ request()->is('admin/counter*') ? 'active' : '' }}">
                                    <i class="nav-icon fa fa-clock"></i>
                                    <p>Counter</p>
                                </a>
                            </li>
                        @endcanany

                        @can(['text-update'])
                            <li class="nav-item">
                                <a href="{{ route('text.index') }}"
                                    class="nav-link {{ request()->is('admin/text*') ? 'active' : '' }}">
                                    <i class="nav-icon fa fa-clock"></i>
                                    <p>Static texts</p>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>

                {{-- @if (in_array('fetchtable', $app_content))
                    @canany(['fetchTable-list', 'fetchTable-create', 'fetchTable-edit', 'fetchTable-delete'])
                        <li class="nav-item">
                            <a href="{{ route('fetchtable.index') }}"
                                class="nav-link {{ request()->is('admin/fetchtable*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-table"></i>
                                <p>Fetch Table</p>
                            </a>
                        </li>
                    @endcanany
                @endif --}}
                {{-- @hasanyrole('Super Admin')

                <li class="nav-item">
                    <a href=" {{ route('adminGetTables') }}"
                        class="nav-link {{ request()->is('admin/fetchtables/assign-table*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-table"></i>
                        <p>Migrate Data</p>
                    </a>
                </li>
                @endhasallroles --}}


                {{-- @if (in_array('environment', $app_content))
                    @hasanyrole('Super Admin')
                    @canany(['env-list'])
                        <li class="nav-item">
                            <a href="{{ route('env.index') }}"
                                class="nav-link {{ request()->is('admin/env*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-clone"></i>
                                <p>.env file</p>
                            </a>
                        </li>
                    @endcanany
                    @endhasallroles
                @endif --}}
                {{-- @if (in_array('migrateOldDatabase', $app_content))
                    @hasanyrole('Super Admin')
                    @canany(['migrateOldDb-list', 'migrateOldDb-create', 'migrateOldDb-edit', 'migrateOldDb-delete'])
                        <li class="nav-item">
                            <a href="{{ route('migration.index') }}"
                                class="nav-link {{ request()->is('admin/migration*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-clone"></i>
                                <p>Migrate Old Database</p>
                            </a>
                        </li>
                    @endcanany
                    @endhasallroles
                @endif --}}

                {{-- @if (in_array('advertisement', $app_content))
                    @canany(['advertisementposition-list', 'advertisementposition-create', 'advertisementposition-edit', 'advertisementposition-delete', 'advertisement-list', 'advertisement-create', 'advertisement-edit', 'advertisement-delete'])
                        <li class="nav-item has-treeview {{ request()->is('admin/advertisement*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->is('admin/advertisement*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-ad"></i>
                                <p>
                                    Ad Management
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @canany(['advertisementposition-list', 'advertisementposition-create', 'advertisementposition-edit', 'advertisementposition-delete'])
                                    <li class="nav-item">
                                        <a href="{{ route('advertisementposition.index') }}"
                                            class="nav-link {{ request()->is('admin/advertisementposition*') ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-ad"></i>
                                            <p>Advertisement Position</p>
                                        </a>
                                    </li>
                                @endcanany
                                @canany(['advertisement-list', 'advertisement-create', 'advertisement-edit', 'advertisement-delete'])
                                    <li class="nav-item">
                                        <a href="{{ route('advertisement.index') }}"
                                            class="nav-link {{ request()->is('admin/advertisement') ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-ad"></i>
                                            <p>Advertisement List</p>
                                        </a>
                                    </li>
                                @endcanany
                            </ul>
                        </li>
                    @endcanany
                @endif --}}
                @if (in_array('team', $app_content))
                    @canany(['team-list', 'team-create', 'team-edit', 'team-delete'])

                        <li
                            class="nav-item has-treeview {{ request()->is('admin/designation*') || request()->is('admin/team*') ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ request()->is('admin/designation*') || request()->is('admin/team*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-friends"></i>
                                <p>
                                    Team Management
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            @canany(['designation-list', 'designation-create', 'designation-edit', 'designation-delete'])
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('designations.index') }}"
                                            class="nav-link {{ request()->is('admin/designation*') ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-user-friends"></i>
                                            <p>Team Designation</p>
                                        </a>
                                    </li>
                                @endcanany
                                @canany(['designation-list', 'designation-create', 'designation-edit',
                                    'designation-delete'])
                                    <li class="nav-item">
                                        <a href="{{ route('team.index') }}"
                                            class="nav-link {{ request()->is('admin/team*') ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-user-friends"></i>
                                            <p>Team List</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcanany
                    @endcanany
                @endif



                @canany(['gallery-list', 'gallery-create', 'gallery-edit', 'gallery-delete'])

                    <li
                        class="nav-item has-treeview {{ request()->is('admin/gallery*') || request()->is('admin/gallerycategory*') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ request()->is('admin/gallery*') || request()->is('admin/team*') ? 'active' : '' }}">
                            <i class="nav-icon far fa-images"></i>
                            <p>
                                Gallery
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            {{-- @canany(['gallerycategory-list', 'gallerycategory-create', 'gallerycategory-edit', 'gallerycategory-delete'])

                                <li class="nav-item">
                                    <a href="{{ route('gallerycategory.index') }}"
                                        class="nav-link {{ request()->is('admin/gallerycategory*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-user-friends"></i>
                                        <p>Gallery Category</p>
                                    </a>
                                </li>
                            @endcanany --}}
                            @canany(['gallery-list', 'gallery-create', 'gallery-edit', 'gallery-delete'])

                                <li class="nav-item">
                                    <a href="{{ route('gallery.index') }}"
                                        class="nav-link {{ request()->is('admin/gallery/*') || request()->is('admin/gallery') ? 'active' : '' }}">
                                        <i class="nav-icon far fa-images"></i>

                                        <p>Add Gallery</p>
                                    </a>
                                </li>
                            @endcanany


                        </ul>
                    </li>
                @endcanany


                {{-- @if (in_array('features', $app_content))
                    @canany(['feature-list', 'feature-create', 'feature-edit', 'feature-delete'])
                        <li class="nav-item">
                            <a href="{{ route('feature.index') }}"
                                class="nav-link {{ request()->is('admin/feature*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-star"></i>
                                <p>Features</p>
                            </a>
                        </li>
                    @endcanany
                @endif --}}
                @if (in_array('testimonial', $app_content))
                    @canany(['testimonial-list', 'testimonial-create', 'testimonial-edit', 'testimonial-delete'])
                        <li class="nav-item">
                            <a href="{{ route('testimonial.index') }}"
                                class="nav-link {{ request()->is('admin/testimonial*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Testimonials</p>
                            </a>
                        </li>
                    @endcanany
                @endif

                @canany(['notice-list', 'notice-create', 'notice-edit', 'notice-delete'])
                    <li class="nav-item">
                        <a href="{{ route('notice.index') }}"
                            class="nav-link {{ request()->is('admin/notice*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-sticky-note"></i>
                            <p>Notices</p>
                        </a>
                    </li>
                @endcanany

                @if (in_array('video', $app_content))
                    @canany(['video-list', 'video-create', 'video-edit', 'video-delete'])
                        <li class="nav-item">
                            <a href="{{ route('video.index') }}"
                                class="nav-link {{ request()->is('admin/video*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-video"></i>
                                <p>videos</p>
                            </a>
                        </li>
                    @endcanany
                @endif


                @if (in_array('faq', $app_content))
                    @canany(['faq-list', 'faq-create', 'faq-edit', 'faq-delete'])
                        <li class="nav-item">
                            <a href="{{ route('faq.index') }}"
                                class="nav-link {{ request()->is('admin/faq*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-comments"></i>
                                <p>Faq</p>
                            </a>
                        </li>
                    @endcanany
                @endif
                @if (in_array('career', $app_content))
                    @canany(['career-list', 'career-create', 'career-edit', 'career-delete'])
                        <li class="nav-item">
                            <a href="{{ route('career.index') }}"
                                class="nav-link {{ request()->is('admin/career*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-secret"></i>
                                <p>career</p>
                            </a>
                        </li>
                    @endcanany
                @endif

                @if (in_array('application', $app_content))
                    @canany(['application-list', 'application-create', 'application-edit', 'application-delete'])
                        <li class="nav-item">
                            <a href="{{ route('application.index') }}"
                                class="nav-link {{ request()->is('admin/application*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-envelope"></i>
                                <p>Vacancy Application</p>
                            </a>
                        </li>
                    @endcanany
                @endif
                @if (in_array('subscriber', $app_content))
                    @canany(['subscriber-list', 'subscriber-create', 'subscriber-edit', 'subscriber-delete'])
                        <li class="nav-item">
                            <a href="{{ route('subscriber.index') }}"
                                class="nav-link {{ request()->is('admin/subscriber*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-suitcase"></i>
                                <p>Subscriber</p>
                            </a>
                        </li>
                    @endcanany
                @endif
                <li class="nav-item">
                    <a href="{{ route('message.show') }}"
                        class="nav-link {{ request()->is('admin/message*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-comment-dots"></i>
                        <p>Message</p>
                    </a>
                </li>


                @if (in_array('contact', $app_content))
                    @canany(['contact-list', 'contact-view', 'contact-edit', 'contact-delete'])
                        <li class="nav-item">
                            <a href="{{ route('contact.index') }}"
                                class="nav-link {{ request()->is('admin/contact*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa fa-user-circle"></i>
                                <p>Contact</p>
                            </a>
                        </li>
                    @endcanany
                @endif


                @if (in_array('mediaLibrary', $app_content))
                    @canany(['mediaLibrary-list'])

                        <li class="nav-item">
                            <a href="{{ route('medialibrary.index') }}"
                                class="nav-link {{ request()->is('admin/medialibrary*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-photo-video"></i>
                                <p>Media Library</p>
                            </a>
                        </li>
                    @endcanany

                @endif
                {{-- @if (in_array('horoscope', $app_content))
                    @canany(['horoscope-list'])
                        <li class="nav-item">
                            <a href="{{ route('horoscope.index') }}"
                                class="nav-link {{ request()->is('admin/horoscope*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-book"></i>
                                <p>Horoscope</p>
                            </a>
                        </li>
                    @endcanany --}}
                <li class="nav-item">
                    <a href="{{ route('usefullinks.index') }}"
                        class="nav-link {{ request()->is('admin/usefullinks*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-link"></i>
                        <p>Useful Links</p>
                    </a>
                </li>

                {{-- @endif --}}
                @if (in_array(
        request()->user()->roles->first()->name,
        admin(),
    ))
                    <li class="nav-header">APP SETTINGS</li>

                    @hasanyrole('Super Admin')
                    <li class="nav-item">
                        <a href="{{ route('sitemap') }}"
                            class="nav-link {{ request()->is('sitemap') ? 'active' : '' }}" target="_blank">
                            <i class="nav-icon fas fa-file-code"></i>
                            <p>
                                Generate Site Map
                            </p>
                        </a>
                    </li>
                    @endhasallroles
                    @hasanyrole('Super Admin|Admin')
                    @if (in_array('user', $app_content))
                        @canany(['user-list', 'user-create', 'user-edit', 'user-delete', 'role-list', 'role-create',
                            'role-edit', 'role-delete'])
                            <li
                                class="nav-item has-treeview {{ request()->is('admin/users*') || request()->is('admin/roles*') || request()->is('admin/user-log') ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ request()->is('admin/users*') || request()->is('admin/roles*') || request()->is('admin/user-log') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-users-cog"></i>
                                    <p>
                                        Users Management
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('user-create')
                                        <li class="nav-item">
                                            <a href="{{ route('users.create') }}"
                                                class="nav-link  {{ request()->is('admin/users/create') ? 'active' : '' }}">
                                                <i class="fas fa-user-plus nav-icon"></i>
                                                <p>Add New User</p>
                                            </a>
                                        </li>
                                    @endcan
                                    @canany(['user-list', 'user-create', 'user-edit', 'user-delete'])
                                        <li class="nav-item">
                                            <a href="{{ route('users.index') }}"
                                                class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}">
                                                <i class="fas fa-users nav-icon"></i>
                                                <p>Users List</p>
                                            </a>
                                        </li>
                                    @endcanany
                                    @canany(['roles-list', 'roles-create', 'roles-edit', 'roles-delete'])
                                        <li class="nav-item">
                                            <a href="{{ route('roles.index') }}"
                                                class="nav-link {{ request()->is('admin/roles*') ? 'active' : '' }}">
                                                <i class="fas fa-user-shield nav-icon"></i>
                                                <p>Roles & Permission</p>
                                            </a>
                                        </li>
                                    @endcanany
                                    @hasanyrole('Super Admin')
                                    <li class="nav-item">
                                        <a href="{{ route('user-log.index') }}"
                                            class="nav-link {{ request()->is('admin/user-log') ? 'active' : '' }}">
                                            <i class="fas fa-history nav-icon"></i>
                                            <p>User Activity Log</p>
                                        </a>
                                    </li>
                                    @endhasallroles
                                </ul>
                            </li>
                        @endcanany
                    @endif
                    @if (in_array('menu', $app_content))
                        @canany(['menu-list', 'menu-create', 'menu-edit', 'menu-delete'])
                            <li class="nav-item has-treeview {{ request()->is('admin/menu*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ request()->is('admin/menu*') ? 'active' : '' }}">
                                    <i class="nav-icon fab fa-mendeley"></i>
                                    <p>
                                        Menu Management
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('menu-create')
                                        <li class="nav-item">
                                            <a href="{{ route('menu.create') }}"
                                                class="nav-link {{ request()->is('admin/menu/create') ? 'active' : '' }}">
                                                <i class="fas fa-plus-circle nav-icon"></i>
                                                <p>Add New Menu</p>
                                            </a>
                                        </li>
                                    @endcan
                                    @canany(['menu-list', 'menu-create', 'menu-edit', 'menu-delete'])
                                        <li class="nav-item">
                                            <a href="{{ route('menu.index') }}"
                                                class="nav-link {{ request()->is('admin/menu*') && !request()->is('admin/menu/create') ? 'active' : '' }}">
                                                <i class="fas fa-bars nav-icon"></i>
                                                <p>Menu List</p>
                                            </a>
                                        </li>
                                    @endcanany
                                </ul>
                            </li>
                        @endcanany
                    @endif
                    @endhasallroles

                    <li
                        class="nav-item has-treeview {{ request()->is('admin/setting*') || request()->is('admin/cities') || request()->is('admin/vehicletype') || request()->is('admin/ridingcost') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ request()->is('admin/setting*') || request()->is('admin/cities') || request()->is('admin/vehicletype') || request()->is('admin/ridingcost') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>
                                General Setting
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            @hasanyrole('Super Admin|Admin')

                            <li class="nav-item">
                                <a href="{{ route('setting.index') }}"
                                    class="nav-link {{ request()->is('admin/setting') ? 'active' : '' }}">
                                    <i class="fas fa-tasks nav-icon"></i>
                                    <p>App Setting</p>
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                            <a href="{{ route('settings.advertisement') }}"
                                class="nav-link {{ request()->is('admin/setting/advertisement') ? 'active' : '' }}">
                                <i class="fas fa-tasks nav-icon"></i>
                                <p>Advertisement Contacts</p>
                            </a>
                        </li> --}}
                            @endhasallroles

                            @hasanyrole('Super Admin')
                            <li class="nav-item">
                                <a href="{{ route('websiteContentFormat') }}" class="nav-link">
                                    <i class="fas fa-cogs nav-icon"></i>
                                    <p>Website Content Format </p>
                                </a>
                            </li>
                            @endhasallroles
                            @hasanyrole('Super Admin')
                            <li class="nav-item">
                                <a href="{{ route('websiteContent') }}" class="nav-link">
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Website Content </p>
                                </a>
                            </li>
                            @endhasallroles
                        </ul>
                    </li>
                @endif

                {{-- <li class="nav-item">
                    <a href="{{ route('wordpressbackup.create') }}" class="nav-link {{ request()->is('admin/blog*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-clone"></i>
                <p>Migrate Wordpress Backup</p>
                </a>
                </li> --}}
            </ul>
        </nav>
    </div>
</aside>
{{-- <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
    $('#lfm').filemanager('image');

</script>
<script>
    jQuery(function(){
        jQuery('#lfm').click();
    });
</script> --}}
