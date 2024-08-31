<?php

class SetupController extends Controller {

    public function index() {
        $userModel = $this->model('User');
        $roleModel = $this->model('Role');
        $permissionModel = $this->model('Permission');
        $mapModel = $this->model('Map');
    }
}