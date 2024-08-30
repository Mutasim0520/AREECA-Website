<?php

class SetupController extends Controller {

    public function index() {
        $roleModel = $this->model('Role');
        $userModel = $this->model('User');
        $permissionModel = $this->model('Permission');
        $mapModel = $this->model('Map');
        // Loads the User model
        // $user = $userModel->getUserById(1);
        // // $this->view('home/index', ['user' => $user]); // Passing data to the view
        // // $user = $this->model('User');
        // // $userData = $user->getUser(1);
        // // $this->view('home/index', ['name' => $userData['name']]);
        // $this->view('index', []);
    }
}