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
    <title>RBAC | Scratch Tools Dashboard</title>
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
                                My account
                            </h1>
                            <p>You can make advanced changes to your account here.</p>
                        </div>
                        <div class="card">
                            <h2 class="card-title">
                                Delete account
                            </h2>
                            <p><b>Warning:</b> This will delete your account and all information associated with it permanently. This action cannot be undone!</p>
                            <button id="delete-account" class="btn btn-danger btn-block" type="button" disabled="disabled">Delete my account</button>
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