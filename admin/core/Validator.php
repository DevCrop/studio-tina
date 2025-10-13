<?php

class Validator {
    protected $errors = [];

    public function require($field, $value, $label = '') {
        if (is_null($value) || trim($value) === '') {
            $this->errors[] = "{$label}을(를) 입력해주세요.";
        }
    }

    public function email($field, $value, $label = '') {
        if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "{$label} 형식이 올바르지 않습니다.";
        }
    }

    public function phone($field, $value, $label = '') {
        if (!empty($value) && !preg_match('/^\d{3}-\d{3,4}-\d{4}$/', $value)) {
            $this->errors[] = "{$label} 형식이 잘못되었습니다. (예: 010-1234-5678)";
        }
    }

    public function getErrors(): array {
        return $this->errors;
    }

    public function fails(): bool {
        return !empty($this->errors);
    }
}