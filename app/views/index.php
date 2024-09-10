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
              <h2>HEADING TO PUT</h2>
            </div>
            <div class="col-lg-12">
              <p style="text-align:justify">The World Bank as one of the partners of the IKI programme has supported the updation of national FLR strategy in Malawi through a comprehensive analytical approach--multicriteria based degradation mapping, drone mapping of degradation hotspots, National FLR opportunity assessment and stocktaking, knowledge sharing--to scale up FLR by unlocking technical, economic, financial, social and environmental challenges to alleviate affects of climate change and biodiversity loss. The activities facilitated by the Bank under AREECA intended to highlight landscape investment of ongoing landscape projects and to enable new operations/initiatives to make better informed decisions and planning of future projects. Additionally, it is also supporting to country’s (Malawi) COP 28 commitment of restoring 4.5 million ha area with GIS based evidence.
  This website is designed to disseminate project outcomes, reports, GIS data from stocktaking and opportunity database as well as some highlights of events hosted during the programme.
              </p>
            </div>
          </div>
          <div class="col-lg-8">
          
            <section id="section-1">
              <div class="content-slider">
                <input type="radio" id="banner1" class="sec-1-input" name="banner" checked>
                <input type="radio" id="banner2" class="sec-1-input" name="banner">
                <input type="radio" id="banner3" class="sec-1-input" name="banner">
                <input type="radio" id="banner4" class="sec-1-input" name="banner">
                <div class="slider">
                  <div id="top-banner-1" class="banner">
                    <div class="banner-inner-wrapper header-text">
                      <div class="main-caption">
                        <h2>Take a Glimpse Into The Beautiful Country Of:</h2>
                        <h1>Caribbean</h1>
                        
                      </div>
                    </div>
                  </div>
                  <div id="top-banner-2" class="banner">
                    <div class="banner-inner-wrapper header-text">
                      <div class="main-caption">
                        <h2>Take a Glimpse Into The Beautiful Country Of:</h2>
                        <h1>Switzerland</h1>
                        
                      </div>
                    </div>
                  </div>
                  <div id="top-banner-3" class="banner">
                    <div class="banner-inner-wrapper header-text">
                      <div class="main-caption">
                        <h2>Take a Glimpse Into The Beautiful Country Of:</h2>
                        <h1>France</h1>
                        
                      </div>
                    </div>
                  </div>
                  <div id="top-banner-4" class="banner">
                    <div class="banner-inner-wrapper header-text">
                      <div class="main-caption">
                        <h2>Take a Glimpse Into The Beautiful Country Of:</h2>
                        <h1>Thailand</h1>
                        
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
        
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
