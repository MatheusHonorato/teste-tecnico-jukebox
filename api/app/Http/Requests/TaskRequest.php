<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Traits\FailedValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    use FailedValidationTrait;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1024',
        ];
    }
}
