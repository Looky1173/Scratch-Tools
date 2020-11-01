<?php

//Initialize the session
session_start();

function url(){
    return sprintf(
      "%s://%s%s",
      isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
      $_SERVER['SERVER_NAME'],
      $_SERVER['REQUEST_URI']
    );
  }  

$nav = array(
'Home'  => 'index',
'About'   => 'about',
'Documentation' => 'documentation',
);
?>

<nav class="navbar">
    <!-- Toggle sidebar -->
    <button id="toggle-sidebar-btn" class="btn btn-action" type="button" onclick="halfmoon.toggleSidebar()">
        <i class="fa fa-bars" aria-hidden="true"></i>
    </button>
    <!-- Navbar brand -->
    <a href="#" class="navbar-brand">
        <p>Scratch Tools</p>
    </a>
    <!-- Navbar text -->
    <span class="navbar-text ml-5">
        <!-- ml-5 = margin-left: 0.5rem (5px) -->
        <span class="badge text-monospace">v0.0.1 <span class="badge badge-danger">Alpha</span></span>
        <!-- text-monospace = font-family shifted to monospace -->
    </span>
    <!-- Navbar nav -->
    <ul class="navbar-nav ml-auto">
        <!-- ml-auto = margin-left: auto -->
        <?php

        foreach($nav as $nav_title => $nav_link)
        {
            echo '<li class="nav-item'.($nav_link == basename($_SERVER['PHP_SELF']) ? ' active"':'"').'><a href="http://localhost/st/'.$nav_link.'" class="nav-link">'.$nav_title.'</a></li>';
        }

        ?>
        <!--
        <li class="nav-item active">
            <a href="https://localhost/st" class="nav-link">Home</a>
        </li>
        <li class="nav-item">
            <a href="https://localhost/st/about" class="nav-link">About</a>
        </li>
        <li class="nav-item">
            <a href="/st/documentation" class="nav-link">Documentation</a>
        </li>
        -->
        <li class="nav-item dropdown with-arrow">
            <a class="nav-link" data-toggle="dropdown" id="nav-link-dropdown-toggle">
                Tools
                <i class="fa fa-angle-down ml-5" aria-hidden="true"></i>
                <!-- ml-5= margin-left: 0.5rem (5px) -->
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="nav-link-dropdown-toggle">
                <a href="<?php $_SERVER['SERVER_NAME'] ?>/tools/utilities" class="dropdown-item">Utilities</a>
                <a href="<?php $_SERVER['SERVER_NAME'] ?>/tools/statistics" class="dropdown-item">Statistics</a>
                <a href="<?php $_SERVER['SERVER_NAME'] ?>/tools/advanced" class="dropdown-item">
                    Advanced
                    <strong class="badge badge-primary float-right">Soon</strong>
                    <!-- float-right = float: right -->
                </a>
                <div class="dropdown-divider"></div>
                <div class="dropdown-content">
                    <a href="<?php $_SERVER['SERVER_NAME'] ?>/tools/all" class="btn btn-block" role="button">
                        See all tools
                        <i class="fa fa-angle-right ml-5" aria-hidden="true"></i>
                        <!-- ml-5= margin-left: 0.5rem (5px) -->
                    </a>
                </div>
            </div>
        </li>
        <!-- Toggle dark mode -->
        <button class="btn btn-action mr-5" type="button" onclick="halfmoon.toggleDarkMode()"
            aria-label="Toggle dark mode">
            <i class="fa fa-moon-o" aria-hidden="true"></i>
        </button>
        <!-- Navbar form (inline form) -->
        <form action="..." method="..." class="form-inline">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">@</span>
                </div>
                <input type="text" class="form-control" value="username">
                <div class="input-group-append">
                    <button class="btn btn-primary">Look up</button>
                </div>
            </div>

        </form>
        <!--<div class="contribute" onclick="alert()">Contribute</div>-->
    </ul>
</nav>