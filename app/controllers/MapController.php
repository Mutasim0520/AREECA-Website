<?php
class MapController extends Controller {
    public function index() {
        $mapModel = $this->model('Map');
        $maps = $mapModel->getMaps();
        $reformattedMapData = $this->prepareMapDataForView($maps);
        $this->view('map_viewer', ['maps' => $reformattedMapData]);
    }

    public function delete() {
        $this->redirect_url = BASE_URL. '/dashboard/index';
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_REQUEST['id'];
            $_SESSION['message_type'] = 'error';
            
            $mapModel = $this->model('Map');
            $delete_action = $mapModel->deleteMap($id);
            
            if($delete_action){
                $maps = $mapModel->getMaps();
                $_SESSION['message_type'] = 'success'; 
                $_SESSION['message'] = "File Deleted successfully";
                $this->redirect($this->redirect_url);
            }
            else{
                $_SESSION['message'] = "File Could Not Be Deleted";
                $this->redirect($this->redirect_url);
            }
        }
        else{
            $_SESSION['message'] = "Request error";
            $this->redirect($this->redirect_url);
        }
    }

    public function upload() {
        $_SESSION['message_type'] = 'error';
        $mapModel = $this->model('Map');
        $redirect_url = BASE_URL. 'dashboard/index';
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
                $allowedExtensions = ['geojson', 'json'];
                $fileName = $_FILES['file']['name'];
                $fileTmpName = $_FILES['file']['tmp_name'];
                $fileSize = $_FILES['file']['size'];
                $fileError = $_FILES['file']['error'];
                $fileType = $_FILES['file']['type']; 
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
                if (in_array($fileExt, $allowedExtensions)) {
                    // Check file size (optional)
                    if ($fileSize < 5000000) { // 5MB max size
                        // Validate the GeoJSON content
                        $fileContent = file_get_contents($fileTmpName);
                        if ($this->validateGeoJSON($fileContent)) {
                            $uploadDir = Storage_Path.'map_data_files/';
                            $fileNewName =$fileName;
                            $fileDestination = $uploadDir . $fileNewName;
        
                            if (move_uploaded_file($fileTmpName, $fileDestination)) {
                                $geo_data_tmp = json_decode($fileContent, true);
                                $geo_data = json_encode($geo_data_tmp['features']);
                                $maps = $mapModel->insert($fileNewName, $uploadDir, $geo_data);
                                if($maps){
                                    $_SESSION['message_type'] = 'success'; 
                                    $_SESSION['message'] = "File uploaded successfully";
                                    $this->redirect($redirect_url);
                                }
                            } else {
                                $_SESSION['message'] = "Error uploading file.\n";
                                $this->redirect($redirect_url);
                            }
                        } else {
                            $_SESSION['message'] = "Uploaded file is not a valid GeoJSON.\n";
                            $this->redirect($redirect_url);
                        }
                    } else {
                        $_SESSION['message'] = "File size is too large.\n";
                        $this->redirect($redirect_url);
                    }
                } else {
                    $_SESSION['message'] = "Invalid file type. Only .geojson and .json files are allowed.\n";
                    $this->redirect($redirect_url);
                }
            } else {
                $_SESSION['message'] = "No file was uploaded or there was an error.\n";
                $this->redirect($redirect_url);
            }
        }
    }

    private function validateGeoJSON($jsonContent) {
        json_decode($jsonContent);
        $jsonError = json_last_error();
        if ($jsonError !== JSON_ERROR_NONE) {
            return false;
        }
        
        $geojson = json_decode($jsonContent, true);
    
        // Check if the JSON content has the required GeoJSON structure
        if (isset($geojson['type']) && $geojson['type'] === 'FeatureCollection' && isset($geojson['features']) && is_array($geojson['features'])) {
            foreach ($geojson['features'] as $feature) {
                if (!isset($feature['type']) || $feature['type'] !== 'Feature') {
                    return false;
                }
                if (!isset($feature['geometry']) || !isset($feature['geometry']['type']) || !isset($feature['geometry']['coordinates'])) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    private function validateInput(){
        $district = $_REQUEST['district'];
        $map_type = $_REQUEST['map_type'];
        $description = $_REQUEST['description'];

        //Check for required fields
        if($district && $map_type){
            //check length
            if(strlen($district) <= 100 && strlen($map_type) <= 100 && strlen($description) <= 5000){
                //Check for special character to stop XSS
                if((preg_match("/^[a-zA-Z-' ]*$/", $description)) && (preg_match("/^[a-zA-Z-' ]*$/", $map_type)) && (preg_match("/^[a-zA-Z-' ]*$/", $district))){
                    return TRUE;
                }
                else return FALSE;

            }
            else
                return FALSE;
        }
        else{
            return FALSE;
        }

    }
}