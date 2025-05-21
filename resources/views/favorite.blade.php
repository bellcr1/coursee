@extends('layouts.app')

@section('content')
<main class="main">
    <section class="favorites-section container">
      <h1>My Favorite Courses</h1>
      <div class="favorites-list">
        @forelse($favorites as $favorite)
          @if($favorite->course) {{-- Check if course exists --}}
            <div class="favorite-item">
              @isset($favorite->course->image) {{-- Safely check for image --}}
                <img src="{{ asset($favorite->course->image) }}" class="card-img-top" alt="{{ $favorite->course->title ?? '' }}">
              @endisset
              <div class="course-info">
                <h3>{{ $favorite->course->title ?? 'Untitled Course' }}</h3>
                <p>Instructor: {{ $favorite->course->name_cotcher ?? 'Unknown Instructor' }}</p>
                <p>{{ $favorite->course->description ?? 'No description available' }}</p>
              </div>
              <div class="course-actions">
                <a href="{{ route('courses.coursedetails', $favorite->course->id) }}" class="btn btn-primary">Start Learning</a>
<button class="remove-btn" onclick="toggleFavorite('{{ $favorite->course->id }}', this)">Remove</button>
              </div>
            </div>
          @endif
        @empty
          <div class="col-12">
            <p>No favorite courses yet.</p>
          </div>
        @endforelse
      </div>
    </section>
</main>

<script>
function toggleFavorite(courseId, btn) {
    fetch('/favorite/toggle/' + courseId, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === 'removed') {
            // Remove the course card from the DOM
            let card = btn.closest('.favorite-item');
            card.parentNode.removeChild(card);

            // If no more favorite-item, show empty message
            if(document.querySelectorAll('.favorite-item').length === 0) {
                let emptyDiv = document.createElement('div');
                emptyDiv.className = 'col-12';
                emptyDiv.innerHTML = '<p>No favorite courses yet.</p>';
                document.querySelector('.favorites-list').appendChild(emptyDiv);
            }
        }
    });
}
</script>

<style>
body {
  font-family: 'Poppins', sans-serif;
  background: #f8f9fa;
  color: #333;
}

.header {
  background: #fff;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.favorites-section {
  padding: 60px 0;
  background: #ffffff;
  border-radius: 12px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
  margin-top: 40px;
  max-width: 1200px;
  margin: 0 auto;
}

.favorites-section h1 {
  font-size: 28px;
  font-weight: 700;
  text-align: center;
  margin-bottom: 30px;
  color: #2d4059;
}

.favorites-list {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(370px, 1fr));
  gap: 16px;
  padding: 0 20px;
}

.favorite-item {
  background: #fff;
  border-radius: 12px;
  width: 100%;
  padding: 16px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  position: relative;
  overflow: hidden;
}

.favorite-item::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 4px;
  background: linear-gradient(90deg, #007bff, #00bcd4);
  opacity: 0;
  transition: opacity 0.3s ease-in-out;
}

.favorite-item:hover::before {
  opacity: 1;
}

.favorite-item:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
}

.favorite-item img {
  width: 100%;
  height: 200px;
  border-radius: 8px;
  object-fit: cover;
  margin-bottom: 12px;
}

.course-info {
  flex-grow: 1;
}

.course-info h3 {
  font-size: 18px;
  font-weight: 600;
  color: #2d4059;
  margin-bottom: 8px;
}

.course-info p {
  font-size: 14px;
  color: #666;
  margin-bottom: 12px;
}

.course-actions {
  display: flex;
  gap: 8px;
  width: 100%;
}

.course-actions button {
  flex: 1;
  padding: 6px 12px;
  font-size: 12px;
  font-weight: 500;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: background 0.3s ease-in-out, transform 0.2s ease-in-out;
}

.play-btn {
  background: linear-gradient(90deg, #007bff, #00bcd4);
  color: #fff;
}

.play-btn:hover {
  background: linear-gradient(90deg, #0056b3, #0097a7);
  transform: scale(1.05);
}

.remove-btn {
  background: linear-gradient(90deg, #dc3545, #ff6b6b);
  color: #fff;
}

.remove-btn:hover {
  background: linear-gradient(90deg, #c82333, #ff5252);
  transform: scale(1.05);
}

.footer {
  background: #fff;
  padding: 20px 0;
  margin-top: 40px;
  box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.05);
  text-align: center;
}

.footer p {
  margin: 0;
}
</style>
@endsection