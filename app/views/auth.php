<!DOCTYPE html>
<html lang="en">

<?php require 'includes/header.php'; ?>

<body>

  <!-- ***** Menu bar ***** -->
  <?php require 'includes/menu.php'; ?>
  <div class="wrapper">
    <div class="reservation-form">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <form id="reservation-form" name="gs" action="<?php echo BASE_URL?>/auth/login" method="POST" enctype="multipart/form-data">
              <div class="row">
                <div class="col-lg-12">
                  <h4>Login To <em>Admin Panel</em></h4>
                </div>
                <div class="col-lg-6">
                    <fieldset>
                        <label for="email" class="form-label">email</label>
                        <input type="text" name="email" class="Name" placeholder="user@mail.com" required>
                    </fieldset>
                </div>
                <div class="col-lg-6">
                  <fieldset>
                      <label for="password" class="form-label">Password</label>
                      <input type="password" name="password" class="Number" placeholder="Password" required>
                  </fieldset>
                </div>
                <div class="col-lg-12">                        
                    <fieldset>
                        <button class="main-button">Sign In</button>
                    </fieldset>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <!-- Bootstrap core JavaScript -->
  <script src="/AREECA/vendor/jquery/jquery.min.js"></script>
  <script src="/AREECA/vendor/bootstrap/js/bootstrap.min.js"></script>

  <script src="/AREECA/public/assets/js/isotope.min.js"></script>
  <script src="/AREECA/public/assets/js/owl-carousel.js"></script>
  <script src="/AREECA/public/assets/js/wow.js"></script>
  <script src="/AREECA/public/assets/js/tabs.js"></script>
  <script src="/AREECA/public/assets/js/popup.js"></script>
  <script src="/AREECA/public/assets/js/custom.js"></script>

  <!-- ***** footer ***** -->
  <?php require 'includes/footer.php'; ?>

  </body>

</html>
