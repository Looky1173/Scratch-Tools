<nav class="navbar">
    <div class="navbar-content">
        <button id="toggle-sidebar-btn" class="btn btn-action" type="button" onclick="halfmoon.toggleSidebar()">
            <i class="fas fa-bars" aria-hidden="true"></i>
        </button>
    </div>
    <a href="/dashboard" class="navbar-brand ml-10 ml-sm-20">
        <img src="/img/scratchtools_light.png" class="hidden-dm" alt="scratchtools-logo">
        <img src="/img/scratchtools_dark.png" class="hidden-lm" alt="scratchtools-logo">
        <span class="d-none d-sm-flex">Dashboard</span>
    </a>
    <div class="navbar-content ml-auto">
        <button class="btn btn-action mr-5" type="button" onclick="halfmoon.toggleDarkMode()">
            <i class="fas fa-moon" aria-hidden="true"></i>
            <span class="sr-only">Toggle dark mode</span>
        </button>
        <a href="#arc" class="btn btn-primary" role="button">Help Scratch Tools continue for FREE!</a>
    </div>
</nav>