@extends('layouts.admin')

@section('content')

        <div class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="card user-form-card">
                            <div class="card-header">
                                <h4 class="card-title"><i class="fas fa-edit mr-2"></i> Edit Category</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('categories.update', $category->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    
                                    <!-- Basic Information Section -->
                                    <div class="form-section">
                                        <h5 class="section-title"><i class="fas fa-info-circle"></i> Basic Information</h5>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="name">Category Name</label>
                                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                        id="name" name="name" value="{{ old('name', $category->name) }}" required>
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                                id="description" name="description" rows="4">{{ old('description', $category->description) }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <!-- Visual Elements Section -->
                                    <div class="form-section">
                                        <h5 class="section-title"><i class="fas fa-image"></i> Visual Elements</h5>
                                        
                                        <div class="form-group">
                                            <label for="image">Category Image</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input @error('image') is-invalid @enderror" 
                                                    id="image" name="image" accept="image/*">
                                                <label class="custom-file-label" for="image">Choose file</label>
                                                @error('image')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            @if($category->image)
                                                <div class="img-preview-container mt-2">
                                                    <small class="text-muted">Current Image:</small>
                                                    <img src="{{ asset($category->image) }}" alt="Current category image" class="img-preview">
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="icon">Icon Class</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fas fa-icons"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control @error('icon') is-invalid @enderror" 
                                                            id="icon" name="icon" value="{{ old('icon', $category->icon) }}" required>
                                                    </div>
                                                    @error('icon')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <small class="text-muted">e.g. "fas fa-book" for Font Awesome icons</small>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="icon_color">Icon Color</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fas fa-palette"></i></span>
                                                        </div>
                                                        <input type="color" class="form-control form-control-color @error('icon_color') is-invalid @enderror" 
                                                            id="icon_color" name="icon_color" value="{{ old('icon_color', $category->icon_color) }}" required>
                                                    </div>
                                                    @error('icon_color')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Form Actions -->
                                    <div class="action-buttons">
                                        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left mr-2"></i> Back
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save mr-2"></i> Update Category
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
    
    <!-- Core JS Files -->
    <script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
    <!-- Kaiadmin JS -->
    <script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>
    
    <script>
      $(document).ready(function() {
        // Update file input label
        $('.custom-file-input').on('change', function() {
          let fileName = $(this).val().split('\\').pop();
          $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
      });
    </script>
</body>
</html>
@endsection