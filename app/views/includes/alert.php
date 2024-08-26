<div class="container mt-4">
        <?php
        // Check if there is a message in the session
        if (isset($_SESSION['message']) && isset($_SESSION['message_type'])):
            $message = $_SESSION['message'];
            $message_type = $_SESSION['message_type'];

            // Determine the alert class and icon based on message type
            switch ($message_type) {
                case 'success':
                    $alert_class = 'alert-success';
                    $icon_class = 'fa-check-circle';
                    break;
                case 'error':
                    $alert_class = 'alert-danger';
                    $icon_class = 'fa-exclamation-circle';
                    break;
                default:
                    $alert_class = 'alert-secondary';
                    $icon_class = 'fa-info-circle';
                    break;
            }
        ?>
        <!-- Display the message with appropriate styling -->
        <div class="alert <?php echo $alert_class; ?> alert-dismissible fade show alert-fixed" style="z-index:1050" role="alert">
            <i class="fas <?php echo $icon_class; ?>"></i> <?php echo $message; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
      <?php
          // Clear the message and type from the session to prevent it from showing again
          unset($_SESSION['message']);
          unset($_SESSION['message_type']);
      endif;
      ?>
  </div>