   <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <a href="index.html" class="logo">
                        <img src="/AREECA/public/assets/images/logo.png" alt="">
                    </a>
                    <!-- ***** Logo End ***** -->
                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                        <li><a href="<?php echo BASE_URL?>index">Home</a></li>
                        <li><a href="<?php echo BASE_URL?>home/events">Events/Workshops</a></li>
                        <li><a href="<?php echo BASE_URL?>map/index">Map Viewer</a></li>
                        <?php if (isset($_SESSION['auth_token'])): ?><li><a href="<?php echo BASE_URL?>dashboard/index">Dashboard</a></li><?php endif ?>
                        <li><a href="<?php echo BASE_URL?>home/documents">Document/Information</a></li>
                        <li><a href="<?php echo BASE_URL?>home/contact">Contact</a></li>
                        <?php if (!isset($_SESSION['auth_token'])): ?><li><a href="<?php echo BASE_URL?>auth/signInForm">Sign In</a></li><?php endif ?>
                        <?php if (isset($_SESSION['auth_token'])): ?><li><a href="<?php echo BASE_URL?>auth/signout">Sign Out</a></li><?php endif ?>
                    </ul>   
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
  </header>
  <script>
  // Get the current URL path
  var currentUrl = window.location.href;

  // Select all navigation links
  var navLinks = document.querySelectorAll('.nav a');

  // Loop through each navigation link
  navLinks.forEach(function(link) {
    // Check if the link's href is part of the current URL
    if (currentUrl.includes(link.href)) {
      // Add the 'active' class to the matching link
      link.classList.add('active');
    }
  });
</script>
  <!-- ***** Header Area End ***** -->
