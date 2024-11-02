<!-- ***** Popup form for adding new event ***** -->
<div class="modal fade bd-example-modal-xl" id="uploadModalDOM" tabindex="-1" role="dialog" aria-labelledby="uploadModalDOMLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h2><i class='fa fa-cog'></i> Add a DOM ELEMENT</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          <form id="uploadFormDOM" action="<?php echo BASE_URL?>dashboard/addDomElement" method="POST" enctype="multipart/form-data">
            <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                  <label for="dom_type">Select html Page <span style="color: red;">*</span></label>
                  <select class="form-control" id="pageSelect" name="html_page_name" required>
                    <option value="" seleted>Select Page</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="dom_type">Select DOM Type <span style="color: red;">*</span></label>
                  <select class="form-control" id="dom_id_select" name="dom_id" required>
                    <option value="" seleted>Select html page first</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="dom_header">DOM Header</label>
                  <input type="text" class="form-control" id="dom_header" name="dom_header">
                </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                    <label for="images">Choose file</label>
                    <input type="file" class="form-control" id="images" name="images[]" accept="image/*" multiple>
                  </div>
              </div>
              <div class="col-md-12">
                  <div class="form-group">
                    <label for="dom_text">DOM Text</label>
                    <textarea class="form-control ckeditor-textarea" id="dom_text" name="dom_text" rows="5"></textarea>
                  </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="uploadButtonDOM">Upload</button>
        </div>
        </div>
      </div>
    </div>
</div>