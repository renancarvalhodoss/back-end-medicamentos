<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicamentosRequest;
use App\Http\Resources\MedicamentosResource;
use App\Models\Medicamentos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MedicamentosController extends Controller
{
    public function store_medicamentos(MedicamentosRequest $request)
    {
        $data = $request->validated();
        $medicamento = new Medicamentos();

        $DOC = $request->file('doc_path');
        $name = uniqid('perfil_') . '.' . $DOC->extension();
        $filename = $DOC->storeAs('Bulas', $name, ['disk' => 'public']);
        $data['doc_path'] = 'storage/' . $filename;

        $medicamento->fill($data)->save();

        return response()->json([
            'status' => true
        ]);
    }

    public function index_medicamentos(Request $request)
    {

        $medicamentos = Medicamentos::orderBy('created_at', 'desc')->where(function ($q) use ($request) {
            $q->whereRaw('lower(nome) LIKE lower(?)', ['%' . $request->search . '%'])->orWhereRaw('lower(fabricante) LIKE lower(?)', ['%' . $request->search . '%']);
        })->paginate(15);

        return response()->json([
            'medicamentos' => MedicamentosResource::collection($medicamentos),
            'pagination' => [
                'current_page' => $medicamentos->currentPage(),
                'last_page' => $medicamentos->lastPage(),
                'total_pages' => $medicamentos->total(),
                'per_page' => $medicamentos->perPage(),
            ],
        ]);
    }

    public function index_medicamento($id)
    {

        $medicamento = Medicamentos::find($id);

        return response()->json([
            'medicamento' => MedicamentosResource::make($medicamento),
        ]);
    }

    public function update_medicamentos(MedicamentosRequest $request)
    {

        $data = $request->validated();
        $medicamento = Medicamentos::find($data['medicamento_id']);
        if ($DOC = $request->file('doc_path')) {
            $name = uniqid('perfil_') . '.' . $DOC->extension();
            $filename = $DOC->storeAs('Bulas', $name, ['disk' => 'public']);
            $data['doc_path'] = 'storage/' . $filename;
        } else {
            unset($data['doc_path']);
        }
        $medicamento->fill($data)->save();

        return response()->json([
            'status' => true
        ]);
    }

    public function delete_medicamento($id){

       $ident = explode(',', $id);
            for ($i = 0; $i <count($ident); $i++) {               
                 $medicamento = Medicamentos::firstWhere("id","=",$ident[$i]);
                $medicamento->delete();
            }
            return response()->json([
                'status' => true,
            ]);
     
    
        
    
        return response()->json([
            'status' => false,
        ]);
      }
}
