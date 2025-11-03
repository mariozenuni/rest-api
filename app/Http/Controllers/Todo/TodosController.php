<?php

namespace App\Http\Controllers\Todo;

use App\Models\Todo;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;

class TodosController extends Controller
{
    public function __construct()
    {

    }

    public function getAll()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $todos = Todo::where('user_id', $user->id)->get();

        return response()->json(['data' => $todos]);
    }

    public function getById($id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $todo = Todo::where('user_id', $user->id)->find($id);

        if (!$todo) {
            return response()->json(['error' => 'Todo not found'], 404);
        }

        return response()->json(['data' => $todo]);
    }


    public function createTodos(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'completed' => 'integer'
        ]);

        $todo = Todo::create([  
            'title' => $validated['title'],
            'completed' => $validated['completed'] ?? false,
            'user_id' => $user->id,
        ]);

        return response()->json(['data' => $todo], 201);
    }

    public function updateTodos(Request $request, $id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $todo = Todo::where('user_id', $user->id)->find($id);

        if (!$todo) {
            return response()->json(['error' => 'Todo not found'], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'completed' => 'sometimes|boolean'
        ]);

        $todo->update($validated);

        return response()->json(['data' => $todo]);
    }

    public function deleteTodos($id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $todo = Todo::where('user_id', $user->id)->find($id);

        if (!$todo) {
            return response()->json(['error' => 'Todo not found'], 404);
        }

        $todo->delete();

        return response()->json(['message' => 'Todo deleted successfully']);
    }
}
