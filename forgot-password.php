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
  <title>Forgot Password | Scratch Tools</title>

  <!-- Halfmoon CSS -->
  <link href="css/halfmoon.min.css" rel="stylesheet" />
  <link href="css/page-transition.css" rel="stylesheet" />

  <!-- Font awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body data-dm-shortcut-enabled="true" data-sidebar-shortcut-enabled="true">
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
            require("./includes/footer.php");
        ?>
  </div>

  <!-- Requires halfmoon.js for toggling sidebar, and toasts -->
  <script src="js/halfmoon.min.js"></script>

  <script src="/st/includes/handle-form-submission.inc.js"></script>
</body>

</html>