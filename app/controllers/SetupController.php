<?php

class SetupController extends Controller {

    public function index() {
        // $userModel = $this->model('User');
        // $roleModel = $this->model('Role');
        // $permissionModel = $this->model('Permission');
        // $mapModel = $this->model('Map');
        $mapModel = $this->model('Event');
    }

    public function test(){
        $a = password_hash("admin", PASSWORD_DEFAULT);
        $b = password_hash("moderator", PASSWORD_DEFAULT);
        echo("admin: " .$a."<br>");
        echo("moderator: " .$b."<br>");
    }

    public function map(){
        $jsonFilePath = __DIR__ .'\Lilongwe.json';
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
        // $this->make_json(json_encode($reformmedData));
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
        $counter = 1;
        foreach($data as $row){
            $formatted_data = array(
                "id" => NULL,
                "file_name" => NULL,
                "file_path" => NULL,
                "features" => array(
                    "geometry" =>array(),
                    "properties" => array()
                ),
                "aggregated_data" =>array(
                    "Area" => NULL,
                    "HaUnderRes" =>NULL
                )
            );

            //prepare values for each row
            $id = $row['id'];
            $file_name = $row['file_name'];
            $file_path = $row['file_path'];
            $geometry = json_decode($row['geometry'], true);
            $properties = json_decode($row['properties'], true);
            $tmp_district = NULL;
            echo($counter. "\n");
            
            $area = 0;
            $area_res = 0;

            //prepare some aggregated data to use in frontend
            foreach($properties as $item){
                if (array_key_exists('Area', $item['properties'])) {
                    $area = $item['properties']['Area'] + $area;
                }
                if (array_key_exists('HaUnderRes', $item['properties'])) {
                    $area_res = $item['properties']['HaUnderRes'] + $area_res;
                }
                if(!$tmp_district){
                    $tmp_district = $item['properties']['District'];
                    echo(
                        $tmp_district. "\n");
                }
            }
            

            //add the values
            $formatted_data['id'] = $id;
            $formatted_data['file_name'] = $file_name;
            $formatted_data['file_path'] = $file_path;
            $formatted_data['features']['geometry'] = $geometry;
            $formatted_data['aggregated_data']['Area'] = $area;
            $formatted_data['aggregated_data']['HaUnderRes'] = $area_res;

            array_push($finalData, $formatted_data);
            $counter++;
        }

        return $finalData;
    }
}