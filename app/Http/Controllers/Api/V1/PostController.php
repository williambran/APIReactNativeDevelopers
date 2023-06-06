<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Support\Facades\Auth;


use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\V1\PostResource;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return PostResource::collection(Post::latest()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        $user = Auth::user();
        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->longitude = $request->longitude;
        $post->latitude = $request->latitude;
        if(isset($user->id)){
            $post->user_id =  $user->id;
        }
        $post->save();



     return response()->json([
        'message' => 'Successfully created!'], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
       // return $post;   //formato como esta echo el modelo
       return new PostResource($post);  //formato con el recurso
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //   // Verificar si la solicitud es PUT o PATCH
    if ($request->isMethod('put')) {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'longitude' => 'required|string',
            'latitude' => 'required|string',
        ]);
        // Actualizar todos los campos del post con los nuevos valores
        $post->title = $request['title'];
        $post->content = $request['content'];
        $post->longitude = $request['longitude'];
        $post->latitude = $request['latitude'];


    } else {
        // Actualización parcial (PATCH)

        // Actualizar solo los campos proporcionados en la solicitud
        if (isset($request['title'])) {
            $post->title = $request['title'];
        }
        if (isset($request['content'])) {
            $post->content = $request['content'];
        }
        if (isset($request['longitude'])) {
            $post->content = $request['content'];
        }
        if (isset($request['latitude'])) {
            $post->content = $request['content'];
        }
    }

    // Guardar los cambios en el post
    $post->save();

    // Retornar la respuesta de éxito
    return response()->json([
        'message' => 'Post actualizado exitosamente',
        'data' => $post,
    ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
        $post->delete();
        return response()->json(['message' => 'Success'], 204);
    }
}
