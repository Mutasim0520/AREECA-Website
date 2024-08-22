<!DOCTYPE html>
<html lang="en">

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<body>

<!-- ***** Menu bar ***** -->
<?php require 'menu.php'; ?>
  <div class="second-page-heading">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h4>Book Prefered Deal Here</h4>
          <h2>Make Your Reservation</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt uttersi labore et dolore magna aliqua is ipsum suspendisse ultrices gravida</p>
          <div class="main-button"><a href="about.html">Discover More</a></div>
        </div>
      </div>
    </div>
  </div>
  <div class="reservation-form">
    <div class="container">
      <div class="row">
        <div class="section-heading">
          <h2>Explore the data</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.</p>
        </div>
        <div class="col-lg-8">
          <div class="col-lg-12" id="map">
          </div>
        </div>
          <script>
            var map = L.map('map').setView([-14.996665839805985, 35.04404396532377], 9.5);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Load GeoJSON data
            fetch('data.geojson')  // Replace with the path to your GeoJSON file
                .then(response => response.json())
                .then(geojsonData => {
                    L.geoJSON(geojsonData, {
                        onEachFeature: function (feature, layer) {
                            // Define a function to create the popup content
                            function createPopupContent() {
                                var name = feature.properties.name;
                                var coordinates = feature.geometry.coordinates;
                                return `
                                    <table class="popup-table">
                                        <tr><th>Name</th><td>${name}</td></tr>
                                        <tr><th>Latitude</th><td>${coordinates[1]}</td></tr>
                                        <tr><th>Longitude</th><td>${coordinates[0]}</td></tr>
                                    </table>
                                `;
                            }

                            // Bind a popup to the marker, set it to open when the marker is clicked
                            layer.bindPopup(createPopupContent());

                            // Ensure the popup opens on click every time
                            layer.on('click', function() {
                                layer.openPopup();
                            });
                        }
                    }).addTo(map);
                })
                .catch(error => console.error('Error loading GeoJSON:', error));
          </script>
        <div class="col-lg-4">
              <table class="table">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Data File</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">1</th>
                    <td>Malawi point sample data</td>
                    <td>
                      <div class="main-button">
                        <a href="reservation.html">View</a>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
        </div>
      </div>
    </div>
  </div>

  <?php require 'footer.php'; ?>


  <!-- Scripts -->
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

  <script src="assets/js/isotope.min.js"></script>
  <script src="assets/js/owl-carousel.js"></script>
  <script src="assets/js/wow.js"></script>
  <script src="assets/js/tabs.js"></script>
  <script src="assets/js/popup.js"></script>
  <script src="assets/js/custom.js"></script>

  <script>
    $(".option").click(function(){
      $(".option").removeClass("active");
      $(this).addClass("active"); 
    });
  </script>

  </body>

</html>
