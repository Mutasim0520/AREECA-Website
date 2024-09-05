<?php

class DashboardController extends Controller {
    
    public function index() {
        if (isset($_SESSION['auth_token'])){
            $maps = $this->model('Map')->getMaps();
            $users = $this->model('User')->getAllUsersWithRoles();
            $reformattedData = $this->prepareMapDataForView($maps);
            $this->view('dashboard', ['maps' => $maps, 'users' => $users]);
        }
        else{
            $redirect_path = BASE_URL. 'auth/signInForm';
            $this->redirect($redirect_path);
        }
    }

    private function prepareMapDataForView($data){
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
            
            $geometry = json_decode(json_encode($row['geometry']), true);
            $properties = json_decode(json_encode($row['properties']), true);

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