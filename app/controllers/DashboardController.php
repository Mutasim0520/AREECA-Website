<?php

class DashboardController extends Controller {
    
    public function index() {
        if (isset($_SESSION['auth_token'])){
            $maps = $this->model('Map')->getMaps();
            $users = $this->model('User')->getAllUsersWithRoles();
            $reformattedMapData = $this->prepareMapDataForView($maps);
            $documents = $this->model('Document')->getAllDocuments();
            $events = $this->model('Event')->getAllEvents();
            $urls = $this->model('Uri')->getAllUris();
            $doms = $this->getDomElements();
            // print_r($doms);
            $this->view('dashboard', ['maps' => $reformattedMapData, 'users' => $users, 'events' => $events, 'documents' => $documents, 'urls' => $urls, 'doms' => $doms]);
        }
        else{
            $redirect_path = BASE_URL. 'auth/signInForm';
            $this->redirect($redirect_path);
        }
    }

    private function getDomElements() {
        $index_doms = $this->model('DomElements')->getAllDomByPageName('index_page');
        $events_doms = $this->model('DomElements')->getAllDomByPageName('event_page');
        $document_doms = $this->model('DomElements')->getAllDomByPageName('documents_page');
        $map_doms = $this->model('DomElements')->getAllDomByPageName('map_viewer_page');

        $allDomElements = ['Index Page' => $index_doms, 'Event Page' => $events_doms, 'Map Viewer Page' => $map_doms, 'Documents Page' => $document_doms,];
        return $allDomElements;
    }

    public function addEvent(){
        $_SESSION['message_type'] = 'error';
        $redirect_url = BASE_URL. 'dashboard/index';
        if($this->is_authorized()){
            if(isset($_POST['event_name']) && isset($_POST['intro']) && isset($_POST['description']) && isset($_FILES['images'])){
                $inputs_rules = array(['field_name' => 'event_name', 'max_length' => 100, 'type' => 'string'],
                                ['field_name' => 'intro', 'max_length' => 200, 'type' => 'string'],
                                ['field_name' => 'venue', 'max_length' => 200, 'type' => 'string'],
                                ['field_name' => 'date', 'max_length' => 1000, 'type' => 'string'],
                                ['field_name' => 'description', 'max_length' => 1000, 'type' => 'string']
                );
                $validation_result = $this->validateInputs($inputs_rules);
                if($validation_result['is_valid']){
                    $name = ucwords(filter_var($_POST['event_name'], FILTER_SANITIZE_SPECIAL_CHARS));
                    $intro = filter_var($_POST['intro'], FILTER_SANITIZE_SPECIAL_CHARS);
                    $venue = filter_var($_POST['venue'], FILTER_SANITIZE_SPECIAL_CHARS);
                    $date = filter_var($_POST['date'], FILTER_SANITIZE_SPECIAL_CHARS);
                    $description = filter_var($_POST['description'], FILTER_SANITIZE_SPECIAL_CHARS);
                    $is_valid_image = $this->validateImage();
                    if($is_valid_image){
                        $cover_photo = $this->moveImageToDirectorie('events');
                        $uploaded_images = $this->moveImagesToDirectorie('events');
                        if($cover_photo){
                            if(!$uploaded_images['invalid_images']){
                                $event = $this->model('Event')->insert($name, $venue, $date, $description, $uploaded_images['valid_images'],$intro,$cover_photo);
                                if($event){
                                    $_SESSION['message_type'] = 'success'; 
                                    $_SESSION['message'] = "Event Created Successfully";
                                    $this->redirect($redirect_url);
                                }
                            }else{
                                $_SESSION['message'] = "ERROR: The image files are not valid or too big. Please Upload in the following format .PNG, .JPEG. No Event was created.\n";
                                $this->redirectBack();
                            }
                        }else{
                            $_SESSION['message'] = "ERROR: The image files are not valid or too big. Please Upload in the following format .PNG, .JPEG. No Event was created.\n";
                            $this->redirectBack();
                        }
                    }else{
                        $_SESSION['message'] = "ERROR: The image files are not valid. Please Upload in the following format .PNG, .JPEG. No Event was created.\n";
                        $this->redirectBack();
                    }
                }else{
                    $_SESSION['message'] = $validation_result['is_valid']."\n";
                    $this->redirectBack();
                }
            }else{
                $_SESSION['message'] = "ERROR: The inputs were not valid. No Event was created.\n";
                $this->redirectBack();
            }
        }
        else{
            $this->redirectBack();
        }
    }

