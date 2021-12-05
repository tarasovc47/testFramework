<?php

namespace models\traits;

use core\App;

trait AccessAction
{
    public function checkAction($view)
    {
        if (App::$components->session->isGuest() && !empty($this->authAction))
        {
            echo 'true';
        }
    }
}