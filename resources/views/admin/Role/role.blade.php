@extends('layouts.admin')
@section('content')

<div class="col-lg-8">
    <div class="card">
        <div class="card-header">
            <h3>Role list</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                 <tr>
                    <th>SL</th>
                    <th>Role</th>
                    <th>Permission</th>
                 </tr>
                 @foreach ($roles as $sl=>$role)
                     <tr>
                        <td>{{ $sl+1 }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            @foreach ($role->getAllPermissions() as $permission)
                               <span class="badge badge-primary my-2" style="font-size: 10px"> {{ $permission->name }}</span>
                            @endforeach
                        </td>
                        <td></td>
                     </tr>
                 @endforeach
            </table>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3>User list</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                 <tr>
                    <th>SL</th>
                    <th>User</th>
                    <th>Role</th>
                    <th>Permission</th>
                    <th>Action</th>
                 </tr>
                 @foreach ($users as $sl=>$user)
                     <tr>
                        <td>{{ $sl+1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>
                            @forelse ($user->getRoleNames() as $role)
                                <span class="badge badge-success my-2">{{ $role }}</span>
                            @empty
                            <span class="btn btn-dark btn-sm">Not Assigend</span>
                            @endforelse
                        </td>
                        <td>
                            @forelse ($user->getAllPermissions() as $permission)
                            <span class="badge badge-light my-2">{{ $permission->name }}</span>
                            @empty
                            <span class="btn btn-dark btn-sm">Not Assigend</span>
                            @endforelse
                        </td>
                        <td>
                          <div class="d-flex">
                            <a href="{{ route('edit.user.role.permission', $user->id) }}" class="btn btn-info shadow btn-xs sharp del_btn"><i class="fa fa-pencil"></i></a>
                                &nbsp;
                            <a href="{{ route('remove.role', $user->id) }}" class="btn btn-danger shadow btn-xs sharp del_btn"><i class="fa fa-trash"></i></a>
                          </div>
                        </td>
                     </tr>
                 @endforeach
            </table>
        </div>
    </div>
</div>
<div class="col-lg-4">
    <div class="card">
        <div class="card-header">
            <h3>Add permissions</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('permission.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">permisson</label>
                    <input type="text" class="form-control" name="permission_name">
                  </div>
                  <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3>Add Role</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('role.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <input type="text" class="form-control" name="role_name">
                  </div>
                   <div class="mb-3">
                    <h5 class="font-size-14 mb-2">Checkbox</h5>
                      @foreach ($permissions as $permission)
                    <div class="form-check">
                        <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" name="permission[]"  value="{{ $permission->name }}">
                           {{ $permission->name}}
                           <i class="input-frame"></i>
                          </label>
                        </label>
                    </div>
                    @endforeach
                  </div>
                  <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Add Role</button>
                  </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3>Assign Role</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('assign.role') }}" method="POST">
                @csrf

                <div class="mb-3">
                   <select name="user_id" class="form-control user_id">
                     <option value=""> --Select User --</option>
                     @foreach ($users as $user)
                         <option value="{{ $user->id }}">{{ $user->name }}</option>
                     @endforeach
                   </select>
                  </div>


                  <div class="mb-3">
                   <select name="role_id" class="form-control user_id">
                     <option value=""> --Select Role --</option>
                     @foreach ($roles as $role)
                         <option value="{{ $role->name }}">{{ $role->name }}</option>
                     @endforeach
                   </select>
                  </div>




                  <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Assign Role</button>
                  </div>
            </form>
        </div>
    </div>
</div>

@endsection
