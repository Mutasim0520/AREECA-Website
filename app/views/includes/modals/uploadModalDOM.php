<!-- ***** Popup form for adding new event ***** -->
<div class="modal fade bd-example-modal-xl" id="uploadModalDOM" tabindex="-1" role="dialog" aria-labelledby="uploadModalDOMLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h2>Add a DOM ELEMENT</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          <form id="uploadFormDOM" action="<?php echo BASE_URL?>dashboard/addDomElement" method="POST" enctype="multipart/form-data">
            <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                  <label for="dom_type">Select html Page</label>
                  <select class="form-control" id="html_page_name" name="html_page_name" onselect=setDomID required>
                    <option value="" seleted>Select Type</option>
                    <option value="index_page">Index Page</option>
                    <option value="events_page">Events Page</option>
                    <option value="events_detail_page">Event Details Page</option>
                    <option value="map_viewer">Map Viewer Page </option>
                    <option value="documents_page">Documents Page </option>
                    <option value="contacts_page">Contacts Page </option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="dom_type">Select DOM Type</label>
                  <select class="form-control" id="dom_type" name="dom_type" onselect=setDomID required>
                    <option value="" seleted>Select Type</option>
                    <option value="index-page-main-slider">Index Page Top Slider Section</option>
                    <option value="index-page-content-1">Index Page Text Section 1</option>
                    <option value="index-page-partners">Index Page Partners Section</option>
                    <option value="event-page-main-text-section">Event Page Top Text Section</option>
                    <option value="map-viewer-page-top-text-section">Map Viewer Page Top Text Section</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="page_url">Page URL</label>
                  <input type="url" class="form-control" id="page_url" name="page_url" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="dom_header">DOM Header</label>
                  <input type="text" class="form-control" id="dom_header" name="dom_header" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="dom_id">DOM ID</label>
                  <input type="text" class="form-control" id="dom_id" name="dom_id" required disabled>
                </div>
              </div>
              <div class="col-md-4">
                  <div class="form-group">
                    <label for="images">Choose file</label>
                    <input type="file" class="form-control" id="images" name="images[]" multiple>
                  </div>
              </div>
              <div class="col-md-12">
                  <div class="form-group">
                    <label for="dom_text">DOM Text</label>
                    <textarea class="form-control" id="dom_text" name="dom_text" rows="5"></textarea>
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