@extends('layouts.base')
@extends('layouts.app')
@section('content')
  <div class="container">
       <a href="{{route('customer.create')}}" class="btn btn-primary a-btn-slide-text"> {{-- ALTERNATIVE: customer/create --}}
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        <span><strong>ADD</strong></span>            
    </a>
  </div>
@if ($message = Session::get('success'))
 <div class="alert alert-success alert-block">
 <button type="button" class="close" data-dismiss="alert">×</button> 
    <strong>{{ $message }}</strong>
 </div>
@endif
<div class="table-responsive">
<table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>Customer ID</th>
        <th>Title</th>
        <th>lname</th>
        <th>fname</th>
        <th>address</th>
        <th>phone</th>
        <th>Edit</th>
        <th>Delete</th>
        </tr>
    </thead>
<tbody>
      @foreach($customers as $customer)
      <tr>
        <td>{{$customer->id}}</td>
        <td>{{$customer->title}}</td> {{-- Wala ginagawa toh pinapakita lnag id nung Customer --}}
        <td><a href="{{route('customer.show',$customer->customer_id)}}">{{$customer->lname}}</a></td> {{-- ALTERNATIVE: "customer/{{ $customer->customer_id }}/show" --}}
        <td>{{$customer->fname}}</td>
        <td>{{$customer->addressline}}</td>
        <td>{{$customer->phone}}</td>

        {{-- ALTERNATIVE: customer/{{ $customer->customer_id }}/edit --}} {{-- Walang open ito dont know why haha --}}
        <td align="center"><a href="{{ route('customer.edit',$customer->customer_id) }}"><i class="fa-regular fa-pen-to-square" aria-hidden="true" style="font-size:24px" ></a></i></td>
        {{-- Better pala ito shorter code. dito may open at close ewan ko bakit sa edit wala open baka nakalimutan lang ni sir --}}
       <td align="center">{!! Form::open(array('route' => array('customer.destroy', $customer->customer_id),'method'=>'DELETE')) !!}
        <button ><i class="fa-solid fa-trash-can" style="font-size:24px; color:red" ></i></button>
        {!! Form::close() !!}
        </td>

        @if($customer->deleted_at)
{{-- customer = deleted at yung table name yan so pag true na delete rerestore nya else walang gagawen --}}
          <td align="center"><a href="{{ route('customer.restore',$customer->customer_id) }}" ><i class="fa fa-undo" style="font-size:24px; color:red" disabled="true"></i></a>
        </td>
        @else
        <td align="center"><a href="#" ><i class="fa fa-undo" style="font-size:24px; color:gray" ></i></a>
        </td>
        @endif

        <td>
{{-- Auto destroy but with return Confirmation useful ito sa mga gento dahil pwede accidentally maclick ni user yan hehe --}}
          <a href="{{ route('customer.forceDelete', $customer->customer_id) }}" >
              <p class="text-center text-3xl bg-black text-white p-2 mx-4" onclick="return confirm('Do you want to delete this data permanently?')"> {{-- OnCLick Event yung mahilig ka. --}}
                 Destroy  &rarr;
              </p>
            </a>
        </td>

        </tr>
        
      @endforeach
</table>
<div>{{$customers->links()}}</div> {{-- Link For pagination --}}
</div>
</div>
@endsection