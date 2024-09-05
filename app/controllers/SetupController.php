<?php

class SetupController extends Controller {

    public function index() {
        $userModel = $this->model('User');
        $roleModel = $this->model('Role');
        $permissionModel = $this->model('Permission');
        $mapModel = $this->model('Map');
    }

    public function test(){
        $a = password_hash("admin", PASSWORD_DEFAULT);
        $b = password_hash("moderator", PASSWORD_DEFAULT);
        echo("admin: " .$a."<br>");
        echo("moderator: " .$b."<br>");
    }

    public function map(){
        $jsonFilePath = __DIR__ .'\Blantyre.geojson';
        $jsonString = file_get_contents($jsonFilePath);
        $dataArray = json_decode($jsonString, true);
        $features = $dataArray['features']; ///all the features
        // var_dump(json_encode($features[0]['geometry']));
        // var_dump(json_encode($features[0]['properties']));
        //print_r($features);
        // foreach ($features as $key => $value) {
        //     echo "$value</br>";
        // }
        $maps = $this->model('Map')->getMaps();
        $reformmedData = $this->formatGeoData($maps);
        $this->make_json(json_encode($reformmedData));
    }

    public function make_json($content){
        $file = __DIR__ . 'example.json';

        // Open the file for writing ('w' mode)
        // 'w' mode will truncate the file to zero length if it exists or create the file if it doesn't exist
        $handle = fopen($file, 'w');

        if ($handle) {
            // Write a string to the file
            fwrite($handle, $content);

            // Write another line
            // $additionalContent = "Adding another line to the file.\n";
            // fwrite($handle, $additionalContent);

            // Close the file handle to release the resource
            fclose($handle);

            echo "File written successfully.";
        } else {
            echo "Unable to open the file.";
        }
    }

    private function formatGeoData($data){
        $finalData = [];
        foreach($data as $row){
            $formatted_data = array(
                "id" => NULL,
                "file_name" => NULL,
                "file_path" => NULL,
                "features" => array(
                    "geometry" =>array(),
                    "properties" => array()
                )
            );

            //prepare values for each row
            $id = $row['id'];
            $file_name = $row['file_name'];
            $file_path = $row['file_path'];
            
            
            $geometry = json_decode($row['geometry'], true);
            $properties = json_decode($row['properties'], true);
            
            // var_dump($properties);
            // foreach($properties as $item){
                
            // }

            //add the values
            $formatted_data['id'] = $id;
            $formatted_data['file_name'] = $file_name;
            $formatted_data['file_path'] = $file_path;
            $formatted_data['features']['geometry'] = $geometry;
            $formatted_data['features']['properties'] = $properties;

            array_push($finalData, $formatted_data);
        }

        return $finalData;
    }
}