@extends('layouts.admin')

@section('content')
 <div class="col-lg-8">
    <form action="{{ route('delete.checked') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header">
                <h3>Category list</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>
                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" class="custom-control-input" id="checkAll">
                                <label class="custom-control-label" for="checkAll">Check All</label>
                            </div>
                        </th>
                        <th>SL</th>
                        <th>Category Name</th>
                        <th>Category Image</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($categories as $sl=>$category )
                        <tr>
                            <td>

                                 <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" name="category_id[]" value="{{ $category->id }}" class="custom-control-input" id="cate{{ $category->id }}">
                                <label class="custom-control-label" for="cate{{ $category->id }}"></label>
                            </div>
                            </td>
                            <td>{{ $categories->firstitem()+$sl }}</td>
                            <td>{{ $category->category_name }}</td>
                            <td><img width="50" src="{{ asset('uploads/categories') }}/{{ $category->category_img }}" alt=""></td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('category.edit', $category->id) }}" class="btn btn-info shadow btn-xs sharp del_btn"><i class="fa fa-pencil"></i></a>
                                    &nbsp;
                                    <a href="{{ route('category.soft.delete', $category->id) }}" class="btn btn-danger shadow btn-xs sharp del_btn"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
                {{ $categories->links() }}
                <button class="btn btn-primary" type="submit">Delete checked</button>
            </div>
        </div>
    </form>
 </div>
 <div class="col-lg-4">
    <div class="card">
        <div class="card-header">
            <h3>Add New Category</h3>
        </div>
        <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
          <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
             <label for="" class="from-lebel">Category Name</label>
             <input type="text" name="category_name" class="form-control">
             @error('category_name')
                 <strong class="text-danger">{{ $message }}</strong>
             @enderror
            </div>
            <div class="mb-3">
             <label for="" class="from-lebel">Category Image</label>
             <input type="file" name="category_img" class="form-control">
             @error('category_img')
             <strong class="text-danger">{{ $message }}</strong>
         @enderror
            </div>
            <div class="mb-3">
            <button type="submit" class="btn btn-primary">Add Category</button>
            </div>
          </form>
        </div>
    </div>
 </div>
@endsection

@section('footer_script')
<script>
    $("#checkAll").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
});
</script>

@endsection
