<?php

class MapController extends Controller {

    public function index() {
        $userModel = $this->model('Map'); // Loads the User model
        $user = $userModel->getUserById(1);
        // $this->view('home/index', ['user' => $user]); // Passing data to the view
        // $user = $this->model('User');
        // $userData = $user->getUser(1);
        // $this->view('home/index', ['name' => $userData['name']]);
        $this->view('index', []);
    }

    public function delete() {
        $redirect_path = Base_Path. '/dashboard/index';
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_REQUEST['id'];
            $_SESSION['message_type'] = 'error';
            
            $mapModel = $this->model('Map');
            $delete_action = $mapModel->deleteMap($id);
            
            if($delete_action){
                $maps = $mapModel->getMaps();
                $_SESSION['message_type'] = 'success'; 
                $_SESSION['message'] = "File Deleted successfully";
                $this->redirect($redirect_path);
            }
            else{
                $_SESSION['message'] = "File Could Not Be Deleted";
                $this->redirect($redirect_path);
            }
        }
        else{
            $_SESSION['message'] = "Request error";
            $this->redirect($redirect_path);
        }
    }
}