<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostAdminController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get();
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'titulo' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:posts',
        'resumen' => 'required|string|max:500',
        'contenido' => 'required|string',
        'nombre_imagen' => 'nullable|string|max:100',
        'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ], [
        'titulo.required' => 'El título es obligatorio.',
        'titulo.max' => 'El título no puede exceder 255 caracteres.',
        'slug.required' => 'El slug es obligatorio.',
        'slug.max' => 'El slug no puede exceder 255 caracteres.',
        'slug.unique' => 'Este slug ya está en uso. Debe ser único.',
        'resumen.required' => 'El resumen es obligatorio.',
        'resumen.max' => 'El resumen no puede exceder 500 caracteres.',
        'contenido.required' => 'El contenido es obligatorio.',
        'nombre_imagen.max' => 'El nombre de la imagen no puede exceder 100 caracteres.',
        'imagen.image' => 'El archivo debe ser una imagen.',
        'imagen.mimes' => 'La imagen debe ser de tipo: jpg, jpeg, png o webp.',
        'imagen.max' => 'La imagen no puede exceder 2MB.',
    ]);

    // Subida de la imagen si existe
    $imageName = null;
    if ($request->hasFile('imagen')) {
        // Si el usuario puso un nombre personalizado
        $customName = $request->input('nombre_imagen');
        $extension = $request->file('imagen')->getClientOriginalExtension();

        // Si no puso nombre, usamos el original sin espacios
        $imageName = $customName
            ? str_replace(' ', '-', $customName) . '.' . $extension
            : time() . '-' . $request->file('imagen')->getClientOriginalName();

        $request->file('imagen')->move(public_path('images/blog'), $imageName);
    }

    // Guardamos el post con el usuario autenticado como autor
    Post::create([
        'user_id' => Auth::guard('admin')->id(), // Asociar al usuario autenticado
        'titulo' => $validated['titulo'],
        'slug' => $validated['slug'],
        'resumen' => $validated['resumen'],
        'contenido' => $validated['contenido'],
        'imagen' => $imageName,
    ]);

    return redirect()->route('posts.index')->with('success', 'Post creado correctamente.');
}

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
{
    $validated = $request->validate([
        'titulo' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:posts,slug,' . $post->id,
        'resumen' => 'required|string|max:500',
        'contenido' => 'required|string',
        'nombre_imagen' => 'nullable|string|max:100',
        'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ], [
        'titulo.required' => 'El título es obligatorio.',
        'titulo.max' => 'El título no puede exceder 255 caracteres.',
        'slug.required' => 'El slug es obligatorio.',
        'slug.max' => 'El slug no puede exceder 255 caracteres.',
        'slug.unique' => 'Este slug ya está en uso. Debe ser único.',
        'resumen.required' => 'El resumen es obligatorio.',
        'resumen.max' => 'El resumen no puede exceder 500 caracteres.',
        'contenido.required' => 'El contenido es obligatorio.',
        'nombre_imagen.max' => 'El nombre de la imagen no puede exceder 100 caracteres.',
        'imagen.image' => 'El archivo debe ser una imagen.',
        'imagen.mimes' => 'La imagen debe ser de tipo: jpg, jpeg, png o webp.',
        'imagen.max' => 'La imagen no puede exceder 2MB.',
    ]);

    $imageName = $post->imagen; // mantener la actual por defecto

    if ($request->hasFile('imagen')) {
        $customName = $request->input('nombre_imagen');
        $extension = $request->file('imagen')->getClientOriginalExtension();
        $imageName = $customName
            ? str_replace(' ', '-', $customName) . '.' . $extension
            : time() . '-' . $request->file('imagen')->getClientOriginalName();

        $request->file('imagen')->move(public_path('images/blog'), $imageName);
    }

    $post->update([
        'user_id' => $post->user_id ?? Auth::guard('admin')->id(), // Mantener autor o asignar si es null
        'titulo' => $validated['titulo'],
        'slug' => $validated['slug'],
        'resumen' => $validated['resumen'],
        'contenido' => $validated['contenido'],
        'imagen' => $imageName,
    ]);

    return redirect()->route('posts.index')->with('success', 'Post actualizado correctamente.');
}


    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post eliminado.');
    }
}
