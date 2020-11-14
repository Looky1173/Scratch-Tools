<?php

include 'includes/autoloader.inc.php';

?>

<!DOCTYPE html>
<html>

<head>
    <?php require 'head.template.php'; ?>
    <!-- Title -->
    <title>About | Scratch Tools</title>
</head>

<body data-dm-shortcut-enabled="true" data-sidebar-shortcut-enabled="true" <?php include 'includes/setTheme.php'; ?>>
    <!-- Page wrapper with navbar, sidebar, navbar fixed bottom, and sticky alerts (toasts) -->
    <div class="page-wrapper with-navbar with-sidebar with-navbar-fixed-bottom with-custom-webkit-scrollbars with-custom-css-scrollbars"
        data-sidebar-type="overlayed-sm-and-down">
        <!-- Sticky alerts (toasts), empty container -->
        <div class="sticky-alerts"></div>
        <!-- Navbar -->
        <?php require 'includes/header.php'; ?>
        <!-- Sidebar overlay -->
        <div class="sidebar-overlay" onclick="halfmoon.toggleSidebar()"></div>
        <!-- Sidebar -->
        <?php require 'includes/sidebar.php'; ?>
        <!-- Content wrapper -->
        <div class="content-wrapper">
        <div class="content">
                <p class="font-size-24 text-center">
                    ABOUT - Scratch Tools is under development.
                </p>
                <p class="text-justify">
                    Welcome to Scratch Tools! This website is dedicated to helping Scratchers as well as New Scratchers get the most out of the Scratch website. Packed with great tools and utilities, Scratch Tools is the perfect choice for beginners and advanced coders. However, since Scratch Tools has just launched, there are actually very few working features. Still, you can go ahead and explore Scratch Tools right now! If you would like to join the development team, please post a comment on my Scratch profile (link below). Thanks!
                    <br><br>
                    Should you have any questions please <a href="https://scratch.mit.edu/users/SuperScratcher_1234" class="hyperlink">contact me on</a> Scratch. Please check back later for updates! Thank you for
                    visiting!
            </div>
        </div>
        <!-- Navbar fixed bottom -->
        <?php
            require 'includes/footer.php';
        ?>
    </div>

</body>

</html>