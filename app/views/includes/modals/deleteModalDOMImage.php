
  <!-- ***** Confirmation Box for delete record ***** -->

  <div class="modal fade" id="deleteModalDOMImage" tabindex="-1" role="dialog" aria-labelledby="deleteModalDOMImageLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header alert alert-danger">
            <h5 class="modal-title" id="deleteModalDOMImageLabel"><i class="fas fa-exclamation-triangle"></i><span> </span>Confimation: Delete Image </h5>
          </div>
          <div class="modal-body">
            <p>Are you sure about Deleting this item?</p>
            <form id="deleteFormDOMImage" action="<?php echo BASE_URL?>dashboard/deleteDOM" method="POST">
                <input type="hidden" name="image_id" id="dom_image_id_delete"> <!-- Item ID to delete -->
            </form>
          </div>  
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="deleteDOMImageButton">Confirm</button>
          </div>
        </div>
      </div>
  </div>