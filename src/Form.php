<?php

namespace Plum\Form;

use Collective\Html\FormBuilder;

class Form extends FormBuilder
{
    private function formGroup($name, $label, $element)
    {
        return view('pform::form_group', [
            'name' => $name,
            'label' => $label,
            'element' => $element,
        ]);
    }

    private function setDefaultFormClass(&$options)
    {
        if (!isset($options['class'])) {
            $options['class'] = 'form-control';
        } else {
            $options['class'] .= ' form-control';
        }
    }

    private function makeElement($name, $labelValue = '', $mandatory = false, $value = null, $options = [])
    {
        $elementType = debug_backtrace()[1]['function'];
        $this->setDefaultFormClass($options);
        $label = $this->makeLabel($name, !empty($labelValue) ? $labelValue : $name, $mandatory);
        $element = parent::$elementType($name, $value, $options);
        return $this->formGroup($name, $label, $element);
    }

    private function makeLabel($name, $value, $mandatory = false)
    {
        $required = '';
        if ($mandatory) {
            $required = ' <span class="mandatory">*</span>';
        }
        return $this->toHtmlString('<label for="' . $name . '">' . $value . $required . '</label>');
    }

    public function text($name, $labelValue = '', $mandatory = false, $value = null, $options = [])
    {
        return $this->makeElement($name, $labelValue, $mandatory, $value, $options);
    }

    public function password($name, $labelValue = '', $mandatory = false, $value = null, $options = [])
    {
        return $this->makeElement($name, $labelValue, $mandatory, $value, $options);
    }

    public function email($name, $labelValue = '', $mandatory = false, $value = null, $options = [])
    {
        return $this->makeElement($name, $labelValue, $mandatory, $value, $options);
    }

    public function tel($name, $labelValue = '', $mandatory = false, $value = null, $options = [])
    {
        return $this->makeElement($name, $labelValue, $mandatory, $value, $options);
    }

    public function number($name, $labelValue = '', $mandatory = false, $value = null, $options = [])
    {
        return $this->makeElement($name, $labelValue, $mandatory, $value, $options);
    }

    public function url($name, $labelValue = '', $mandatory = false, $value = null, $options = [])
    {
        return $this->makeElement($name, $labelValue, $mandatory, $value, $options);
    }

    public function submit($value = null, $options = [])
    {
        $options['class'] = 'btn btn-primary';
        return parent::submit($value, $options);
    }

    public function textarea($name, $labelValue = '', $mandatory = false, $value = null, $options = [])
    {
        return $this->makeElement($name, $labelValue, $mandatory, $value, $options);
    }

    public function select(
        $name,
        $list = [],
        $mandatory = false,
        $selected = null,
        array $selectAttributes = [],
        array $optionsAttributes = [],
        array $optgroupsAttributes = []
    ) {
        $this->setDefaultFormClass($options);
        $label = $this->makeLabel($name, !empty($labelValue) ? $labelValue : $name, $mandatory);
        $element = parent::select($name, $list, $selected, $selectAttributes, $optionsAttributes,
            $optgroupsAttributes);
        return $this->formGroup($name, $label, $element);
    }

    public function checkbox($name, $value = 1, $mandatory = false, $checked = null, $options = [])
    {
        $this->setDefaultFormClass($options);
        $label = $this->makeLabel($name, !empty($labelValue) ? $labelValue : $name, $mandatory);
        $element = parent::checkbox($name, $value, $checked, $options);
        return $this->formGroup($name, $label, $element);
    }

    public function radio($name, $value = null, $mandatory = false, $checked = null, $options = [])
    {
        $this->setDefaultFormClass($options);
        $label = $this->makeLabel($name, !empty($labelValue) ? $labelValue : $name, $mandatory);
        $element = parent::radio($name, $value, $checked, $options);
        return $this->formGroup($name, $label, $element);
    }
}