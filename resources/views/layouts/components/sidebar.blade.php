<nav class="pcoded-navbar">
    <div class="nav-list">
        <div class="pcoded-inner-navbar main-menu">
            <div class="pcoded-navigation-label">Dashboard</div>
            <ul class="pcoded-item pcoded-left-item">
                <li @class(['active' => Request::is('dashboard')])>
                    <a href="{{ route('dashboard.index') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="feather icon-home"></i>
                        </span>
                        <span class="pcoded-mtext">Dashboard</span>
                    </a>
                </li>
            </ul>

            @canany(['view invoice', 'view product', 'view order'])
                <div class="pcoded-navigation-label">Sales</div>
            @endcanany
            <ul class="pcoded-item pcoded-left-item">
                @can('view invoice')
                    <li class="">
                        <a href="" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="feather icon-edit"></i>
                            </span>
                            <span class="pcoded-mtext">Invoices</span>
                        </a>
                    </li>
                @endcan
                @can('view product')
                    <li @class([
                        'active' => Request::is('products', 'products/create', 'products/*/edit'),
                    ])>
                        <a href="{{ route('products.index') }}" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="fas fa-cube"></i>
                            </span>
                            <span class="pcoded-mtext">Manage Products</span>
                        </a>
                    </li>
                @endcan

                @can('view order')
                    <li class=" ">
                        <a href="" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="fas fa-cube"></i>
                            </span>
                            <span class="pcoded-mtext">Manage Orders</span>
                        </a>
                    </li>
                @endcan

                @can('view vehicle configuration')
                    <li @class([
                        'pcoded-hasmenu',
                        'pcoded-trigger active' => Request::is(
                            'vehicle-categories',
                            'vehicle-categories/create',
                            'vehicle-categories/*/edit',
                            'vehicle-types',
                            'vehicle-types/create',
                            'vehicle-types/*/edit',
                            'vehicle-brands',
                            'vehicle-brands/create',
                            'vehicle-brands/*/edit',
                            'vehicle-models',
                            'vehicle-models/create',
                            'vehicle-models/*/edit',
                            'vehicle-model-variants',
                            'vehicle-model-variants/create',
                            'vehicle-model-variants/*/edit'),
                    ])>
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="fas fa-car"></i></span>
                            <span class="pcoded-mtext">Vehicle Configuration</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li @class([
                                'active' => Request::is(
                                    'vehicle-categories',
                                    'vehicle-categories/create',
                                    'vehicle-categories/*/edit'),
                            ])>
                                <a href="{{ route('vehicle-categories.index') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Vehicle Categories</span>
                                </a>
                            </li>
                            <li @class([
                                'active' => Request::is(
                                    'vehicle-types',
                                    'vehicle-types/create',
                                    'vehicle-types/*/edit'),
                            ])>
                                <a href="{{ route('vehicle-types.index') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Vehicle Types</span>
                                </a>
                            </li>
                            <li @class([
                                'active' => Request::is(
                                    'vehicle-brands',
                                    'vehicle-brands/create',
                                    'vehicle-brands/*/edit'),
                            ])>
                                <a href="{{ route('vehicle-brands.index') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Vehicle Brands</span>
                                </a>
                            </li>
                            <li @class([
                                'active' => Request::is(
                                    'vehicle-models',
                                    'vehicle-models/create',
                                    'vehicle-models/*/edit'),
                            ])>
                                <a href="{{ route('vehicle-models.index') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Vehicle Models</span>
                                </a>
                            </li>
                            <li @class([
                                'active' => Request::is(
                                    'vehicle-model-variants',
                                    'vehicle-model-variants/create',
                                    'vehicle-model-variants/*/edit'),
                            ])>
                                <a href="{{ route('vehicle-model-variants.index') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Vehicle Model Variants</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('view vehicle')
                    <li @class([
                        'active' => Request::is(
                            'vehicles',
                            'vehicles/create',
                            'vehicles/*/edit'),
                    ])>
                        <a href="{{ route('vehicles.index') }}" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="fas fa-car"></i>
                            </span>
                            <span class="pcoded-mtext">Vehicles Management</span>
                        </a>
                    </li>
                @endcan
                {{-- @can('view vehicle') --}}
                    <li @class([
                        'active' => Request::is(
                            'coupons',
                            'coupons/create',
                            'coupons/*/edit'),
                    ])>
                        <a href="{{ route('coupons.index') }}" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="fas fa-car"></i>
                            </span>
                            <span class="pcoded-mtext">Coupon/Offers</span>
                        </a>
                    </li>
                {{-- @endcan --}}
            </ul>

            @canany([
                'view user',
                'view customer',
                'view vehicle configuration',
                'view vehicle',
                'view branch',
                'view
                inquiry',
                'view inspection',
                'view job',
                ])
                <div class="pcoded-navigation-label">Administrator</div>
            @endcanany
            <ul class="pcoded-item pcoded-left-item">
                @can('view user')
                    <li @class([
                        'active' => Request::is('users', 'users/create', 'users/*/edit'),
                    ])>
                        <a href="{{ route('users.index') }}" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="feather icon-user"></i>
                            </span>
                            <span class="pcoded-mtext">User Management</span>
                        </a>
                    </li>
                @endcan
                @can('view customer')
                    <li @class([
                        'active' => Request::is('customers', 'customers/create', 'customers/*/edit'),
                    ])>
                        <a href="{{ route('customers.index') }}" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="feather icon-users"></i>
                            </span>
                            <span class="pcoded-mtext">Customer Management</span>
                        </a>
                    </li>
                @endcan
                @can('view branch')
                    <li @class([
                        'active' => Request::is('branches', 'branches/create', 'branches/*/edit'),
                    ])>
                        <a href="{{ route('branches.index') }}" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="ti-direction"></i>
                            </span>
                            <span class="pcoded-mtext">Branch Management</span>
                        </a>
                    </li>
                @endcan
                @can('view inquiry')
                    <li  class="{{ Request::segment(1) == 'inquiries' ? 'active' : '' }}">
                        <a href="{{ route('inquiries.index')}}" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="ti-notepad"></i>
                            </span>
                            <span class="pcoded-mtext">Inquiries</span>
                        </a>
                    </li>
                @endcan
                @can('view inspection')
                    <li class=" ">
                        <a href="" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="ti-write"></i>
                            </span>
                            <span class="pcoded-mtext">Inspection</span>
                        </a>
                    </li>
                @endcan
                @can('view job')
                    <li class=" ">
                        <a href="" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="ti-id-badge f-16"></i>
                            </span>
                            <span class="pcoded-mtext">Job Management</span>
                        </a>
                    </li>
                @endcan
            </ul>
            <div class="pcoded-navigation-label">Settings</div>
            <ul class="pcoded-item pcoded-left-item">
                @can('view job')
                    <li class="view email template ">
                        <a href="" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="feather icon-mail"></i>
                            </span>
                            <span class="pcoded-mtext">Email Template</span>
                        </a>
                    </li>
                @endcan
                <li @class([
                    'active' => Request::is('settings', 'settings/general-setting'),
                ])>
                    <a href="{{ route('settings.index')}}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="feather icon-settings"></i>
                        </span>
                        <span class="pcoded-mtext">Settings</span>
                    </a>
                </li>

                @can('view roles & permissions')
                    <li @class([
                        'pcoded-hasmenu',
                        'pcoded-trigger active' => Request::is('roles', 'roles-and-permissions'),
                    ])>
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="feather icon-clipboard"></i></span>
                            <span class="pcoded-mtext">Roles & Permissions</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li @class(['active' => Request::is('roles')])>
                                <a href="{{ route('roles.index') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Manage Roles</span>
                                </a>
                            </li>
                            <li @class(['active' => Request::is('roles-and-permissions')])>
                                <a href="{{ route('roles-and-permissions.index') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-mtext">Roles & Permissions</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
            </ul>
        </div>
    </div>
</nav>
