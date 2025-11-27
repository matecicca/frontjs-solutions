<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostAdminController extends Controller
{
    /**
     * Muestra el listado de todos los posts en el panel de administración.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $posts = Post::latest()->get();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Muestra el formulario para crear un nuevo post.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Guarda un nuevo post en la base de datos.
     * Incluye validación y procesamiento de imagen opcional.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'titulo'        => 'required|string|max:255',
        'slug'          => 'required|string|max:255|unique:posts',
        'resumen'       => 'required|string|max:500',
        'contenido'     => 'required|string',
        'nombre_imagen' => 'nullable|string|max:100',
        'imagen'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ], [
        'titulo.required'    => 'El título es obligatorio.',
        'titulo.max'         => 'El título no puede exceder 255 caracteres.',
        'slug.required'      => 'El slug es obligatorio.',
        'slug.max'           => 'El slug no puede exceder 255 caracteres.',
        'slug.unique'        => 'Este slug ya está en uso. Debe ser único.',
        'resumen.required'   => 'El resumen es obligatorio.',
        'resumen.max'        => 'El resumen no puede exceder 500 caracteres.',
        'contenido.required' => 'El contenido es obligatorio.',
        'nombre_imagen.max'  => 'El nombre de la imagen no puede exceder 100 caracteres.',
        'imagen.image'       => 'El archivo debe ser una imagen.',
        'imagen.mimes'       => 'La imagen debe ser de tipo: jpg, jpeg, png o webp.',
        'imagen.max'         => 'La imagen no puede exceder 2MB.',
    ]);

    $imagePath = null;

    if ($request->hasFile('imagen')) {
        $file       = $request->file('imagen');
        $customName = $request->input('nombre_imagen');

        // Base del nombre de archivo (slugged)
        $baseName = $customName
            ? Str::slug($customName)
            : time() . '-' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));

        $extension = $file->getClientOriginalExtension();
        $fileName  = $baseName . '.' . $extension;

        // Guarda en storage/app/public/blog/...
        $imagePath = $file->storeAs('blog', $fileName, 'public');
        // $imagePath queda algo tipo: "blog/react-introduccion.jpg"
    }

    Post::create([
        'user_id'   => Auth::guard('admin')->id(),
        'titulo'    => $validated['titulo'],
        'slug'      => $validated['slug'],
        'resumen'   => $validated['resumen'],
        'contenido' => $validated['contenido'],
        'imagen'    => $imagePath, // puede ser null
    ]);

    return redirect()->route('posts.index')->with('success', 'Post creado correctamente.');
}

    /**
     * Muestra el formulario para editar un post existente.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\View\View
     */
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Actualiza un post existente en la base de datos.
     * Permite cambiar la imagen, eliminando la anterior si existe.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Post $post)
{
    $validated = $request->validate([
        'titulo'        => 'required|string|max:255',
        'slug'          => 'required|string|max:255|unique:posts,slug,' . $post->id,
        'resumen'       => 'required|string|max:500',
        'contenido'     => 'required|string',
        'nombre_imagen' => 'nullable|string|max:100',
        'imagen'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ], [
        'titulo.required'    => 'El título es obligatorio.',
        'titulo.max'         => 'El título no puede exceder 255 caracteres.',
        'slug.required'      => 'El slug es obligatorio.',
        'slug.max'           => 'El slug no puede exceder 255 caracteres.',
        'slug.unique'        => 'Este slug ya está en uso. Debe ser único.',
        'resumen.required'   => 'El resumen es obligatorio.',
        'resumen.max'        => 'El resumen no puede exceder 500 caracteres.',
        'contenido.required' => 'El contenido es obligatorio.',
        'nombre_imagen.max'  => 'El nombre de la imagen no puede exceder 100 caracteres.',
        'imagen.image'       => 'El archivo debe ser una imagen.',
        'imagen.mimes'       => 'La imagen debe ser de tipo: jpg, jpeg, png o webp.',
        'imagen.max'         => 'La imagen no puede exceder 2MB.',
    ]);

    // Mantener ruta actual por defecto
    $imagePath = $post->imagen;

    if ($request->hasFile('imagen')) {
        $file       = $request->file('imagen');
        $customName = $request->input('nombre_imagen');

        $baseName = $customName
            ? Str::slug($customName)
            : time() . '-' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));

        $extension = $file->getClientOriginalExtension();
        $fileName  = $baseName . '.' . $extension;

        // Borrar la imagen anterior si existía
        if ($post->imagen) {
            Storage::disk('public')->delete($post->imagen);
        }

        // Guardar nueva imagen
        $imagePath = $file->storeAs('blog', $fileName, 'public');
    }

    $post->update([
        'user_id'   => $post->user_id ?? Auth::guard('admin')->id(),
        'titulo'    => $validated['titulo'],
        'slug'      => $validated['slug'],
        'resumen'   => $validated['resumen'],
        'contenido' => $validated['contenido'],
        'imagen'    => $imagePath,
    ]);

    return redirect()->route('posts.index')->with('success', 'Post actualizado correctamente.');
}

    /**
     * Elimina un post de la base de datos.
     * También elimina la imagen asociada del storage si existe.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Post $post)
{
    // Si el post tiene imagen asociada, eliminarla del storage
    if ($post->imagen) {
        Storage::disk('public')->delete($post->imagen);
    }

    $post->delete();

    return redirect()->route('posts.index')->with('success', 'Post eliminado.');
}

}
