
  <!-- ***** Confirmation Box for delete record ***** -->

  <div class="modal fade" id="deleteModalURL" tabindex="-1" role="dialog" aria-labelledby="deleteModalURLLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header alert alert-danger">
            <h5 class="modal-title" id="deleteModalURLLabel"><i class="fas fa-exclamation-triangle"></i><span> </span>Confimation: Delete URL </h5>
          </div>
          <div class="modal-body">
            <p>Are you sure about Deleting this <i class="fa-solid fa-link"></i> item?</p>
            <form id="deleteFormURL" action="<?php echo BASE_URL?>dashboard/deleteURL" method="POST">
                <input type="hidden" name="id" id="URL_id_delete"> <!-- Item ID to delete -->
            </form>
          </div>  
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="deleteURLtButton">Confirm</button>
          </div>
        </div>
      </div>
  </div>