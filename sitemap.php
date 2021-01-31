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
                <h1 class="content-title font-size-24">
                    Sitemap
                </h1>
                <p>This sitemap contains an index of all pages of Scratch Tools.</p>
            </div>
            <div class="card">
                <h2 class="card-title">
                    Main pages
                </h2>
                <a href="/">Home</a> - the landing page of Scratch Tools that is displayed by default
                <br>
                <a href="/about">About</a> - information and background story of Scratch Tools
                <br>
                <a href="/dashboard">Dashboard</a> - the panel where users can manage their accounts and access features and tools like <i>Scratch Tools Collaborations</i>
                <br>
                <a href="/documentation">Documentation</a> - detailed descriptions and explanations on how to use certain features of Scratch Tools
                <br>
                <a href="/contact">Contact</a> - the page where new features can be suggested and the Scratch Tools team can be contacted for assistance
                <br>
                <a href="/sitemap">Sitemap</a> - this page; a list of pages of Scratch Tools, each with a brief explanation

            </div>
            <div class="card">
                <h2 class="card-title">
                    Tools & Utilities
                </h2>
                <a href="/tools/all">Tools</a> - the list of all tools on Scratch Tools grouped by the categories <i>Utilities</i>, <i>Statistics</i>, and <i>Advanced</i>
                <br>
                <a href="/tools/utilities">Utilities</a> - tools in the <i>Utilities</i> section; common easy to use tools
                <div class="card bg-dark-light">
                    <h3 class="card-title font-size-16">
                        Tools -> Utilities
                    </h3>
                    <a href="/tools/all">Unfollowers</a> - ontain a list of users who have unfollowed you (both deleted and active users)
                    <br>
                    <a href="/tools/utilities">Unshared project viewer</a> - see and edit unshared projects

                </div>
                <br>
                <a href="/tools/statistics">Statistics</a> - tools in the <i>Statistics</i> section; tools to obtain statistics
                <br>
                <a href="/tools/advanced">Advanced</a> - tools in the <i>Advanced</i> section; recommended for experienced users

            </div>
        </div>
        <!-- Navbar fixed bottom -->
        <?php
        require $_SERVER["DOCUMENT_ROOT"] . '/resources/templates/footer.php';
        ?>
    </div>

</body>

</html>