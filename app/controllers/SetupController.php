<?php

class SetupController extends Controller {

    public function index() {
        $userModel = $this->model('User');
        $roleModel = $this->model('Role');
        $permissionModel = $this->model('Permission');
        $mapModel = $this->model('Map');
    }

    public function test_auth(){
        $admin_token = "0q65DWgwFjrhgo5CIRTUmgm8vOtAyDe4hwoF5D6QUjc4G6rZocm7DOuTOGup0lKh";
        $moderator_token = "Qwm2PDafZQFdhtsDR3ePstfhcGSpwiI1OUxjhcwCeECKB6kPsSiGwZsvwL77qfe3";
        $_SESSION['auth_token'] = $admin_token;
        parent::__construct();
    }
}