<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function getAll()
    {
        $posts=Post::all();
        if($posts){
            return response()->json([
            'status'=>'success',
            'data'=>$posts,
        ],201);
    }else{
        return response()->json([
            'msg' => 'Posts not found'
        ], 404);
    }
    }

    public function show($id)
    {
        $post=Post::findOrFail($id);
        if($post){
            return response()->json([
                'status'=>'success',
                'data'=>$post,
            ],201);
        }else{
            return response()->json([
                'msg' => 'Post not found'
            ], 404);
        }
    }

    public function store(Request $request){
        $validate=Validator::make($request->all(),[
            'title'=>'required|string|max:255',
            'content'=>'required|string|'
        ]);
        if($validate->fails()){
            return response()->json([
                'msg'=>$validate->errors()
            ]);
        }
        $user=Auth::user();
        if (!$user) {
            return response()->json([
                'error' => 'You are not authenticated'
            ], 401);
        }
        
        Post::create([
            'user_id'=>$user->id,
            'title'=>$request->title,
            'content'=>$request->content
        ]);
        return response()->json([
            'status'=>'success',
            'msg'=>'Post created successfully'
        ],201);
    }

    public function update(Request $request, $id){
        $validate=Validator::make($request->all(),[
            'title'=>'required|string|max:255',
            'content'=>'required|string|'
        ]);
        $post=Post::find($id);
        if($validate->fails()){
            return response()->json([
                'msg'=>$validate->errors()
            ],400);
        }
        if (!$post) {
            return response()->json(['msg' => 'Post not found'], 404);
        }
        if ($post->user_id !== Auth::id()) {
            return response()->json([
                'msg' => 'you do not have permission to update this post'
            ], 400);
        }
        $post->update([
            'title'=>$request->title,
            'content'=>$request->content
        ]);
        return response()->json([
            'status'=>'success',
            'msg'=>'Post updated successfully'
        ],201);
    }

    public function delete($id){
        $post=Post::find($id);
        if (!$post) {
            return response()->json(['msg' => 'Post not found'], 404);
        }
        if ($post->user_id !== Auth::id()) {
            return response()->json([
                'msg' => 'you do not have permission to update this post'
            ], 400);
        }
        $post->delete();
        return response()->json([
            'msg'=>'Post deleted successfully'
        ],201);
    }
}

