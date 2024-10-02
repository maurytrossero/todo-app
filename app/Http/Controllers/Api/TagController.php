<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Muestra una lista de todas las etiquetas.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            // Recupera todas las etiquetas
            $tags = Tag::all();

            // Retorna las etiquetas en formato JSON
            return response()->json($tags);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al recuperar las etiquetas.'], 500);
        }
    }
}
