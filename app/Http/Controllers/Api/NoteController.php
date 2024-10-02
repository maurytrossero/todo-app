<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Note;

class NoteController extends Controller
{
    /**
     * Listar todas las notas.
     */
    public function index(Request $request)
    {
        try {
            if (!auth()->check()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }
    
            $sortField = $request->query('sort', 'created_at');
            $sortOrder = $request->query('order', 'asc');
            
            $userId = auth()->id();
            
            $notes = Note::where('user_id', $userId)
                        ->with('user')
                        ->with('tag') // Cargar las etiquetas relacionadas
                        ->orderBy($sortField, $sortOrder)
                        ->get();
    
            return response()->json([
                'success' => true,
                'data' => $notes
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    

    /**
     * Guardar una nueva nota en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los campos
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tag_id' => 'required|exists:tags,id', // Validar que el tag exista en la tabla tags
        ]);
    
        // Almacenar la ID del usuario autenticado
        $validated['user_id'] = auth()->id();
    
        // Si no se proporciona 'due_date', lo asignamos a un mes después de la fecha actual
        $validated['due_date'] = $request->due_date ?? now()->addMonth();
    
        // Crear la nueva nota
        $note = Note::create($validated);
    
        // Retornar la nueva nota con su tag como JSON
        return response()->json([
            'success' => true,
            'data' => $note->load('tag') // Cargar la tag asociada a la nota
        ], 201);
    }
    
    

    /**
     * Mostrar los detalles de una nota específica.
     */
    public function show($id)
    {
        // Obtener la nota por su ID junto con los tags
        $note = Note::with('tags')->find($id);
    
        // Verificar si la nota existe
        if (!$note) {
            return response()->json([
                'success' => false,
                'message' => 'Nota no encontrada'
            ], 404);
        }
    
        // Retornar la nota con los tags
        return response()->json([
            'success' => true,
            'data' => $note
        ], 200);
    }
    

    /**
     * Actualizar una nota existente en la base de datos.
     */
    public function update(Request $request, $id)
    {
        // Validar los campos
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'nullable|date',
            'tag_id' => 'required|exists:tags,id', // Validar que el tag exista en la tabla tags
        ]);

        // Buscar la nota
        $note = Note::findOrFail($id);

        // Asegurarse de que solo el propietario de la nota pueda actualizarla
        if ($note->user_id !== auth()->id()) {
            return response()->json(['error' => 'No tienes permiso para actualizar esta nota'], 403);
        }

        // Actualizar la nota
        $note->update($validated);

        // Retornar la nota actualizada con su tag
        return response()->json([
            'success' => true,
            'data' => $note->load('tag') // Cargar la tag asociada a la nota
        ], 200);
    }

    /**
     * Eliminar una nota de la base de datos.
     */
    public function destroy($id)
    {
        // Obtener la nota por su ID
        $note = Note::find($id);

        // Verificar si la nota existe
        if (!$note) {
            return response()->json([
                'success' => false,
                'message' => 'Nota no encontrada'
            ], 404);
        }

        // Eliminar la nota
        $note->delete();

        // Retornar una respuesta exitosa
        return response()->json([
            'success' => true,
            'message' => 'Nota eliminada con éxito'
        ], 200);
    }
}
