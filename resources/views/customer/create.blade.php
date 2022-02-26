@extends('layouts.base')
@section('body')
<div class="container">
   <ul class="errors">
 @foreach($errors->all() as $message)
   <li><p>{{ $message }}</p></li> {{-- Take this for example lahat ng error lumabas --}}
 @endforeach
 </ul>
  <h2>Create new Customer</h2>
  <form method="POST" action="{{route('customer.store')}}" > {{-- akin"/customer" gets mo toh diba?para sa n yung ,store wala alng? no--}} 
  @csrf
  <div class="form-group">
    <label for="title" class="control-label">Title</label> {{-- Yung old para bumalik yung nilagay mo pag may error  --}}
    <input type="text" class="form-control" id="title" name="title" value="{{old('title')}}">@if($errors->has('title'))
    <small>{{ $errors->first('title') }}</small> {{-- Kaya first kasi yan lang need mo error pag walang first lahat ng error lalabas --}}
   @endif 
  </div> 
<div class="form-group"> 
    <label for="lname" class="control-label">last name</label>
    <input type="text" class="form-control " id="lname" name="lname" value="{{old('lname')}}" >@if($errors->has('lname'))
    <small>{{ $errors->first('lname') }}</small>
   @endif 
  </div> 
  <div class="form-group"> 
    <label for="fname" class="control-label">First Name</label>
    <input type="text" class="form-control " id="fname" name="fname" value="{{old('fname')}}">@if($errors->has('fname'))
    <small>{{ $errors->first('fname') }}</small>
   @endif 
  </div>
<div class="form-group"> 
    <label for="address" class="control-label">Address</label>
    <input type="text" class="form-control" id="address" name="address" value="{{old('address')}}">@if($errors->has('address'))
    <small>{{ $errors->first('address') }}</small>
   @endif 
  </div>
  <div class="form-group"> 
    <label for="town" class="control-label">Town</label>
    <input type="text" class="form-control" id="town" name="town" value="{{old('town')}}">@if($errors->has('town'))
    <small>{{ $errors->first('town') }}</small>
   @endif 
  </div>
<div class="form-group"> 
    <label for="zipcode" class="control-label">Zip code</label>
    <input type="text" class="form-control" id="zipcode" name="zipcode" value="{{old('zipcode')}}">@if($errors->has('zipcode'))
    <small>{{ $errors->first('zipcode') }}</small>
   @endif 
  </div>
  <div class="form-group"> 
    <label for="phone" class="control-label">Phone</label>
    <input type="text" class="form-control" id="phone" name="phone" value="{{old('phone')}}">@if($errors->has('phone'))
    <small>{{ $errors->first('phone') }}</small>
   @endif 
  </div>
<button type="submit" class="btn btn-primary">Save</button>
  <a href="{{url()->previous()}}" class="btn btn-default" role="button">Cancel</a> {{-- Kung anu previoue url na gamit mo dun ka babalik --}}
  </div>     
</div>
</form> 
@endsection