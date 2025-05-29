@extends('layouts.admin')

@section('content')
<div class="page-inner">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h4 class="card-title">Category Management</h4>
          <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Add Category
          </a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="category-table" class="display table table-striped table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Image</th>
                  <th>Name</th>
                  <th>Description</th>
                  <th style="width: 10%">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($categories as $category)
                <tr>
                  <td>{{ $category->id }}</td>
                  <td>
                    @if($category->image)
                      <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="img-thumbnail" style="max-height: 50px;">
                    @else
                      <span class="text-muted">No Image</span>
                    @endif
                  </td>
                  <td>{{ $category->name }}</td>
                  <td>{{ Str::limit($category->description, 50) }}</td>
                  <td>
                    <div class="form-button-action">
                      <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-link btn-primary btn-lg">
                        <i class="fa fa-edit"></i>
                      </a>
                      <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">
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
</div>
@endsection

@push('scripts')
<script>
  $(document).ready(function() {
    $('#category-table').DataTable({
      pageLength: 10,
      responsive: true
    });
  });
</script>
@endpush