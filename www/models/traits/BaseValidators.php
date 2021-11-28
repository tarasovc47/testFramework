<?php

namespace models\traits;

trait BaseValidators
{
    /**
     * @param $attribute
     * привязка валидатора к инпуту
     */
    public function validateRequired($attribute)
    {
        if (!$this->$attribute)
        {
            $this->addError($attribute, "Поле \"{$this->getAttributeLabel($attribute)}\" не заполнено. ");
        }
    }
}