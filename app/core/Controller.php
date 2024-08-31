<?php
class Controller {
    protected $userAuth= array(
        "token" => NULL,
        "roles" => NULL,
        "permissions" => array()
    );
    

    public function __construct(){
        if (isset($_SESSION['auth_token'])) {
            $user_id = $this->model('User')->getUserIdByToken($_SESSION['auth_token']);
            $roles = $this->model('Role')->getRoles($user_id);
            $permissionArray = [];
            foreach($roles as $role){
                $permissions = $this->model('Permission')->getPermissionsByRoleId($role["id"]);
                $model = $permissions['model'];
                $read = $permissions['raed_permission'];
                $write = $permissions['write_permission'];
                $delete = $permissions['delete_permission'];
                
                $permissionArray[$model] = [
                    'r' => $read,
                    'w' => $write,
                    'd' => $delete
                ];
            }
            $this->userAuth["token"] = $_SESSION['token'];
            $this->userAuth["roles"] = $roles;
            $this->userAuth["permissions"] = $permissionArray;

        }
    }

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