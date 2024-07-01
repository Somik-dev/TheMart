@extends('layouts.admin')
@section('content')
<div class="col-lg-8">
    <div class="card">
        <div class="card-header">
            <h3>Category list</h3>
        </div>
        <form action="{{ route('restore.checked') }}" method="POST">
            @csrf
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
                @forelse ($trash_category as $sl=>$category )
                    <tr>
                        <td>
                        <div class="custom-control custom-checkbox mb-3">
                           <input type="checkbox" name="category_id[]" value="{{ $category->id }}" class="custom-control-input" id="cate{{ $category->id }}">
                           <label class="custom-control-label" for="cate{{ $category->id }}"></label>
                       </div>
                       </td>
                        <td>{{ $sl+1 }}</td>
                        <td>{{ $category->category_name }}</td>
                        <td><img width="50" src="{{ asset('uploads/categories') }}/{{ $category->category_img }}" alt=""></td>
                        <td>
                            <div class="d-flex">
                                <a title="restore" href="{{ route('category.restore', $category->id) }}" class="btn btn-info shadow btn-xs sharp del_btn"><i class="fa fa-reply"></i></a>
                                &nbsp;
                                <a title="Delete" href="{{ route('category.hard.delete', $category->id) }}" class="btn btn-danger shadow btn-xs sharp del_btn"><i class="fa fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">No trash found</td>
                    </tr>
                @endforelse
            </table>
            <button class="btn btn-primary" type="submit">Restore checked</button>
        </div>
    </form>
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
