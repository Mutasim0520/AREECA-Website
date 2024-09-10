<!-- ***** Popup form for adding new event ***** -->
<div class="modal fade bd-example-modal-xl" id="uploadModalEvent" tabindex="-1" role="dialog" aria-labelledby="uploadModalEventLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h2>Add a New Event</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          <form id="uploadFormEvent" action="<?php echo BASE_URL?>dashboard/addEvent" method="POST" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="event_name">Event Name</label>
                  <input type="text" class="form-control" id="event_name" name="event_name" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="venue">Venue</label>
                  <input type="text" class="form-control" id="venue" name="venue" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="date">Date</label>
                  <input type="date" class="form-control" id="date" name="date" required>
                </div>
              </div>
              <div class="col-md-4">
                  <div class="form-group">
                    <label for="images">Choose file</label>
                    <input type="file" class="form-control" id="images" name="images[]" multiple required>
                  </div>
              </div>
              <div class="col-md-12">
                  <div class="form-group">
                    <label for="intro">Intro</label>
                    <textarea class="form-control" id="intro" name="intro" rows="2"></textarea>
                  </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="10"></textarea>
                  </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="uploadButtonEvent">Upload</button>
        </div>
        </div>
      </div>
    </div>
</div>