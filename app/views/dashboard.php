<!DOCTYPE html>
<html lang="en">

<?php require 'includes/header.php'; ?>

<body>

    <!-- ***** Menu bar ***** -->
    <?php require 'includes/menu.php'; ?>
    <?php require 'includes/alert.php'; ?>

  
  <div class="weekly-offers">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 offset-lg-3">
          <div class="section-heading text-center">
            <h2>Best Weekly Offers In Each City</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.</p>
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
              <p>You can ee the available data files in the following table.</p>
              <div class="border-button">
                <a href="#" data-toggle="modal" data-target="#uploadModal">Upload New Data File</a>
                </div>
              
            </div>
              <table class="table" id="data-table">
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
  </div>

  <!-- ***** Popup form of map file upload ***** -->
  <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="uploadModalLabel">Upload File</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="uploadForm" action="<?php echo BASE_URL?>/map/upload" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <label for="fileInput">Choose file</label>
                <input type="file" class="form-control" id="fileInput" name="file" required>
              </div>
              <div class="form-group">
                <label for="map_type">Select Map Type</label>
                <select class="custom-select" id="map_type" name="map_type" required>
                    <option value="" selected>Select Type</option>
                    <option value="point">Point</option>
                    <option value="line">Line</option>
                    <option value="polygone">Ploygone</option>
                </select>
              </div>
              <div class="form-group">
                <label for="district">Select District</label>
                <select class="custom-select" id="district" name="district" required>
                  <option value="" selected>Select District</option>
                  <?php
                    $filePath = 'C:\xampp\htdocs\AREECA\public\assets\districts.txt';

                    // Read the file content into an array
                    $districts = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                    foreach($districts as $item): ?>
                      <option value="<?php echo $item; ?>"><?php echo $item; ?></option>
              
                    

                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group">
                <label for="description">Description of the file</label>
                <textarea class="form-control" rows="5" id="comment" name="description"></textarea>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="uploadButton">Upload</button>
          </div>
        </div>
      </div>
  </div>

  <!-- ***** Confirmation Box for delete record ***** -->

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header alert alert-danger">
              <h5 class="modal-title" id="deleteModalLabel"><i class="fas fa-exclamation-triangle"></i><span> </span>Confimation: Delete Map </h5>
            </div>
            <div class="modal-body">
              <p>Are you sure about Deleting this file?</p>
              <form id="deleteMapForm" action="<?php echo BASE_URL?>/map/delete" method="POST">
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

  <script>
    $(".option").click(function(){
      $(".option").removeClass("active");
      $(this).addClass("active"); 
    });
  </script>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
                            <a style="padding:5px 12px" href="${BASE_URL}/map/update?id=${row.id}"><i class="fas fa-sync" title="Update DataFile"></i></a>
                            <a style="padding:5px 12px" href="#" data-toggle="modal" data-target="#deleteModal" data-id="${row.id}"><i class="fas fa-trash" title="Delete DataFile"></i></a>
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


            //delete map modal: Set id of map
            $('#deleteModal').on('show.bs.modal', function (event) {
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
    document.getElementById('uploadButton').addEventListener('click', function() {
        document.getElementById('uploadForm').submit();
    });
    document.getElementById('deleteMapButton').addEventListener('click', function() {
        document.getElementById('deleteMapForm').submit();
    });
    
  </script>

  </body>

</html>
