<?php

include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/autoloader.php';
include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/session.php';

?>

<!DOCTYPE html>
<html>

<head>
    <?php require $_SERVER["DOCUMENT_ROOT"] . '/resources/templates/head.php'; ?>
    <title>All Tools | Scratch Tools</title>
    <style>
        /* Sponsor section card */

        .tools-section-card {
            display: block;
            text-decoration: none;
        }

        .dark-mode .tools-section-card {
            background-color: #1e2125;
        }

        .tools-section-card:hover {
            text-decoration: none;
        }

        .tools-section-card:focus {
            text-decoration: none;
            box-shadow: 0 0 0 0.2rem rgba(24, 144, 255, 0.6);
            outline: none;
        }

        .h-120 {
            height: 12rem;
        }

        .tools-section-card-scroll-block {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 100%;
            height: 1rem;
            border-bottom-right-radius: 0.4rem;
            background-color: rgba(255, 255, 255, 0.975);
        }

        .dark-mode .tools-section-card-scroll-block {
            background-color: rgba(30, 33, 37, 0.95);
        }

        .tools-section-card,
        .tools-section-card:hover,
        .tools-section-card:focus,
        .tools-section-card:active {
            color: rgba(0, 0, 0, 0.7);
        }

        .dark-mode .tools-section-card,
        .dark-mode .tools-section-card:hover,
        .dark-mode .tools-section-card:focus,
        .dark-mode .tools-section-card:active {
            color: rgba(255, 255, 255, 0.6);
        }

        .w-60 {
            width: 6rem;
        }

        .h-60 {
            height: 6rem;
        }
    </style>
</head>

<body data-dm-shortcut-enabled="true" data-sidebar-shortcut-enabled="true" <?php include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/theme.php'; ?>>
    <?php include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/modals.php'; ?>
    <!-- Hidden navigation section id -->
    <input type="hidden" name="nav-section-id" id="nav-section-id" value="tools">
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
                <p class="font-size-24 text-center">
                    Tools
                </p>
                <p class="text-justify">
                    Here you will find all the avaible tools on Scratch Tools. Have a productive day!
            </div>
            <div class="m-20">
                <div id="utilities" name="utilities" class="card">
                    <h2 class="card-title">Utilities <a href="#utilities" class="ml-5 text-decoration-none">#</a></h2>
                    <!-- Lis of all tools on Scratch Tools -->
                    <a href="/tools/unfollowers" class="card tools-section-card w-350 mw-full m-0 p-0 d-inline-flex" rel="noopener">
                        <div class="w-100 h-100 m-10 align-self-center">
                            <!--<div class="w-100 h-100 rounded d-flex align-items-center justify-content-center" style="background-color: #5352ed;">
                        <i class="fa fa-photo fa-2x text-white" aria-hidden="true"></i>
                        <span class="sr-only">Sponsor image placeholder</span>
                    </div>-->
                            <img src="/img/unfollowers.gif" class="d-block w-100 h-100 rounded" alt="Unfollowers image.">
                        </div>
                        <div class="flex-grow-1 overflow-y-hidden d-inline-flex align-items-center position-relative h-120">
                            <div class="p-10 w-full m-auto">
                                <p class="font-size-20 text-dark-lm text-light-dm m-0 mb-5 text-truncate font-weight-medium">
                                    Who unfollowed me?
                                </p>
                                <p class="font-size-12 mt-5 mb-0">
                                    Find out who unfollowed you and deleted accounts that are no longer following you in one click!
                                    <span class="text-primary text-smoothing-auto-dm d-inline-block">Let's go! <i class="fa fa-angle-right" aria-hidden="true"></i></span>
                                </p>
                            </div>
                            <div class="tools-section-card-scroll-block"></div>
                        </div>
                    </a>
                </div>
                <div id="statistics" name="statistics" class="card">
                    <h2 class="card-title">Statistics <a href="#statistics" class="ml-5 text-decoration-none">#</a></h2>
                    <a href="/search" class="card tools-section-card w-350 mw-full m-0 p-0 d-inline-flex" rel="noopener">
                        <div class="w-100 h-100 m-10 align-self-center">
                            <img src="/img/search.png" class="d-block w-100 h-100 rounded" alt="Unfollowers image.">
                        </div>
                        <div class="flex-grow-1 overflow-y-hidden d-inline-flex align-items-center position-relative h-120">
                            <div class="p-10 w-full m-auto">
                                <p class="font-size-20 text-dark-lm text-light-dm m-0 mb-5 text-truncate font-weight-medium">
                                    Search!
                                </p>
                                <p class="font-size-12 mt-5 mb-0">
                                    Obtain statistics about users, projects, studios, and everything Scratch!
                                    <span class="text-primary text-smoothing-auto-dm d-inline-block">Let's go! <i class="fa fa-angle-right" aria-hidden="true"></i></span>
                                </p>
                            </div>
                            <div class="tools-section-card-scroll-block"></div>
                        </div>
                    </a>
                </div>
                <div id="advanced" name="advanced" class="card">
                    <h2 class="card-title">Advanced <a href="#advanced" class="ml-5 text-decoration-none">#</a></h2>
                    <i>Coming soon...</i>
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