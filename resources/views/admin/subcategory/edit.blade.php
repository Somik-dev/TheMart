@extends('layouts.admin')
@section('content')
<div class="col-lg-8 m-auto">
    <div class="card">
        <div class="card-header">
            <h3>Edit Subcategory</h3>
        </div>
        <div class="card-body">
            @if (session('updated'))
                <div class="alert alert-success">{{ session('updated') }}</div>
            @endif
            @if (session('exists'))
                <div class="alert alert-danger">{{ session('exists') }}</div>
            @endif
            <form action="{{ route('subcategory.update',$subcategory->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <select name="category" class="form-control">
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                        <option {{ $category->id == $subcategory->category_id?'selected':'' }} value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                    @error('category')
                    <strong class="text-danger">{{ $message }}</strong>
                @enderror
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Subcategory Name</label>
                    <input type="text" name="category_name" class="form-control" value="{{ $subcategory->category_name }}">
                    @error('category')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Update Subcategory</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
