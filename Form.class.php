<?php

class Form
{
    private $action;
    private $method;
    private $fields = [];

    public function __construct($action = "", $method = "POST")
    {
        $this->action = $action;
        $this->method = $method;
    }

    // Method memulai form
    public function startForm($attributes = "")
    {
        return "<form action='{$this->action}' method='{$this->method}' $attributes>";
    }

    // Method mengakhiri form
    public function endForm()
    {
        return "</form>";
    }

    // Method  input 
    public function inputText($name, $label, $value = "", $attributes = "")
    {
        $field = "
        <div class='form-group'>
            <label for='$name'>$label</label>
            <input type='text' name='$name' id='$name' value='$value' $attributes class='form-control'>
        </div>";

        $this->fields[] = $field;
        return $field;
    }

    // Method input password
    public function inputPassword($name, $label, $attributes = "")
    {
        $field = "
        <div class='form-group'>
            <label for='$name'>$label</label>
            <input type='password' name='$name' id='$name' $attributes class='form-control'>
        </div>";

        $this->fields[] = $field;
        return $field;
    }

    // Method radio button
    public function inputRadio($name, $label, $options, $selected = "", $attributes = "")
    {
        $radioFields = "
        <div class='form-group'>
            <label>$label</label><br>";

        foreach ($options as $value => $text) {
            $checked = ($value == $selected) ? "checked" : "";
            $radioFields .= "
            <div class='form-check form-check-inline'>
                <input type='radio' name='$name' id='{$name}_{$value}' value='$value' $checked $attributes class='form-check-input'>
                <label class='form-check-label' for='{$name}_{$value}'>$text</label>
            </div>";
        }

        $radioFields .= "</div>";
        $this->fields[] = $radioFields;
        return $radioFields;
    }

    // Method checkbox
    public function inputCheckbox($name, $label, $options, $selected = [], $attributes = "")
    {
        $checkboxFields = "
        <div class='form-group'>
            <label>$label</label><br>";

        foreach ($options as $value => $text) {
            $checked = in_array($value, $selected) ? "checked" : "";
            $checkboxFields .= "
            <div class='form-check'>
                <input type='checkbox' name='{$name}[]' id='{$name}_{$value}' value='$value' $checked $attributes class='form-check-input'>
                <label class='form-check-label' for='{$name}_{$value}'>$text</label>
            </div>";
        }

        $checkboxFields .= "</div>";
        $this->fields[] = $checkboxFields;
        return $checkboxFields;
    }

    // Method dropdown/select
    public function inputSelect($name, $label, $options, $selected = "", $attributes = "")
    {
        $selectField = "
        <div class='form-group'>
            <label for='$name'>$label</label>
            <select name='$name' id='$name' $attributes class='form-control'>";

        foreach ($options as $value => $text) {
            $isSelected = ($value == $selected) ? "selected" : "";
            $selectField .= "<option value='$value' $isSelected>$text</option>";
        }

        $selectField .= "</select></div>";
        $this->fields[] = $selectField;
        return $selectField;
    }

    // Method textarea
    public function inputTextarea($name, $label, $value = "", $attributes = "")
    {
        $field = "
        <div class='form-group'>
            <label for='$name'>$label</label>
            <textarea name='$name' id='$name' $attributes class='form-control'>$value</textarea>
        </div>";

        $this->fields[] = $field;
        return $field;
    }

    // Method menampilkan semua field
    public function render()
    {
        $form = $this->startForm();
        foreach ($this->fields as $field) {
            $form .= $field;
        }
        $form .= $this->endForm();
        return $form;
    }
}
?>