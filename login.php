<?php

include 'includes/autoloader.inc.php';

?>

<!DOCTYPE html>
<html>

<head>
    <?php require 'head.template.php'; ?>
    <!-- Title -->
    <title>Login | Scratch Tools</title>
</head>

<body data-dm-shortcut-enabled="true" data-sidebar-shortcut-enabled="true" <?php include 'includes/setTheme.php'; ?>>
    <!-- Page wrapper with navbar, sidebar, navbar fixed bottom, and sticky alerts (toasts) -->
    <div id="page-wrapper"
        class="page-wrapper with-navbar with-navbar-fixed-bottom with-custom-webkit-scrollbars with-custom-css-scrollbars"
        data-sidebar-type="overlayed-sm-and-down">
        <!-- Sticky alerts (toasts), empty container -->
        <div class="sticky-alerts"></div>
        <!-- Navbar -->
        <?php require './includes/header.php'; ?>
        <!-- Content wrapper -->
        <div class="content-wrapper">
            <div class="content">
                <h5 class="modal-title">Sign in to your account</h5>
                <div id="login-form">
                    <p id="login-text" class="text-justify">Please enter your credentials below to log in. Leave the
                        password field blank if you have not set a password during registration.</p>
                    <form id="login">
                        <div class="form-group">
                            <label for="username" class="required">Username</label>
                            <input type="text" id="username" class="form-control" placeholder="Username"
                                required="required">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" class="form-control" placeholder="Password">
                        </div>
                        <input class="btn btn-primary btn-block" type="submit" disabled="disabled" id="submit-login"
                            value="Sign in">
                    </form>
                </div>
                <div class="text-right mt-10">
                    <a href="register" class="hyperlink">Register</a>
                    <br>
                    <a href="forgot-password" class="hyperlink">Forgot password</a>
                </div>

            </div>
        </div>
        <!-- Navbar fixed bottom -->
        <?php
            require './includes/footer.php';
        ?>
    </div>

</body>

</html>