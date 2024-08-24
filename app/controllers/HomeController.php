<?php

class HomeController extends Controller {

    public function index() {
        $userModel = $this->model('User'); // Loads the User model
        $user = $userModel->getUserById(1);
        // $this->view('home/index', ['user' => $user]); // Passing data to the view
        // $user = $this->model('User');
        // $userData = $user->getUser(1);
        // $this->view('home/index', ['name' => $userData['name']]);
        $this->view('index', []);
    }
}