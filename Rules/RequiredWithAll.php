<?php

namespace Lib\Classes\Validation\Rules;

use Lib\Classes\Validation\Rule;

class RequiredWithAll extends Required
{
    protected $implicit = true;

    protected $message = "The :attribute is required";

    public function fillParameters(array $params)
    {
        $this->params['fields'] = $params;
        return $this;
    }

    public function check($value)
    {
        $this->requireParameters(['fields']);
        $fields = $this->parameter('fields');
        $validator = $this->validation->getValidator();
        $required_validator = $validator('required');

        foreach($fields as $field) {
            if (!$this->validation->hasValue($field)) {
                return true;
            }
        }

        $this->setAttributeAsRequired();
        return $required_validator->check($value, []); 
    }

}
