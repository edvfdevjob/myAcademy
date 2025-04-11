<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        $rules = [
            'registration_id' => 'required|exists:registrations,id',
            'method' => 'required|string|max:255|in:cash,transfer',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
        ];

        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Errores de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $registration = Registration::with('student.responsible')->find($request->registration_id);

        if ($user->role === 'responsible') {
            if (!$user->responsible || $registration->student->responsible_id !== $user->responsible->id) {
                return response()->json(['message' => 'No autorizado.'], 403);
            }
        }

        $payment = Payment::create($validator->validated());

        return response()->json([
            'data' => $payment,
            'message' => 'Pago registrado con éxito.'
        ], 201);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $payment = Payment::with('registration.student.responsible')->find($id);

        if (!$payment) {
            return response()->json(['message' => 'Pago no encontrado'], 404);
        }

        $student = $payment->registration->student;

        if ($user->role === 'responsible') {
            if (!$user->responsible || $student->responsible_id !== $user->responsible->id) {
                return response()->json(['message' => 'No autorizado.'], 403);
            }
        }

        $payment->delete();

        return response()->json(['message' => 'Pago eliminado con éxito.']);
    }
}
