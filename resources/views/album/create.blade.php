@extends('layouts.base')
@extends('layouts.app')
@section('content')
<div class="container">
  <h2>Create new album</h2>
  {{-- <form method="post" action="{{url('store')}}" > --}}
  {{-- <form method="post" action="{{url('')}}" > --}}
    <form method="post" action="{{route('album.store')}}" enctype="multipart/form-data">

  {{-- <form method="post" action="{{route('album.store')}}" > --}}
  @csrf  
  {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}
<div class="form-group">
    <label for="album_name" class="control-label">Album Name</label>
    <input type="text" class="form-control" id="album_name" name="album_name" >
  </div> 

<div class="form-group">
    <label for="artist" class="control-label">Artist</label>
    {{-- <input type="text" class="form-control " id="artist" name="artist"> --}}

    {{-- fetch customer with dropdown --}}
    
      <select class="form-select" name="artist_id" id="artist_name">
        @foreach($artists as $id => $artist)
          <option value="{{$id}}">{{$artist}}</option>
        @endforeach
      </select>
    </div>
    
    <div class="form-group">
      <label for="image" class="control-label">Album Cover</label>
      <input type="file" class="form-control" id="image" name="image" >

      <div class="form-group">
        <label for="genre" class="control-label">Genre</label>
        <input type="text" class="form-control" id="genre" name="genre">
      </div>

       @error('image') {{-- kapag may error  --}}
      <div class="alert alert-danger">{{ $message }}</div>
      @enderror
    </div> 

<button type="submit" class="btn btn-primary"> Save </button>
  <a href="{{url()->previous()}}" class="btn btn-default" role="button">Cancel</a>
  </div>   
</div>
</form> 
@endsection
