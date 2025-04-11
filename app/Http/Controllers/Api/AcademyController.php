<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Academy;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class AcademyController extends Controller
{
    public function index()
    {
        $academies = Academy::all();
        $response = [
            'data' => $academies,
            'message' => 'Se han mostrado las academias con exito.' 
        ];
        return response()->json(Academy::all());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:academies,name',
            'phone_number' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Errores de validación',
                'errors' => $validator->errors()
            ], 422);
        }
        $validated = $validator->validate();
        $academy = Academy::create($validated);
        $response = [
            'data' => $academy,
            'message' => 'Se ha creado una academia con exito.' 
        ];
        return response()->json($response, 201);
    }

    public function show($id)
    {
        $academy = Academy::findOrFail($id);
        $response = [
            'data' => $academy,
            'message' => 'Se ha mostrado los detalles de una academia con exito.' 
        ];
        return response()->json($response);
    }

    public function update(Request $request, $id)
    {
        $academy = Academy::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'min:3',
                Rule::unique('academies', 'name')->ignore($academy?->id),
            ],
            'phone_number' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Errores de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validate();
        $academy->update($validated);
        $response = [
            'data' => $academy,
            'message' => 'Se ha actualizado una academia con exito.' 
        ];
        return response()->json($response);
    }

    public function destroy($id)
    {
        $academy = Academy::find($id);
        if($academy){
            $academy->delete();
            return response()->json(['message' => 'Se ha eliminado una academia con exito']);
        }

        return response()->json(['message' => 'No se pudo encontrar la academia'], 422);
    }
}
