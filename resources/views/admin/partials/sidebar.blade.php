<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.home') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Desi Naumova</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @if(request()->path() === 'admin') active @endif">
        <a class="nav-link" href="{{ route('admin.home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Home</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="{{ admin_link_active_class('/^admin\/categories(\/|$)/') }}">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseOne"
           aria-expanded="true" aria-controls="collapseOne">
            <i class="fas fa-fw fa-cog"></i>
            <span>Categories</span>
        </a>
        <div id="collapseOne" class="{{ admin_link_active_class('/^admin\/categories(\/|$)/', 'collapse', 'show') }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Actions:</h6>
                <a class="{{ admin_link_active_class('/^admin\/categories\/?$/', 'collapse-item') }}" href="{{ route('categories.index') }}">List all</a>
                <a class="{{ admin_link_active_class('/^admin\/categories\/create?\/?$/', 'collapse-item') }}" href="{{ route('categories.create') }}">Add new</a>
            </div>
        </div>
    </li>

    <li class="{{ admin_link_active_class('/^admin\/products(\/|$)/') }}">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseTwo"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Products</span>
        </a>
        <div id="collapseTwo" class="{{ admin_link_active_class('/^admin\/products(\/|$)/', 'collapse', 'show') }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Actions:</h6>
                <a class="{{ admin_link_active_class('/^admin\/products\/?$/', 'collapse-item') }}" href="{{ route('products.index') }}">List all</a>
                <a class="{{ admin_link_active_class('/^admin\/products\/create?\/?$/', 'collapse-item') }}" href="{{ route('products.create') }}">Add new</a>
            </div>
        </div>
    </li>

    <li class="{{ admin_link_active_class('/^admin\/orders(\/|$)/') }}">
        <a class="nav-link" href="#" >
            <i class="fas fa-fw fa-cog"></i>
            <span>Orders</span>
        </a>
    </li>


    <hr class="sidebar-divider">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
