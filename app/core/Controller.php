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

    protected function is_authorized(){
        if($this->$this->userRole){
            $role_id = $_SESSION['role_id'];
        }
    }

}