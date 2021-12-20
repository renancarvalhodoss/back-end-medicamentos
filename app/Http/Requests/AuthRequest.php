<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
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
    public function messages()
    {
        return [
            'name.required' =>'O campo Nome é obrigatório',
            'sobrename.required' =>'O campo Sobrenome é obrigatório',
            'email.required'=>'O campo E-mail é obrigatório',
            'email.email'=>'O campo E-mail deve ser um E-mail válido',
            'password.required'=>'O campo Senha é obrigatório',
            'password.min'=>'O campo Senha deve ter no mínimo 6 caractéres',
            'password.max'=>'O campo Senha deve ter no máximo 20 caractéres',
            'password.confirmed'=>'O campo Confirmar senha não pode ser diferente da senha.',
        ];
    }
    public function rules()
    {
        switch (strtolower($this->route()->getActionMethod())):
            case 'login':
                return [
                    'email' => 'required|email',
                    'password' => 'required|min:6|max:20',
                ];
                break;
            case 'register':
                return [
                    'name' => 'required|string',
                    'sobrenome' => 'required|string',
                    'email' => 'required|email',
                    'password' => 'required|string|min:6|max:20|confirmed',
                    'imagem' => 'sometimes|nullable|image'
                ];
                break;
            case 'edit_profile':
                return [
                    'name' => 'required|string',
                    'password' => 'sometimes|nullable|string|min:6|max:20|confirmed',
                    'imagem' => 'sometimes|nullable|image'
                ];
                break;

            default:
                return [];
                break;
        endswitch;
    }
}
