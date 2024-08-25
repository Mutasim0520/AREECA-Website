<!DOCTYPE html>
<html lang="en">

<body>

    <!-- ***** Menu bar ***** -->
    <?php require 'menu.php'; ?>

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
                          <a href="reservation.html"><i class="fas fa-eye" title="View DataFile"></i></a>
                          <a href="reservation.html"><i class="fas fa-sync" title="Update DataFile"></i></a>
                          <a href="reservation.html"><i class="fas fa-trash" title="Delete DataFile"></i></a>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
            </div>
        </div>
      </div>
    </div>
  </div>

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
            <form id="uploadForm" action="uploadMapData" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <label for="fileInput">Choose file</label>
                <input type="file" class="form-control-file" id="fileInput" name="file">
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

   <!-- ***** footer ***** -->
   <?php require 'footer.php'; ?>


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

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script>
    document.getElementById('uploadButton').addEventListener('click', function() {
        document.getElementById('uploadForm').submit();
    });
    </script>

  </body>

</html>
