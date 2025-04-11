<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        $response = [
            'data' => $courses,
            'message' => 'Se han mostrado los cursos con éxito.'
        ];
        return response()->json($response);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:courses,name',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:60|max:4000',
            'academy_id' => 'required|exists:academies,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Errores de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validate();
        $course = Course::create($validated);

        $response = [
            'data' => $course,
            'message' => 'Se ha creado un curso con éxito.'
        ];
        return response()->json($response, 201);
    }

    public function show($id)
    {
        $course = Course::find($id);
        if ($course) {
            $response = [
                'data' => $course,
                'message' => 'Se han mostrado los detalles del curso con éxito.'
            ];
            return response()->json($response);
        }
        
        return response()->json(['message' => 'No se pudo encontrar el curso.'], 422);
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('courses', 'name')->ignore($course->id),
            ],
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:60|max:4000',
            'academy_id' => 'required|exists:academies,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Errores de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validate();
        $course->update($validated);

        $response = [
            'data' => $course,
            'message' => 'Se ha actualizado el curso con éxito.'
        ];
        return response()->json($response);
    }

    public function destroy(Request $request, $id)
    {
        $course = Course::find($id);

        if ($course) {
            $course->delete();
            return response()->json(['message' => 'Se ha eliminado el curso con éxito.']);
        }

        return response()->json(['message' => 'No se pudo encontrar el curso.'], 422);
    }
}
