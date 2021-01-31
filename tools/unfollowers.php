<?php

include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/autoloader.php';
include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/session.php';

?>

<!DOCTYPE html>
<html>

<head>
    <?php require $_SERVER["DOCUMENT_ROOT"] . '/resources/templates/head.php'; ?>
    <!-- Title -->
    <title>Scratch Tools</title>

    <script src="/js/unfollowers.js"></script>
</head>

<body data-dm-shortcut-enabled="true" data-sidebar-shortcut-enabled="true" <?php include $_SERVER["DOCUMENT_ROOT"] . '/resources/common/theme.php'; ?>>
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
                <form id="unfollowers-form">
                    <div class="form-group">
                        <label for="unfollowers-username" class="required">Scratch username</label>
                        <input type="text" id="unfollowers-username" class="form-control" placeholder="Scratch username" required="required">
                    </div>
                    <input id="submit-unfollowers" class="btn btn-primary btn-block" type="submit" value="Go!" disabled="disabled">
                </form>
                <p class="text-justify font-size-18" id="loading-status-text" style="display: none;"></p>
                <!--
                <div class="progress h-25" id="old-followers-progress-div" style="display: none;">
                    
                    <div id="old-followers-progress" class="progress-bar rounded-0 progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                </div>
                <br>
                <div class="progress h-25" id="deleted-unfollowers-progress-div">
                    <div id="deleted-unfollowers-progress" class="progress-bar rounded-0 progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                </div>-->
                <br>
                <div class="custom-checkbox unfollowers-agreement">
                    <input type="checkbox" class="agreement" id="agreement-1" value="">
                    <label for="agreement-1">I agree to use this tool responsibly and respect the feelings and thoughts of others, and I will not make anyone feel upset or have a negative reaction using the results. I understand that breaking these rules come with a penalty.</label>
                </div>
                <div class="custom-checkbox unfollowers-agreement">
                    <input type="checkbox" class="agreement" id="agreement-2" value="">
                    <label for="agreement-2">I understand that some outputs might be innacurate or incomplete. I am capable of accepting and dealing with the results.</label>
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