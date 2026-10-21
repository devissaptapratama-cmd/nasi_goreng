<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PostController extends Controller
{
    public function index(){
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // max 2MB
        ]);

        $file = $request->file('image');

        // Jika ada file diunggah, proses gambar. Jika tidak, lanjutkan tanpa gambar.
        if ($file) {
            $original = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $ext = strtolower($file->getClientOriginalExtension());
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-_]/', '_', $original) . '.' . $ext;
            $path = 'posts/' . $filename;

            $manager = new ImageManager(Driver::class);
            $image = $manager->decodePath($file->getRealPath())
                             ->cover(800, 800);

            // encode sesuai ekstensi (png atau jpg)
            if ($ext === 'png') {
                $encoded = $image->encodeUsingFileExtension('png', quality: 90);
            } else {
                $encoded = $image->encodeUsingFileExtension('jpg', quality: 85);
            }

            // simpan ke disk public
            Storage::disk('public')->put($path, $encoded->toString());

            // sertakan path gambar ke data yang akan disimpan ke DB
            $data['image'] = $path;
        }

        Post::create($data);

        return redirect()->route('posts.index')->with('success', 'Post ditambahkan');
    }
}
