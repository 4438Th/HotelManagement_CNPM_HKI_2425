<?php
class HomeController
{
    public function index()
    {
        // Xử lý logic cho trang chủ
        echo "Welcome to THE HOTEL!";
    }
    public function detail($id = '', $name = '')
    {
        $id = $_GET['id'];
        $name = $_GET['name'];
        echo 'id: ' . $id . '<br>';
        echo 'name: ' . $name . '<br>';
    }
}
