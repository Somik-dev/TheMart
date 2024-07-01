@extends('layouts.admin')
@section('content')


    <div class="col-lg-8 m-auto">
       <div class="card">
        <div class="card-header">
            <h3>Edit User Permission</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('permission.update') }}" method="POST">
                @csrf
               <div class="mb-3">
                <input type="hidden" name="user_id" value="{{ $users->id }}">
                <input type="text" readonly value="{{ $users->name }}" class="form-control">
                <input type="text" readonly value="@foreach ($users->getRoleNames() as $role){{ $role }} @endforeach" class="form-control">
               </div>

               <div class="mb-3">
                <h5 class="font-size-14 mb-2">Checkbox</h5>
                  @foreach ($permissions as $permission)
                <div class="form-check">
                    <label class="form-check-label">
                    <input {{ ($users->hasPermissionTo($permission->name))?'checked':'' }} type="checkbox" class="form-check-input" name="permission[]"  value="{{ $permission->name }}">
                       {{ $permission->name}}
                       <i class="input-frame"></i>
                      </label>
                    </label>
                </div>
                @endforeach
              </div>
              <div class="mb-3">
                <button type="submit" class="btn btn-primary">Update</button>
              </div>
            </form>
        </div>
       </div>
    </div>


@endsection
