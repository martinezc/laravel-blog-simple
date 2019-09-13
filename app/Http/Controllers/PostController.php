<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\Tag;
use Carbon\Carbon;
use Purifier;
use Image;
use File;

class PostController extends Controller
{
    public function __construct() {
        //lockdown controller for login user only
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest('id')->paginate(10);
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $cats = [];
        foreach ($categories as $category) {
           $cats[$category->id] = $category->name;
        }

        $tags = Tag::all();
        $tgs = [];
        foreach ($tags as $tag) {
            $tgs[$tag->id] = $tag->name;
        }

        return view('posts.create', compact('cats', 'tgs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate the data
        $request->validate([
            'title'             => 'required|max:255',
            'slug'              => 'required|alpha_dash|min:5|max:250|unique:posts,slug',
            'category_id'       => 'required|integer',
            'body'              => 'required',
            'featured_image'    => 'sometimes|image'
        ]);

        //store in db
        $post = new Post;

        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->category_id = $request->category_id;
        $post->body = Purifier::clean($request->body);

        //save image
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/' . $filename);
            Image::make($image)->resize(800, 400)->save($location);
        
            $post->image = $filename;
        }

        $post->save();

        $post->tags()->sync($request->tags, false);

        return redirect()->route('posts.show', $post->id)->with('success', 'The blog post was successfully save!');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        $date = Carbon::now(); 
        return view('posts.show', compact('post', 'date'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $date = Carbon::now();
        $post = Post::findOrFail($id);

        $categories = Category::all();
        $cats = [];
        foreach ($categories as $category) {
           $cats[$category->id] = $category->name;
        }

        $tags = Tag::all();
        $tgs = [];
        foreach ($tags as $tag) {
            $tgs[$tag->id] = $tag->name;
        }

        return view('posts.edit', compact('post', 'cats', 'tgs', 'date'));
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
        $post = Post::findOrFail($id);

        $request->validate([
            'title' => 'required|max:255',
            'slug'  => "required|alpha_dash|min:5|max:250|unique:posts,slug,$id",
            'category_id'   => 'required|integer',
            'body'  => 'required',
            'featured_image'    => 'image'
        ]);
    
        $post = Post::findOrFail($id);

        $post->title = $request->input('title');
        $post->slug = $request->input('slug');
        $post->category_id = $request->input('category_id');
        $post->body = Purifier::clean($request->input('body'));

        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/' . $filename);
            Image::make($image)->resize(800, 400)->save($location);
        
            $oldFilename = $post->image;

            $post->image = $filename;

            File::delete(public_path('images/'. $oldFilename));
        }

        $post->save();

        $post->tags()->sync($request->tags);

        return redirect()->route('posts.show', $post->id)->with('success', 'The post was successfully save.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->tags()->detach();
        File::delete(public_path('images/'. $post->image));
        $post->delete();
        
        return redirect('posts')->with('success', 'The post was succesfully deleted.');
    }
}
