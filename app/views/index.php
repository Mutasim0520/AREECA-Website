<!DOCTYPE html>
<html lang="en">

<?php require 'includes/header.php'; ?>

<style>
  <?php 
      foreach($doms as $item){
        if($item['dom_id'] == 'index-page-main-slider'){
          $i=1;
          foreach($item['images'] as $image){ ?>
            .section-1 .content-slider #banner<?php echo $i; ?>:checked ~ .slider #top-banner-<?php echo $i; ?>
            {
              opacity: 1;
              z-index:1;
            }
            <?php $i++;?>
    <?php }}}?> 
</style>

<body>

  <!-- ***** Menu bar ***** -->
  <?php require 'includes/menu.php'; ?>

  <!-- ***** Main Banner Area Start ***** -->
  <section class="section-1" id="index-page-main-slider">
    <div class="content-slider">
      <?php 
        $image_counter = 1;
        foreach($doms as $item):
          if($item['dom_id'] == 'index-page-main-slider'):
            foreach($item['images'] as $image): ?>
              <input type="radio" id="<?php echo 'banner' . $image_counter; ?>" class="sec-1-input" name="banner" <?php echo $image_counter === 1 ? 'checked' : ''; ?>>
              <?php 
              $image_counter++;
            endforeach;
          endif;
        endforeach; 
      ?>
      <div class="slider">
        <?php 
          $image_counter = 1; 
          foreach($doms as $item):
            if($item['dom_id'] == 'index-page-main-slider'):
              foreach($item['images'] as $image): ?>
                <div id="<?php echo 'top-banner-' . $image_counter; ?>" class="banner" 
                    style="background-image: url('<?php echo BASE_IMAGE_URL . 'doms/' . $image; ?>'); background-size: cover; background-position: center center;"></div>
                <?php 
                $image_counter++;
              endforeach;
            endif;
          endforeach; 
        ?>
      </div>
    </div>
  </section>



  <!-- ***** Main Banner Area End ***** -->
   
  <div class="wrapper">
    <div class="visit-country">
      <div class="container">
        <div class="row" id="index-page-content-1">
          <div class="section-heading text-center">
            <h1>HEADING TO PUT</h1>
          </div>
          <div class="col-lg-12">
            <p style="text-align:justify">The World Bank as one of the partners of the IKI programme has supported the updation of national FLR strategy in Malawi through a comprehensive analytical approach--multicriteria based degradation mapping, drone mapping of degradation hotspots, National FLR opportunity assessment and stocktaking, knowledge sharing--to scale up FLR by unlocking technical, economic, financial, social and environmental challenges to alleviate affects of climate change and biodiversity loss. The activities facilitated by the Bank under AREECA intended to highlight landscape investment of ongoing landscape projects and to enable new operations/initiatives to make better informed decisions and planning of future projects. Additionally, it is also supporting to country’s (Malawi) COP 28 commitment of restoring 4.5 million ha area with GIS based evidence.
                This website is designed to disseminate project outcomes, reports, GIS data from stocktaking and opportunity database as well as some highlights of events hosted during the programme.
            </p>
          </div>
        </div>
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
                    $arr = [1, 2, 3, 4];  // Array of logos
                    
                    foreach($arr as $item):
                        $image_url = BASE_IMAGE_URL . 'partners/' . $item . '.png';
                ?>
                <div class="logo-container">
                    <img src="<?php echo($image_url); ?>" class="partner-logo" />
                </div>
                <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="call-to-action">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h2></h2>
          <h4>Make A Reservation By Clicking The Button</h4>
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