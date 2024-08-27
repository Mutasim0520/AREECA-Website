<?php

class DashboardController extends Controller {

    public function index() {
        $mapModel = $this->model('Map');

        $maps = $mapModel->getMaps();
        // print_r($maps);
        $this->view('dashboard', ['maps' => $maps]);
    }
}