<?php

namespace App\Cores;

use function PHPSTORM_META\type;

abstract class FormRequest extends Request
{
    public const RULE_REQUIRED = 'required';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';

    protected array $errors = [];

    public function __construct()
    {
        parent::__construct();

        if (!$this->validate()) {
            $this->failedValidation();
        }
    }

    abstract protected function rules(): array;

    abstract protected function messages(): array;

    protected function validate(): bool
    {
        $rules = $this->rules();

        foreach ($rules as $formField => $rules) {

            $input = $this->input($formField);

            foreach ($rules as $rule) {

                if (self::RULE_REQUIRED === $rule && !$this->has($formField)) {
                    $this->errors[$formField][] = $this->setError(self::RULE_REQUIRED, $formField);
                    break;
                }

                if (str_starts_with($rule, self::RULE_MIN)) {
                    $min = substr($rule, 4);

                    if (is_numeric($min) && strlen($input) < (int) $min) {
                        $this->errors[$formField][] = $this->setError(self::RULE_MIN, $formField, $min);
                    }
                }

                if (str_starts_with($rule, self::RULE_MAX)) {
                    $max = substr($rule, 4);

                    if (is_numeric($max) && strlen($input) > (int) $max) {
                        $this->errors[$formField][] = $this->setError(self::RULE_MAX, $formField, $max);
                    }
                }
            }
        }

        // var_dump($this->errors);
        // die();

        return empty($this->errors);
    }

    private function setError($rule, $field, $valueOfRule = null)
    {
        $messages = $this->messages();

        $msg = isset($messages["$field.$rule"]) ? $messages["$field.$rule"] : null;

        if ($rule == self::RULE_REQUIRED) {
            return $msg ?? "$field khong duoc de trong";
        }

        if ($rule == self::RULE_MIN && $valueOfRule != null) {
            return $msg ?? "$field yeu cau toi thieu $valueOfRule ki tu!";
        }

        if ($rule == self::RULE_MAX && $valueOfRule != null) {
            return $msg ?? "$field yeu cau toi da $valueOfRule ki tu!";
        }

        return null;
    }

    protected function failedValidation()
    {
        // save err to session, redirect to old page and error
        Application::$app->session->setFlash('error', $this->errors);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
