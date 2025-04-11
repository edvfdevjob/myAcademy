<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comunication;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ComunicationController extends Controller
{
    public function index()
    {
        $comunications = Comunication::latest()->get();

        return response()->json([
            'data' => $comunications,
            'message' => 'Comunicados obtenidos con éxito.'
        ]);
    }

    public function resend($id)
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $comunication = Comunication::find($id);
        if (!$comunication) {
            return response()->json(['message' => 'Comunicado no encontrado'], 404);
        }

        Comunication::sendEmails($comunication);

        return response()->json([
            'data' => $comunication,
            'message' => 'El comunicado ha sido enviado exitosamente.'
        ]);
    }
}
