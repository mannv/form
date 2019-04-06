<?php

namespace Plum\Form;

use Collective\Html\FormBuilder;
use Illuminate\View\Factory;

class Form extends FormBuilder
{
    protected $mandatory = [];

    protected $fromView = 'form_group';

    protected $showMandatory = true;

    /**
     * Created by ManNV
     * Description: get field mandatory from form request
     * @param null $abstract
     * @return array|void
     */
    private function makeFormMandatory($abstract = null)
    {
        if (empty($abstract)) {
            return;
        }

        $validate = new $abstract;
        $rules = $validate->rules();
        if (empty($rules)) {
            return [];
        }

        foreach ($rules as $name => $rule) {
            $listRule = $rule;
            if (is_string($rule)) {
                $listRule = explode('|', $rule);
            }
            if (in_array('required', $listRule)) {
                $this->mandatory[$name] = true;
            }
        }
    }

    private function validateJS($abstract, $formId)
    {
        $factory = app(Factory::class);
        $factory->startPush('scripts');
        $validateJS = \JsValidator::formRequest($abstract, '#' . $formId);
        echo $validateJS;
        $factory->stopPush();
    }

    private function initForm(&$options, $abstract = null)
    {
        if (!empty($abstract)) {
            if (!isset($options['id']) | empty($options['id'])) {
                $options['id'] = 'form_' . uniqid();
            }

            if (!in_array($options['id'], config('pform.skip_validate_js', []))) {
                $this->validateJS($abstract, $options['id']);
            }
        }

        if (isset($options['view']) && !empty($options['view'])) {
            $this->fromView = $options['view'];
        }

        if (isset($options['hide_mandatory']) && !empty($options['hide_mandatory'])) {
            $this->showMandatory = false;
        }
    }

    public function open(array $options = [], $abstract = null)
    {
        $this->initForm($options, $abstract);
        $this->makeFormMandatory($abstract);
        return parent::open($options);
    }

    public function model($model, array $options = [], $abstract = null)
    {
        $this->initForm($options, $abstract);
        $this->makeFormMandatory($abstract);
        return parent::model($model, $options);
    }

