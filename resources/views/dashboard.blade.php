@extends('layouts.admin')

@section('content')
<div class="col-lg-8 m-auto">
<div class="card">
    <div class="card-header">
        <h3>Admin panel</h3>
    </div>
    <div class="card-body">
        <p>welcome to Dashboard,<strong>{{ Auth::user()->name }}</strong></p>
    </div>
</div>
</div>
@endsection
