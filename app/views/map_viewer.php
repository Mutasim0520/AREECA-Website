<!DOCTYPE html>
<html lang="en">

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<?php require 'includes/header.php'; ?>
<body>

<!-- ***** Menu bar ***** -->
<?php require 'includes/menu.php'; ?>
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
          <div id="map">
          </div>
        </div>
          <script>
            var map = L.map('map').setView([-14.996665839805985, 35.04404396532377], 9.5);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Load GeoJSON data
            var base_url = '<?php echo BASE_URL; ?>';
            var data_file_path = base_url + 'app/storage/map_data_files/data.geojson';
            fetch(data_file_path)  // Replace with the path to your GeoJSON file
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
          <table class="table table-responsive" id="data-table">
            <thead class="thead-light">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Map Type</th>
                <th scope="col">District</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
          <nav>
            <ul class="pagination" id="pagination">
              <!-- Pagination links will be inserted here -->
            </ul>
          </nav>
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

  <!-- table pagination -->
  <script id="data-script" type="application/json">
        <?php echo(json_encode($maps)); ?>
  </script>
  <script>
        const rowsPerPage = 10;
        let currentPage = 1;
        let data = JSON.parse(document.getElementById('data-script').textContent);
        var BASE_URL = '<?php echo BASE_URL; ?>';

        function loadData() {
          renderTable();
          renderPagination();
        }

        function renderTable() {
            const startIndex = (currentPage - 1) * rowsPerPage;
            const endIndex = startIndex + rowsPerPage;
            const paginatedData = data.slice(startIndex, endIndex);

            $('#data-table tbody').empty();
            paginatedData.forEach(row => {
                $('#data-table tbody').append(`
                    <tr>
                        <td>${row.id}</td>
                        <td>${row.name}</td>
                        <td>${row.map_type}</td>
                        <td>${row.district}</td>
                        <td>
                          <div class="main-button">
                            <a style="padding:5px 12px" href="${BASE_URL}/map/index?id=${row.id}"><i class="fas fa-eye" title="View DataFile"></i></a>
                          </div>
                        </td>
                    </tr>
                `);
            });
        }

        function renderPagination() {
            const pageCount = Math.ceil(data.length / rowsPerPage);
            $('#pagination').empty();

            for (let i = 1; i <= pageCount; i++) {
                $('#pagination').append(`
                    <li class="page-item ${i === currentPage ? 'active' : ''}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                    </li>
                `);
            }
        }

        $(document).ready(function() {
            loadData(); // Load data when the document is ready

            $(document).on('click', '#pagination .page-link', function(e) {
                e.preventDefault();
                currentPage = $(this).data('page');
                renderTable();
                renderPagination();
            });
        });
    </script>

  <script>
    $(".option").click(function(){
      $(".option").removeClass("active");
      $(this).addClass("active"); 
    });
  </script>

  </body>

</html>