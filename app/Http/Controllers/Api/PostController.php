<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    public function index(){

        $posts = Post::where('user_id',Auth::user()->id)->
        with('comments')->paginate(5);

        if(!$posts){
            return response()->json([
                'message'=> 'There Is No Post Found'
            ]);
    
        }
        return $posts;







    }
    public function store(PostRequest $request){

        $user = Auth::user()->id;

        $post = Post::create([
            'title'=> $request->title,
            'body'=> $request->body,
            'user_id'=> $user,
        ]);

        return response()->json([
            'post'=>$post,
            'message'=> 'Post Created Successfully'
        ]);




    }
    public function update(UpdatePostRequest $request , $id){
        $post = Post::where('user_id' , Auth::user()->id)->where('id',$id)->first();
         $post->update($request->all());

        return response()->json([
            'post'=>$post,
            'message'=> 'Post Updated Successfully'
        ]);






    }
    public function delete($id){
        $post = Post::where('user_id' , Auth::user()->id)->where('id',$id)->first();

        $post->delete();

        return response()->json([
            'message'=> 'Post Deleted Successfully'
        ]);







    }
}
