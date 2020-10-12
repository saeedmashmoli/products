<div class="page-wrapper chiller-theme toggled">
    <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
        <i class="fa fa-bars"></i>
    </a>
    <nav id="sidebar" class="sidebar-wrapper">
        <div class="sidebar-content">
            <div class="sidebar-brand">
                <div id="close-sidebar">
                    <i class="fa fa-bars"></i>
                </div>
            </div>
            <div class="sidebar-header pb-0 pt-1">
                <div class="user-pic w-100 text-center">
                    <img style="border-radius: 50%" class="img-responsive img-rounded w-25" src="@if(auth()->user()->picUrl){{asset(auth()->user()->picUrl)}}@else {{asset('images/UserPic.png')}} @endif"
                         alt="User picture">
                </div>
                <div class="user-info col-lg-12">
                    <span class="user-name text-center">{{auth()->user()->username}} ({{auth()->user()->role ? auth()->user()->role->title : ''}})</span>
                </div>
            </div>
            <div class="dropdown-divider text-justify"></div>
            <!-- sidebar-header  -->
        {{-- <div class="sidebar-search">
          <div>
            <div class="input-group">
              <input type="text" class="form-control search-menu" placeholder="Search...">
              <div class="input-group-append">
                <span class="input-group-text">
                  <i class="fa fa-search" aria-hidden="true"></i>
                </span>
              </div>
            </div>
          </div>
        </div> --}}
        <!-- sidebar-search  -->
            <div class="sidebar-menu">
                <ul>
                    {{-- <li class="header-menu">
                      <span>General</span>
                    </li> --}}
                    {{-- <li class="sidebar-dropdown">
                      <a href="#">
                        <i class="fa fa-tachometer"></i>
                        <span>داشبورد</span> --}}
                    {{-- <span class="badge badge-pill badge-warning">New</span> --}}
                    {{-- </a>
                    <div class="sidebar-submenu">
                      <ul>
                        <li>
                          <a href="#">Dashboard 1

                          </a>
                        </li>
                        <li>
                          <a href="#">Dashboard 2</a>
                        </li>
                        <li>
                          <a href="#">Dashboard 3</a>
                        </li>
                      </ul>
                    </div>
                  </li> --}}
                    <li class="header-menu">
                        <span>تنظیمات</span>
                    </li>
                    @can('show-roles')
                        <li class="sidebar-dropdown">
                            <a class="@if(Route::currentRouteName()=='roles.index' ||
                                 Route::currentRouteName()=='permissions.index' ||
                                 Route::currentRouteName()=='about.index' ||
                                 Route::currentRouteName()=='permissions.create' ||
                                 Route::currentRouteName()=='permissions.edit' ||
                                 Route::currentRouteName()=='roles.create' ||
                                 Route::currentRouteName()=='roles.edit') active @endif">
                                <i class="fa fa-cog"></i>
                                <span>سمت و دسترسی ها</span>
                            </a>
                            <div class="sidebar-submenu @if(Route::currentRouteName()=='roles.index' || Route::currentRouteName()=='permissions.index') active @endif">
                                <ul>
                                    <li class="@if(Route::currentRouteName()=='roles.index') active @endif">
                                        <a class="@if(Route::currentRouteName()=='roles.index') active @endif" href="{{route('roles.index')}}" >سمت ها</a>
                                    </li>
                                    <li class="@if(Route::currentRouteName()=='permissions.index') active @endif">
                                        <a class="@if(Route::currentRouteName()=='permissions.index') active @endif" href="{{route('permissions.index')}}">دسترسی ها</a>
                                    </li>
                                    <li class="@if(Route::currentRouteName()=='about.index') active @endif">
                                        <a class="@if(Route::currentRouteName()=='about.index') active @endif" href="{{route('about.index')}}">ارتباط با ما</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endcan
                    <li class="header-menu">
                        <span>مدیریت</span>
                    </li>
                    @can('show-categories')
                        <li class="sidebar-dropdown">
                            <a class="@if(Route::currentRouteName()=='categories.index' ||
                              Route::currentRouteName()=='categories.create' ||
                              Route::currentRouteName()=='categories.edit') active @endif"
                                href="{{route('categories.index')}}"
                            >
                                <i class="fa fa-group"></i>
                                <span>دسته ها</span>
                            </a>
                        </li>
                    @endcan
                    @can('show-users')
                        <li class="sidebar-dropdown">
                            <a class="@if(Route::currentRouteName()=='users.index' ||
                                Route::currentRouteName()=='users.create' ||
                                Route::currentRouteName()=='users.edit') active @endif"
                               href="{{route('users.index')}}"
                            >
                                <i class="fa fa-user"></i>
                                <span>کاربران</span>
                            </a>
                        </li>
                    @endcan
                    @can('show-products')
                        <li class="sidebar-dropdown">
                            <a class="@if(Route::currentRouteName()=='products.index' ||
                                Route::currentRouteName()=='products.create' ||
                                Route::currentRouteName()=='products.edit') active @endif"
                               href="{{route('products.index')}}"
                            >
                                <i class="fa fa-product-hunt"></i>
                                <span>محصولات</span>
                            </a>
                        </li>
                    @endcan
                    @can('show-articles')
                        <li class="sidebar-dropdown">
                            <a class="@if(Route::currentRouteName()=='articles.index' ||
                            Route::currentRouteName()=='articles.create' ||
                            Route::currentRouteName()=='articles.edit') active @endif"
                               href="{{route('articles.index')}}"
                            >
                                <i class="fa fa-archive"></i>
                                <span>مقاله ها</span>
                            </a>
                        </li>
                    @endcan
                    @can('show-videos')
                        <li class="sidebar-dropdown">
                            <a class="@if(Route::currentRouteName()=='videos.index' ||
                            Route::currentRouteName()=='videos.create' ||
                            Route::currentRouteName()=='videos.edit') active @endif"
                               href="{{route('videos.index')}}"
                            >
                                <i class="fa fa-video-camera"></i>
                                <span>ویدئو ها</span>
                            </a>
                        </li>
                    @endcan
                    @can('show-comments')
                        <li class="sidebar-dropdown">
                            <a class="@if(Route::currentRouteName()=='comments.index') active @endif" href="{{route('comments.index')}}">
                                <i class="fa fa-comment"></i>
                                <span>کامنت ها</span>
                            </a>
                        </li>
                    @endcan
                    @can('show-chats')
                        <li class="sidebar-dropdown">
                            <a class="@if(Route::currentRouteName()=='chats.index') active @endif" href="{{route('chats.index')}}">
                                <i class="fa fa-comment"></i>
                                <span>چت ها</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </div>
            <!-- sidebar-menu  -->
        </div>
        <!-- sidebar-content  -->
        <div class="sidebar-footer">
            {{-- <a href="#">
              <i class="fa fa-bell"></i>
              <span class="badge badge-pill badge-warning notification">3</span>
            </a>
            <a href="#">
              <i class="fa fa-envelope"></i>
              <span class="badge badge-pill badge-success notification">7</span>
            </a> --}}
            <a href="{{ route('profile.show') }}">
                <i class="fa fa-cog"></i>
                {{-- <span class="badge-sonar"></span> --}}
            </a>
            <a href="{{ route('logout') }}">
                <i class="fa fa-user"></i>
            </a>
            <a href="{{ route('/') }}">
                <i class="fa fa-retweet"></i>
            </a>
        </div>
    </nav>
    <!-- sidebar-wrapper  -->


