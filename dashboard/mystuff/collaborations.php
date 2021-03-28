<?php

include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/autoloader.php';
include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/session.php';

$perm = new Permissions($db);

?>

<!DOCTYPE html>
<html>

<head>
    <?php require $_SERVER["DOCUMENT_ROOT"] . '/resources/templates/head.php'; ?>
    <!-- Title -->
    <title>Collaborations | Scratch Tools Dashboard</title>
</head>

<body data-dm-shortcut-enabled="true" data-sidebar-shortcut-enabled="true" <?php include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/theme.php'; ?>>
    <?php include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/modals.php'; ?>
    <!-- Page wrapper start -->
    <div id="page-wrapper" class="page-wrapper with-navbar with-sidebar with-transitions with-custom-webkit-scrollbars with-custom-css-scrollbars" data-sidebar-type="full-height">

        <!-- Sticky alerts -->
        <div class="sticky-alerts"></div>

        <!-- Navbar start -->
        <?php include $_SERVER["DOCUMENT_ROOT"] . '/resources/templates/dashboard/navbar.php'; ?>
        <!-- Navbar end -->

        <!-- Sidebar overlay -->
        <div class="sidebar-overlay" onclick="halfmoon.toggleSidebar()"></div>

        <!-- Sidebar start -->
        <?php include $_SERVER["DOCUMENT_ROOT"] . '/resources/templates/dashboard/sidebar.php'; ?>
        <!-- Sidebar end -->

        <!-- Content wrapper start -->
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row row-eq-spacing-lg">
                    <div class="col-lg-9">
                        <div class="content">
                            <h1 class="content-title">
                                Collaborations
                            </h1>
                            <p></p>
                        </div>
                        <br>
                        <div class="alert alert-primary" role="alert">
                            <h4 class="alert-heading">Heads up!</h4>
                            This section of the website is under development therefore it is currently inaccessible. If you would like to contribute, please see the <a href="https://github.com/Looky1173/Scratch-Tools" class="alert-link">GitHub repository</a> of Scratch Tools.
                        </div>
                    </div>
                    <div class="col-lg-3 d-none d-lg-block">
                        <div class="content">
                            <h2 class="content-title font-size-20">
                                Feedback
                            </h2>
                            <a href="#feedback" class="btn btn-primary" role="button">Give feedback</a>
                            <br>
                            <br>
                            <!-- Tip start -->
                            <?php include $_SERVER["DOCUMENT_ROOT"] . '/resources/templates/dashboard/tip.php'; ?>
                            <!-- Tip end -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Custom footer start -->
            <?php include $_SERVER["DOCUMENT_ROOT"] . '/resources/templates/dashboard/footer.php'; ?>
            <!-- Custom footer end -->
        </div>
        <!-- Content wrapper end -->
    </div>
    <!-- Page wrapper end -->

</body>

</html>