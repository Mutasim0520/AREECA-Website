<!-- ***** Popup form of Document file upload ***** -->
<div class="modal fade" id="uploadModalDocument" tabindex="-1" role="dialog" aria-labelledby="uploadModalDocumentLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="uploadModalDocumentLabel">Upload New Document</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="uploadFormDocument" action="<?php echo BASE_URL?>/dashboard/uploadDocument" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <label for="fileInput">Choose file</label>
              <input type="file" class="form-control" id="fileInput" name="file" required>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="uploadButtonDocument">Upload</button>
        </div>
      </div>
    </div>
</div>