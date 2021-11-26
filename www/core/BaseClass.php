<?php

namespace core;
/* "класс классов" */
class BaseClass
{
    /**
     * @param array $properties
     * универсальный конструктор
     */
    public function __construct(array $properties = [])
    {
        foreach ($properties as $name => $value) {
            $this->$name = $value;
        }
    }

    /**
     * @param $name
     * создаём универсальный геттер
     */
    public function __get($name)
    {
        if (method_exists($this, $name))
        {
            return $this->$name();
        }
        elseif (method_exists($this, 'get' . ucfirst($name)))
        {
            $method = 'get' . ucfirst($name);
            return $this->$method;
        }
        throw new \Exception("не найдено свойство {$this->getClass()}::\${$name}");
    }

    /**
     * @param string $name
     * @param $value
     * тут будет универсальный сеттер, не совсем понятно зачем здесь исключение
     */
    public function __set($name, $value)
    {
        throw new \Exception("Не найдено свойство {$this->getClass()}::\${$name}");
    }

    /**
     * @param $name
     * @param $arguments
     * делаем универсальный вызов методов из контекста объекта
     */
    public function __call($name, $arguments)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method))
        {
            return $this->$method($arguments);
        }
        throw new \Exception("Не найден метод {$this->getClass()}::\${$name}()");
    }

    /**
     * @return string
     * возвращаем имя текущего класса
     */
    public function getClass()
    {
        return get_class($this);
    }
}