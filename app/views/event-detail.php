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
        <div class="container">
          <div class="row" style="box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.15); padding-bottom:30px; background-color:#f6fff6;">
            <div class="section-heading text-center">
              <h1><?php echo($event[0]['name']);?></h1>
            </div>
            <div class="col-lg-6">
              <p style="text-align:justify"><?php echo($event[0]['description']);?></p>
            </div>
            <div class="col-lg-6" style="margin-top:8px;">
              <section id="section-1" style="min-height:45vh; object-fit:cover;">
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
                      <div id="<?php echo'top-banner-'. $image_counter;?>" class="banner" style="background-image: url('<?php echo BASE_IMAGE_URL.'events/' . $image; ?>');"></div>
                      <?php $image_counter++ ; ?>
                    <?php endforeach; ?>
                  </div>
                </div>
              </section>
            </div>
          </div>

          <br>
          <div class="row">
            <div class="col-lg-12">
              <div class="section-heading text-center">
                <h1>Other Events</h1>
                <hr>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="owl-weekly-urls owl-carousel">
                <?php foreach($events as $item): 
                  $file_path = BASE_IMAGE_URL.'events/'.$item['images'][0];
                  $event_url = BASE_URL.'home/viewEvent/'.$item['id'];
                  ?>
                  <div class="item">
                    <div class="thumb">
                      <div class="event-image-container" style="width: 100%; height: 22vh; overflow: hidden; position: relative;text-align:center; font-size: larger; font-weight: 500;">
                        <a href="<?php echo($event_url); ?>" target="_blank" rel="noopener noreferrer">
                          <img src="<?php echo($file_path)?>" alt="" style="object-fit:cover; height:100%; width:100%"> 
                        </a>
                      </div>
                    </div>
                    <h5 style="text-align:center; margin-top:5px;"><?php echo($item['name']); ?></h5>
                  </div>
                <?php endforeach ?>
              </div>
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
