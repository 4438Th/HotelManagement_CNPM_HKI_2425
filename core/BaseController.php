<?php

namespace Core;

class BaseController
{
    protected $view;
    protected $model;

    public function __construct()
    {
        // Khởi tạo các thuộc tính hoặc phụ thuộc chung
    }

    /**
     * Tải một lớp model.
     *
     * @param string $modelName Tên của model cần tải
     * @return object
     */
    protected function loadModel($modelName)
    {
        $modelPath = '../models/' . $modelName . '.php';
        if (file_exists($modelPath)) {
            require_once $modelPath;
            $this->model = new $modelName();
        } else {
            throw new \Exception("Không tìm thấy file model: " . $modelPath);
        }
    }

    /**
     * Hiển thị một file view.
     *
     * @param string $viewName Tên của view cần hiển thị
     * @param array $data Dữ liệu truyền vào view
     * @return void
     */
    protected function render($viewName, $data = [])
    {
        $viewPath = PAGE_PATH . '/' . $viewName . '.html';
        if (file_exists($viewPath)) {
            extract($data);
            require_once $viewPath;
        } else {
            throw new \Exception("Không tìm thấy file view: " . $viewPath);
        }
    }

    /**
     * Chuyển hướng đến một URL khác.
     *
     * @param string $url URL cần chuyển hướng đến
     * @return void
     */
    protected function redirect($url)
    {
        header("Location: " . $url);
        exit();
    }
}
