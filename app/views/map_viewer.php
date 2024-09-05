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
        <div class="col-lg-12">
          <div class="section-heading">
            <h1>E X P L O R E &nbsp;&nbsp;  M A P S</h1>
            <p id="map_data_detail">To see the map data click on the <i class="fas fa-eye" title="View DataFile"></i> icon on the records of the Data Files table.</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-7">
          <table class="table table-responsive" id="data-table" style="font-size:smaller;">
            <thead class="thead-light">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Type</th>
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
        <div class="col-lg-5">
          <div id="map"></div>
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
        var map = L.map('map').setView([-14.996665839805985, 35.04404396532377], 7.5);
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
                            var coordinates = feature.geometry.coordinates;
                              // Define a function to create the popup content
                              function createPopupContent() {
                                  var properties = feature.properties;
                                  var tableContent = `<div>
                                                        <div>
                                                          <p style="border-bottom: 1px solid #dfe2e6;">${file_name}</p>
                                                        </div>
                                                        <div>
                                                          <p><span style="font-size:smaller">Lattitude: </span><span style="font-size:smaller"> ${coordinates[0]}</span></p>
                                                          <p><span style="font-size:smaller">Longitude: </span><span style="font-size:smaller"> ${coordinates[1]}</span></p>
                                                        </div>
                                                        <div style="max-height: 40vh; overflow-y: auto;"><table class="table" style="font-size:smaller">
                                                          <tbody>`;
                                  for (var key in properties) {
                                      if (properties.hasOwnProperty(key)) {
                                          tableContent += `<tr><th>${key}</th><td>${properties[key]}</td></tr>`;
                                      }
                                  }

                                  tableContent += '</tbody></table></div></div></div>'
                                  return tableContent;
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