<?php

include 'includes/autoloader.inc.php';

?>

<!DOCTYPE html>
<html>

<head>
    <!-- Meta tags -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
    <meta name="viewport" content="width=device-width" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-175740416-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-175740416-1');
    </script>

    <!-- Favicon and title -->
    <link rel="icon" href="/st/assets/img/scratch-cat-transparent-background.gif">
    <title>Scratch Tools</title>

    <!-- Halfmoon CSS -->
    <link href="css/halfmoon.min.css" rel="stylesheet" />
    <link href="css/page-transition.css" rel="stylesheet" />

    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body data-dm-shortcut-enabled="true" data-sidebar-shortcut-enabled="true">
    <!-- Page wrapper with navbar, sidebar, navbar fixed bottom, and sticky alerts (toasts) -->
    <div class="page-wrapper with-navbar with-sidebar with-navbar-fixed-bottom with-custom-webkit-scrollbars with-custom-css-scrollbars"
        data-sidebar-type="overlayed-sm-and-down">
        <!-- Sticky alerts (toasts), empty container -->
        <div class="sticky-alerts"></div>
        <!-- Navbar -->
        <?php require("./includes/header.php"); ?>
        <!-- Sidebar overlay -->
        <div class="sidebar-overlay" onclick="halfmoon.toggleSidebar()"></div>
        <!-- Sidebar -->
        <?php require("./includes/sidebar.php"); ?>
        <!-- Content wrapper -->
        <div class="content-wrapper">
            <div class="content">
                <p class="font-size-24 text-center">
                    Coming Soon
                </p>
                <p class="text-justify">
                    Scratch Tools is under development. Currently, none of the links are functional on this website.
                    Should you have any questions please <a href="https://scratch.mit.edu/users/SuperScratcher_1234"
                        class="hyperlink">contact me on</a> Scratch. Please check back later for updates! Thank you for
                    visiting!

                    <?php
                    $testReg = new HandleUsers;
                    $testReg->register("username", "nickname", "password", 1, "2020-12-31 12:00:00", "2020-12-31 12:00:00", "normal");
                    ?>
                    
            </div>
        </div>
        <!-- Navbar fixed bottom -->
        <?php
            require("./includes/footer.php");
        ?>
    </div>

    <!-- Requires halfmoon.js for toggling sidebar, and toasts -->
    <script src="js/halfmoon.min.js"></script>
</body>

</html>