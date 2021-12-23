<?php

namespace core;

use models\traits\AccessAction;

class Controller
{
    use AccessAction;

    const VIEW_FOLDER = 'views/';
    const LAYOUT_FOLDER = 'views/layouts/';
    public $defaultAction = 'index';
    public $authAction = [];
    public $guestAction = [];
    protected $layout = 'main';
    private $_view;
    private $_data;

    /**
     * возвращает 404
     * @param string $message
     * @param false $exit
     * @return mixed
     */
    public function showError($message = null, $exit = false)
    {
        $this->render('error', compact('message'));
        if ($exit) {
            exit();
        }
    }
    /* // это из другого примера, тоже работает
     * public function render($page, $data)
    {
        return $this->renderLayout($page, $this->renderView($page));
    }
    public function renderLayout()
    {
        return require ROOT . self::LAYOUT_FOLDER . $this->layout . '.php';
    }
    public function renderView($page)
    {
        if (file_exists(ROOT . self::VIEW_FOLDER . $page . '.php'))
        {
            return include ROOT . self::VIEW_FOLDER . $page . '.php';
        }
    }*/

    /**
     * @param string $view путь к представлению
     * @param array $data данные для представления
     * @return mixed
     */
    public function render($view, $data = [])
    {
        $this->checkAction($view);
        $this->_view = $view;
        $this->_data = $data;
        return $this->getLayout($this->getView());
    }

    public function getLayout()
    {
        return require ROOT . self::LAYOUT_FOLDER . $this->layout . '.php';
    }

    /**
     * @param string $view путь к представлению
     * @param array $data данные для представления
     * @return false|string
     */
    public function renderPartial($view, $data)
    {
        $this->checkAction($view);
        $this->_view = $view;
        $this->_data = $data;
        echo $this->getContent();
    }

    public function getContent()
    {
        ob_start();
        $this->getView();
        return ob_get_clean();
    }

    public function getView()
    {
        extract($this->_data);
        return require $this->getViewFolder() . "/{$this->_view}.php";
    }

    public function getViewFolder()
    {
        $dir = $this->_view == 'error' ? null : $this->getChildClassName();
        return ROOT . self::VIEW_FOLDER . $dir;
    }

    public function getChildClassName()
    {
        return strtolower(str_replace(['controllers\\', 'Controller', 'core\\'], '', get_class($this)));
    }

    public function redirect($view)
    {
        $this->checkAction($view);
        return header("Location: {$view}");
    }

    /**
     * @param string $path
     * @return string
     */
    public function registerCSSFile($path)
    {
        echo "<link href='{$path}' rel='stylesheet'>";
    }
    public function registerJsFile($path)
    {
        echo "<script src='{$path}' type='text/javascript'></script>";
    }
}