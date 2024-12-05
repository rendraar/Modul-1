<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GenreController extends Controller
{
    public function index()
    {
        return response()->json(Genre::all());
    }

    public function store(Request $request)
    {
        // Reset auto-increment jika tabel kosong
        if (Genre::count() === 0) {
            DB::statement('ALTER TABLE genres AUTO_INCREMENT = 1');
        }
        $data = $request->validate(['name' => 'required|string']);
        $genre = Genre::create($data);
        return response()->json(['message' => 'Genre created', 'data' => $genre], 201);
    }

    public function show($id)
    {
        $genre = Genre::find($id);
        return $genre ? response()->json($genre) : response()->json(['message' => 'Genre not found'], 404);
    }

    public function update(Request $request, $id)
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json(['message' => 'Genre not found'], 404);
        }

        $genre->update($request->all());
        return response()->json(['message' => 'Genre updated', 'data' => $genre]);
    }

    public function destroy($id)
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json(['message' => 'Genre not found'], 404);
        }

        $genre->delete();
        return response()->json(['message' => 'Genre deleted']);
    }
}
