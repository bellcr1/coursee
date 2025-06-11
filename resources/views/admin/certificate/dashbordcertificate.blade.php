@extends('layouts.admin')

@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Certificate Management</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="certificates-table" class="display table table-striped table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Student Name</th>
                <th>Course</th>
                <th>Completion Date</th>
             
               
                <th style="width: 15%">Actions</th>
              </tr>
            </thead>
            <tbody>
              @php
              $i=0;
              @endphp
              @foreach ($courseUsers as $courseUser)
                 @php
                 $i++;
                      $user = \App\Models\User::find($courseUser->user_id);
                      $course = \App\Models\Course::find($courseUser->course_id);
                      $category = \App\Models\Category::find($course->category);
                @endphp
             
             
              <tr>
                <td>{{$i}}</td>
                <td>{{$user->name.' '.$user->lastname}}</td>
                <td>{{$category->name.' ('.$course->title.')'}}</td>
                <td>{{ $courseUser->updated_at->format('Y-m-d') }}</td>
               
                
                <td>
                  <div class="form-button-action">
                    <a href="/certificate/verify/{{$courseUser->verify}}" class="btn btn-link btn-primary btn-lg" data-bs-toggle="tooltip" title="View Certificate">
                      <i class="fa fa-eye"></i>
                    </a>
                    <button type="button" class="btn btn-link btn-danger" data-bs-toggle="tooltip" title="Revoke">
                      <i class="fa fa-trash"></i>
                    </button>
                  </div>
                </td>
              </tr>
              @endforeach
                
              </tr>
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
  $("#certificates-table").DataTable({
    pageLength: 5,
  });
  
  // Enable tooltips
  $('[data-bs-toggle="tooltip"]').tooltip();
});
</script>
@endpush