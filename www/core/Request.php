<?php
namespace core;
class Request extends BaseObject
{
    public function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
    public function isAjax()
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH'])
            && (strtolower(getenv('HTTP_X_REQUESTED_WITH')) === 'xmlhttprequest'));
    }
    public function post($key = null)
    {
        if ($key)
        {
            return isset($_POST[$key]) ? $_POST[$key] : null;
        }
        return $_POST;
    }
    public function get($key = null)
    {
        if ($key)
        {
            return isset($_GET[$key]) ? $_GET[$key] : null;
        }
        return $_GET;
    }
    public function getReferer()
    {
        return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
    }
    public function files($key = null)
    {
        if ($key)
        {
            return isset($_FILES[$key]) ? $_FILES[$key] : null;
        }
        return $_FILES;
    }
}