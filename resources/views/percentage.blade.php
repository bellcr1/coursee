@extends('layouts.admin')

@push('styles')
<style>
  .stat-card {
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 15px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    border-left: 4px solid;
    transition: all 0.2s ease;
  }
  .stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  }
  .stat-card.users {
    border-left-color: #4e73df;
  }
  .stat-card.coaches {
    border-left-color: #1cc88a;
  }
  .stat-card.courses {
    border-left-color: #36b9cc;
  }
  .stat-title {
    font-size: 13px;
    color: #6c757d;
    margin-bottom: 5px;
    text-transform: uppercase;
  }
  .stat-value {
    font-size: 22px;
    font-weight: bold;
    color: #2c2e3e;
  }
  .chart-card {
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    margin-bottom: 15px;
  }
  .chart-card .card-header {
    padding: 10px 15px;
    background-color: #fff;
    border-bottom: 1px solid rgba(0,0,0,0.05);
  }
  .chart-card .card-title {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 2px;
  }
  .chart-card .card-subtitle {
    font-size: 11px;
    color: #6c757d;
  }
  .chart-card .card-body {
    padding: 10px;
  }
</style>
@endpush

@section('content')
<div class="page-header">
  <h4 class="page-title">Dashboard Overview</h4>
</div>

<!-- Stats Cards Row -->
<div class="row">
  <div class="col-md-4">
    <div class="stat-card users">
      <div class="card-body">
        <h6 class="stat-title">Total Users</h6>
        <h3 class="stat-value">{{ $totalUsers }}</h3>
      </div>
    </div>
  </div>
  
  <div class="col-md-4">
    <div class="stat-card coaches">
      <div class="card-body">
        <h6 class="stat-title">Total Coaches</h6>
        <h3 class="stat-value">{{ $totalCoaches }}</h3>
      </div>
    </div>
  </div>
  
  <div class="col-md-4">
    <div class="stat-card courses">
      <div class="card-body">
        <h6 class="stat-title">Total Courses</h6>
        <h3 class="stat-value">{{ $totalCourses }}</h3>
      </div>
    </div>
  </div>
</div>

<!-- Compact Charts Row 1 -->
<div class="row mt-3">
  <div class="col-md-8">
    <div class="chart-card">
      <div class="card-header">
        <h6 class="card-title">User Registration Trend</h6>
        <small class="card-subtitle">Last 6 months</small>
      </div>
      <div class="card-body">
        <canvas id="userRegistrationChart" height="150"></canvas>
      </div>
    </div>
  </div>
  
  <div class="col-md-4">
    <div class="chart-card">
      <div class="card-header">
        <h6 class="card-title">Course Categories</h6>
        <small class="card-subtitle">Distribution</small>
      </div>
      <div class="card-body">
        <canvas id="courseCategoryChart" height="150"></canvas>
      </div>
    </div>
  </div>
</div>

<!-- Compact Chart Row 2 -->
<div class="row mt-3">
  <div class="col-12">
    <div class="chart-card">
      <div class="card-header">
        <h6 class="card-title">Monthly Enrollment</h6>
        <small class="card-subtitle">Current year</small>
      </div>
      <div class="card-body">
        <canvas id="enrollmentChart" height="120"></canvas>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // User Registration Chart
    new Chart(document.getElementById('userRegistrationChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'New Users',
                data: [65, 59, 80, 81, 56, 72],
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 1.5,
                tension: 0.3,
                fill: true,
                pointRadius: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { 
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.03)' },
                    ticks: { font: { size: 9 } }
                },
                x: { 
                    grid: { display: false },
                    ticks: { font: { size: 9 } }
                }
            }
        }
    });

    // Course Category Chart
    new Chart(document.getElementById('courseCategoryChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Coaches', 'Users', 'Courses'],
            datasets: [{
                data: [{{ $totalCoaches }}, {{ $totalUsers }}, {{ $totalCourses }}],
                backgroundColor: [
                    'rgba(78, 115, 223, 0.8)',
                    'rgba(28, 200, 138, 0.8)',
                    'rgba(246, 194, 62, 0.8)',
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { padding: 10, font: { size: 9 }, boxWidth: 8 }
                }
            }
        }
    });

    // Enrollment Chart
    new Chart(document.getElementById('enrollmentChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: ['J', 'F', 'M', 'A', 'M', 'J', 'J', 'A', 'S', 'O', 'N', 'D'],
            datasets: [{
                label: 'Enrollments',
                data: [120, 190, 170, 220, 180, 150, 200, 240, 210, 190, 230, 260],
                backgroundColor: 'rgba(54, 185, 204, 0.7)',
                borderColor: 'rgba(54, 185, 204, 1)',
                borderWidth: 1,
                borderRadius: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { 
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.03)' },
                    ticks: { font: { size: 9 } }
                },
                x: { 
                    grid: { display: false },
                    ticks: { font: { size: 9 } }
                }
            }
        }
    });
});
</script>
@endpush