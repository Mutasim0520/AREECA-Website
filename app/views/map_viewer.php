<!DOCTYPE html>
<html lang="en">

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<?php require 'includes/header.php'; ?>
<style>
  /* Style the legend container */
  .custom-legend {
    background-color: #ede3e385;
    padding: 10px;
    border: 1px solid #18331a;
    border-radius: 8px;
    max-width: 200px;
    width: 100%;
    z-index: 999;
  }

  /* Style each legend item */
  .legend-item {
    display: flex;
    align-items: center;
    margin-bottom: 8px;
  }

  /* Style the color indicator */
  .legend-color {
    height:12px;
    width: 12px;
    border-radius: 50%;
    margin-right: 10px;
    margin-top: 4px;
    border: 1px solid #18331a;
  }

  /* Style the legend label */
  .legend-label {
    font-size: 0.9em;
    color: #18331a;
  }

  .graph-container{
    background-color: #f7f7f7;
    padding: 20px;
    margin-bottom: 30px;
  }

  .responsive-canvas{
    display: block;
    height: 45vh !important;
    width: auto !important;
  }
</style>

<body>
  <!-- ***** Menu bar ***** -->
  <?php require 'includes/menu.php'; ?>

  <div class="wrapper">
    <div class="visit-country">
      <div class="container-fluid">
        <div class="row" id="map-viewer-page-top-text-section" style="margin-bottom:20px;">
          <div class="col-lg-12">
            <div class="section-heading text-center">
              <h1><?php echo $text_dom_sections[0]['dom_header']; ?></h1>
              <hr>
              <p class="text-center" id="map_data_detail"><?php echo $text_dom_sections[0]['dom_text']; ?></p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div id="graph-container"></div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">
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
                    </div>
                  </th>
                </tr>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Table of Content</th>
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
          <div class="col-lg-10">
            <div id="map"></div>
          </div>
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
        const colorMap = {
                          'River and Stream bank Restoration': 'rgba(2, 205, 255, 0.7)', 
                          'Soil and Water Conservation': 'rgba(122, 68, 0, 0.7)', 
                          'Community Forest and Woodlots': 'rgba(142, 255, 133, 0.7)',
                          'Forest Management': 'rgba(2, 87, 42, 0.7)',
                          'Improved Agricultural Technologies': 'rgba(247, 240, 15, 0.7)', 
                      };

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
                    <td>${row['district']}</td>
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

        addLegend(map, colorMap);

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
                                  fillOpacity: 0.7
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
                      loadGraph();

                
                    

                  })
                  .catch(error => console.error('Error loading GeoJSON:', error));
          }

    // Function to add the legend
    function addLegend(map, colorMap) {
        var legend = L.control({ position: 'bottomright' });

        legend.onAdd = function () {
            var div = L.DomUtil.create('div', 'info legendc custom-legend');

            // Create legend content
            var legendHtml = '<h6>Forestation Types</h6>';
            for (var key in colorMap) {
                legendHtml +=
                    '<div style="display:flex;"><div class="legend-color" style="background:' + colorMap[key] + '"></div> ' +
                    '<span class="legend-label">' + key + '</span></div>';
            }

            div.innerHTML = legendHtml;
            return div;
        };

        legend.addTo(map);
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

      function loadGraph() {
        let valuesArray = Object.keys(layers);
        let selectedDistricts = valuesArray.map(item => item.replace(".geojson", ""));

        // If no districts are selected, populate selectedDistricts with all districts from original_data
        if (selectedDistricts.length === 0) {
            selectedDistricts = [...new Set(original_data.map(row => row['district']))]; // Get unique districts
        }

        let graph_data = original_data.filter(row => {
            return selectedDistricts.includes(row['district']); // Check if the row's district is in the selectedDistricts array
        });

        var element = '#graph-container';
        var caption = "Accumulated HAUnderRes of the following Districts: " + selectedDistricts.join(', ');

        if(selectedDistricts) {
            document.getElementById('graph-container').classList.add('graph-container');
        }

        $(element).empty();
        $(element).append(`
            
          <canvas id="myChart" class="responsive-canvas"></canvas>
            
        `);

        var ctx = document.getElementById('myChart').getContext('2d');
        var column_names = selectedDistricts; // Now, labels represent districts

        // Initialize counters for each forestation type and district
        let counters = {
            'River and Stream bank Restoration': new Array(selectedDistricts.length).fill(0),
            'Soil and Water Conservation': new Array(selectedDistricts.length).fill(0),
            'Community Forest and Woodlots': new Array(selectedDistricts.length).fill(0),
            'Forest Management': new Array(selectedDistricts.length).fill(0),
            'Improved Agricultural Technologies': new Array(selectedDistricts.length).fill(0)
        };

        // Populate counters with data from graph_data
        graph_data.forEach(row => {
            const districtIndex = selectedDistricts.indexOf(row['district']); // Find index of the district in selectedDistricts

            row['features']['properties'].forEach(item => {
                let type = item['properties']['Type'];
                if (counters[type]) {
                    counters[type][districtIndex] += parseFloat(item['properties']['HaUnderRes']);
                }
            });
        });

        var myChart = new Chart(ctx, {
            type: 'bar',  // Bar chart type (for grouped bars)
            data: {
                labels: column_names,  // District labels
                datasets: [
                    {
                        label: 'River and Stream bank Restoration',
                        data: counters['River and Stream bank Restoration'],  // Data for each district
                        backgroundColor: 'rgba(2, 205, 255, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Soil and Water Conservation',
                        data: counters['Soil and Water Conservation'],
                        backgroundColor: 'rgba(122, 68, 0, 0.7)',
                        borderColor: 'rgba(82, 45, 0, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Community Forest and Woodlots',
                        data: counters['Community Forest and Woodlots'],
                        backgroundColor: 'rgba(142, 255, 133, 0.7)',
                        borderColor: 'rgba(21, 249, 3, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Forest Management',
                        data: counters['Forest Management'],
                        backgroundColor: 'rgba(2, 87, 42, 0.7)',
                        borderColor: 'rgba(1, 158, 10, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Improved Agricultural Technologies',
                        data: counters['Improved Agricultural Technologies'],
                        backgroundColor: 'rgba(247, 240, 15, 0.7)',
                        borderColor: 'rgba(247, 240, 15, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
              responsive: true, // Make the chart responsive
              maintainAspectRatio: false, // Allow it to break the aspect ratio
                scales: {
                    x: {
                        stacked: false,  // Disable stacking on x-axis to show grouped bars
                    },
                    y: {
                        beginAtZero: true  // Keep y-axis starting at zero
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',  // Align the legend to the top
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
          loadData(original_data);
          loadGraph(); // Load data when the document is ready
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