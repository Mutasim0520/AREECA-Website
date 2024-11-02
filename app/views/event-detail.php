<!DOCTYPE html>
<html lang="en">

<?php require 'includes/header.php'; ?>
<style>
  <?php 
    $i=1;
    foreach($event[0]['images'] as $image){ ?>
      .section-1 .content-slider #banner<?php echo $i; ?>:checked ~ .slider #top-banner-<?php echo $i; ?>
      {
        opacity: 1;
        z-index:1;
      }
      <?php $i++;?>    
    <?php }?> 
</style>

<body>

  <!-- ***** Menu bar ***** -->
  <?php require 'includes/menu.php'; ?>

  <!-- ***** Main Banner Area Start ***** -->
  
  <!-- ***** Main Banner Area End ***** -->
  
    <div class="wrapper">
      <div class="visit-country">
        <div class="container">
          <div class="row">
            <div class="section-heading text-center">
              <h1><?php echo($event[0]['name']);?></h1>
            </div>
            <div class="event-detail">
            <!-- Image Slider Floated Right -->
              <div class="image-slider">
                  <section class="section-1">
                      <div class="content-slider">
                          <?php 
                          $image_counter = 1;
                          foreach($event[0]['images'] as $image): ?>
                              <input type="radio" id="<?php echo 'banner' . $image_counter; ?>" class="sec-1-input" name="banner" <?php echo $image_counter === 1 ? 'checked' : ''; ?>>
                              <?php $image_counter++; ?>
                          <?php endforeach; ?>
                          
                          <div class="slider">
                              <?php 
                              $image_counter = 1;
                              foreach($event[0]['images'] as $image): ?>
                                  <div id="<?php echo 'top-banner-' . $image_counter; ?>" class="banner" 
                                      style="background-image: url('<?php echo BASE_IMAGE_URL . 'events/' . $image; ?>'); background-size: cover; background-position: center center;">
                                  </div>
                              <?php $image_counter++;
                              endforeach; ?>
                          </div>
                      </div>
                  </section>
              </div>
            <!-- Description Text -->
              <div class="event-description">
                  <p style="text-align: justify;">
                      <?php echo (str_replace(["\r\n", "\n"], '<br>', $event[0]['description'])); ?>
                  </p>
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
                      <div class="event-image-container" style="border-radius:0px; width: 100%; height: 22vh; overflow: hidden; position: relative;text-align:center; font-size: larger; font-weight: 500;">
                        <a href="<?php echo($event_url); ?>" target="_blank" rel="noopener noreferrer">
                          <img src="<?php echo($file_path)?>" alt="" style="padding:0px; object-fit:cover; height:100%; width:100%"> 
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
  <?php require 'includes/load_scripts.php'; ?>

  <!-- ***** footer ***** -->


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
