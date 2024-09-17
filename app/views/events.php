<!DOCTYPE html>
<html lang="en">

<?php require 'includes/header.php'; ?>

<body>

  <!-- ***** Menu bar ***** -->
  <?php require 'includes/menu.php'; ?>
  
  <div class="wrapper">
    <div class="visit-country">
    <div class="container">
    <?php foreach($text_dom_sections as $section): ?>
      <div class="row" id="event-page-main-text-section" style="margin-bottom:50px;">
        <div class="col-lg-12">
          <div class="section-heading text-center">
            <h1><?php echo $section['dom_header']; ?></h1>
            <hr>
            <p><?php echo $section['dom_text']; ?></p>
          </div>
        </div>
      </div>

<?php endforeach;?>
      
    </div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="owl-weekly-offers owl-carousel">
            <?php foreach($events as $event): 
              $file_path = 'events/'.$event['images'][0];
              ?>
              <div class="item">
                <div class="thumb">
                  <div class="event-image-container"><img src="<?php echo(BASE_IMAGE_URL).$file_path ?>" alt=""></div>
                  <div class="text">
                    <h4><?php echo($event['name']); ?></h4>
                    
                    <div class="line-dec"></div>
                    <ul>
                     
                      <li><?php echo($event['intro']); ?></li>
                    </ul>
                    <div class="main-button">
                      <a href="<?php echo(BASE_URL).'home/viewEvent/'.$event['id']?>">Read More</a>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="call-to-action">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h2>Are You Looking To Travel ?</h2>
          <h4>Make A Reservation By Clicking The Button</h4>
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
