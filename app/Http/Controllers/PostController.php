<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;



class PostController extends Controller 
{

    public function index()
    {
        return Post::with('user')->get();
    }

    public function store(Request $request)
    {
        $ValidatedData=$request->validate([
            'Title'=>'required|string',
            'Descreption'=>'required|string',
            'category_id'=>'required|exists:categories,id'
        ]);

       
        $post=$request->user()->posts()->create($ValidatedData);
        Log::info('Post created: ', ['post' => $post]);
        return response()->json(['message' => 'Post created successfully', 'Post' => Post::all()]);

      
    }

    public function show($id)
    {
       return Post::with('user')->find($id);
    }

    public function update(Request $request, Post $post)
    {
      
        $ValidatedData=$request->validate([
            'Title'=>'required|string',
            'Descreption'=>'required|string',
            'category_id'=>'exists:categories,id'
          
        ]);

        if(auth()->id() == $post->user_id)
        {
            
            $post->update($ValidatedData);
            Log::info('Post updated: ', ['post' => $post]);
            return response()->json(['message' => 'Post updated successfully']);
        }
        else
        return ['message' => 'Not allowed'];


    }

    public function destroy(Post $post)
    {
        if(auth()->id() == $post->user_id)
        {
            $post->delete();
            Log::info('Post deleted: ', ['post' => $post]);
            return ['message'=>'Post deleted successfully'];

        }
        else
        return ['message' => 'Not allowed'];
    }
}
