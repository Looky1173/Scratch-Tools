<nav class="navbar">
    <!-- Toggle sidebar -->
    <button id="toggle-sidebar-btn" class="btn btn-action" type="button" onclick="halfmoon.toggleSidebar()" aria-label="Toggle sidebar">
        <i class="fas fa-bars" aria-hidden="true"></i>
    </button>
    <!-- Navbar brand -->
    <a href="/" class="navbar-brand">
        <p>Scratch Tools</p>
    </a>
    <!-- Navbar text -->
    <span class="navbar-text ml-5 d-none d-sm-block">
        <!-- ml-5 = margin-left: 0.5rem (5px) -->
        <span class="badge text-monospace">v0.0.4 <span class="badge badge-danger">Alpha</span></span>
        <!-- text-monospace = font-family shifted to monospace -->
    </span>
    <!-- Navbar nav -->
    <ul class="navbar-nav ml-auto d-none d-md-flex">
        <!-- ml-auto = margin-left: auto -->
        <li id="navbar-home" class="nav-item">
            <a href="/index" class="nav-link">Home</a>
        </li>
        <li id="navbar-about" class="nav-item">
            <a href="/about" class="nav-link">About</a>
        </li>
        <li id="navbar-documentation" class="nav-item">
            <a href="/documentation" class="nav-link">Documentation</a>
        </li>
        <li id="navbar-tools" class="nav-item dropdown with-arrow">
            <a class="nav-link" data-toggle="dropdown" id="nav-link-dropdown-toggle">
                Tools
                <i class="fas fa-angle-down ml-5" aria-hidden="true"></i>
                <!-- ml-5= margin-left: 0.5rem (5px) -->
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="nav-link-dropdown-toggle">
                <a href="/tools/#utilities" class="dropdown-item">Utilities</a>
                <a href="/tools/#statistics" class="dropdown-item">Statistics</a>
                <a href="/tools/#advanced" class="dropdown-item">
                    Advanced
                    <strong class="badge badge-primary float-right">Soon</strong>
                    <!-- float-right = float: right -->
                </a>
                <div class="dropdown-divider"></div>
                <div class="dropdown-content">
                    <a href="/tools" class="btn btn-block" role="button">
                        See all tools
                        <i class="fas fa-angle-right ml-5" aria-hidden="true"></i>
                        <!-- ml-5= margin-left: 0.5rem (5px) -->
                    </a>
                </div>
            </div>
        </li>
        <!-- Toggle dark mode -->
        <button class="btn btn-action mr-5" type="button" onclick="halfmoon.toggleDarkMode()" aria-label="Toggle dark mode">
            <i class="fas fa-moon" aria-hidden="true"></i>
        </button>
        <!-- Navbar form (inline form) -->
        <form class="form-inline d-none d-lg-flex">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">@</span>
                </div>
                <input id="search-username" type="text" class="form-control" value="" placeholder="username" aria-label="Search for a usern and view their statistics">
                <div class="input-group-append">
                    <button id="lookup" class="btn btn-primary">Look up</button>
                </div>
            </div>

        </form>
    </ul>
    <div class="navbar-content d-lg-none ml-auto">
        <!-- d-md-none = display: none on medium screens and up (width > 768px), ml-auto = margin-left: auto -->
        <div class="dropdown with-arrow">
            <button class="btn" data-toggle="dropdown" type="button" id="navbar-dropdown-toggle-btn-1">
                Menu
                <i class="fas fa-angle-down" aria-hidden="true"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right w-300" aria-labelledby="navbar-dropdown-toggle-btn-1">
                <!-- w-200 = width: 20rem (200px) -->
                <div class="d-md-none">
                    <a href="#" class="dropdown-item">Docs</a>
                    <a href="#" class="dropdown-item">Products</a>
                    <div class="dropdown-divider"></div>
                    <button class="btn my-10" type="button" style="width: 100%;" onclick="halfmoon.toggleDarkMode()" aria-label="Toggle dark mode">
                        <i class="fas fa-moon" aria-hidden="true"></i> Toggle dark mode
                    </button>
                    <div class="dropdown-divider"></div>
                </div>
                <div class="dropdown-content">
                    <form>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">@</span>
                            </div>
                            <input id="search-username-s" type="text" class="form-control" value="" placeholder="username">
                            <div class="input-group-append">
                                <button id="lookup-s" class="btn btn-primary"><i class="fas fa-search" aria-hidden="true"></i></button>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="d-sm-none">
                    <div class="dropdown-divider"></div>
                    <span class="navbar-text ml-5 mt-10 mb-5">
                        <!-- ml-5 = margin-left: 0.5rem (5px) -->
                        <span class="badge text-monospace">v0.0.4 <span class="badge badge-danger">Alpha</span></span>
                        <!-- text-monospace = font-family shifted to monospace -->
                    </span>
                </div>
            </div>
        </div>
    </div>
</nav>