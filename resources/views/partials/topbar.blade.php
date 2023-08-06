<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow">
            <a
                class="nav-link dropdown-toggle"
                href="{{ route('admin.logout') }}"
                role="button"
                aria-haspopup="true"
                aria-expanded="false"
            >
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Logout</span>
            </a>
        </li>
    </ul>
</nav>