    private function moveImagesToDirectorie($directorie=NULL){
        $imageFileUploadStat= array(
            "valid_images" => array(),
            "invalid_images" => array()
        );
        if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])){
            $target_dir = BASE_IMAGE_PATH. $directorie .'/';      
            $valid_images = array();
            $invalid_images = array();
            foreach ($_FILES['images']['name'] as $key => $name) {
                $imageFileType = strtolower(pathinfo($name, PATHINFO_EXTENSION)); 
                $newFileName = uniqid() . '_' . time() . '.' . $imageFileType;
                
                // Define the full path for the new file
                $target_file = $target_dir . $newFileName;     
               
                // If all checks pass, move the file
                if (move_uploaded_file($_FILES['images']['tmp_name'][$key], $target_file)) {
                    array_push($valid_images, $newFileName); // Store the new file name
                }else{
                    array_push($invalid_images, $newFileName); // Store the new file name
                }
            }
        
            $imageFileUploadStat['valid_images'] = $valid_images;
            $imageFileUploadStat['invalid_images'] = $invalid_images;
        }

        return $imageFileUploadStat;
        
    }

    private function moveImageToDirectorie($directorie=NULL){
        $temp_file = $_FILES['image']['tmp_name'];
        if($directorie){
            $target_directory = BASE_IMAGE_PATH. $directorie .'/';
        }
        else{
            $target_directory = BASE_IMAGE_PATH;
        }

        $target_file = $target_directory . basename($_FILES['image']['name']);
            
         // Check file type (e.g., only allow JPEG and PNG)
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png'];
            
        if (!in_array($file_type, $allowed_types)) {
            return false;
        }
        
            // Check file size (e.g., limit to 5MB)
        if ($_FILES['image']['size'] > 6 * 1024 * 1024) {
            return false;
        }
            
            // Move the file
        if (move_uploaded_file($temp_file, $target_file)) {
            return basename($_FILES['image']['name']);
        } else {
                return false;
        }
    }

    private function validateInputsDOM(){
        $validType = True;
        $validLength = True;

        $dom_text = trim($_POST['dom_text']);
        $dom_header = ucwords(trim($_POST['dom_header']));
        $html_page_name = trim($_POST['html_page_name']);
        $dom_id = trim($_POST['dom_id']);

        if($dom_id){
            //Length Check
            if((strlen($html_page_name) <= 100) && (strlen($dom_text) <= 2000) && (strlen($dom_header) <= 200)){
                $validLength = TRUE;
            }

            // if(strlen($dom_text)){
            //     if(preg_match("/^[$;*]+$/", $dom_text)){
            //         $validType = False;
            //     }
            // }
            // if(strlen($dom_header)){
            //     if(preg_match("/^[$;}* ]+$/", $dom_header)){
            //         $validType = False;
            //     }
            // }
            
        }

        return ($validLength && $validType);
    }

    private function validateImage(){
        $uploadOk = true;
        if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])){
            foreach ($_FILES['images']['name'] as $key => $name) {
                
                $check = getimagesize($_FILES['images']['tmp_name'][$key]);
                $imageFileType = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                
                // Check if the file is an actual image
                if ($check !== false) {
                    $uploadOk = true;
                } else {
                    return false;
                }
                
                // Check file size (e.g., 5MB maximum)
                if ($_FILES['images']['size'][$key] > 6000000) {
                    return false;
                }
                
                // Allow certain file formats
                $allowed_types = ['jpg', 'jpeg', 'png'];
                if (!in_array($imageFileType, $allowed_types)) {
                    return false;
                }
            }
        }
        return $uploadOk;
    }

    public function uploadDocument(){
        $_SESSION['message_type'] = 'error';
        $redirect_url = BASE_URL. 'dashboard/index';
        if($this->is_authorized()){
            if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
                $allowedExtensions = ['pdf', 'txt', 'docx', 'ppt', 'pptx', 'doc', 'xlsx'];
                $fileName = $_FILES['file']['name'];
                $fileTmpName = $_FILES['file']['tmp_name'];
                $fileSize = $_FILES['file']['size'];
                $fileError = $_FILES['file']['error'];
                $fileType = $_FILES['file']['type']; 
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                if (in_array($fileExt, $allowedExtensions)) {
                    
                    // Check file size (optional)
                    if ($fileSize < 5000000) { // 5MB max size
                        $uploadDir = Storage_Path.'docs/';
                        $fileNewName =uniqid() . '_' . time() . '.' . $fileExt;
                        $fileDestination = $uploadDir . $fileNewName;

                        if (move_uploaded_file($fileTmpName, $fileDestination)){
                            $doc_upload = $this->model('Document')->insert($fileNewName, $fileName);
                            if($doc_upload){

                                $_SESSION['message_type'] = 'success'; 
                                $_SESSION['message'] = "fileName has been uploaded successfully";
                                $this->redirect($redirect_url);
                            }
                            else{
                                $_SESSION['message'] = "ERROR: There was a problem moving the file please try again \n";
                                $this->redirectBack();}
                        }else{
                            $_SESSION['message'] = "ERROR: There was a problem moving the file please try again \n";
                            $this->redirectBack();
                        }
                    }
                    $_SESSION['message'] = "ERROR: The uploaded file is too big. Maximum allowed File size 5MB \n";
                    $this->redirectBack();
                    
                }else{
                    $_SESSION['message'] = "ERROR: The uploaded file Type is not allowed. Only the following types oof file can be uploaded 'pdf', 'txt', 'docx', 'ppt', 'pptx', 'doc', 'xlsx'\n";
                    $this->redirectBack();
                }
            }else{
                $_SESSION['message'] = "ERROR: The uploaded file Type is not allowed. Only the following types oof file can be uploaded 'pdf', 'txt', 'docx', 'ppt', 'pptx', 'doc', 'xlsx'\n";
                $this->redirectBack();
            }
        }else{
            $this->redirectBack();
        }
    }

    public function uploadURL(){
        $_SESSION['message_type'] = 'error';
        $redirect_url = BASE_URL. 'dashboard/index';
        if($this->is_authorized()){
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                $url = $_POST['perma_link'];
                $name = $_POST['name'];
                $logo = $this->moveImageToDirectorie('doms');
                if (filter_var($url, FILTER_VALIDATE_URL) && strlen($name) <=100 && (preg_match("/^[a-zA-Z-0-9.:' ]+$/", $name))) {
                    $add_url = $this->model('Uri')->insert($name,$url,$logo);
                    if($add_url){
                        $_SESSION['message_type'] = 'success'; 
                        $_SESSION['message'] = "URL Successfully Added";
                        return $this->redirect($redirect_url);
                    }else{
                        $_SESSION['message'] = "Something Went Wrong. Please Try AGAIN \n";
                        return $this->redirectBack();
                    }
                } else {
                    $_SESSION['message'] = "Not A valid URL or Name \n";
                    return $this->redirectBack();
                }
            }
        }
        
    }

    public function addDomElement(){
        $_SESSION['message_type'] = 'error';
        $redirect_url = BASE_URL. 'dashboard/index';
        if($this->is_authorized()){
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                if($this->validateInputsDOM()){
                    $html_page_name = trim($_POST['html_page_name']);
                    $dom_id = trim($_POST['dom_id']);
                    $dom_text = trim($_POST['dom_text']);
                    $dom_header = ucwords(trim($_POST['dom_header']));
                    $is_valid_image = $this->validateImage();
                    if($is_valid_image){
                        $uploaded_images = $this->moveImagesToDirectorie('doms');
                        if(!$uploaded_images['invalid_images']){
                            $event = $this->model('DomElements')->insert($html_page_name, $dom_id, $dom_text, $dom_header, $uploaded_images['valid_images']);
                            if($event){
                                $_SESSION['message_type'] = 'success'; 
                                $_SESSION['message'] = "DOM Created Successfully";
                                $this->redirect($redirect_url);
                            }
                        }
                    }else{
                        $_SESSION['message'] = "ERROR: The image files are not valid. Please Upload in the following format .PNG, .JPEG. No Event was created.\n";
                        $this->redirectBack();
                    }

                }else{
                    $_SESSION['message'] = "ERROR: The inputs were not valid. No DOM was not Updated.\n";
                    $this->redirectBack();
                }
            }
        }
        else{
            $this->redirectBack();
        }
    }

    public function deleteDOM(){
        $_SESSION['message_type'] = 'error';
        $redirect_url = BASE_URL. 'dashboard/index';
        if($this->is_authorized()){
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                if(isset($_POST['image_id'])){
                    $id = $_POST['image_id'];
                    $is_deleted = $this->model('DomElements')->deleteDOMImage($id);
                }
                else{
                    $id = $_POST['id'];
                    $is_deleted = $this->model('DomElements')->deleteDOM($id);
                }
                if ($is_deleted){
                    $_SESSION['message_type'] = 'success'; 
                    $_SESSION['message'] = "Successfully Deleted";
                    return $this->redirect($redirect_url);
                }
                else{
                    $_SESSION['message'] = "Something Went Wrong. Please Try AGAIN \n";
                    return $this->redirectBack();
                }
                 
            }else{
                return $this->redirectBack();
            }
        }else{
            return $this->redirectBack();
        }
    }

    public function deleteEvent(){
        $_SESSION['message_type'] = 'error';
        $redirect_url = BASE_URL. 'dashboard/index';
        if($this->is_authorized()){
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                if(isset($_POST['id'])){
                    $id = $_POST['id'];
                    $is_deleted = $this->model('Event')->deleteEvent($id);
                }
                if ($is_deleted){
                    $_SESSION['message_type'] = 'success'; 
                    $_SESSION['message'] = "Event Successfully Deleted";
                    return $this->redirect($redirect_url);
                }
                else{
                    $_SESSION['message'] = "Something Went Wrong. Please Try AGAIN \n";
                    return $this->redirectBack();
                }
                 
            }else{
                return $this->redirectBack();
            }
        }else{
            return $this->redirectBack();
        }
    }

    public function deleteDocument(){
        $_SESSION['message_type'] = 'error';
        $redirect_url = BASE_URL. 'dashboard/index';
        if($this->is_authorized()){
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                if(isset($_POST['id'])){
                    $id = $_POST['id'];
                    $is_deleted = $this->model('Document')->deleteDocument($id);
                }
                if ($is_deleted){
                    $_SESSION['message_type'] = 'success'; 
                    $_SESSION['message'] = "Document Successfully Deleted";
                    return $this->redirect($redirect_url);
                }
                else{
                    $_SESSION['message'] = "Something Went Wrong. Please Try AGAIN \n";
                    return $this->redirectBack();
                }
                 
            }else{
                return $this->redirectBack();
            }
        }else{
            return $this->redirectBack();
        }
    }

    public function deleteURL(){
        $_SESSION['message_type'] = 'error';
        $redirect_url = BASE_URL. 'dashboard/index';
        if($this->is_authorized()){
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                if(isset($_POST['id'])){
                    $id = $_POST['id'];
                    $is_deleted = $this->model('Uri')->deleteUri($id);
                }
                if ($is_deleted){
                    $_SESSION['message_type'] = 'success'; 
                    $_SESSION['message'] = "URL Successfully Deleted";
                    return $this->redirect($redirect_url);
                }
                else{
                    $_SESSION['message'] = "Something Went Wrong. Please Try AGAIN \n";
                    return $this->redirectBack();
                }
                 
            }else{
                return $this->redirectBack();
            }
        }else{
            return $this->redirectBack();
        }
    }


}