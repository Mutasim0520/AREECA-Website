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
            $roles = $this->model('User')->getRoles($user_id[0]["id"]);
            $permissionArray = [];
            foreach($roles as $role){
                $permissions = $this->model('Permission')->getPermissionsByRoleId($role["id"]);
                foreach($permissions as $item){
                    $model = $item['model'];
                    $read = $item['raed_permission'];
                    $write = $item['write_permission'];
                    $delete =$item['delete_permission'];

                    $permissionArray[$model] = [
                        'r' => $read,
                        'w' => $write,
                        'd' => $delete
                    ];
                }
            }

            $this->userAuth["token"] = $_SESSION['auth_token'];
            $this->userAuth["roles"] = $roles;
            $this->userAuth["permissions"] = $permissionArray;

            print_r($this->userAuth);

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