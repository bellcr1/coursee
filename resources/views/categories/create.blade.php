@extends('layouts.admin')

@push('styles')
<style>
    .user-form-card {
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        border: none;
        overflow: hidden;
    }
    
    .user-form-card .card-header {
        background: linear-gradient(120deg, #6777ef 0%, #3519db 100%);
        color: white;
        padding: 1.75rem 2rem;
        border-bottom: 0;
    }
    
    .user-form-card .card-header h4 {
        font-weight: 600;
        margin-bottom: 0;
        display: flex;
        align-items: center;
    }
    
    .user-form-card .card-body {
        padding: 2.5rem;
    }
    
    .form-section {
        margin-bottom: 1.75rem;
        padding-bottom: 1.75rem;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .form-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #4a4a4a;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }
    
    .section-title i {
        margin-right: 0.75rem;
        color: #6777ef;
    }
    
    .img-preview-container {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        margin-top: 1rem;
    }
    
    .img-preview {
        max-width: 150px;
        border-radius: 8px;
        border: 1px solid #e3e3e3;
        padding: 4px;
        margin-top: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    
    .action-buttons {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #f0f0f0;
    }
    
    .custom-file-label::after {
        content: "Browse";
    }
    
    .form-group label {
        font-weight: 500;
        color: #555;
        margin-bottom: 0.5rem;
    }
    
    .form-control {
        border-radius: 6px;
        padding: 0.75rem 1rem;
        border: 1px solid #e0e0e0;
        transition: all 0.3s;
    }
    
    .form-control:focus {
        border-color: #6777ef;
        box-shadow: 0 0 0 0.2rem rgba(103, 119, 239, 0.25);
    }
    
    .is-invalid {
        border-color: #f1556c;
    }
    
    .invalid-feedback {
        font-size: 0.85rem;
        margin-top: 0.35rem;
    }
    
    .btn {
        border-radius: 6px;
        padding: 0.65rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .btn i {
        margin-right: 0.5rem;
    }
    
    .btn-primary {
        background-color: #6777ef;
        border-color: #6777ef;
    }
    
    .btn-primary:hover {
        background-color: #5166ea;
        border-color: #5166ea;
    }
    
    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }
    
    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }
    
    .form-control-color {
        height: calc(2.75rem + 2px);
        padding: 0.375rem;
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card user-form-card">
            <div class="card-header">
                <h4 class="card-title"><i class="fas fa-plus-circle mr-2"></i> Add New Category</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Basic Information Section -->
                    <div class="form-section">
                        <h5 class="section-title"><i class="fas fa-info-circle"></i> Basic Information</h5>
                        <div class="form-group">
                            <label for="name">Category Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                id="description" name="description" rows="4">{{ old('description') }}</textarea>
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
                                            id="icon" name="icon" value="{{ old('icon', 'bi bi-exclamation') }}" required>
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
                                            id="icon_color" name="icon_color" value="{{ old('icon_color', '#3498db') }}" required>
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
                            <i class="fas fa-save mr-2"></i> Create Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Update file input label
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
});
</script>
@endpush