<!DOCTYPE html>
<html lang="en">

<?php require 'includes/header.php'; ?>

<style>
  <?php 
      $i=1;
      foreach($main_slider as $item){
          foreach($item['images'] as $image){ ?>
            .section-1 .content-slider #banner<?php echo $i; ?>:checked ~ .slider #top-banner-<?php echo $i; ?>
            {
              opacity: 1;
              z-index:1;
            }
            <?php $i++;?>
    <?php }}?> 
</style>

<body>

  <!-- ***** Menu bar ***** -->
  <?php require 'includes/menu.php'; ?>

  <!-- ***** Main Banner Area Start ***** -->
  <section class="section-1" id="index-page-main-slider">
    <div class="content-slider">
      <?php 
        $image_counter = 1;
        foreach($main_slider as $item):
            foreach($item['images'] as $image): ?>
              <input type="radio" id="<?php echo 'banner' . $image_counter; ?>" class="sec-1-input" name="banner" <?php echo $image_counter === 1 ? 'checked' : ''; ?>>
              <?php 
              $image_counter++;
            endforeach;
        endforeach; 
      ?>
      <div class="slider">
        <?php 
          $image_counter = 1; 
          foreach($main_slider as $item):
              foreach($item['images'] as $image): ?>
                <div id="<?php echo 'top-banner-' . $image_counter; ?>" class="banner" 
                    style="background-size: cover; background-position: center center; object-fit:cover; max-height:85vh;">
                  <img src="<?php echo BASE_IMAGE_URL . 'doms/' . $image['file_name'];?>">
                </div>
                <?php 
                $image_counter++;
              endforeach;
          endforeach; 
        ?>
      </div>
    </div>
  </section>



  <!-- ***** Main Banner Area End ***** -->
   
  <div class="wrapper">
    <div class="visit-country">
      <div class="container">
        <?php foreach($text_dom_sections as $section): ?>

        <div class="row" style="margin-bottom:80px;">
          <div class="section-heading text-center">
            <h1><?php echo $section['dom_header']; ?></h1>
          </div>
          <div class="col-lg-12">
            <p style="text-align:justify">
              <?php echo (str_replace(["\r\n", "\n"], '<br><br>', $section['dom_text'])); ?>
            </p>
          </div>
        </div>

        <?php endforeach;?>
      </div>
      <br></br><br></br>
      <div class="container">
        <div class="row" id="index-page-partners" style="box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.15); padding:20px;background-color:#f6fff6;">
          <div class="section-heading text-center">
            <h1>P A R T N E R S</h1>
            <hr>
          </div>
          <div class="col-lg-12">
            <div class="logo-wrapper">
                <?php 
                    foreach($partner_dom_section as $dom):
                      foreach($dom['images'] as $item):
                        $image_url = BASE_IMAGE_URL . 'doms/' . $item['file_name'];?>
                        <div class="logo-container">
                            <img src="<?php echo($image_url); ?>" class="partner-logo" />
                        </div>
                      <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
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

  <script>
    function bannerSwitcher() {
      var current = $('.sec-1-input:checked');
      var next = current.next('.sec-1-input');
      
      if (next.length) {
        next.prop('checked', true); 
        console.log(current); // Move to the next banner
      } else {
        $('.sec-1-input').first().prop('checked', true);  // Loop back to the first banner
      }
    }

    var bannerTimer = setInterval(bannerSwitcher, 5000);

    $('nav .controls label').click(function() {
      clearInterval(bannerTimer);
      bannerTimer = setInterval(bannerSwitcher, 5000);
    });
  </script>

  </body>

</html>