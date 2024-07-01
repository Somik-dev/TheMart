@extends('layouts.admin')
@section('content')
<div class="container">
<div class="row">
<div class="col-lg-10 m-auto">
<div class="card">
<div class="card-header">
<h3>Subscriber List</h3>
</div>
<div class="card-body">
@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
<table class="table table-bordered">
<tr>
        <th>SL</th>
        <th>Email</th>
        <th>Action</th>
</tr>

@foreach ($subscribers as $sl=>$subscriber)
<tr>
<td>{{ $sl+1 }}</td>
<td>{{ $subscriber->email }}</td>
<td>
<a href="{{ route('send.newslater',$subscriber->id) }}" class="btn btn-success btn-sm">Send Newsletter</a>
<a href="" class="btn btn-danger btn-sm">Delete</a>
</td>
</tr>
@endforeach

</table>
</div>
</div>
</div>
</div>
</div>
@endsection
