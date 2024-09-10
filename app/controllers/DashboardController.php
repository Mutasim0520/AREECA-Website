<?php

class DashboardController extends Controller {
    
    public function index() {
        if (isset($_SESSION['auth_token'])){
            $maps = $this->model('Map')->getMaps();
            $users = $this->model('User')->getAllUsersWithRoles();
            $reformattedMapData = $this->prepareMapDataForView($maps);
            $this->view('dashboard', ['maps' => $reformattedMapData, 'users' => $users]);
        }
        else{
            $redirect_path = BASE_URL. 'auth/signInForm';
            $this->redirect($redirect_path);
        }
    }

    public function addEvent(){
        $_SESSION['message_type'] = 'error';
        $redirect_url = BASE_URL. 'dashboard/index';
        if($this->is_authorized()){
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                if($this->validateInputs()){
                    $name = trim($_POST['event_name']);
                    $intro = trim($_POST['intro']);
                    $venue = trim($_POST['venue']);
                    $date = trim($_POST['date']);
                    $description = trim($_POST['description']);
                    $uploaded_images = $this->moveImagesToDirectorie();

                    if($uploaded_images['valid_images']){
                        $event = $this->model('Event')->insert($name, $venue, $date, $description, $uploaded_images['valid_images'],$intro);
                        if($event){
                            $_SESSION['message_type'] = 'success'; 
                            $_SESSION['message'] = "Event Created Successfully";
                            $this->redirect($redirect_url);
                        }
                    }
                    else{
                        $_SESSION['message'] = "ERROR: The image files are not valid. Please Upload in the following format .PNG, .JPEG. No Event was created.\n";
                        $this->redirectBack();
                    }

                }else{
                    $_SESSION['message'] = "ERROR: The inputs were not valid. No Event was created.\n";
                    $this->redirectBack();
                }
            }
        }
        else{
            $this->redirectBack();
        }
    }

    private function moveImagesToDirectorie(){
        $target_dir = BASE_IMAGE_PATH.'/events/';
        $imageFileUploadStat= array(
            "valid_images" => array(),
            "invalid_images" => array()
        );
        
        $valid_images = array();
        $invalid_images = array();
    
        foreach ($_FILES['images']['name'] as $key => $name) {
            $imageFileType = strtolower(pathinfo($name, PATHINFO_EXTENSION)); 
            $newFileName = uniqid() . '_' . time() . '.' . $imageFileType;
            
            // Define the full path for the new file
            $target_file = $target_dir . $newFileName;     
            $uploadOk = 1;
            
            // Check if the file is an actual image
            $check = getimagesize($_FILES['images']['tmp_name'][$key]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            }
            
            // Check file size (e.g., 5MB maximum)
            if ($_FILES['images']['size'][$key] > 6000000) {
                $uploadOk = 0;
            }
            
            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                $uploadOk = 0;
            }
            
            // If all checks pass, move the file
            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES['images']['tmp_name'][$key], $target_file)) {
                    array_push($valid_images, $newFileName); // Store the new file name
                }
            } else {
                array_push($invalid_images, $newFileName); // Store the original file name if the file is invalid
            }
        }
    
        $imageFileUploadStat['valid_images'] = $valid_images;
        $imageFileUploadStat['invalid_images'] = $invalid_images;
    
        return $imageFileUploadStat;
    }
    

    private function validateInputs(){
        $name = $_POST['event_name'];
        $venue = $_POST['venue'];
        $date = $_POST['date'];
        $description = $_POST['description'];
        $intro = $_POST['intro'];
        $validType = FALSE;
        $validLength = FALSE;

        if($name && $date && $description && $venue){
            //Length Check
            if((strlen($name) <= 200 ) && (strlen($venue) <= 100) && (strlen($description) <= 1000) && (strlen($intro) <= 200)){
                $validLength = TRUE;
            }

            if(!(preg_match("/^[$:;*]+$/", $description)) && !(preg_match("/^[$:;}* ]+$/", $intro)) && (preg_match("/^[a-zA-Z-0-9.:' ]+$/", $name)) && (preg_match("/^[a-zA-Z-0-9.:' ]+$/", $venue))){
                $validType = TRUE;
            }
        }

        return ($validLength && $validType);
    }

}