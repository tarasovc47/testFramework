<?php
namespace core;

class BaseObject
{
    public function __construct(array $properties = [])
    {
        foreach ($properties as $name => $value) {
            $this->$name = $value;
        }
    }

    /**
     * @param string $name
     * универсальный геттер
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
        throw new \Exception("Не найдено свойство {$this->getClass()}::\${$name}");
    }

    /**
     * @param $name
     * @param $value
     * @throws \Exception
     * универсальный сеттер, закрывающий доступ извне
     */
    public function __set($name, $value)
    {
        throw new \Exception("Не найдено свойство {$this->getClass()}::\${$name}");
    }

    public function __call(string $name, array $arguments)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method))
        {
            return $this->$method($arguments);
        }
        throw new \Exception("Не найден метод {$this->getClass()}::\${$name}");
    }
    public function getClass()
    {
        return get_class($this);
    }
}