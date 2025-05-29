@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Feedback Management</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="feedback-table" class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Rating</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th style="width: 10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($feedbacks as $feedback)
                            <tr>
                                <td>{{ $feedback->id }}</td>
                                <td>{{ $feedback->name }}</td>
                                <td>{{ $feedback->email }}</td>
                                <td>
                                    <div class="rating-stars">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fa fa-star{{ $i <= $feedback->rating ? '' : '-o' }}" 
                                               style="color: {{ $i <= $feedback->rating ? '#FFD700' : '#CCCCCC' }}"></i>
                                        @endfor
                                    </div>
                                </td>
                                <td>{{ Str::limit($feedback->message, 50) }}</td>
                                <td>{{ $feedback->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="form-button-action">
                                        <button type="button" class="btn btn-link btn-primary btn-lg" 
                                                data-bs-toggle="modal" data-bs-target="#viewFeedbackModal{{ $feedback->id }}">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        <form action="{{ route('admin.feedback.destroy', $feedback->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link btn-danger" 
                                                    onclick="return confirm('Are you sure you want to delete this feedback?')">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- View Feedback Modal -->
                            <div class="modal fade" id="viewFeedbackModal{{ $feedback->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Feedback Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Name:</strong> {{ $feedback->name }}</p>
                                            <p><strong>Email:</strong> {{ $feedback->email }}</p>
                                            <p><strong>Rating:</strong>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="fa fa-star{{ $i <= $feedback->rating ? '' : '-o' }}" 
                                                       style="color: {{ $i <= $feedback->rating ? '#FFD700' : '#CCCCCC' }}"></i>
                                                @endfor
                                            </p>
                                            <p><strong>Message:</strong></p>
                                            <p>{{ $feedback->message }}</p>
                                            <p><small class="text-muted">Submitted on: {{ $feedback->created_at->format('M d, Y H:i') }}</small></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .rating-stars {
        color: #FFD700;
        font-size: 16px;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    $('#feedback-table').DataTable({
        pageLength: 10,
        responsive: true,
        columnDefs: [
            { orderable: false, targets: [6] } // Disable sorting for actions column
        ]
    });
});
</script>
@endpush