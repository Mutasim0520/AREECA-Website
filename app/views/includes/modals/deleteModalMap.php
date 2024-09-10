
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