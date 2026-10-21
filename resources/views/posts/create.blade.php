<h1>Tambah Post</h1>

<form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
    @csrf
    <p><input name="title" placeholder="Judul" value="{{ old('title') }}"></p>
    <p><textarea name="content" placeholder="Isi">{{ old('content') }}</textarea></p>
    <p><input type="file" name="image"></p>
    <button type="submit">Simpan</button>
</form>

@if($errors->any())
    <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
@endif
