@extends('layouts.admin')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Transaction Management</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="add-row" class="display table table-striped table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Student</th>
                <th>Course</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($payments as $payment)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $payment->user->name ?? 'N/A' }}</td>
                  <td>{{ $payment->course->title ?? 'N/A' }}</td>
                  <td>${{ number_format($payment->amount/100, 2) }}</td>
                  <td>
                    @if ($payment->status === 'succeeded')
                      <span class="badge bg-success">Paid</span>
                    @elseif ($payment->status === 'pending')
                      <span class="badge bg-warning text-dark">Pending</span>
                    @else
                      <span class="badge bg-danger">Failed</span>
                    @endif
                  </td>
                  <td>{{ $payment->created_at->format('Y-m-d') }}</td>
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
  $("#add-row").DataTable({
    pageLength: 5,
  });
  $('[data-bs-toggle="tooltip"]').tooltip();
});
</script>
@endpush