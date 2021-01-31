<?php

include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/autoloader.php';
include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/session.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require $_SERVER["DOCUMENT_ROOT"] . '/resources/templates/head.php'; ?>
    <!-- Title -->
    <title>Scratch Tools</title>
</head>

<body data-dm-shortcut-enabled="true" data-sidebar-shortcut-enabled="true" <?php include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/theme.php'; ?>>
    <!-- Hidden navigation section id -->
    <input type="hidden" name="nav-section-id" id="nav-section-id" value="home">
    <?php include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/modals.php'; ?>
    <!-- Page wrapper with navbar, sidebar, navbar fixed bottom, and sticky alerts (toasts) -->
    <div class="page-wrapper with-navbar with-sidebar with-navbar-fixed-bottom with-custom-webkit-scrollbars with-custom-css-scrollbars" data-sidebar-type="overlayed-sm-and-down">
        <!-- Sticky alerts (toasts), empty container -->
        <div class="sticky-alerts"></div>
        <!-- Navbar -->
        <?php require $_SERVER["DOCUMENT_ROOT"] . '/resources/templates/header.php'; ?>
        <!-- Sidebar overlay -->
        <div class="sidebar-overlay" onclick="halfmoon.toggleSidebar()"></div>
        <!-- Sidebar -->
        <?php require $_SERVER["DOCUMENT_ROOT"] . '/resources/templates/sidebar.php'; ?>
        <!-- Content wrapper -->
        <div class="content-wrapper">
            <div class="content">
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">Since you are here...</h4>
                    ...you may want to chechk out the new <a href="/dashboard" class="alert-link">dashboard</a> and explore our <a href="/tools" class="alert-link">tools</a>. Any feedback is welcome and appreciated!
                </div>
                <br>
                <div class="alert alert-primary" role="alert">
                    <h4 class="alert-heading">Heads up!</h4>
                    This section of the website is under development therefore it is currently inaccessible. If you would like to contribute, please see the <a href="https://github.com/Looky1173/Scratch-Tools" class="alert-link">GitHub repository</a> of Scratch Tools.
                </div>
                <p class="font-size-24 text-center">
                    Scratch Tools is under development.
                </p>
                <p class="text-justify">
                    Welcome to Scratch Tools! This website is dedicated to helping Scratchers as well as New Scratchers get the most out of the Scratch website. Packed with great tools and utilities, Scratch Tools is the perfect choice for beginners and advanced coders. However, since Scratch Tools has just launched, there are actually very few working features. Still, you can go ahead and explore Scratch Tools right now! If you would like to join the development team, please post a comment on my Scratch profile (link below). Thanks!
                    <br><br>
                    Should you have any questions please <a href="https://scratch.mit.edu/users/SuperScratcher_1234" class="hyperlink" target="_self">contact me on</a> Scratch. Please check back later for updates! Thank you for
                    visiting!
            </div>
        </div>
        <!-- Navbar fixed bottom -->
        <?php
        require $_SERVER["DOCUMENT_ROOT"] . '/resources/templates/footer.php';
        ?>
    </div>

</body>

</html>