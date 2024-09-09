<!DOCTYPE html>
<html lang="en">

<?php require 'includes/header.php'; ?>

<body>

  <!-- ***** Menu bar ***** -->
  <?php require 'includes/menu.php'; ?>
  
  <div class="visit-country">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-7">
            <div class="row">
            <div class="col-md-12">
              <div class="section-heading"><h3>FLR Forum Oct 2023</h3></div>
              <p>The Government of Malawi, through the Ministry of Natural Resources and Climate Change and its Department of Forestry, in collaboration with the AREECA Program and the World Bank, co-hosted the Forum titled "Landscape Restoration Forum: Opportunities and Challenges - Scaling up Financing for Forest Landscape Restoration in Malawi" on October 5th, 2023, at the Bingu International Convention Centre in Lilongwe.
The Forum brought together representatives from the Government of Malawi, local leaders, AREECA consortium partners, civil society, the private sector, development partners, and national and international experts. The discussions focused on strategies for restoring degraded lands, promoting sustainable land management practices, scaling up financing to landscape restoration and enhancing the resilience of Malawi’s ecosystems. 
The Forum served as a vital platform for stakeholders to explore innovative restoration and financial solutions, while the sessions were designed to raise awareness of FLR successes and improve coordination among actors involved in forest landscape restoration.
              </p>
            </div>
            <div class="col-md-12">
              <img style="max-height:45vh;" src="<?php echo BASE_IMAGE_URL.'event-01.png';?>" >
            </div>
            </div>
        </div>
        <div class="col-lg-5">
          <div class="row">
            <div class="item">
              <div class="col-md-12">
              <div class="section-heading"><h3>National stocktaking exercise at district offices</h3></div>
              <p>First phase of Stocktaking exercise was carried out to collect, store and integrate district wise database with metadata of FLR intervention across the country and other data related to private sector participation in Landscape restoration, community engagement and other parameters of interest to AREECA. At the end of exercise, approximately 12000 interventions were mapped along with attribute information
              </p>
              </div>
              <div class="col-md-12">
                <img style="max-height:35vh;" src="<?php echo BASE_IMAGE_URL.'event-02.png';?>" >
              </div>
            </div>
            <div class="item">
              <div class="col-md-12">
                <div class="section-heading"><h3>Validation workshop</h3></div>
                <p>Validation workshop was hosted as phase two of stocktaking activity, to validate the mapping and quantification of FLR interventions at district level and to finalize a harmonized GIS database of ongoing/completed projects. Event aimed at finalizing the database that was created during phase one, fill data gaps and capture additional project data in the events of new projects. 
Additionally Future opportunity mapping of FLR interventions was also carried out during workshop. Participants were given hard copy maps of their district to identify future intervention under five categories, best on model suitability results.
</p>
              </div>
              <div class="col-md-12">
                <img style="max-height:35vh;" src="<?php echo BASE_IMAGE_URL.'event-03.png';?>" >
              </div>
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
