<?php

class SetupController extends Controller {

    public function index() {
        $userModel = $this->model('User');
        $roleModel = $this->model('Role');
        $permissionModel = $this->model('Permission');
        $mapModel = $this->model('Map');
    }

    public function test(){
        $a = password_hash("admin", PASSWORD_DEFAULT);
        $b = password_hash("moderator", PASSWORD_DEFAULT);
        echo("admin: " .$a."<br>");
        echo("moderator: " .$b."<br>");
    }
}