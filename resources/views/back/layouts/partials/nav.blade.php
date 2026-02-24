<nav class="nxl-navigation">
    <div class="navbar-wrapper">
        <div class="m-header">
            <style>
                .nxl-navigation .m-header .b-brand {
                    display: flex !important;
                    align-items: center;
                }

                html.minimenu .nxl-navigation .m-header .b-brand {
                    display: block !important;
                }
            </style>
            <a href="{{ route('admin.dashboard') }}" class="b-brand">
                <!-- ========   change your logo hear   ============ -->
                <img src="{{ asset('back/assets/images/logo-scj.png') }}" alt="SCJ Logo" class="logo logo-lg"
                    style="object-fit: contain; height: 45px; flex-shrink: 0;" />
                <span class="logo logo-lg ms-2 fw-bold text-uppercase"
                    style="font-size: 14px; line-height: 1.3; letter-spacing: 0.5px; white-space: nowrap;">SINAR
                    <span style="color: red;">CEMARA</span><br>JAYA</span>
                <img src="{{ asset('back/assets/images/logo-scj.png') }}" alt="SCJ Logo" class="logo logo-sm"
                    style="object-fit: contain; height: 35px;" />
            </a>
        </div>
        <div class="navbar-content">
            <ul class="nxl-navbar">
                <li class="nxl-item nxl-caption">
                    <label>Navigation</label>
                </li>

                @foreach (config('back_menus') as $menu)
                    @if (empty($menu['children']))
                        @can(data_get($menu, 'can'))
                            <li class="nxl-item {{ !empty($menu['url']) && request()->routeIs($menu['url']) ? 'active' : '' }}">
                                <a href="{{ !empty($menu['url']) ? route($menu['url']) : 'javascript:void(0);' }}" class="nxl-link">
                                    <span class="nxl-micon"><i class="{{ $menu['icon'] }}"></i></span>
                                    <span class="nxl-mtext">{{ $menu['title'] }}</span>
                                </a>
                            </li>
                        @endcan
                    @else
                        @if (auth()->user()->hasAnyPermission(data_get($menu, 'can', [])))
                            @php
                                $isActive = false;
                                foreach ($menu['children'] as $child) {
                                    if (!empty($child['url']) && Illuminate\Support\Facades\Route::has($child['url'])) {
                                        $prefix = \Illuminate\Support\Str::beforeLast($child['url'], '.');
                                        if (request()->routeIs($child['url']) || request()->routeIs($prefix . '.*')) {
                                            $isActive = true;
                                            break;
                                        }
                                    }
                                    if (!empty($child['children'])) {
                                        foreach ($child['children'] as $sub) {
                                            if (
                                                !empty($sub['url']) &&
                                                Illuminate\Support\Facades\Route::has($sub['url'])
                                            ) {
                                                $prefix = \Illuminate\Support\Str::beforeLast($sub['url'], '.');
                                                if (
                                                    request()->routeIs($sub['url']) ||
                                                    request()->routeIs($prefix . '.*')
                                                ) {
                                                    $isActive = true;
                                                    break 2;
                                                }
                                            }
                                        }
                                    }
                                }
                            @endphp
                            <li class="nxl-item nxl-hasmenu {{ $isActive ? 'active nxl-trigger' : '' }}">
                                <a href="javascript:void(0);" class="nxl-link">
                                    <span class="nxl-micon"><i class="{{ $menu['icon'] }}"></i></span>
                                    <span class="nxl-mtext">{{ $menu['title'] }}</span>
                                    <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                                </a>
                                <ul class="nxl-submenu">
                                    @foreach ($menu['children'] as $child)
                                        @if (auth()->user()->hasAnyPermission(data_get($child, 'can', [])))
                                            @if (empty($child['children']))
                                                @php
                                                    if (isset($child['active'])) {
                                                        $isChildActive = request()->routeIs($child['active']);
                                                    } else {
                                                        $childPrefix = !empty($child['url'])
                                                            ? \Illuminate\Support\Str::beforeLast($child['url'], '.')
                                                            : '';
                                                        $isChildActive =
                                                            !empty($child['url']) &&
                                                            (request()->routeIs($child['url']) ||
                                                                (!empty($childPrefix) &&
                                                                    request()->routeIs($childPrefix . '.*')));
                                                    }
                                                @endphp
                                                <li class="nxl-item {{ $isChildActive ? 'active' : '' }}">
                                                    <a class="nxl-link"
                                                        href="{{ !empty($child['url']) ? route($child['url']) : 'javascript:void(0);' }}">{{ $child['title'] }}</a>
                                                </li>
                                            @else
                                                @php
                                                    $isSubmenuActive = false;
                                                    foreach ($child['children'] as $subchild) {
                                                        if (
                                                            !empty($subchild['url']) &&
                                                            Illuminate\Support\Facades\Route::has($subchild['url'])
                                                        ) {
                                                            $prefix = \Illuminate\Support\Str::beforeLast(
                                                                $subchild['url'],
                                                                '.',
                                                            );
                                                            if (
                                                                request()->routeIs($subchild['url']) ||
                                                                request()->routeIs($prefix . '.*')
                                                            ) {
                                                                $isSubmenuActive = true;
                                                                break;
                                                            }
                                                        }
                                                    }
                                                @endphp
                                                <li class="nxl-item nxl-hasmenu {{ $isSubmenuActive ? 'active nxl-trigger' : '' }}">
                                                    <a href="javascript:void(0);" class="nxl-link">
                                                        <span class="nxl-mtext">{{ $child['title'] }}</span>
                                                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                                                    </a>
                                                    <ul class="nxl-submenu">
                                                        @foreach ($child['children'] as $subchild)
                                                            @can(data_get($subchild, 'can'))
                                                                @php
                                                                    if (isset($subchild['active'])) {
                                                                        $isSubchildActive = request()->routeIs(
                                                                            $subchild['active'],
                                                                        );
                                                                    } else {
                                                                        $subPrefix = !empty($subchild['url'])
                                                                            ? \Illuminate\Support\Str::beforeLast(
                                                                                $subchild['url'],
                                                                                '.',
                                                                            )
                                                                            : '';
                                                                        $isSubchildActive =
                                                                            !empty($subchild['url']) &&
                                                                            (request()->routeIs($subchild['url']) ||
                                                                                (!empty($subPrefix) &&
                                                                                    request()->routeIs(
                                                                                        $subPrefix . '.*',
                                                                                    )));
                                                                    }
                                                                @endphp
                                                                <li class="nxl-item {{ $isSubchildActive ? 'active' : '' }}">
                                                                    <a class="nxl-link"
                                                                        href="{{ !empty($subchild['url']) ? route($subchild['url']) : 'javascript:void(0);' }}">{{ $subchild['title'] }}</a>
                                                                </li>
                                                            @endcan
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endif
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</nav>