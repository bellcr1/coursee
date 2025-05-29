
@extends('layouts.admin')

@section('content')
        <div class="container">
            <div class="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title">Contact Messages</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <div class="table-responsive">
                                    <table id="add-row" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Subject</th>
                                                <th>Message</th>
                                                <th>Date</th>
                                                <th style="width: 10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($contacts as $contact)
                                            <tr>
                                                <td>{{ $contact->id }}</td>
                                                <td>{{ $contact->name }}</td>
                                                <td>{{ $contact->email }}</td>
                                                <td>{{ $contact->subject }}</td>
                                                <td>{{ Str::limit($contact->message, 50) }}</td>
                                                <td>{{ $contact->created_at->format('Y-m-d H:i') }}</td>
                                                <td>
                                                    <div class="form-button-action">
                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#viewMessageModal{{ $contact->id }}" class="btn btn-link btn-primary btn-lg" title="View Message">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                        
                                                        <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-link btn-danger" onclick="return confirm('Are you sure you want to delete this message?')" title="Delete">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- View Message Modal -->
                                            <div class="modal fade" id="viewMessageModal{{ $contact->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Message Details</h5>
                                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><strong>Name:</strong> {{ $contact->name }}</p>
                                                            <p><strong>Email:</strong> {{ $contact->email }}</p>
                                                            <p><strong>Subject:</strong> {{ $contact->subject }}</p>
                                                            <p><strong>Message:</strong></p>
                                                            <p>{{ $contact->message }}</p>
                                                            <p><strong>Received:</strong> {{ $contact->created_at->format('Y-m-d H:i') }}</p>
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
                            <div class="card-footer">
                                {{ $contacts->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
