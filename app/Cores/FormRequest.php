<?php

namespace App\Cores;

abstract class FormRequest extends Request
{
    protected array $errors = [];

    public function __construct()
    {
        parent::__construct();

        $this->validate();
    }

    abstract protected function rules(): array;

    abstract protected function messages(): array;

    protected function validate(): bool
    {
        return true;
    }
}
