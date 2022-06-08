@extends('layouts.base')
@extends('layouts.app')
@section('content')
<div class="container">
  <h2>Create new artist</h2>
  {{-- <form method="post" action="{{url('store')}}" > --}}
  {{-- <form method="post" action="{{url('')}}" > --}}
  {{-- <form method="post" action="{{route('artist.store')}}" > --}}

  <form method="post" action="{{route('artist.store')}}" enctype="multipart/form-data">

  @csrf  
  
<div class="form-group">
    <label for="artist_name" class="control-label">Artist name</label>
    <input type="text" class="form-control" id="artist_name" name="artist_name" >
  </div> 

  <div class="form-group">
    <label for="image" class="control-label">Artist Image</label>
    <input type="file" class="form-control" id="image" name="image" >
    @error('image')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
  </div>
  
<button type="submit" class="btn btn-primary">Save</button>
  <a href="{{url()->previous()}}" class="btn btn-default" role="button">Cancel</a>
  </div>     
</div>
</form> 
@endsection