<?php

class DashboardController extends Controller {
    
    public function index() {
        if (isset($_SESSION['auth_token'])){
            $maps = $this->model('Map')->getMaps();

            $this->view('dashboard', ['maps' => $maps]);
        }
        else{
            $redirect_path = BASE_URL. 'auth/signInForm';
            $this->redirect($redirect_path);
        }
    }
}