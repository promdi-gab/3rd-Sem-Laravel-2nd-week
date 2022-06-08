@extends('layouts.base')
@extends('layouts.app')
@section('content')
<div class="container">
  <h2>Edit Customer</h2>
   {{ Form::model($customer,['route' => ['customer.update',$customer->customer_id],'method'=>'PUT']) }} {{-- Alternative for shorter code di na kailangan ng CSRF at PUT dahil all in one na siya tinawag --}}
  {{-- {{csrf_field()}} --}}
{{--{{ method_field('PUT') }}--}}
  <div class="form-group">
    <label for="title" class="control-label">Title</label>
    {{ Form::text('title',null,array('class'=>'form-control','customer_id'=>'title')) }} {{-- Same gaya sa type:text sa html search mo na lang sa w3School --}}
    @if($errors->has('title')) {{-- Without null di gagana yan error class for css class and customer id para alam ni laravel kanino siya babase --}}
    <small>{{ $errors->first('title') }}</small>
    @endif
  </div> 
<div class="form-group"> 
    <label for="lname" class="control-label">last name</label>
    {{ Form::text('lname',null,array('class'=>'form-control','customer_id'=>'lname')) }}
    @if($errors->has('lname'))
    <small>{{ $errors->first('lname') }}</small>
    @endif
  </div> 
<div class="form-group"> 
    <label for="fname" class="control-label">First Name</label>
    {{ Form::text('fname',null,array('class'=>'form-control','customer_id'=>'fname')) }}
    @if($errors->has('fname'))
    <small>{{ $errors->first('fname') }}</small>
    @endif
  </div>
  <div class="form-group"> 
    <label for="address" class="control-label">Address</label>
    {{ Form::text('address',null,array('class'=>'form-control','customer_id'=>'address')) }}
    @if($errors->has('address'))
    <small>{{ $errors->first('address') }}</small>
    @endif
</div>
  <div class="form-group"> 
    <label for="town" class="control-label">Town</label>
    {{ Form::text('town',null,array('class'=>'form-control','customer_id'=>'town')) }}
    @if($errors->has('town'))
    <small>{{ $errors->first('town') }}</small>
    @endif
  </div>
<div class="form-group"> 
    <label for="zipcode" class="control-label">Zip code</label>
    {{ Form::text('zipcode',null,array('class'=>'form-control','customer_id'=>'zipcode')) }}
    @if($errors->has('zipcode'))
    <small>{{ $errors->first('zipcode') }}</small>
    @endif
  </div>
  <div class="form-group"> 
    <label for="phone" class="control-label">Phone</label>
   {{ Form::text('phone',null,array('class'=>'form-control','customer_id'=>'phone')) }}
   @if($errors->has('phone'))
    <small>{{ $errors->first('phone') }}</small>
    @endif
  </div>

<button type="submit" class="btn btn-primary">Update</button>
<a href="{{url()->previous()}}" class="btn btn-default" role="button">Cancel</a>
  </div>     
</div>
{!! Form::close() !!} {{-- Dont forget close imporatnte toh --}}
@endsection