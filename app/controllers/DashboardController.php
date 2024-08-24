<?php

class DashboardController extends Controller {

    public function dashboard() {
        $userModel = $this->model('User'); // Loads the User model
        $user = $userModel->getUserById(1);
        $this->view('index', ['user' => $user]); // Passing data to the view
        // print_r($user);
    }
}