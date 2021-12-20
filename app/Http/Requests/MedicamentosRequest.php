<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicamentosRequest extends FormRequest
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

    public function messages()
    {
        return [
            'codigo.required'=>'O campo Código é obrigatório',
            'nome.required'=>'O campo nome é obrigatório',
            'quantidade.required'=>'O campo quantidade é obrigatório',
            'doc_path.required'=>'O campo Bula é obrigatório',
            'dosagem.required'=>'O campo Dosagem é obrigatório',
            'marca.required'=>'O campo Marca é obrigatório',
            'fabricante.required'=>'O campo Fabricante é obrigatório',
            'principio.required'=>'O campo Principio ativo é obrigatório',
            'observacoes.max'=>'O campo Observações deve ter no máximo 255 caractéres',

        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch (strtolower($this->route()->getActionMethod())):
            case 'store_medicamentos':
                return [
                    'nome' => 'required',
                    'codigo' => 'required',
                    'quantidade' => 'required',
                    'doc_path' => 'required',
                    'dosagem' => 'required',
                    'marca' => 'required',
                    'fabricante' => 'required',
                    'principio' => 'required',
                    'observacoes'=> 'sometimes',
                ];
                break;
           case 'update_medicamentos':
                return [
                    'medicamento_id'=>'required',
                    'nome' => 'required',
                    'codigo' => 'required',
                    'quantidade' => 'required',
                    'doc_path' => 'required',
                    'dosagem' => 'required',
                    'marca' => 'required',
                    'fabricante' => 'required',
                    'principio' => 'required',
                    'observacoes'=> 'sometimes',
                ];
                break;
            default:
                return [];
                break;
        endswitch;
    }
}
