<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Responsible;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $students = Student::with('responsible')->get();
        } else {
            $students = Student::with('responsible')
                ->where('responsible_id', $user->responsible->id)
                ->get();
        }

        return response()->json([
            'data' => $students,
            'message' => 'Se han mostrado los estudiantes con éxito.'
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
        ];

        if ($user->role === 'admin') {
            $rules['responsible_id'] = 'required|exists:responsibles,id';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Errores de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        if ($user->role === 'responsible') {
            $data['responsible_id'] = $user->responsible->id;
        }

        $student = Student::create($data);

        return response()->json([
            'data' => $student,
            'message' => 'Se ha creado un estudiante con éxito.'
        ], 201);
    }

    public function show($id)
    {
        $student = Student::with('responsible')->findOrFail($id);
        $user = Auth::user();

        if ($user->role === 'responsible') {
            $responsible = $user->responsible;
            if ($student->responsible_id !== $responsible->id) {
                return response()->json(['message' => 'Acceso no autorizado.'], 403);
            }
        }

        return response()->json([
            'data' => $student,
            'message' => 'Se ha mostrado el estudiante con éxito.'
        ]);
    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id);
        if($student){
            $user = Auth::user();

            if ($user->role === 'responsible') {
                $responsible = $user->responsible;
                if ($student->responsible_id !== $responsible->id) {
                    return response()->json(['message' => 'Acceso no autorizado.'], 403);
                }
            }

            $rules = [
                'name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'birth_date' => 'required|date',
            ];
    
            if ($user->role === 'admin') {
                $rules['responsible_id'] = 'required|exists:responsibles,id';
            }
    
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Errores de validación',
                    'errors' => $validator->errors()
                ], 422);
            }
    
            $data = $validator->validated();
    
            if ($user->role === 'responsible') {
                $data['responsible_id'] = $user->responsible->id;
            }
    
            $student->update($data);
    
            return response()->json([
                'data' => $student,
                'message' => 'Se ha actualizado el estudiante con éxito.'
            ]);
        }
        return response()->json([
            'message' => 'No se pudo encontrar el estudiante.'
        ], 404);
        
    }

    public function destroy($id)
    {
        $student = Student::find($id);

        if ($student) {
            $user = Auth::user();
            if ($user->role === 'responsible') {
                $responsible = $user->responsible;
                if ($student->responsible_id !== $responsible->id) {
                    return response()->json(['message' => 'Acceso no autorizado.'], 403);
                }
            }
            $student->delete();

            return response()->json([
                'message' => 'Se ha eliminado el estudiante con éxito.'
            ]);
        }

        return response()->json([
            'message' => 'No se pudo encontrar el estudiante.'
        ], 404);
    }
}
