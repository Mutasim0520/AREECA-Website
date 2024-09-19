<!-- ***** Popup form for adding new event ***** -->
<div class="modal fade bd-example-modal-xl" id="uploadModalURL" tabindex="-1" role="dialog" aria-labelledby="uploadModalURLLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h2>Add a New URL</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          <form id="uploadFormURL" action="<?php echo BASE_URL?>dashboard/uploadURL" method="POST" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-8">
                <div class="form-group">
                  <label for="perma-link">Perma Link</label>
                  <input type="url" class="form-control" id="perma-link" name="perma_link" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="url_name">URL Name</label>
                  <input type="text" class="form-control" id="url_name" name="name" required>
                </div>
              </div>
              <div class="col-md-12">
                  <div class="form-group">
                    <label for="images">Choose Logo</label>
                    <input type="file" class="form-control" id="image" name="image" required>
                  </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="uploadButtonURL">Upload</button>
        </div>
        </div>
      </div>
    </div>
</div>