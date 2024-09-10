<!DOCTYPE html>
<html lang="en">

<?php require 'includes/header.php'; ?>

<body>

  <!-- ***** Menu bar ***** -->
  <?php require 'includes/menu.php'; ?>

  <!-- ***** Main Banner Area Start ***** -->
  
  <!-- ***** Main Banner Area End ***** -->
  
    <div class="wrapper">
      <div class="visit-country">
        <div class="container">
          <div class="row">
            <div class="col-lg-6 offset-lg-3">
              <div class="section-heading text-center">
                <h1>L A T E S T &nbsp; E V E N T S</h1>
                <hr>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="itme">
              <table class="table" id="documents_table">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">File</th>
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
            <div class="itme"></div>
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

  <!-- ***** footer ***** -->

  <script id="data-script" type="application/json">
        <?php echo(json_encode($documents)); ?>
  </script>
  <script id="data-script-storage-path" type="application/json">
        <?php echo(Storage_Path); ?>
  </script>
  <script>
    const rowsPerPage = 10;
        let currentPage = 1;
        let original_data = JSON.parse(document.getElementById('data-script').textContent);
        let storage_path = (document.getElementById('data-script-storage-path').textContent) + "docs/";
        console.log(storage_path);

        function loadData(data) {
          renderTable(data);
          renderPagination(data);
        }

        function renderTable(data) {
            const startIndex = (currentPage - 1) * rowsPerPage;
            const endIndex = startIndex + rowsPerPage;
            const paginatedData = data.slice(startIndex, endIndex);

            $('#documents_table tbody').empty();
            var index_counter = 1;
            paginatedData.forEach(row => {
                    $('#documents_table tbody').append(`
                    <tr>
                        <td>${index_counter}</td>
                        <td>${row['real_name']}</td>
                        <td>
                          <div class="main-button">
                            <a style="padding:5px 12px" href="${storage_path + row['name']}" download><i class="fa-solid fa-download" title="Download File"></i></a>
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

        $(document).ready(function() {
          loadData(original_data); // Load data when the document is ready
          $(document).on('click', '#pagination .page-link', function(e) {
              e.preventDefault();
              currentPage = $(this).data('page');
              loadData(original_data);
          });
      });
  </script>

  </body>

</html>
