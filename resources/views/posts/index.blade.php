<!DOCTYPE html>
<html>
<head>
    <title>Daftar Post</title>
</head>
<body>
    <h1>Daftar Post</h1>

    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <a href="{{ route('posts.create') }}">+ Tambah Post</a>

    <!-- Looping data yang dikirim dari controller -->
    @foreach($posts as $post)
        <h2>{{ $post->title }}</h2>
        <p>{{ $post->content }}</p>

        @if($post->image)
            <img src="{{ asset('storage/'.$post->image) }}" width="150">
        @endif
    @endforeach
</body>
</html>
