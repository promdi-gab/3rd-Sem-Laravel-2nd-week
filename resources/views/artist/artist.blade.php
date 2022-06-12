@extends('layouts.base')
@section('body')
<div class="container">
    <br />
    @if ( Session::has('success'))
    <div class="alert alert-success">
        <p>{{ Session::get('success') }}</p>
    </div><br />
    @endif
</div>
<div class="row">
    {{$dataTable->table(['class' => 'table table-bordered table-striped table-hover'], true)}}
</div>
@push('scripts')
{{$dataTable->scripts()}}
@endpush
@endsection