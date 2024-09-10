<!DOCTYPE html>
<html lang="en">

<?php require 'includes/header.php'; ?>

<body>

  <!-- ***** Menu bar ***** -->
  <?php require 'includes/menu.php'; ?>

  <!-- ***** Main Banner Area Start ***** -->
  
  <!-- ***** Main Banner Area End ***** -->
  
    <div class="wrapper">
      <div class="visit-country">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-4">
              <div class="col-lg-12">
                <h2><?php echo($event[0]['name']);?></h2>
              </div>
              <div class="col-lg-12">
                <p style="text-align:justify"><?php echo($event[0]['description']);?></p>
              </div>
            </div>
            <div class="col-lg-8">
            
              <section id="section-1">
                <div class="content-slider">
                  <?php 
                    $image_counter = 1 ;
                    foreach($event[0]['images'] as $image):
                      if($image_counter == 1): ?>
                        <input type="radio" id="<?php echo'banner'. $image_counter;?>" class="sec-1-input" name="banner" checked>
                        <?php else: ?>
                          <input type="radio" id="<?php echo'banner'. $image_counter;?>" class="sec-1-input" name="banner">
                      <?php endif;
                      $image_counter++ ; ?>
                    <?php endforeach; ?>
                  <div class="slider">
                  <?php 
                    $image_counter = 1 ;
                    foreach($event[0]['images'] as $image):?>
                      <div id="<?php echo'top-banner-'. $image_counter;?>" class="banner" style="background-image: url('<?php echo BASE_IMAGE_URL.'events/' . $image; ?>');">

                      </div>
                      <?php $image_counter++ ; ?>
                    <?php endforeach; ?>
                  </div>
                </div>
              </section>
          
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php require 'includes/footer.php'; ?>

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


  <script>
    function bannerSwitcher() {
      next = $('.sec-1-input').filter(':checked').next('.sec-1-input');
      if (next.length) next.prop('checked', true);
      else $('.sec-1-input').first().prop('checked', true);
    }

    var bannerTimer = setInterval(bannerSwitcher, 5000);

    $('nav .controls label').click(function() {
      clearInterval(bannerTimer);
      bannerTimer = setInterval(bannerSwitcher, 5000)
    });
  </script>

  </body>

</html>
