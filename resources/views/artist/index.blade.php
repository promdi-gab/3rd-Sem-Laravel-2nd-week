@extends('layouts.base')
@extends('layouts.app')
@section('content')

<div class="container">
    <br />
    @if ( Session::has('success'))
      <div class="alert alert-success">
        <p>{{ Session::get('success') }}</p>
      </div><br />
     @endif

     @include('partials.search')

    <table class="table table-striped">
      <tr>{{ link_to_route('artist.create', 'Add new artist:')}}</tr>
    
<thead>
      <tr>
        <th>Artist ID</th>
        <th>Artist Name</th>
        <th>Album Name</th>
        <th>Genre</th>
        <th>Artist Image</th>
     

        <th colspan="2">Action</th>
      </tr>
    </thead>
 <tbody>
     {{-- dd($artists) --}}
     {{-- @foreach($artists as $artist)
     <tr>
       <td>{{$artist->id}}</td>
       <td>{{$artist->artist_name}}</td>
       <td>{{$artist->album_name}} --}}

        @foreach($artists as $artist)
      
        <tr>
          <td>{{$artist->id}}</td>
          <td>{{$artist->artist_name}}</td>
      
          <td>
          @foreach($artist->albums as $album)
         
            <td>
            {{-- <li>{{$album->album_name}} </li>   --}}
      
           <li>{{$album->album_name}} Genre: {{$album->genre}}  </li>  
          @endforeach
          </td>

       

        {{-- <td><img src="{{ asset($artist->img_path) }}" /></td> --}}

        <td><img src="{{ asset('storage/'.$artist->img_path) }}" /></td>
        {{-- php artisan storage:link //para makita yung imgs--}}


      {{-- @foreach($artists as $artist)
      <tr>
        <td>{{$artist->id}}</td>
        <td>{{$artist->artist_name}}</td>
        <td>{{$artist->album_name}}</td> --}}
        <td>
        {{-- @foreach($artist->albums as $art)
         <ul>{{ $art->id . $art->name}}</ul> 
        @endforeach --}}
        </td>
<td><a href = "{{ route('artist.show', $artist->id ) }}"  class="btn btn-warning">show</a></td>
        <td>
        <td><a href="{{ action('ArtistController@edit', $artist->id)}}" class="btn btn-warning">Edit</a></td>
        <td>
<form action="{{ action('ArtistController@destroy', $artist->id)}}" method="post">
           {{ csrf_field() }}
            <input name="_method" type="hidden" value="DELETE">
            <button class="btn btn-danger" type="submit">Delete</button>
          </form>
        </td>
      </tr>
@endforeach
    </tbody>
  </table>
  </div>
@endsection