    private function formGroup($name, $label, $element)
    {
        return view('plum::' . $this->fromView, [
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

    private function makeElement($name, $labelValue = '', $value = null, $options = [])
    {
        $elementType = debug_backtrace()[1]['function'];
        $this->setDefaultFormClass($options);
        $label = $this->makeLabel($name, !empty($labelValue) ? $labelValue : $name);
        if ($elementType == 'password') {
            $element = parent::password($name, $options);
        } else {
            $element = parent::$elementType($name, $value, $options);
        }
        return $this->formGroup($name, $label, $element);
    }

    private function makeLabel($name, $value)
    {
        $required = '';
        if (isset($this->mandatory[$name]) && $this->showMandatory) {
            $required = ' <span class="mandatory">*</span>';
        }
        return $this->toHtmlString('<label for="' . $name . '">' . $value . $required . '</label>');
    }

    public function text($name, $labelValue = '', $value = null, $options = [])
    {
        return $this->makeElement($name, $labelValue, $value, $options);
    }

    public function password($name, $labelValue = '', $value = null, $options = [])
    {
        return $this->makeElement($name, $labelValue, $value, $options);
    }

    public function email($name, $labelValue = '', $value = null, $options = [])
    {
        return $this->makeElement($name, $labelValue, $value, $options);
    }

    public function tel($name, $labelValue = '', $value = null, $options = [])
    {
        return $this->makeElement($name, $labelValue, $value, $options);
    }

    public function number($name, $labelValue = '', $value = null, $options = [])
    {
        return $this->makeElement($name, $labelValue, $value, $options);
    }

    public function url($name, $labelValue = '', $value = null, $options = [])
    {
        return $this->makeElement($name, $labelValue, $value, $options);
    }

    public function submit($value = null, $options = [])
    {
        if (!isset($options['class'])) {
            $options['class'] = 'btn btn-primary';
        }
        return parent::submit($value, $options);
    }

    public function textarea($name, $labelValue = '', $value = null, $options = [])
    {
        return $this->makeElement($name, $labelValue, $value, $options);
    }

    public function select(
        $name,
        $labelValue = '',
        $list = [],
        $selected = null,
        array $selectAttributes = [],
        array $optionsAttributes = [],
        array $optgroupsAttributes = []
    ) {
        $this->setDefaultFormClass($options);
        $label = $this->makeLabel($name, !empty($labelValue) ? $labelValue : $name);
        $element = parent::select($name, $list, $selected, $selectAttributes, $optionsAttributes,
            $optgroupsAttributes);
        return $this->formGroup($name, $label, $element);
    }

    public function checkbox($name, $labelValue = '', $value = 1, $checked = null, $options = [])
    {
        $this->setDefaultFormClass($options);
        $label = $this->makeLabel($name, !empty($labelValue) ? $labelValue : $name);
        $element = parent::checkbox($name, $value, $checked, $options);
        return $this->formGroup($name, $label, $element);
    }

    public function radio($name, $labelValue = '', $value = null, $checked = null, $options = [])
    {
        $this->setDefaultFormClass($options);
        $label = $this->makeLabel($name, !empty($labelValue) ? $labelValue : $name);
        $element = parent::radio($name, $value, $checked, $options);
        return $this->formGroup($name, $label, $element);
    }

    public function groupCheckBox(
        $name,
        $labelValue = '',
        $list = [],
        $checked = null,
        $delimiter = null,
        $bsCol = 0,
        $options = []
    ) {
        if (empty($list)) {
            return;
        }
        $this->setDefaultFormClass($options);
        $label = $this->makeLabel($name, !empty($labelValue) ? $labelValue : $name);

        $listHtml = [];
        foreach ($list as $id => $value) {
            $checkState = $this->getCheckboxCheckedState($name, $id, $checked);
            if (is_array($checkState)) {
                $checkState = in_array($id, $checkState);
            }
            $item = parent::checkbox($name . '[]', $id, $checkState);
            $html = '<label class="normal-text"> ' . $item . ' ' . $value . '</label>';
            if (!empty($delimiter)) {
                $listHtml[] = $html;
            } else {
                $listHtml[] = '<div class="col-md-' . $bsCol . '">' . $html . '</div>';
            }

        }
        if (!empty($delimiter)) {
            $delimiter = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $outputHtml = implode($delimiter, $listHtml);
        } else {
            $outputHtml = '<div class="row">' . implode('', $listHtml) . '</div>';
        }

        return $this->formGroup($name, $label, $outputHtml);
    }

    public function groupRadio(
        $name,
        $labelValue = '',
        $list = [],
        $checked = null,
        $delimiter = null,
        $bsCol = 0,
        $options = []
    ) {
        if (empty($list)) {
            return;
        }
        $this->setDefaultFormClass($options);
        $label = $this->makeLabel($name, !empty($labelValue) ? $labelValue : $name);

        $listHtml = [];

        foreach ($list as $id => $value) {
            $checkState = $this->getCheckboxCheckedState($name, $id, $checked);
            if (is_array($checkState)) {
                $checkState = in_array($id, $checkState);
            }
            $item = parent::radio($name, $id, $checkState);
            $html = '<label class="normal-text"> ' . $item . ' ' . $value . '</label>';
            if (!empty($delimiter)) {
                $listHtml[] = $html;
            } else {
                $listHtml[] = '<div class="col-md-' . $bsCol . '">' . $html . '</div>';
            }
        }


        if (!empty($delimiter)) {
            $delimiter = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $outputHtml = implode($delimiter, $listHtml);
        } else {
            $outputHtml = '<div class="row">' . implode('', $listHtml) . '</div>';
        }

        return $this->formGroup($name, $label, $outputHtml);
    }

}