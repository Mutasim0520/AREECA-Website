<!DOCTYPE html>
<html lang="en">

<?php require 'includes/header.php'; ?>
<link rel="stylesheet" href="/AREECA/public/assets/css/dashboard.css">

<body>

    <!-- ***** Menu bar ***** -->
    <?php require 'includes/menu.php'; ?>
    <?php require 'includes/alert.php'; ?>
    <div class="wrapper">
      <div class="visit-country">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="section-heading text-center">
                <h1>D A S H B O A R D</h1>
                <p style="text-align:center;">Manage Your Website HERE</p>
              </div>
            </div>
          </div>
        </div>

        <div class="container">
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
                <div class="table-container">
                  <table class="table" id="map-data-table">
                    <thead class="thead-light">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">District</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
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
                        <!-- <div class="border-button">
                          <a href="#" data-toggle="modal" data-target="#uploadModal">Create New User</a>
                        </div> -->
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
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
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
                  <div class="table-container">
                  <table class="table" id="event-data-table">
                    <thead class="thead-light">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
                </div>

                <div class="section-heading">
                    <h4>Documents Management</h4>
                    <p>Upload And Delete Important URL or Documents HERE</p>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="border-button">
                          <a href="#" data-toggle="modal" data-target="#uploadModalDocument">Add New Document</a>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="border-button">
                          <a href="#" data-toggle="modal" data-target="#uploadModalURL">Add New URL</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="table-container">
                        <table class="table" id="document-data-table">
                          <thead class="thead-light">
                          <tr>
                              <th colspan=3 style="text-align:center">Documents Table</th>
                            </tr>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">File Name</th>
                              <th scope="col">Actions</th>
                            </tr>
                          </thead>
                          <tbody></tbody>
                        </table>
                    </div>
                    </div>
                    <div class="col-lg-6">
                        <table class="table" id="url-data-table">
                            <thead class="thead-light">
                            <tr>
                                <th colspan=4 style="text-align:center">URLs Table</th>
                              </tr>
                              <tr>
                                <th scope="col">#</th>
                                <th scope="col">URL</th>
                                <th scope="col">Name</th>
                                <th scope="col">Actions</th>
                              </tr>
                            </thead>
                            <tbody></tbody>
                          </table>
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="section-heading text-center">
                <h1>DOM MANAGEMENT</h1>
                <p style="text-align:center;">Manage Your Website HERE</p>
                <div class="offset-md-4 col-md-4">
                  <div class="border-button">
                    <a href="#" data-toggle="modal" data-target="#uploadModalDOM">Add New DOM</a>
                  </div>
                </div>
              </div> 
            </div>
            <?php foreach($doms as $key => $value): ?>
              <div class="row" style="border: 2px solid #18331a; margin-bottom:30px;">
              <div class="col-lg-12">
                <div class="section-heading" style="background-color:#d6dfcd; padding:20px;">
                  <h3><?php echo($key); ?></h3>
                  <hr>
                  <p style="text-align:justify;">Index page settings</p>
                </div> 
              </div>
              <?php foreach($value as $dom):  ?>
                <div class="col-md-12 page-sec-container">
                  <div class="col-lg-12">
                    <div class="row">
                      <div class="col-md-1">
                        <div class="border-button" style="margin-top:20px;">
                          <a href="#" data-toggle="modal" data-target="#deleteModalDOM" data-id="<?php echo($dom['id']); ?>"><i class="fas fa-trash" title="Delete complete section"></i></a>
                        </div>
                      </div>
                      <div class="col-md-11">
                        <div class="section-heading border-button">
                          <h5><?php echo($dom['dom_id']); ?></h>
                        </div> 
                      </div>
                    </div>
                  </div> 
                  <div class="col-lg-12">
                    <div class="scrollable-div">
                    <div class="row">
                      <?php if($dom['dom_header']):?>
                        <div class="col-lg-12 content">
                            <div class="flex-container">
                              <!-- <a href="#" data-toggle="modal" data-target="#deleteModalDOM" data-id="<?php echo($dom['id']); ?>"><i class="fas fa-trash" title="Delete Header"></i></a> -->
                              <h5 style="font-size:small; font-style:italic;"><span style="font-size:14px; color:#b1880d;"> HEADER: </span><?php echo($dom['dom_header']); ?></h5>
                            </div>
                        </div>
                        <hr>
                        <?php endif;?>
                        <?php if($dom['dom_text']):?>
                          <div class="col-lg-12 content">
                            <div class="flex-container">
                              <!-- <a href="#" data-toggle="modal" data-target="#deleteModalDOM" data-id=""><i class="fas fa-trash" title="Delete Text"></i></a> -->
                              <p style="font-size:small; font-style:italic; text-align:justify;">
                                <span style="font-size:14px; color:#b1880d; font-weight:500;"> TEXT: </span>
                                <?php echo($dom['dom_text']); ?>
                              </p>
                            </div>
                          </div>
                          <hr>
                        <?php endif;?>
                        <?php if($dom['images']):?>
                          <div class="col-lg-12 image-gallery">
                              <?php foreach($dom['images'] as $image): ?>
                                <div class="image-item">
                                    <a href="#" data-toggle="modal" data-target="#deleteModalDOMImage" data-id="<?php echo($image['id']); ?>">
                                        <img src="<?php echo BASE_IMAGE_URL . 'doms/' . $image['file_name']; ?>" alt="Image <?php echo $image_counter; ?>">
                                        <div class="hover-icon">
                                            <i class="fas fa-trash"></i>
                                        </div>
                                    </a>
                                </div>
                              <?php endforeach; ?>
                          </div>
                        <?php endif;?>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>   
            </div>
            <?php endforeach; ?>    
          </div>
        </div>
      </div>
    </div>
  <?php require 'includes/modals/uploadModalMap.php';?>
  <?php require 'includes/modals/uploadModalDocument.php';?>
  <?php require 'includes/modals/uploadModalEvent.php';?>
  <?php require 'includes/modals/uploadModalURL.php';?>
  <?php require 'includes/modals/uploadModalDOM.php';?>
  <?php require 'includes/modals/deleteModalMap.php';?>
  <?php require 'includes/modals/deleteModalDOM.php';?>
  <?php require 'includes/modals/deleteModalDOMImage.php';?>
  <?php require 'includes/modals/deleteModalEvent.php';?>
  <?php require 'includes/modals/deleteModalDocument.php';?>
  <?php require 'includes/modals/deleteModalURL.php';?>

    

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

  <script id="event-data" type="application/json">
        <?php echo(json_encode($events)); ?>
  </script>
  <script id="document-data" type="application/json">
        <?php echo(json_encode($documents)); ?>
  </script>
  <script id="url-data" type="application/json">
        <?php echo(json_encode($urls)); ?>
  </script>
  <script>
        // const rowsPerPage = 10;
        // let currentPage = 1;

        function loadMapDataTable() {
          let map_data = JSON.parse(document.getElementById('map-data').textContent);
          let aggregated_data_indicies = {aggregated_data:['Area','HaUnderRes']};
          let map_data_indexes = ['id','file_name',  'district'];
          let map_row_actions = [{ type: "delete", uri: '#', popup_element_id: "#deleteModalMap" }];
          renderTable('map',map_data, map_data_indexes, map_row_actions);
        }

        function loadEventDataTable() {
          let event_data = JSON.parse(document.getElementById('event-data').textContent);
          let aggregated_data_indicies = {aggregated_data:['Area','HaUnderRes']};
          let data_indexes = ['id','name','description'];
          let row_actions = [{ type: "delete", uri: '#', popup_element_id: "#deleteModalEvent" }];
          renderTable('event',event_data, data_indexes, row_actions);
        }

        function loadDocumentDataTable() {
          let document_data = JSON.parse(document.getElementById('document-data').textContent);
          let aggregated_data_indicies = {aggregated_data:['Area','HaUnderRes']};
          let data_indexes = ['id','real_name'];
          let row_actions = [{ type: "delete", uri: '#', popup_element_id: "#deleteModalDocument" }];
          renderTable('document',document_data, data_indexes, row_actions);
        }

        function loadUrlDataTable() {
          let url_data = JSON.parse(document.getElementById('url-data').textContent);
          let aggregated_data_indicies = {aggregated_data:['Area','HaUnderRes']};
          let data_indexes = ['id','perma_link','name'];
          let row_actions = [{ type: "delete", uri: '#', popup_element_id: "#deleteModalURL" }];
          renderTable('url',url_data, data_indexes, row_actions);
        }

        function loadUserDataTable() {
          let user_data = JSON.parse(document.getElementById('user-data').textContent);
          let user_data_indexes = ['user_id','username','user_email', 'role_name'];
          let user_row_actions = [];
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
          loadEventDataTable();
          loadDocumentDataTable();
          loadUrlDataTable();
          

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

            
            $('#deleteModalDOM').on('show.bs.modal', function (event) {
              // Get the button or link that triggered the modal
              var button = $(event.relatedTarget); 
                  
                  // Extract the ID from data-id attribute
              var recordId = button.data('id'); 
                  
                  // Update the modal's hidden input with this ID
              var modal = $(this);
              modal.find('#dom_id_delete').val(recordId);
            });

            $('#deleteModalDOMImage').on('show.bs.modal', function (event) {
              // Get the button or link that triggered the modal
              var button = $(event.relatedTarget); 
                  
                  // Extract the ID from data-id attribute
              var recordId = button.data('id'); 
                  
                  // Update the modal's hidden input with this ID
              var modal = $(this);
              modal.find('#dom_image_id_delete').val(recordId);
            });

            $('#deleteModalEvent').on('show.bs.modal', function (event) {
              // Get the button or link that triggered the modal
              var button = $(event.relatedTarget); 
                  
                  // Extract the ID from data-id attribute
              var recordId = button.data('id'); 
                  
                  // Update the modal's hidden input with this ID
              var modal = $(this);
              modal.find('#event_id_delete').val(recordId);
            });

            $('#deleteModalDocument').on('show.bs.modal', function (event) {
              // Get the button or link that triggered the modal
              var button = $(event.relatedTarget); 
                  
                  // Extract the ID from data-id attribute
              var recordId = button.data('id'); 
                  
                  // Update the modal's hidden input with this ID
              var modal = $(this);
              modal.find('#document_id_delete').val(recordId);
            });

            $('#deleteModalURL').on('show.bs.modal', function (event) {
              // Get the button or link that triggered the modal
              var button = $(event.relatedTarget); 
                  
                  // Extract the ID from data-id attribute
              var recordId = button.data('id'); 
                  
                  // Update the modal's hidden input with this ID
              var modal = $(this);
              modal.find('#URL_id_delete').val(recordId);
            });
            
            document.getElementById('pageSelect').addEventListener('change', function() {
              const selectedPage = this.value;
              updateDomSelect(selectedPage);
            });

            // Initial population of the page select field
            populatePageSelect();
        });
    </script>

  <script>
    document.getElementById('uploadButtonDocument').addEventListener('click', function() {
        document.getElementById('uploadFormDocument').submit();
    });
    document.getElementById('uploadButtonMap').addEventListener('click', function() {
        document.getElementById('uploadFormMap').submit();
    });
    document.getElementById('uploadButtonEvent').addEventListener('click', function() {
        document.getElementById('uploadFormEvent').submit();
    });
    document.getElementById('uploadButtonURL').addEventListener('click', function() {
        document.getElementById('uploadFormURL').submit();
    });
    document.getElementById('uploadButtonDOM').addEventListener('click', function() {
        document.getElementById('uploadFormDOM').submit();
    });
    document.getElementById('deleteMapButton').addEventListener('click', function() {
        document.getElementById('deleteFormMap').submit();
    });
    document.getElementById('deleteDOMImageButton').addEventListener('click', function() {
        document.getElementById('deleteFormDOMImage').submit();
    });
    document.getElementById('deleteDOMButton').addEventListener('click', function() {
        document.getElementById('deleteFormDOM').submit();
    });
    document.getElementById('deleteEventButton').addEventListener('click', function() {
        document.getElementById('deleteFormEvent').submit();
    });
    document.getElementById('deleteDocumentButton').addEventListener('click', function() {
        document.getElementById('deleteFormDocument').submit();
    });
    document.getElementById('deleteURLtButton').addEventListener('click', function() {
        document.getElementById('deleteFormURL').submit();
    });

    function handleModalActivation(activeSubmitId) {
        $('button[type="submit"]').prop('disabled', true); // Disable all submit buttons
        if (activeSubmitId) {
            $('#' + activeSubmitId).prop('disabled', false); // Enable the submit button of the active modal
        }
      }

      // Event listener for showing modals
      $('#uploadModalDocument').on('show.bs.modal', function () {
          handleModalActivation('uploadButtonDocument');
      });

      $('#uploadModalMap').on('show.bs.modal', function () {
          handleModalActivation('uploadButtonMap');
      });

      $('#uploadModalEvent').on('show.bs.modal', function () {
          handleModalActivation('uploadButtonEvent');
      });

      $('#uploadModalURL').on('show.bs.modal', function () {
          handleModalActivation('uploadButtonURL');
      });

      $('#uploadModalDOM').on('show.bs.modal', function () {
          handleModalActivation('uploadButtonDOM');
      });

      // Event listener for closing modals
      $('.modal').on('hide.bs.modal', function () {
          handleModalActivation(null); // Disable all submit buttons when no modal is open
      });
    
  </script>

  </body>

</html>
