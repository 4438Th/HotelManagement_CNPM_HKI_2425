<?php
require_once CORE_PATH . '/BaseController.php';

use Core\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        $this->render('home', []);
        // echo  PUBLIC_PATH . '/css' . '/style.css' . '<br>';
    }
    public function detail($id = '', $name = '')
    {
        $id = isset($_GET['id']) ? $_GET['id'] : $id;
        $name = isset($_GET['name']) ? $_GET['name'] : $name;
        echo 'id: ' . $id . '<br>';
        echo 'name: ' . $name . '<br>';
    }
}
