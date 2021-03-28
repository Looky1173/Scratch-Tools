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
    <style>
        .progress-custom {
            position: fixed;
            height: 7.5px;
            display: block;
            width: 100%;
            background-color: var(--gray-color-light);
            /*border-radius: 2px;*/
            /*margin: .5rem 0 1rem 0;*/
            overflow: hidden
        }

        .progress-custom .indeterminate {
            background-color: var(--primary-color);
        }

        .progress-custom .indeterminate:before {
            content: '';
            position: absolute;
            background-color: inherit;
            top: 0;
            left: 0;
            bottom: 0;
            will-change: left, right;
            -webkit-animation: indeterminate 2.1s cubic-bezier(0.65, 0.815, 0.735, 0.395) infinite;
            animation: indeterminate 2.1s cubic-bezier(0.65, 0.815, 0.735, 0.395) infinite
        }

        .progress-custom .indeterminate:after {
            content: '';
            position: absolute;
            background-color: inherit;
            top: 0;
            left: 0;
            bottom: 0;
            will-change: left, right;
            -webkit-animation: indeterminate-short 2.1s cubic-bezier(0.165, 0.84, 0.44, 1) infinite;
            animation: indeterminate-short 2.1s cubic-bezier(0.165, 0.84, 0.44, 1) infinite;
            -webkit-animation-delay: 1.15s;
            animation-delay: 1.15s
        }

        @-webkit-keyframes indeterminate {
            0% {
                left: -35%;
                right: 100%
            }

            60% {
                left: 100%;
                right: -90%
            }

            100% {
                left: 100%;
                right: -90%
            }
        }

        @keyframes indeterminate {
            0% {
                left: -35%;
                right: 100%
            }

            60% {
                left: 100%;
                right: -90%
            }

            100% {
                left: 100%;
                right: -90%
            }
        }

        @-webkit-keyframes indeterminate-short {
            0% {
                left: -200%;
                right: 100%
            }

            60% {
                left: 107%;
                right: -8%
            }

            100% {
                left: 107%;
                right: -8%
            }
        }

        @keyframes indeterminate-short {
            0% {
                left: -200%;
                right: 100%
            }

            60% {
                left: 107%;
                right: -8%
            }

            100% {
                left: 107%;
                right: -8%
            }
        }

        #search-banner {
            font-size: 7.5rem !important;
            transition: 0.6s;
            background: none;
        }

        #search-banner:hover {
            font-size: 8rem !important;
            transform: skew(-10deg);
            -webkit-transform: skew(-10deg);
            background: rgb(255, 152, 0);
            background: linear-gradient(90deg, rgba(255, 152, 0, 1) 0%, rgba(255, 193, 7, 1) 50%, rgba(255, 235, 59, 1) 100%);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>

<body data-dm-shortcut-enabled="true" data-sidebar-shortcut-enabled="true" <?php include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/theme.php'; ?>>
    <!-- Hidden navigation section id -->
    <input type="hidden" name="nav-section-id" id="nav-section-id" value="search">
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
            <?php
            if (!isset($_GET['type'])) {
                // Type not set
                $type = null;
            } else {
                if (!empty($_GET['type'])) {
                    // Type provided
                    $type = $_GET['type'];
                } else {
                    // Empty type
                    $type = null;
                }
            }
            if (!isset($_GET['data'])) {
                // Data not set
                $data = null;
            } else {
                if (!empty($_GET['data'])) {
                    // Data provided
                    $data = $_GET['data'];
                } else {
                    // Empty data
                    $data = null;
                }
            }
            ?>
            <div id="search-loader" class="progress-custom">
                <div class="indeterminate"></div>
            </div>
            <div id="main-area">
                <?php
                switch ($type) {
                    case 'users':
                        include $_SERVER["DOCUMENT_ROOT"] . '/resources/templates/search/user.html';
                        break;
                    case 'studios':
                        include $_SERVER["DOCUMENT_ROOT"] . '/resources/templates/search/studio.html';
                        break;
                    case 'projects':
                        include $_SERVER["DOCUMENT_ROOT"] . '/resources/templates/search/project.html';
                        break;
                    case 'forums':
                        include $_SERVER["DOCUMENT_ROOT"] . '/resources/templates/search/topic.html';
                        break;
                    case 'posts':
                        include $_SERVER["DOCUMENT_ROOT"] . '/resources/templates/search/post.html';
                        break;
                    default:
                        include $_SERVER["DOCUMENT_ROOT"] . '/resources/templates/search/search.html';
                        break;
                }

                ?>

            </div>
        </div>
        <!-- Navbar fixed bottom -->
        <?php
        require $_SERVER["DOCUMENT_ROOT"] . '/resources/templates/footer.php';
        ?>
    </div>


    <script defer src="/js/search/search.js"></script>

</body>

</html>