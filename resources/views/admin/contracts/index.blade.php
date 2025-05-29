@extends('layouts.admin')

@section('content')

        <div class="container">
          <div class="page-inner">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Coach Contracts</h4>
                    <a href="{{ route('admin.contracts.create') }}" class="btn btn-primary btn-sm">
                      <i class="fas fa-plus"></i> Add Contract
                    </a>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="contract-table" class="display table table-striped table-hover">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Coach</th>
                            <th>Title</th>
                            <th>Period</th>
                            <th>Status</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($contracts as $contract)
                          <tr>
                            <td>{{ $contract->id }}</td>
                            <td>{{ $contract->user->name }} {{ $contract->user->lastname }}</td>
                            <td>{{ $contract->title }}</td>
                            <td>
                              {{ \Carbon\Carbon::parse($contract->start_date)->format('M d, Y') }} - 
                              {{ \Carbon\Carbon::parse($contract->end_date)->format('M d, Y') }}
                            </td>
                            <td>
                              <span class="badge badge-{{ 
                                  $contract->status === 'active' ? 'success' : 
                                  ($contract->status === 'pending' ? 'warning' : 'secondary') 
                              }}">
                                  {{ ucfirst($contract->status) }}
                              </span>
                            </td>
                            <td>
                              <div class="form-button-action">
                                <form action="{{ route('admin.contracts.destroy', $contract) }}" method="POST">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="btn btn-link btn-danger" onclick="return confirm('Are you sure?')">
                                    <i class="fa fa-trash"></i>
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
        </div>
      </div>

     
        <div class="custom-toggle">
          <i class="icon-settings"></i>
        </div>
      </div>
    </div>

    <!-- Core JS Files -->
    <script src="../assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <!-- Datatables -->
    <script src="../assets/js/plugin/datatables/datatables.min.js"></script>
    <!-- Kaiadmin JS -->
    <script src="../assets/js/kaiadmin.min.js"></script>
    <!-- Kaiadmin DEMO methods -->
    <script src="../assets/js/setting-demo2.js"></script>
    
    <script>
      $(document).ready(function() {
        $('#contract-table').DataTable({
          pageLength: 10,
          responsive: true
        });
      });
    </script>
  </body>
</html>
@endsection