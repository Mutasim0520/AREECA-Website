<!DOCTYPE html>
<html lang="en">

<?php require 'includes/header.php'; ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<body>

    <!-- ***** Menu bar ***** -->
    <?php require 'includes/menu.php'; ?>
    <?php require 'includes/alert.php'; ?>

  <div class="weekly-offers">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 offset-lg-3">
          <div class="section-heading text-center">
            <h1>D A S H B O A R D</h1>
            <p style="text-align:center;">Manage Your Website HERE</p>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="item">
            <div class="section-heading">
              <h3>Map Data Files Management</h3>
              <p>You can see the available data files in the following table.</p>
              <div class="border-button">
                <a href="#" data-toggle="modal" data-target="#uploadModalMap">Upload New Data File</a>
              </div>
            </div>
            <table class="table" id="map-data-table">
              <thead class="thead-light">
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Area</th>
                  <th scope="col">HAUnderRes</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
            <nav>
              <ul class="pagination" id="map-table-pagination">
                    <!-- Pagination links will be inserted here -->
              </ul>
            </nav>
          </div>
          <br>
          <br>
          <hr>
          <div class="item">
              <div class="section-heading">
                <h3>User Management</h3>
                <div class="row">
                  <div class="col-sm-6">
                    <p>Create a new user with appropriate roles and also Update and Delete the USER INFO(Ex: email,password, role).</p>
                    <p>Users can have a role of <b>ADMIN</b> or <b>Moderator</b> or by default <b>GUEST</b> The Flowwing table shows the allowed actions of a Role.</p>
                    <div class="border-button">
                      <a href="#" data-toggle="modal" data-target="#uploadModal">Create New User</a>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <table class="table table-bordered" style="font-size:x-small; color:#6db1bf; text-align:center">
                      <thead class="thead-light">
                        <tr>
                          <th scope="col">Role</th>
                          <th scope="col">See</th>
                          <th scope="col">Create</th>
                          <th scope="col">Update</th>
                          <th scope="col">Delete</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td scope="col">Admin</td>
                          <td scope="col"><i class="fas fa-check" title="Allowed"></i></td>
                          <td scope="col"><i class="fas fa-check" title="Allowed"></i></td>
                          <td scope="col"><i class="fas fa-check" title="Allowed"></i></td>
                          <td scope="col"><i class="fas fa-check" title="Allowed"></i></td>
                        </tr>
                        <tr>
                          <td scope="col">Moderator</td>
                          <td scope="col"><i class="fas fa-check" title="Allowed"></i></td>
                          <td scope="col"><i class="fas fa-check" title="Allowed"></i></td>
                          <td scope="col"><i class="fas fa-check" title="Allowed"></i></td>
                          <td scope="col"><i class="fas fa-ban" title="Not Allowed"></i></td>
                        </tr>

                        <tr>
                          <td scope="col">Guest</td>
                          <td scope="col"><i class="fas fa-check" title="Allowed"></i></td>
                          <td scope="col"><i class="fas fa-ban" title="Not Allowed"></i></td>
                          <td scope="col"><i class="fas fa-ban" title="Not Allowed"></i></td>
                          <td scope="col"><i class="fas fa-ban" title="Not Allowed"></i></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <table class="table" id="user-data-table">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
              <nav>
                <ul class="pagination" id="user-table-pagination">
                      <!-- Pagination links will be inserted here -->
                </ul>
              </nav>
            </div>
            <br>
            <br>
            <hr>
          <div class="item">
              <div class="section-heading">
                <h3>WEBSITE Management</h3>
                <p>Basic Changes!!! of your website pages HERE. Changes include Description and Images of following avilable webpages.</p>
                <div class="border-button">
                  <a href="#" data-toggle="modal" data-target="#uploadModalEvent">Add New Event</a>
                </div>
              </div>
              <table class="table">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Actions</th>
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

            <div class="section-heading">
                <h4>Documents Management</h4>
                <p>Upload And Delete Important URL or Documents HERE</p>
                <div class="border-button">
                  <a href="#" data-toggle="modal" data-target="#uploadModalDocument">Add New Document</a>
                </div>
              </div>
              <table class="table" id="documents_table">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Actions</th>
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
    </div>
  </div>

  <!-- ***** Popup form of map file upload ***** -->
  <div class="modal fade" id="uploadModalMap" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="uploadModalLabel">Upload File</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="uploadFormMap" action="<?php echo BASE_URL?>/map/upload" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <label for="fileInput">Choose file</label>
              <input type="file" class="form-control" id="fileInput" name="file" required>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="uploadButtonMap">Upload</button>
        </div>
      </div>
    </div>
  </div>

   <!-- ***** Popup form of Document file upload ***** -->
   <div class="modal fade" id="uploadModalDocument" tabindex="-1" role="dialog" aria-labelledby="uploadModalDocumentLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="uploadModalDocumentLabel">Upload New Document</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="uploadFormDocument" action="<?php echo BASE_URL?>/dashboard/uploadDocument" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <label for="fileInput">Choose file</label>
              <input type="file" class="form-control" id="fileInput" name="file" required>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="uploadButtonDocument">Upload</button>
        </div>
      </div>
    </div>
  </div>

   <!-- ***** Popup form for adding new event ***** -->
  <div class="modal fade bd-example-modal-xl" id="uploadModalEvent" tabindex="-1" role="dialog" aria-labelledby="uploadModalEventLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h2>Add a New Event</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          <form id="uploadFormEvent" action="<?php echo BASE_URL?>dashboard/addEvent" method="POST" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="event_name">Event Name</label>
                  <input type="text" class="form-control" id="event_name" name="event_name" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="venue">Venue</label>
                  <input type="text" class="form-control" id="venue" name="venue" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="date">Date</label>
                  <input type="date" class="form-control" id="date" name="date" required>
                </div>
              </div>
              <div class="col-md-4">
                  <div class="form-group">
                    <label for="images">Choose file</label>
                    <input type="file" class="form-control" id="images" name="images[]" multiple required>
                  </div>
              </div>
              <div class="col-md-12">
                  <div class="form-group">
                    <label for="intro">Intro</label>
                    <textarea class="form-control" id="intro" name="intro" rows="2"></textarea>
                  </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="10"></textarea>
                  </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="uploadButtonEvent">Upload</button>
        </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ***** Confirmation Box for delete record ***** -->

    <div class="modal fade" id="deleteModalMap" tabindex="-1" role="dialog" aria-labelledby="deleteModalMapLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header alert alert-danger">
            <h5 class="modal-title" id="deleteModalMapLabel"><i class="fas fa-exclamation-triangle"></i><span> </span>Confimation: Delete Map </h5>
          </div>
          <div class="modal-body">
            <p>Are you sure about Deleting this file?</p>
            <form id="deleteFormMap" action="<?php echo BASE_URL?>/map/delete" method="POST">
                <input type="hidden" name="id" id="map_id_delete"> <!-- Item ID to delete -->
            </form>
          </div>  
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="deleteMapButton">Confirm</button>
          </div>
        </div>
      </div>
    </div>

  <!-- ***** Popup for MAP View ***** -->
  <div class="modal fade bd-example-modal-lg" id="viewModalMap" tabindex="-1" role="dialog" aria-labelledby="viewModalMapLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="viewModalMapLabel">MAP</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="map"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

    

   <!-- ***** footer ***** -->
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
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="/AREECA/public/assets/js/functions.js"></script>

  <script>
    $(".option").click(function(){
      $(".option").removeClass("active");
      $(this).addClass("active"); 
    });
  </script>

  <!-- table pagination -->
  <script id="map-data" type="application/json">
        <?php echo(json_encode($maps)); ?>
  </script>

  <script id="user-data" type="application/json">
        <?php echo(json_encode($users)); ?>
  </script>
  <script>
        // const rowsPerPage = 10;
        // let currentPage = 1;
        var map = L.map('map').setView([-14.996665839805985, 35.04404396532377], 7.5);
        var currentLayer = null;
       

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy;<a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a><span id="loaded_file_name" style="font-size:bold"></span>'
        }).addTo(map);

        function loadMapDataTable() {
          let map_data = JSON.parse(document.getElementById('map-data').textContent);
          let aggregated_data_indicies = {aggregated_data:['Area','HaUnderRes']};
          let map_data_indexes = ['id','file_name', aggregated_data_indicies];
          let map_row_actions = [{ type: "view", uri: '#', popup_element_id: "#viewModalMap" },
                                    { type: "update", uri: '#', popup_element_id: "#updateModalMap" },
                                    { type: "delete", uri: '#', popup_element_id: "#deleteModalMap" }];
          renderTable('map',map_data, map_data_indexes, map_row_actions);
        }

        function loadUserDataTable() {
          let user_data = JSON.parse(document.getElementById('user-data').textContent);
          let user_data_indexes = ['user_id','username','user_email', 'role_name'];
          let user_row_actions = [{ type: "view", uri: '#', popup_element_id: "#viewModalMap" },
                                    { type: "update", uri: '#', popup_element_id: "#updateModalMap" },
                                    { type: "delete", uri: '#', popup_element_id: "#deleteModalMap" }];
          renderTable('user',user_data, user_data_indexes, user_row_actions);
        }

        function handleModalActivation(activeSubmitId) {
          $('button[type="submit"]').prop('disabled', true); // Disable all submit buttons
          if (activeSubmitId) {
            $('#' + activeSubmitId).prop('disabled', false); // Enable the submit button of the active modal
          }
        }

        $(document).ready(function() {
          loadMapDataTable();
          loadUserDataTable();
          

            $(document).on('click', '#pagination .page-link', function(e) {
                e.preventDefault();
                currentPage = $(this).data('page');
                renderTable();
                renderPagination();
            });


            //delete map modal: Set id of map
            $('#deleteModalMap').on('show.bs.modal', function (event) {
                  // Get the button or link that triggered the modal
                  var button = $(event.relatedTarget); 
                  
                  // Extract the ID from data-id attribute
                  var recordId = button.data('id'); 
                  
                  // Update the modal's hidden input with this ID
                  var modal = $(this);
                  modal.find('#map_id_delete').val(recordId);
                });

            

          
        });
    </script>

  <script>
    document.getElementById('uploadButtonDocument').addEventListener('click', function() {
        document.getElementById('uploadFormDocument').submit();
    });
    document.getElementById('uploadButtonMap').addEventListener('click', function() {
        document.getElementById('uploadFormMap').submit();
    });
    document.getElementById('uploadModalEvent').addEventListener('click', function() {
        document.getElementById('uploadFormEvent').submit();
    });
    document.getElementById('deleteMapButton').addEventListener('click', function() {
        document.getElementById('deleteFormMap').submit();
    });
    
  </script>

  </body>

</html>
