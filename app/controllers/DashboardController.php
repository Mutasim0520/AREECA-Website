<?php

class DashboardController extends Controller {
    
    public function index() {
        if (isset($_SESSION['auth_token'])){
            $maps = $this->model('Map')->getMaps();
            $users = $this->model('User')->getAllUsersWithRoles();
            $this->view('dashboard', ['maps' => $maps, 'users' => $users]);
        }
        else{
            $redirect_path = BASE_URL. 'auth/signInForm';
            $this->redirect($redirect_path);
        }
    }
}