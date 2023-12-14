<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite(['./resources/sass/app.scss', 'resources/js/app.js'])
  <title>Document</title>
</head>
<body>
  <div class="container">
    <div class="row">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{route('main.index')}}">Main</a>
      <a class="navbar-brand" href="{{route('post.index')}}">Posts</a>
      <a class="navbar-brand" href="{{route('gallery.index')}}">Gallery</a>
      <a class="navbar-brand" href="{{route('about.index')}}">About</a>
      <a class="navbar-brand" href="{{route('course.index')}}">Course</a>
      </div>
    </nav>
      </div>
    @yield('content')
  </div>
</body>
</html>