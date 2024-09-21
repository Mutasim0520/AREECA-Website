<?php
class Controller {
    protected $userAuth= array(
        "token" => NULL,
        "roles" => NULL,
        "permissions" => array()
    );

    public function model($model) {
        require_once 'app/models/' . $model . '.php';
        return new $model();
    }

    public function view($view, $data = []) {
        extract($data);
        require_once 'app/views/' . $view . '.php';
    }

    public function redirect($url) {
        header('Location: ' . $url);
        exit;
    }

    public function redirectBack() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $url =  $_SERVER['HTTP_REFERER'];
        }
        else{
            $url =  BASE_URL. 'index';
        }
        
        header('Location: ' . $url);
        exit;
    }

    protected function is_authorized(){
        if(isset($_SESSION['auth_token'])){
           return TRUE;
        }
        else {
            $_SESSION['message'] = "You are not authorized to perfor this action.\n";
            return FALSE;
        }
    }

    protected function prepareMapDataForView($data){
        $finalData = [];
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
                ),
                "type_tags" => array(),
                "district" => NULL
            );

            //prepare values for each row
            $id = $row['id'];
            $file_name = $row['file_name'];
            $file_path = $row['file_path'];
            $geometry = json_decode($row['geometry'], true);
            $properties = json_decode($row['properties'], true);
            
            $area = 0;
            $area_res = 0;
            $tmp_district = NULL;
            $tmp_type_tags = array();

            // Read the file content for the indexes of properties which are used as table filters
            $filePath = BASE_PATH .'\public\assets\districts.txt';                   
            $filters = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);


            //prepare some aggregated data to use in frontend
            if($properties){
                foreach($properties as $item){
                    if(array_key_exists('Area', $item['properties'])) {
                        $area = $item['properties']['Area'] + $area;
                    }
                    if(array_key_exists('HaUnderRes', $item['properties'])) {
                        $area_res = $item['properties']['HaUnderRes'] + $area_res;
                    }
    
                    if(!$tmp_district){
                        $tmp_district = $item['properties']['District'];
                    }
                    if(!in_array($item['properties']['Type'], $tmp_type_tags)){
                        array_push($tmp_type_tags, $item['properties']['Type']);
                    }
                }
            }

            //add the values
            $formatted_data['id'] = $id;
            $formatted_data['file_name'] = $file_name;
            $formatted_data['file_path'] = $file_path;
            $formatted_data['features']['geometry'] = $geometry;
            $formatted_data['features']['properties'] = $properties;
            $formatted_data['aggregated_data']['Area'] = $area;
            $formatted_data['aggregated_data']['HaUnderRes'] = $area_res;
            $formatted_data['type_tags'] = $tmp_type_tags;
            $formatted_data['district'] = $tmp_district;

            array_push($finalData, $formatted_data);
        }

        return $finalData;
    }

    protected function filterDomElement($doms,$target_dom_id){
        $matching_dom_elemnts = array();

        //filter the matching dom indexs
        foreach ($doms as $index => $element) {
            if ($element['dom_id'] == $target_dom_id) {
                $matching_dom_elemnts[] = $element;
            }
        }

        return $matching_dom_elemnts;

    }

}