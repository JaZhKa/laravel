@extends('layouts.main')
@section('content')
  <div>
    <form action="{{route('post.store')}}" method="post">
      @csrf
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Title</label>
        <input name="title" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Title" value="{{ old('title') }}">
        @error('title')
          <p class="text-danger">{{ $message }}</p>
        @enderror
      </div>
      <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Content</label>
        <textarea name="content" class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder='Content'>{{ old('content') }}</textarea>
        @error('content')
          <p class="text-danger">{{ $message }}</p>
        @enderror
      </div>
      <div class="mb-3">
        <label for="exampleFormControlInput2" class="form-label">Image</label>
        <input name="image" type="img" class="form-control" id="exampleFormControlInput2" placeholder="img.jpg" value="{{ old('image') }}">
        @error('image')
          <p class="text-danger">{{ $message }}</p>
        @enderror
      </div>
      <div class="form-groupe">
        <label for="category">Category</label>
          <select class="form-select mb-3" aria-label="Category select" id="category" name="category_id">
            <option selected disabled>Open this select menu</option>
            @foreach($categories as $category)
              <option
                {{ old('category_id') == $category->id ? 'selected' : '' }}
                value="{{ $category->id }}">{{ $category->title }}</option>
            @endforeach
          </select>
      </div>
      <label for="tags">Tags</label>
      <select class="form-select mb-3" multiple aria-label="multiple select example" id="tags" name="tags[]">
        @foreach($tags as $tag)
          <option value="{{ $tag->id }}">{{ $tag->title }}</option>
        @endforeach 
      </select>
      <button type="submit" class="btn btn-primary">Create</button>
    </form>
  </div>
@endsection