<?php

namespace models\traits;

use core\App;

trait AccessAction
{
    public function checkAction($view)
    {
        if (App::$components->session->isGuest() && !empty($this->authAction)) { // если пользователь - гость и список экшенов для авторизованных не пуст
            foreach ($this->authAction as $action) { // то обрабатываем этот список
                $this->check($view, $action); // и сверяем
            }
        }
        elseif (!empty($this->guestAction)) //если список экшенов для гостей не пуст
        {
            foreach ($this->guestAction as $action) { //то обрабатываем этот список
                $this->check($view, $action); // и сверяем
            }
        }
    }
    private function check($view, $action)
    {
        if ($view == $action) // если нашёлся экшен, который есть в списке гостевых экшенов ИЛИ в списке авторизованных экшенов и юзер при этом гость
        {
            $referer = App::$components->request->referer;
            return header("Location: {$referer}"); // то отправляем откуда пришёл
        }
    }
}