<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnimeController extends Controller
{
    public function index()
    {
        return response()->json(Anime::with('genre')->get());
    }

    public function store(Request $request)
    {
        // Reset auto-increment jika tabel kosong
        if (Anime::count() === 0) {
            DB::statement('ALTER TABLE datanime AUTO_INCREMENT = 1');
        }
    
        $data = $request->validate([
            'anime_name' => 'required|string',
            'slug' => 'required|string',
            'type' => 'required|string',
            'status' => 'required|string',
            'image_url' => 'required|string',
            'description' => 'nullable|string',
            'genre_id' => 'required|exists:genres,id',
        ]);
    
        $anime = new Anime($request->all());
        $anime->save();
    
        return response()->json(['message' => 'Anime created', 'data' => $anime], 201);
    }    

    public function show($id)
    {
        $anime = Anime::with('genre')->find($id);
        return $anime ? response()->json($anime) : response()->json(['message' => 'Anime not found'], 404);
    }

    public function update(Request $request, $id)
    {
        $anime = Anime::find($id);

        if (!$anime) {
            return response()->json(['message' => 'Anime not found'], 404);
        }

        $anime->update($request->all());
        return response()->json(['message' => 'Anime updated', 'data' => $anime]);
    }

    public function destroy($id)
    {
        $anime = Anime::find($id);

        if (!$anime) {
            return response()->json(['message' => 'Anime not found'], 404);
        }

        $anime->delete();
        return response()->json(['message' => 'Anime deleted']);
    }
}
