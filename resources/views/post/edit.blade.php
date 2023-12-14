@extends('layouts.main')
@section('content')
  <div>
    <form action="{{ route('post.update', $post->id) }}" method="post">
      @csrf
      @method('patch')
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Title</label>
        <input name="title" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Title" value="{{ $post->title }}">
      </div>
      <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Content</label>
        <textarea name="content" class="form-control" id="exampleFormControlTextarea1" rows="3">{{ $post->content }}</textarea>
      </div>
      <div class="mb-3">
        <label for="exampleFormControlInput2" class="form-label">Image</label>
        <input name="image" type="img" class="form-control" id="exampleFormControlInput2" placeholder="img.jpg" value="{{ $post->image }}">
      </div>
      <div class="form-groupe">
        <label for="category">Category</label>
          <select class="form-select mb-3" aria-label="Category select" id="category" name="category_id">
            @foreach($categories as $category)
              <option
                {{ $category->id === $post->category->id ? ' selected' : '' }}
               value="{{ $category->id }}">{{ $category->title }}</option>
            @endforeach
          </select>
      </div>
      <label for="tags">Tags</label>
      <select class="form-select mb-3" multiple aria-label="multiple select example" id="tags" name="tags[]">
        @foreach($tags as $tag)
          <option
            @foreach($post->tags as $postTag)
              {{ $tag->id === $postTag->id ? ' selected' : '' }}
            @endforeach
          value="{{ $tag->id }}">{{ $tag->title }}</option>
        @endforeach 
      </select>
      <button type="submit" class="btn btn-primary">Update</button>
    </form>
  </div>
@endsection