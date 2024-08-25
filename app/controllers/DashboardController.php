<?php

class DashboardController extends Controller {

    public function dashboard() {
        $userModel = $this->model('User'); // Loads the User model
        $user = $userModel->getUserById(1);
        // $this->view('home/index', ['user' => $user]); // Passing data to the view
        // $user = $this->model('User');
        // $userData = $user->getUser(1);
        // $this->view('home/index', ['name' => $userData['name']]);
        $this->view('dashboard', []);
    }

    public function uploadMapData() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
                $allowedExtensions = ['geojson', 'json'];
                $fileName = $_FILES['file']['name'];
                $fileTmpName = $_FILES['file']['tmp_name'];
                $fileSize = $_FILES['file']['size'];
                $fileError = $_FILES['file']['error'];
                $fileType = $_FILES['file']['type'];
                $map_type = "Pointer";
                $district = "Kakao";
                $description = "Random text";
        
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
                if (in_array($fileExt, $allowedExtensions)) {
                    // Check file size (optional)
                    if ($fileSize < 5000000) { // 5MB max size
                        // Validate the GeoJSON content
                        $fileContent = file_get_contents($fileTmpName);
                        if ($this->validateGeoJSON($fileContent)) {
                            $uploadDir = Storage_Path.'map_data_files/';
                            $fileNewName = uniqid('', true) . "." . $fileExt;
                            $fileDestination = $uploadDir . $fileNewName;
        
                            if (move_uploaded_file($fileTmpName, $fileDestination)) {
                                $mapModel = $this->model('Map');
                                $maps = $mapModel->insert($fileNewName,$map_type,$district, $description);
                                $this->view('dashboard', ['map' => $maps]);
                                echo "File is valid and was successfully uploaded.\n";
                            } else {
                                echo "Error uploading file.\n";
                            }
                        } else {
                            echo "Uploaded file is not a valid GeoJSON.\n";
                        }
                    } else {
                        echo "File size is too large.\n";
                    }
                } else {
                    echo "Invalid file type. Only .geojson and .json files are allowed.\n";
                }
            } else {
                echo "No file was uploaded or there was an error.\n";
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
}