<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use App\Http\Filters\PostFilter;
use App\Http\Requests\StoreRequest;
use App\Http\Requests\UpdateRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use App\Services\PostService;

class PostController extends Controller
{
    public $service;
    public function __construct(PostService $service)
    {
        $this->service = $service;
    }

    public function index(FilterRequest $request)
    {
        $data = $request->validated();

        $page = $data['page'] ?? 1;
        $perPage = $data['per_page'] ?? 10;

        $filter = app()->make(PostFilter::class, ['queryParams' => array_filter($data)]);
        $posts = Post::filter($filter)->orderByDesc('id')->paginate($perPage, ['*'], 'page', $page);

        return PostResource::collection($posts);

        // return view('post.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        $data = [
            'categories' => $categories,
            'tags' => $tags,
        ];

        return response()->json($data);
        // return view('post.create', compact('categories', 'tags'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $post = $this->service->store($data);
        return $post instanceof Post ? new PostResource($post) : $post;
    }

    public function show(Post $post)
    {
        // return view('post.show', compact('post'));
        return new PostResource($post);
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('post.edit', compact('post', 'categories', 'tags'));
    }

    public function update(UpdateRequest $request, Post $post)
    {
        $data = $request->validated();
        $post = $this->service->update($post, $data);
        return $post instanceof Post ? new PostResource($post) : $post;
    }


    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('post.index');
    }

    public function delete()
    {
        $post = Post::find(1);
        $post->delete();
        dd('deleted');
    }

    public function restore()
    {
        $post = Post::withTrashed()->find(2);
        $post->restore();
        dd('restored');
    }

    public function firstOrCreate()
    {
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

    public function updateOrCreate()
    {
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
