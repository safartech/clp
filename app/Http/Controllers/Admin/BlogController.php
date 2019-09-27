<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use TCG\Voyager\Models\Post;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('espaces.admin.blog');
    }
    public function loadPost()
    {
        $listepost=Post::get();

        return compact('listepost');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = new Post();

        $post->author_id = Auth::user()->id;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->save();

        return $post;
    }


    public function storecomment(Request $request)
    {
        $comment=new Comment();
        $comment->post_id=$request->input('post_id');
        $comment->content=$request->input('content');
        $comment->user_id=Auth::user()->id;
        $comment->save();
        return $comment;
    }



    public  function loaduser(Request $request,$id)
    {
        $res= Post::find($id);
        $user=User::get()->where('id','=',$res->author_id);
        $comment=Comment::get()->where('post_id','=',$res->id);

        return  compact('user','comment');
    }

    public function updateposte(Request $request,$id)
    {
        $post=Post::find($id);
        $post->update($request->input());
        return 'ok';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        Post::destroy($id);
        Comment::where('post_id',$id)->delete();
        return 'ok';
    }

    public function destroyComment(Request $request,$id)
    {
        Comment::destroy($id);
        return 'ok';
    }
}
