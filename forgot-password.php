<?php

include 'includes/autoloader.inc.php';

?>

<!DOCTYPE html>
<html>

<head>
  <?php require 'head.template.php'; ?>
  <!-- Title -->
  <title>Forgot Password | Scratch Tools</title>
</head>

<body data-dm-shortcut-enabled="true" data-sidebar-shortcut-enabled="true" <?php include 'includes/setTheme.php'; ?>>
  <!-- Page wrapper with navbar, sidebar, navbar fixed bottom, and sticky alerts (toasts) -->
  <div
    class="page-wrapper with-navbar with-navbar-fixed-bottom with-custom-webkit-scrollbars with-custom-css-scrollbars"
    data-sidebar-type="overlayed-sm-and-down">
    <!-- Sticky alerts (toasts), empty container -->
    <div class="sticky-alerts"></div>
    <!-- Navbar -->
    <?php require("./includes/header.php"); ?>
    <!-- Content wrapper -->
    <div class="content-wrapper">
      <div class="content">
        <h5 class="modal-title">Forgot your password?</h5>
        <div id="forgot-password-form">
          <p id="forgot-password-text" class="text-justify">Have you forgot your password? That's okay! To continue,
            please enter your username below:</p>
          <form id="fogot-password">
            <div class="form-group">
              <label for="username" class="required">Username</label>
              <input type="text" id="username" class="form-control" placeholder="Username" required="required">
            </div>
            <input id="submit-forgot-password" class="btn btn-primary btn-block" type="submit" disabled="disabled"
              value="Reset your password with Scratch">
          </form>
        </div>
        <div class="text-right mt-10">
          <p><a href="login" class="hyperlink">Login</a> or <a href="register" class="hyperlink">Register</a></p>
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