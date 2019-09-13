<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Post;

class CommentsController extends Controller
{
    public function __construct() {
        //lockdown controller for login user only
        $this->middleware('auth', ['except' => 'store']);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $post_id)
    {
        $request->validate([
            'name'         => 'required|max:255',
            'email'        => 'required|email|max:255',
            'comment'      => 'required|min:5|max:2000'
        ]);
        
        $post = Post::findOrFail($post_id);

        $comment = new Comment;
        
        $comment->name = $request->name;
        $comment->email = $request->email;
        $comment->comment = $request->comment;
        $comment->approved = true;
        $comment->post()->associate($post);

        $comment->save();

        return redirect()->route('blog.single', [$post->slug])->with('success', 'Comment was added');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comment = Comment::findOrFail($id);
        return view('comments.edit', compact('comment'));
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
        $request->validate([
            'comment'      => 'required|min:5|max:2000'
        ]);

        $comment = Comment::findOrFail($id);

        $comment->comment = $request->comment;
        $comment->save();

        return redirect()->route('posts.show', $comment->post->id)->with('success', 'Comment Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $post_id = $comment->post->id;
        $comment->delete();

        return redirect()->route('posts.show', $post_id)->with('success', 'Comment Deleted');
    }
}
