<?php

include 'includes/autoloader.inc.php';

?>

<!DOCTYPE html>
<html>

<head>
  <?php require 'head.template.php'; ?>
  <!-- Title -->
  <title>Register | Scratch Tools</title>
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
        <h5 class="modal-title">Register an account</h5>
        <div id="register-form">
          <p id="register-text" class="text-justify">Please fill in the fields below to register. Leave the password
            fields blank if you would like to login with Scratch. <strong>Please remember to use a secure password that
              you are not using on any other site!</strong></p>
          <form id="register">
            <div class="form-group">
              <label for="username" class="required">Scratch username</label>
              <input type="text" id="username" class="form-control" placeholder="Scratch username" required="required">
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" id="password" class="form-control" placeholder="Password">
            </div>
            <div class="form-group">
              <label for="repeat-password">Repeat password</label>
              <input type="password" id="password_repeat" class="form-control" placeholder="Repeat password">
            </div>
            <input id="submit-register" class="btn btn-primary btn-block" type="submit" disabled="disabled"
              value="Register with Scratch">
          </form>
        </div>
        <div class="text-right mt-10">
          <a href="login" class="hyperlink">Login</a>
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