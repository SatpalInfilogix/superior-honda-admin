<nav class="pcoded-navbar">
    <div class="nav-list">
        <div class="pcoded-inner-navbar main-menu">
            @canany(['view dashboard'])
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
            @endcanany

            @canany(['view customer inquiry', 'view invoice', 'view services'])
                <div class="pcoded-navigation-label">Sales</div>
            @endcanany
            <ul class="pcoded-item pcoded-left-item">
                @can('view customer inquiry')
                <li @class([
                    'active' => Request::is('customer-inquiry', 'customer-inquiry/create', 'customer-inquiry/*/edit'),
                ])>
                    <a href="{{ route('customer-inquiry.index') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="ti-direction"></i>
                        </span>
                        <span class="pcoded-mtext">Customer Inquiry</span>
                    </a>
                </li>
                @endcan
                 @canany(['view invoice','view services'])
                <li @class([
                    'pcoded-hasmenu',
                    'pcoded-trigger active' => Request::is(
                        'invoices',
                        'invoices/create',
                        'invoices/*/edit',
                        'services',
                        'services/create',
                        'services/*/edit'),
                ])>
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fas fa-cube"></i>
                        </span>
                        <span class="pcoded-mtext">Manage Invoices</span>
                    </a>
                    <ul class="pcoded-submenu">
                        @can('view invoice')
                            <li @class([
                                'active' => Request::is(
                                            'invoices',
                                            'invoices/*/view'),
                                    
                            ])>
                                <a href="{{ route('invoices.index')}}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon">
                                        <i class="feather icon-edit"></i>
                                    </span>
                                    <span class="pcoded-mtext">Invoices</span>
                                </a>
                            </li>
                        @endcan
                        @can('view services')
                            <li class="{{ Request::segment(1) == 'services' ? 'active' : '' }}">
                                <a href="{{ route('services.index')}}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon">
                                        <i class="fas fa-cog"></i>
                                    </span>
                                    <span class="pcoded-mtext">Invoice Services</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
                @endcanany
                @canany(['view inquiry','view inspection','view bay','view product','view promotions','view reports'])
                    <div class="pcoded-navigation-label">Operations</div>
                @endcanany
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
                    <li class="{{ Request::segment(1) == 'inspection' ? 'active' : '' }}">
                        <a href="{{ route('inspection.index')}}" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="ti-write"></i>
                            </span>
                            <span class="pcoded-mtext">Inspection</span>
                        </a>
                    </li>
                @endcan
                @can('view bay')
                    <li  @class([
                        'active' => Request::is('bay', 'bay/create', 'bay/*/edit'),
                    ])>
                        <a href="{{ route('bay.index') }}" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="ti-package"></i>
                            </span>
                            <span class="pcoded-mtext">Bay</span>
                        </a>
                    </li>
                @endcan
                @can('view product')
                    <li @class([
                        'pcoded-hasmenu',
                        'pcoded-trigger active' => Request::is(
                            'products',
                            'products/create',
                            'products/*/edit',
                            'product-categories',
                            'product-categories/create',
                            'product-categories/*/edit'),
                    ])>
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="fas fa-cube"></i>
                            </span>
                            <span class="pcoded-mtext">Manage Products</span>
                        </a>
						<ul class="pcoded-submenu">
                            <li @class([
                                'active' => Request::is(
                                    'product-categories',
                                    'product-categories/create',
                                    'product-categories/*/edit'),
                            ])>
							    <a href="{{ route('product-categories.index') }}" class="waves-effect waves-dark">
									<span class="pcoded-micon">
										<i class="fas fa-cube"></i>
									</span>
									<span class="pcoded-mtext">Product Categories</span>
								</a>
							</li>
							<li @class([
                                'active' => Request::is(
                                    'products',
                                    'products/create',
                                    'products/*/edit',),
                            ])>
							    <a href="{{ route('products.index') }}" class="waves-effect waves-dark">
									<span class="pcoded-micon">
										<i class="fas fa-cube"></i>
									</span>
									<span class="pcoded-mtext">Products</span>
								</a>
							</li>
						</ul>
                    </li>
                @endcan
                @can('view promotions')
                    <li @class([
                        'active' => Request::is(
                            'promotions',
                            'promotions/create',
                            'promotions/*/edit'),
                    ])>
                        <a href="{{ route('promotions.index') }}" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="fas fa-credit-card"></i>
                            </span>
                            <span class="pcoded-mtext">Promotions</span>
                        </a>
                    </li>
                @endcan
                @can('view reports')
                    <li @class([
                        'active' => Request::is('reports'),
                    ])>
                        <a href="{{ route('reports.index') }}" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="feather icon-user"></i>
                            </span>
                            <span class="pcoded-mtext">Reports</span>
                        </a>
                    </li>
                @endcan
                @canany(['view vehicle configuration','view branch','view location'])
                    <div class="pcoded-navigation-label">Configuration</div>
                @endcanany
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
                @canany(['view branch','view location'])
                    <li @class([
                        'pcoded-hasmenu',
                        'pcoded-trigger active' => Request::is(
                            'branches',
                            'branches/create',
                            'branches/*/edit',
                            'locations',
                            'locations/create',
                            'locations/*/edit'),
                    ])>
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="fas fa-cube"></i>
                            </span>
                            <span class="pcoded-mtext">Location Management</span>
                        </a>
                        <ul class="pcoded-submenu">
                            @can('view location')
                            <li @class([
                                'active' => Request::is(
                                    'locations',
                                    'locations/create',
                                    'locations/*/edit'),
                            ])>
                                <a href="{{ route('locations.index') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon">
                                        <i class="fas fa-cube"></i>
                                    </span>
                                    <span class="pcoded-mtext">Location Management</span>
                                </a>
                            </li>
                            @endcan
                            @can('view branch')
                            <li @class([
                                'active' => Request::is(
                                    'branches',
                                    'branches/create',
                                    'branches/*/edit'),
                            ])>
                                <a href="{{ route('branches.index') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon">
                                        <i class="fas fa-cube"></i>
                                    </span>
                                    <span class="pcoded-mtext">Branch Management</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany

                {{--@can('view order')
                    <li class="{{ Request::segment(1) == 'orders' ? 'active' : '' }}">
                        <a href="{{ route('orders.index')}}" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="fas fa-cube"></i>
                            </span>
                            <span class="pcoded-mtext">Manage Orders</span>
                        </a>
                    </li>
                @endcan--}}

                <!-- <li class="{{ Request::segment(1) == 'banners' ? 'active' : '' }}">
                    <a href="{{ route('banners.index')}}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fas fa-cube"></i>
                        </span>
                        <span class="pcoded-mtext">Banners</span>
                    </a>
                </li> -->
                @canany(['view user','view customer'])
                    <div class="pcoded-navigation-label">User management</div>
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
                </ul>

                {{--@can('view coupons')
                    <li @class([
                        'active' => Request::is(
                            'coupons',
                            'coupons/create',
                            'coupons/*/edit'),
                    ])>
                        <a href="{{ route('coupons.index') }}" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="fas fa-credit-card"></i>
                            </span>
                            <span class="pcoded-mtext">Coupon/Offers</span>
                        </a>
                    </li>
                @endcan--}}

            </ul>

            {{--@canany([
                'view user',
                'view customer',
                'view vehicle configuration',
                'view vehicle',
                'view branch',
                'view inquiry',
                'view inspection',
                'view job',
                ])
                <div class="pcoded-navigation-label">Administrator</div>
            @endcanany
            <ul class="pcoded-item pcoded-left-item">
                @can('view job')
                    <li class="{{ Request::segment(1) == 'jobs' ? 'active' : '' }}">
                        <a href="{{ route('jobs.index')}}" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="ti-id-badge f-16"></i>
                            </span>
                            <span class="pcoded-mtext">Job Management</span>
                        </a>
                    </li>
                @endcan
                @can('view cart')
                <li  class="{{ Request::segment(1) == 'carts' ? 'active' : '' }}">
                    <a href="{{ route('carts.index')}}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="ti-shopping-cart"></i>
                        </span>
                        <span class="pcoded-mtext">Cart/Wishlist</span>
                    </a>
                </li>
                @endcan

                @can('view Order')
                <li  class="{{ Request::segment(1) == 'orders' ? 'active' : '' }}">
                    <a href="{{ route('orders.index')}}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="ti-layout-grid4"></i>
                        </span>
                        <span class="pcoded-mtext">Orders</span>
                    </a>
                </li>
                @endcan
                @can('view banners')
                <li class="{{ Request::segment(1) == 'banners' ? 'active' : '' }}">
                    <a href="{{ route('banners.index')}}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fas fa-cube"></i>
                        </span>
                        <span class="pcoded-mtext">Banners</span>
                    </a>
                </li>
                @endcan
                @can('view sales-products')
                <li class="{{ Request::segment(1) == 'sales-products' ? 'active' : '' }}">
                    <a href="{{ route('sales-products.index')}}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fas fa-cubes"></i>
                        </span>
                        <span class="pcoded-mtext">Sales Product</span>
                    </a>
                </li>
                @endcan
            </ul>--}}
            @canany(['view job','view faqs','view testimonials','view roles & permissions','view settings'])
                <div class="pcoded-navigation-label">Settings</div>
            @endcanany
            <ul class="pcoded-item pcoded-left-item">
                @can('view job')
                    <li class="view email template ">
                        <a href="{{ route('emails.index') }}" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="feather icon-mail"></i>
                            </span>
                            <span class="pcoded-mtext">Email Template</span>
                        </a>
                    </li>
                @endcan
                @can('view faqs')
                    <li class="{{ Request::segment(1) == 'faqs' ? 'active' : '' }}">
                        <a href="{{ route('faqs.index')}}" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="fas fa-question-circle"></i>
                            </span>
                            <span class="pcoded-mtext">Faq</span>
                        </a>
                    </li>
                @endcan
                @can('view testimonials')
                    <li class="{{ Request::segment(1) == 'testimonials' ? 'active' : '' }}">
                        <a href="{{ route('testimonials.index')}}" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="fas fa-quote-right"></i>
                            </span>
                            <span class="pcoded-mtext">Testimonials</span>
                        </a>
                    </li>
                @endcan
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
                @can('view settings')
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
                @endcan
            </ul>
        </div>
    </div>
</nav>
