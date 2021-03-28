<?php

include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/autoloader.php';
include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/session.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require $_SERVER["DOCUMENT_ROOT"] . '/resources/templates/head.php'; ?>
    <!-- Title -->
    <title>Contact Us | Scratch Tools</title>
</head>

<body data-dm-shortcut-enabled="true" data-sidebar-shortcut-enabled="true" <?php include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/theme.php'; ?>>
    <!-- Hidden navigation section id -->
    <input type="hidden" name="nav-section-id" id="nav-section-id" value="about">
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
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Please note</h4>
                    Issues and concerns related to something inappropriate or dangerous must be reported <a href="#" class="alert-link">here</a>. We will take the necessary actions; however, we are not able to respond to these reports.
                </div>
                
            </div>
        </div>
        <!-- Navbar fixed bottom -->
        <?php
        require $_SERVER["DOCUMENT_ROOT"] . '/resources/templates/footer.php';
        ?>
    </div>

</body>

</html>