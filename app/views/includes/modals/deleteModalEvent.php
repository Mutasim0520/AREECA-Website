
  <!-- ***** Confirmation Box for delete record ***** -->

  <div class="modal fade" id="deleteModalEvent" tabindex="-1" role="dialog" aria-labelledby="deleteModalEventLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header alert alert-danger">
            <h5 class="modal-title" id="deleteModalEventLabel"><i class="fas fa-exclamation-triangle"></i><span> </span>Confimation: Delete Event </h5>
          </div>
          <div class="modal-body">
            <p>Are you sure about Deleting this <i class='fa-regular fa-file-lines'></i> item?</p>
            <form id="deleteFormEvent" action="<?php echo BASE_URL?>dashboard/deleteEvent" method="POST">
                <input type="hidden" name="id" id="event_id_delete"> <!-- Item ID to delete -->
            </form>
          </div>  
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="deleteEventButton">Confirm</button>
          </div>
        </div>
      </div>
  </div>