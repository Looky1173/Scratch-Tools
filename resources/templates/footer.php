<nav class="navbar navbar-fixed-bottom">
  <div class="container-fluid d-none d-md-flex">
    <!-- Second switch (checked by default) -->
    <div class="custom-switch">
      <input type="checkbox" id="animations" value="" disabled="disabled">
      <label for="animations">Animations</label>
    </div>
    <ul class="navbar-nav ml-auto">
      <!-- ml-auto = margin-left: auto -->
      <li class="nav-item">
        <a href="contact" class="nav-link">Contact</a>
      </li>
      <li class="nav-item">
        <a href="https://trello.com/b/t3yX5EH4" target="_blank" class="nav-link" rel="noopener">Development roadmap</a>
      </li>
    </ul>
    <!-- Navbar text -->
    <span class="navbar-text">
      &copy; <?php echo date("Y"); ?> - Scratch Tools, All rights reserved
    </span>
  </div>
  <div class="container-fluid hidden-md-and-up d-flex justify-content-center">
    <div class="dropdown dropup with-arrow">
      <button class="btn" data-toggle="dropdown" type="button" id="navbar-dropdown-toggle-btn-1">
        More
        <i class="fa fa-angle-up" aria-hidden="true"></i>
      </button>
      <div class="dropdown-menu" aria-labelledby="navbar-dropdown-toggle-btn-1">
        <!-- w-200 = width: 20rem (200px) -->
        <div class="d-md-none">
          <a href="contact" class="dropdown-item">Contact</a>
          <a href="https://trello.com/b/t3yX5EH4" target="_blank" class="dropdown-item" rel="noopener">Development roadmap</a>
          <div class="dropdown-divider"></div>
          <!-- Second switch (checked by default) -->
          <div class="custom-switch my-10">
            <input type="checkbox" id="animations-s" value="" disabled="disabled">
            <label for="animations-s">Animations</label>
          </div>
        </div>
      </div>
    </div>
    <span class="navbar-text">
      &copy; <?php echo date("Y"); ?> - Scratch Tools, All rights reserved
    </span>
  </div>
</nav>

<!-- Requires halfmoon.js for toggling sidebar, and toasts -->
<script src="/js/halfmoon.min.js"></script>
<!-- Include file to handle actions on the site -->
<script src="/js/forms.js"></script>
<!-- Include file to handle external links and the corresponding popup on the site -->
<script src="/js/external.js"></script>
<!-- Include script to handle the toggling of animations -->
<script src="/js/animations.js"></script>
<!-- Include script to find and mark as active the current navigation section -->
<script src="/js/find-active-nav.js"></script>
<!-- Include script to lookup users -->
<script src="/js/lookup.js"></script>