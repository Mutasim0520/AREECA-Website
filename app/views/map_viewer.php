<!DOCTYPE html>
<html lang="en">

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<?php require 'includes/header.php'; ?>
<body>

<!-- ***** Menu bar ***** -->
<?php require 'includes/menu.php'; ?>
  <div class="weekly-offers">
    <div class="container-fluid">
      <div class="row">
        <div class="section-heading">
          <h1>Explore The Data</h1>
          <p id="map_data_detail">To see the map data click on the <i class="fas fa-eye" title="View DataFile"></i> icon on the records of the Data Files table.</p>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-8">
          <div id="map"></div>
        </div>
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
                            <a style="padding:5px 12px" href="#" onclick="renderMap('${row.name}')"><i class="fas fa-eye" title="View DataFile"></i></a>
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

        //Initial map
        var map = L.map('map').setView([-14.996665839805985, 35.04404396532377], 9.5);
        var currentLayer = null;
        var base_url = '<?php echo BASE_URL; ?>';

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy;<a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a><span id="loaded_file_name" style="font-size:bold"></span>'
        }).addTo(map);


        function renderMap(file_name) {
              var data_file_path = base_url + 'app/storage/map_data_files/' + file_name;

              fetch(data_file_path)  // Fetch the GeoJSON file
                  .then(response => response.json())
                  .then(geojsonData => {

                      // Remove the current layer if it exists
                      if (currentLayer) {
                          map.removeLayer(currentLayer);
                      }

                      // Add the new GeoJSON layer to the map and store it in currentLayer
                      currentLayer = L.geoJSON(geojsonData, {
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
                      
                      //Dynamically focus map based on data
                      var bounds = currentLayer.getBounds();
                      map.fitBounds(bounds);

                      var contentDiv = document.getElementById("loaded_file_name");
                      contentDiv.innerHTML = `<span style="font-weight:bold;">  Current File: ${file_name}</span>`

                  })
                  .catch(error => console.error('Error loading GeoJSON:', error));
          }

        function updateContent(element_id,content) {
          // Get the div element by its ID
          
  
          contentDiv.appendChild(newParagraph);
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