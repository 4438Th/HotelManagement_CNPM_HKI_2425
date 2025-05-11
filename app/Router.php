<?php
class Router
{
    private $__controller,
        $__action,
        $__params;
    function __construct()
    {
        global $router;
        // Lấy thông tin controller, action, params từ config
        if (!empty($router['defaultController'])) {
            $this->__controller = $router['defaultController'];
        }
        $this->__action = $router['defaultAction'];
        $this->__params = $router['defaultParams'];
        // Xử lý URL
        $this->handleURL();
    }
    function getURL()
    {
        // Lấy URL từ request
        if (!empty(($_SERVER['PATH_INFO']))) {
            $url = $_SERVER['PATH_INFO'];
        } else {
            $url = '/';
        }
        return $url;
    }
    function handleURL()
    {
        // Lấy URL từ request
        $url = $this->getURL();
        // Xử lý URL
        $urlArr = array_filter(explode('/', $url)); // Tách URL thành mảng
        $urlArr = array_values($urlArr); // Đánh chỉ số lại mảng
        // Xử lý controller
        if (!empty($urlArr[0])) {
            $this->__controller = ucfirst($urlArr[0]);
        } else {
            $this->__controller = ucfirst($this->__controller);
        }
        if (file_exists('app/controllers/' . $this->__controller . '.php')) {
            require_once 'controllers/' . $this->__controller . '.php';
            $this->__controller = new $this->__controller();
            unset($urlArr[0]);
        } else {
            $this->loadError('404');
        }
        // Xử lý action
        if (!empty($urlArr[1])) {
            $this->__action = $urlArr[1];
            unset($urlArr[1]);
        }
        $this->__params = array_values($urlArr);
        call_user_func_array([$this->__controller, $this->__action], $this->__params);
    }
    function loadError($errorName = '404')
    {
        require_once './app/views/errors/' . $errorName . '.php';
    }
}
