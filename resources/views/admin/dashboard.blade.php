@extends('layouts.admin')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">User Management</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="add-row" class="display table table-striped table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Role</th>
                <th style="width: 10%">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($users as $user)
              <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->lastname }}</td>
                <td>{{ $user->email }}</td>
                <td>
                  <span class="badge bg-{{ $user->role === 'Admin' ? 'primary' : 'success' }}">
                    {{ $user->role }}
                  </span>
                </td>
                <td>
                  <div class="form-button-action">
                    <a href="{{ route('profile.editadmin', $user->id) }}" class="btn btn-link btn-primary btn-lg">
                      <i class="fa fa-edit"></i>
                    </a>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;">
                      @csrf
                      @method('DELETE')
                      <input type="hidden" name="redirect_to" value="{{ route('admin.dashboard') }}">
                      <button type="submit" class="btn btn-link btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">
                        <i class="fa fa-times"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
  // Initialize DataTable
  $("#add-row").DataTable({
    pageLength: 5,
  });
});
</script>
@endpush