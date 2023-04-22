<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index(Request $request) {
        $keyword = $request->get('search');
        $perPage = 4;
        if(!empty($keyword)) {
            $posts = Post::where('title', 'LIKE', "%$keyword%")
                    ->orWhere('category', 'LIKE', "%$keyword%")
                    ->latest()->paginate($perPage);
        } else {
            $posts = Post::latest()->paginate($perPage);
        }
        return view('posts.index', ['posts' => $posts])->with('i', (request()->input('page',1) -1) *4);
    }

    public function create() {
         return view('posts.create');
    }

    public function store(Request $request) {

        $request->validate([
            'title' => 'required',
            'image' => 'required|image|mimes:jpg,phg,jpeg,gif,svg|max:2028'
        ]); 

        $post = new Post;

        $file_name = time() . '.' . request()->image->getClientOriginalExtension();
        request()->image->move(public_path('images'), $file_name);

        $post->title = $request->title;
        $post->category = $request->category;
        $post->summary = $request->summary;
        $post->description = $request->description;
        $post->image = $file_name;

        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post Add successfully');
    }

    public function edit($id) {
        $post = Post::findOrFail($id);
        return view('posts.edit', ['post'=>$post]);
    }

    public function update(Request $request, Post $post) {
        $request->validate([
            'title' => 'required',
            'image' => 'required|image|mimes:jpg,phg,jpeg,gif,svg|max:2028'
        ]);

        $file_name = $request->hidden_post_image;

        if($request->image != '') {
            $file_name = time() . '.' . request()->image->getClientOriginalExtension();
            request()->image->move(public_path('images'), $file_name);
        }

        $post = Post::find($request->hidden_id);

        $post->title = $request->title;
        $post->category = $request->category;
        $post->summary = $request->summary;
        $post->description = $request->description;
        $post->image = $file_name;

        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post updated successfully');
    }

    public function destroy($id) {
        $post = Post::findOrFail($id);
        $image_path = public_path()."/images/";
        $image = $image_path. $post->image;
        if(file_exists($image)) {
            @unlink($image);
        }
        $post->delete();
        return redirect('posts')->with('success', 'Post deleted!');
    }
}
