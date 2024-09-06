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
        if($this->$this->userRole){
            $role_id = $_SESSION['role_id'];
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
                )
            );

            //prepare values for each row
            $id = $row['id'];
            $file_name = $row['file_name'];
            $file_path = $row['file_path'];
            $geometry = json_decode($row['geometry'], true);
            $properties = json_decode($row['properties'], true);
            
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
            }
            

            //add the values
            $formatted_data['id'] = $id;
            $formatted_data['file_name'] = $file_name;
            $formatted_data['file_path'] = $file_path;
            $formatted_data['features']['geometry'] = $geometry;
            $formatted_data['aggregated_data']['Area'] = $area;
            $formatted_data['aggregated_data']['HaUnderRes'] = $area_res;

            array_push($finalData, $formatted_data);
        }

        return $finalData;
    }

}