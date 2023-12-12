<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function index(){
        $comments = Comment::where('user_id',Auth::user()->id)->paginate(5);

        return response()->json([
            'comment'=>$comments,
        ]);

    }


    public function store(CommentRequest $request,$id){
    $post = Post::where('id',$id)->first();       
    $user = Auth::user()->id; 
    $comment = Comment::create([
        'body'=>$request->body,
        'user_id'=>$user,
        'post_id'=>$post->id,

    ]);
    return response()->json([
        'comment'=>$comment,
        'message'=> 'Comment Created Successfully'
    ]);


    }
    public function update(CommentRequest $request,$id){

        $comment = Comment::findOrFail($id);

        $comment->body = $request->body;
        $comment->save();

        return response()->json([
            'comment'=>$comment,
            'message'=> 'Comment Updated Successfully'
        ]);
    
        
    }
    public function delete($id){
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return response()->json([
            'message'=> 'Comment Deleted Successfully'
        ]);
    }
}
