<?php

namespace Plum\Form;

class Mandatory
{
    /**
     * @param $abstractRequest
     * @return array
     */
    public function mandatory($abstractRequest)
    {
        $validate = new $abstractRequest;
        $rules = $validate->rules();
        if (empty($rules)) {
            return [];
        }
        $response = [];
        foreach ($rules as $name => $rule) {
            $listRule = $rule;
            if (is_string($rule)) {
                $listRule = explode('|', $rule);
            }
            if (in_array('required', $listRule)) {
                $response[$name] = true;
            }
        }
        return $response;
    }
}