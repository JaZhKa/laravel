<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;

class PostController extends Controller
{
    public function index() {
        $posts = Post::paginate(10);
        return view('post.index', compact('posts'));

        // $category = Category::find(1);
        // $post = Post::find(1);
        // dd($post->category);
        // $tag = Tag::find(1);
        // dd($tag->posts);
    }

    public function create() {
        $categories = Category::all();
        $tags = Tag::all();

       return view('post.create', compact('categories', 'tags'));
    }

    public function store(PostRequest $request) {
        $data = $request->validated();
        $tags = $data['tags'];
        unset($data['tags']);
        $post = Post::create($data);

        $post->tags()->attach($tags);

        return redirect()->route('post.index');
    }

    public function show(Post $post) {
        return view('post.show', compact('post'));
    }

    public function edit(Post $post) {
        $categories = Category::all();
        $tags = Tag::all();

        return view('post.edit', compact('post', 'categories', 'tags'));
    }

    public function update(PostRequest $request, Post $post) {
        $data = $request->validated();
        $tags = $data['tags'];
        unset($data['tags']);

        $post->update($data);
        $post->tags()->sync($tags);
        return redirect()->route('post.show', $post->id );
    }

    public function destroy(Post $post) {
        $post->delete();
        return redirect()->route('post.index');
    }

    public function delete() {
        $post = Post::find(1);
        $post->delete();
        dd('deleted');
    }

    public function restore() {
        $post = Post::withTrashed()->find(2);
        $post->restore();
        dd('restored');
    }

    public function firstOrCreate() {
        $anotherPost = [
            'title' => 'some post',
            'content' => 'some content',
            'image' => 'Someimage.jpg',
            'likes' => 200,
            'is_published' => 1,
        ];

        $post = Post::firstOrCreate([
            'title' => 'some title oj post frome phpstore'
        ], [
            'title' => 'some title oj post frome phpstore',
            'content' => 'some content',
            'image' => 'Someimage.jpg',
            'likes' => 200,
            'is_published' => 1,
        ]);
        dump($post->content);
        dd('FOC finished');
    }

    public function updateOrCreate() {
        $anotherPost = [
            'title' => 'updateOrCreate some title oj post frome phpstore',
            'content' => 'updateOrCreate usome content',
            'image' => 'updateOrCreateSomeimage.jpg',
            'likes' => 300,
            'is_published' => 0,
        ];

        $post = Post::updateOrCreate([
            'title' => 'some title not phpstore',
        ], [
            'title' => 'some title not phpstore',
            'content' => 'not updateOrCreate usome content',
            'image' => 'not updateOrCreateSomeimage.jpg',
            'likes' => 0,
            'is_published' => 0,
        ]);
        dump($post->content);
        dd('UOC finished');
        }
}
