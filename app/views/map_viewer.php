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
          <div class="row">
          <div class="col-sm-12">
            <div id="graph-container" style="background-color: #fdf9f6; padding: 20px; margin-bottom: 30px;">
            </div>
          </div>
        </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-3">
        <div class="row">
          <div class="col-sm-12">
          <table class="table table-responsive" id="data-table" style="font-size:smaller;">
                <thead class="thead-light">
                  <tr>
                    <th colspan="3">
                      <div class="row">
                        <div class="col-md-12">
                          <select name="district" class="form-select" style ="font-size:smaller" aria-label="Default select example" id="map-table-district-filter" onChange="filterTable()">
                            <option value="" selected>Filter District ....</option>
                            <?php
                              $filePath = 'C:\xampp\htdocs\AREECA\public\assets\districts.txt';
              
                              $districts = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                              foreach($districts as $item): ?>
                                <option value="<?php echo $item; ?>"><?php echo $item; ?></option> 
                            <?php endforeach ?>
                          </select>
                        </div>
                        
                        <!-- <div class="col-md-6">
                          <select name="type" class="form-select" style ="font-size:smaller" aria-label="Default select example" id="map-table-type-filter" onChange="filterTable()">
                            <option selected value="">filter Type ....</option>
                            <?php
                              $filePath = 'C:\xampp\htdocs\AREECA\public\assets\types.txt';
                                // Read the file content into an array
                              $districts = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                              foreach($districts as $item): ?>
                                <option value="<?php echo $item; ?>"><?php echo $item; ?></option> 
                            <?php endforeach ?>
                          </select>
                        </div> -->
                      </div>
                    </th>
                  </tr>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
              <nav>
                <ul class="pagination" id="pagination">
                      <!-- Pagination links will be inserted here -->
                </ul>
              </nav>
          </div>
        </div>
        
          
          
        </div>
        <!-- <div class="col-lg-4">
          <canvas id="myChart" width="400" height="200"></canvas>
        </div> -->
        <div class="col-lg-9">
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
        let original_data = JSON.parse(document.getElementById('data-script').textContent);
        var BASE_URL = '<?php echo BASE_URL; ?>';

        function loadData(data) {
          renderTable(data);
          renderPagination(data);
        }

        function renderTable(data) {
            const startIndex = (currentPage - 1) * rowsPerPage;
            const endIndex = startIndex + rowsPerPage;
            const paginatedData = data.slice(startIndex, endIndex);

            $('#data-table tbody').empty();
            var index_counter = 1;
            paginatedData.forEach(row => {
              var check_box_id = 'check-box-' + index_counter;
              $('#data-table tbody').append(`
                <tr>
                    <td>${index_counter}</td>
                    <td>${row['file_name']}</td>
                    <td>
                      <div class="main-button">
                        <input type="checkbox" id="${check_box_id}" onchange="handelCheckboxAction('${row['file_name']}','${check_box_id}')"></a>
                      </div>
                    </td>
                </tr>
              `);
                 
              index_counter = index_counter+1;
            });
        }

        function renderPagination(data) {
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
        // Store each layer by file_name in this object
        var layers = {};

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy;<a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a><span id="loaded_file_name" style="font-size:bold"></span>'
        }).addTo(map);

        function handelCheckboxAction(file_name,id){
          var checkbox = document.getElementById(id);
          renderMap(file_name, checkbox.checked);
        }
        
        
        

        function renderMap(file_name, addLayer) {
          var data_file_path = BASE_URL + 'app/storage/map_data_files/' + file_name;

          // If addLayer is false, remove the layer
          if (!addLayer) {
              if (layers[file_name]) {
                  map.removeLayer(layers[file_name]);  // Remove the layer from the map
                  delete layers[file_name];            // Remove from layers object
              }
              loadGraph();
              return;
          }

          // Fetch and add the new layer if addLayer is true
          fetch(data_file_path)
              .then(response => response.json())
              .then(geojsonData => {

                  // If the layer already exists, do nothing
                  if (layers[file_name]) {
                      return;
                  }

                  // Define a color map based on a property
                  const colorMap = {
                      'River and Stream bank Restoration': 'rgba(255, 99, 132)', 
                      'Soil and Water Conservation': 'rgba(54, 162, 235)', 
                      'Community Forest and Woodlots': 'rgba(255, 206, 86)',
                      'Forest Management': 'rgba(75, 192, 192)',
                      'Improved Agricultural Technologies': 'rgba(153, 102, 255)', 
                     
                  };

                  // Add the new GeoJSON layer to the map
                  var newLayer = L.geoJSON(geojsonData, {
                      pointToLayer: function (feature, latlng) {
                          // Determine the color based on the feature's properties
                          var type = feature.properties.Type; // Adjust this to match your GeoJSON property
                          var color = colorMap[type] || '#000000'; // Default to black if type is not found

                          return L.circleMarker(latlng, {
                              radius: 8,
                              fillColor: color,
                              color: color,
                              weight: 1,
                              opacity: 1,
                              fillOpacity: 0.8
                          });
                      },
                      onEachFeature: function (feature, layer) {
                          var coordinates = feature.geometry.coordinates;

                          function createPopupContent() {
                              var properties = feature.properties;
                              var tableContent = `<div>
                                                    <div>
                                                      <p style="border-bottom: 1px solid #dfe2e6;">${file_name}</p>
                                                    </div>
                                                    <div>
                                                      <p><span style="font-size:smaller">Latitude: </span><span style="font-size:smaller"> ${coordinates[1]}</span></p>
                                                      <p><span style="font-size:smaller">Longitude: </span><span style="font-size:smaller"> ${coordinates[0]}</span></p>
                                                    </div>
                                                    <div style="max-height: 40vh; overflow-y: auto;">
                                                      <table class="table" style="font-size:smaller">
                                                        <tbody>`;
                              for (var key in properties) {
                                  if (properties.hasOwnProperty(key)) {
                                      tableContent += `<tr><th>${key}</th><td>${properties[key]}</td></tr>`;
                                  }
                              }

                              tableContent += '</tbody></table></div></div></div>';
                              return tableContent;
                          }

                          layer.bindPopup(createPopupContent());
                          layer.on('click', function() {
                              layer.openPopup();
                          });
                      }
                  }).addTo(map);

                  // Store the new layer in the layers object
                  layers[file_name] = newLayer;

                  // Adjust map bounds to fit new data
                  var bounds = newLayer.getBounds();
                  map.fitBounds(bounds);

                  // Update content to show the loaded file name
                  var contentDiv = document.getElementById("loaded_file_name");
                  contentDiv.innerHTML = `<span style="font-weight:bold;">Current File: ${file_name}</span>`;
                  loadGraph();

              })
              .catch(error => console.error('Error loading GeoJSON:', error));
            }




        function updateContent(element_id,content) {
          // Get the div element by its ID
          contentDiv.appendChild(newParagraph);
        }

        function filterTable(){
          var selectedDistrict = document.getElementById("map-table-district-filter").value;
          if (selectedDistrict === ""){
            loadData(original_data);
          }
          
          else{
            let filtered_data = original_data.filter(row => { 
              if (selectedDistrict) {
                  return row['district'] == selectedDistrict;
              }
          });

            loadData(filtered_data);
          }
      }

      function loadGraph(){
        let valuesArray = Object.keys(layers);
        let selectedDistricts = valuesArray.map(item => item.replace(".geojson", ""));


        let graph_data = original_data.filter(row => { 
                        if (selectedDistricts && selectedDistricts.length > 0) {
                            return selectedDistricts.includes(row['district']); // Check if the row's district is in the selectedDistricts array

                        } else {
                            return true; // Return all data if no districts are selected
                        }
                      });
        
        var element = '#graph-container';
        var caption = "Accumulated HAUnderRes of " + selectedDistricts.join(', ');
        $(element).empty();
        $(element).append(`
           <figure>
            <figcaption style="text-align: center; text-align: center; color: #4b3232; font-weight: 500;">${caption}</figcaption>
              <canvas id="myChart" style="max-height:400px;"></canvas>
          </figure>
        `);
        var ctx = document.getElementById('myChart').getContext('2d');
        var column_names = ["River and Stream bank Restoration", "Soil and Water Conservation", "Community Forest and Woodlots", "Forest Management", "Improved Agricultural Technologies"];
        var counter_1 = 0;
        var counter_2 = 0;
        var counter_3 = 0;
        var counter_4 = 0;
        var counter_5 = 0;

        graph_data.forEach(row =>{
          row['features']['properties'].forEach(item =>{
            if(item['properties']['Type'] == 'River and Stream bank Restoration'){
              counter_1 = counter_1 + parseFloat(item['properties']['HaUnderRes']);
            }else if(item['properties']['Type'] == 'Soil and Water Conservation'){
              counter_2 = counter_2 + item['properties']['HaUnderRes'];
            }else if(item['properties']['Type'] == 'Community Forest and Woodlots'){
              counter_3 = counter_3 + item['properties']['HaUnderRes'];
            }else if(item['properties']['Type'] == 'Forest Management'){
              counter_4 = counter_4 + item['properties']['HaUnderRes'];
            }else if(item['properties']['Type'] == 'Improved Agricultural Technologies'){
              counter_5 = counter_5 + item['properties']['HaUnderRes'];
            }
          });
        });

        var statistics = [counter_1, counter_2, counter_3, counter_4, counter_5];

          var myChart = new Chart(ctx, {
              type: 'bar',  // Column chart type
              data: {
                  labels: column_names,  // Labels for each column
                  datasets: [{
                      label: '',
                      data: statistics,  // Data for each column
                      backgroundColor: [
                          'rgba(255, 99, 132, 0.2)',  // Color for Jan
                          'rgba(54, 162, 235, 0.2)',  // Color for Feb
                          'rgba(255, 206, 86, 0.2)',  // Color for Mar
                          'rgba(75, 192, 192, 0.2)',  // Color for Apr
                          'rgba(153, 102, 255, 0.2)'// Color for May
                      // Color for Jun
                      ],
                      borderColor: [
                          'rgba(255, 99, 132, 1)',
                          'rgba(54, 162, 235, 1)',
                          'rgba(255, 206, 86, 1)',
                          'rgba(75, 192, 192, 1)',
                          'rgba(153, 102, 255, 1)',
                          'rgba(255, 159, 64, 1)'
                      ],
                      borderWidth: 1
                  }]
              },
              options: {
                  scales: {
                      y: {
                          beginAtZero: true
                      }
                  },
                  plugins: {
                      legend: {
                          position: 'top',  // Align the legend to the right
                          labels: {
                              padding: 20,
                              textAlign: 'left',
                              usePointStyle: true
                          }
                      }
                  }
              }
          });
      }

        $(document).ready(function() {
          loadData(original_data); // Load data when the document is ready
          $(document).on('click', '#pagination .page-link', function(e) {
              e.preventDefault();
              currentPage = $(this).data('page');
              renderTable(original_data);
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