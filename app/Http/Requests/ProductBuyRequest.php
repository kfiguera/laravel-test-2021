<?php

namespace App\Http\Requests;

use App\Rules\MaximumStock;
use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductBuyRequest extends FormRequest
{
    use ApiResponse;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $product = $this->route('product');
        return [
            'quantity' => ['required', 'min:1', new MaximumStock($product)]
        ];
    }
    /**
     * Custom format errors.
     */
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException($this->showError(
            'No se puede procesar la petición',
            $validator->errors()->all(),
            400
        ));
    }
}
