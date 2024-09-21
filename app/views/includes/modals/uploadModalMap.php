<!-- ***** Popup form of map file upload ***** -->
<div class="modal fade" id="uploadModalMap" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="uploadModalLabel"><i class="fa fa-map-marker"></i> Upload Map File</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="uploadFormMap" action="<?php echo BASE_URL?>/map/upload" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <label for="fileInput">Select Only (.geojson) Formatted File <span style="color: red;">*</span></label>
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