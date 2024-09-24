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
          <div class="section-heading text-center">
            <h1>Contact Us</h1>
            <hr>
            <div class="col-lg-12">
              <div class="address-container">
                  <div class="address-image">
                      <img src=" <?php echo(BASE_IMAGE_URL."home.png"); ?>" alt="Address Image">
                  </div>
                  <div class="address-details">
                      <h4>Head Office</h4>
                      <p>Director<br>Department of Forestry<br>Nkhalango house<br>PO box 30048<br>Lilongwe-3, Malawi</p>
                  </div>
              </div>
            </div>
          </div>
          <div class="col-lg-12">
          <form id="reservation-form" action="<?php echo BASE_URL?>home/message" method="POST" enctype="multipart/form-data">
            <div class="row">
              <div class="col-lg-6">
                  <div class="form-group">
                      <label for="password" class="form-label">Your Name</label>
                      <input type="text" class="form-control" name="name" class="Name" required>
                  </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" class="Name" required>
                    </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-group">
                      <label for="message" class="form-label">Your Message</label>
                      <textarea class="form-control" name="message" rows="10" required></textarea>
                  </div>
                </div>
                <div class="col-lg-12">                        
                    <div>
                        <button class="main-button">Send</button>
                    </div>
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