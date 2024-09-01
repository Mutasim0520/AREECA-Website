<?php

class AuthController extends Controller {

    public function loginForm() {
        return $this->view('auth');
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $email = $_REQUEST['email'];
            $password = $_REQUEST['password'];
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $user = $this->model('User')->getUserByEmail($email);

            if ($user && password_verify($hashedPassword, $user[0]['password'])) {
                $_SESSION['auth_token'] = $user[0]['token'];
                $this->setUserAuthInfo($user);
                return $this->view('dashboard');
            } else {
                $_SESSION['message_type'] = 'error';
                $_SESSION['message'] = "Login failed. Please check your email and password.";
                return $this->view('auth');
            }
        } else{

        }
    }
    
    protected function setUserAuthInfo($user){
        if (isset($_SESSION['auth_token'])) {
            $roles = $this->model('User')->getRoles($user[0]["id"]);
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
        }
    }
}