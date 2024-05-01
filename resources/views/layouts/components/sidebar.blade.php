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
            <div class="pcoded-navigation-label">Sales</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class=" ">
                    <a href="" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="feather icon-edit"></i>
                        </span>
                        <span class="pcoded-mtext">Invoices</span>
                    </a>
                </li>
                <li class=" ">
                    <a href="" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fas fa-cube"></i>
                        </span>
                        <span class="pcoded-mtext">Manage Products</span>
                    </a>
                </li>
                <li class=" ">
                    <a href="" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fas fa-cube"></i>
                        </span>
                        <span class="pcoded-mtext">Manage Orders</span>
                    </a>
                </li>
            </ul>
            <div class="pcoded-navigation-label">Administrator</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class=" ">
                    <a href="" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="feather icon-user"></i>
                        </span>
                        <span class="pcoded-mtext">User Management</span>
                    </a>
                </li>
                <li class=" ">
                    <a href="" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="feather icon-users"></i>
                        </span>
                        <span class="pcoded-mtext">Customer Management</span>
                    </a>
                </li>
                <li class=" ">
                    <a href="" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="ti-car"></i>
                        </span>
                        <span class="pcoded-mtext">Car Management</span>
                    </a>
                </li>
                <li class=" ">
                    <a href="" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="feather icon-file-text"></i>
                        </span>
                        <span class="pcoded-mtext">Branch Management</span>
                    </a>
                </li>
                <li class=" ">
                    <a href="" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="feather icon-file-text"></i>
                        </span>
                        <span class="pcoded-mtext">Inquiries</span>
                    </a>
                </li>
                <li class=" ">
                    <a href="" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="feather icon-file-text"></i>
                        </span>
                        <span class="pcoded-mtext">Inspection</span>
                    </a>
                </li>
                <li class=" ">
                    <a href="" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="feather icon-briefcase"></i>
                        </span>
                        <span class="pcoded-mtext">Job Management</span>
                    </a>
                </li>
            </ul>
            <div class="pcoded-navigation-label">Settings</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class=" ">
                    <a href="" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="feather icon-mail"></i>
                        </span>
                        <span class="pcoded-mtext">Email Template</span>
                    </a>
                </li>
                <li class=" ">
                    <a href="" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="feather icon-settings"></i>
                        </span>
                        <span class="pcoded-mtext">Settings</span>
                    </a>
                </li>
                <li class=" ">
                    <a href="" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="feather icon-clipboard"></i>
                        </span>
                        <span class="pcoded-mtext">Roles & Permissions</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>