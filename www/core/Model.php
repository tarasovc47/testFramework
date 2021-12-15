<?php
namespace core;

use models\traits\BaseValidators;
class Model extends BaseObject
{
    use BaseValidators;
    private $_errors = [];
    public function __construct(array $properties = [])
    {
        $this->init();
        parent::__construct($properties);
    }
    public function init()
    {

    }

    /**
     * @return array
     * возвращаем массив с правилами валидации
     */
    public function validateRules()
    {
        return [];
    }

    /**
     * @return bool
     * собственно сама валидация
     */
    public function validate()
    {
        /**
         * каждая пара из массива с правилами обрабатывается, и возвращается true или false в зависимости от наличия ошибок
         */
        foreach ((array)$this->validateRules() as $validateRow) {
            $attributes = array_shift($validateRow);
            $validateMethod = array_shift($validateRow);
            foreach ((array)$attributes as $attribute) {
                $this->$validateMethod($attribute);
            }
        }
        return (bool)!$this->getErrors();
    }

    /**
     * @param $array
     * заполняем свойства обхекта из массива аргумента
     */
    public function load($array)
    {
        foreach ((array)$array as $attribute => $value) {
            if (property_exists($this, $attribute))
            {
                $this->$attribute = $value;
            }
        }
    }

    /**
     * @return array
     * даем названия полям по аттрибуту
     */
    public function attributeLabels()
    {
        return [];
    }

    /**
     * @param $attribute
     * @return mixed
     * по умолчанию лейбл == аттрибут, но если указано иное в массиве, то переназначаем и возвращаем
     */
    public function getAttributeLabel($attribute)
    {
        $label = $attribute;
        if (isset($this->attributeLabels()[$attribute]) || array_key_exists($attribute, $this->attributeLabels()))
        {
            $label = $this->attributeLabels()[$attribute];
        }
        return $label;
    }
    public function addError($attribute, $message)
    {
        $this->_errors[$attribute] = $message;
    }
    public function getError($attribute)
    {
        return isset($this->_errors[$attribute]) ? $this->_errors[$attribute] : null;
    }
    public function getErrors()
    {
        return $this->_errors;
    }
}