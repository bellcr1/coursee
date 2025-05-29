@extends('layouts.admin')

@section('content')
<style>
  .contract-form-card {
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border: none;
    overflow: hidden;
  }
  
  .contract-form-card .card-header {
    background: linear-gradient(120deg, #6777ef 0%, #3519db 100%);
    color: white;
    padding: 1.75rem 2rem;
    border-bottom: 0;
  }
  
  .contract-form-card .card-header h4 {
    font-weight: 600;
    margin-bottom: 0;
    display: flex;
    align-items: center;
  }
  
  .contract-form-card .card-body {
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
</style>

<div class="row justify-content-center">
  <div class="col-lg-10">
    <div class="card contract-form-card">
      <div class="card-header">
        <h4 class="card-title"><i class="fas fa-file-contract mr-2"></i> Create New Contract</h4>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.contracts.store') }}" enctype="multipart/form-data">
          @csrf
          
          <div class="form-section">
            <h5 class="section-title"><i class="fas fa-user-tie"></i> Coach Information</h5>
            <div class="form-group">
              <label>Select Coach</label>
              <select name="user_id" class="form-control" required>
                @foreach($coaches as $coach)
                <option value="{{ $coach->id }}">{{ $coach->name }} {{ $coach->lastname }}</option>
                @endforeach
              </select>
            </div>
          </div>
          
          <div class="form-section">
            <h5 class="section-title"><i class="fas fa-file-alt"></i> Contract Details</h5>
            <div class="form-group">
              <label>Title</label>
              <input type="text" name="title" class="form-control" required>
            </div>
            
            <div class="form-group">
              <label>Terms</label>
              <textarea name="terms" class="form-control" rows="6" required></textarea>
            </div>
          </div>
          
          <div class="form-section">
            <h5 class="section-title"><i class="fas fa-calendar-alt"></i> Contract Duration</h5>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Start Date</label>
                  <input type="date" name="start_date" class="form-control" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>End Date</label>
                  <input type="date" name="end_date" class="form-control" required>
                </div>
              </div>
            </div>
          </div>
          
          <div class="form-section">
            <h5 class="section-title"><i class="fas fa-file-upload"></i> Contract Document</h5>
            <div class="form-group">
              <div class="custom-file">
                <input type="file" name="document" class="custom-file-input" id="document">
                <label class="custom-file-label" for="document">Choose file (PDF or Word)</label>
              </div>
            </div>
          </div>

          <div class="action-buttons">
            <a href="{{ route('admin.contracts.index') }}" class="btn btn-secondary">
              <i class="fas fa-arrow-left mr-2"></i> Cancel
            </a>
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save mr-2"></i> Create Contract
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection