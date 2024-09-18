
  <!-- ***** Confirmation Box for delete record ***** -->

  <div class="modal fade" id="deleteModalDOM" tabindex="-1" role="dialog" aria-labelledby="deleteModalDOMLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header alert alert-danger">
            <h5 class="modal-title" id="deleteModalDOMLabel"><i class="fas fa-exclamation-triangle"></i><span> </span>Confimation: Delete Item </h5>
          </div>
          <div class="modal-body">
            <p>Are you sure about Deleting this item?</p>
            <form id="deleteFormDOM" action="<?php echo BASE_URL?>dashboard/deleteDOM" method="POST">
                <input type="hidden" name="id" id="dom_id_delete"> <!-- Item ID to delete -->
            </form>
          </div>  
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="deleteDOMButton">Confirm</button>
          </div>
        </div>
      </div>
  </div>