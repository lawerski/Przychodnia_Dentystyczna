<?php

namespace App\Http\Requests;

use App\Models\Dentist;
use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (auth()->user()->type === 'admin') {
            return true; // Admins can update any service
        }
        // For dentists, check if the dentist ID matches the one in the request
        $user = $this->user();
        $dentist = Dentist::where('user_id', $user->id)->first();
        if (!$dentist) {
            // Dentist not found - this should never happen
            return false;
        }
        return $dentist->id == $this->service->dentist_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'dentist_id' => 'required|exists:dentists,id',
            'service_name' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
        ];
    }
}
