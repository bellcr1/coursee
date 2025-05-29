@extends('layouts.app')

@section('content')
<main class="main">
    <section class="favorites-section container">
      <div class="section-header">
        <h1><i class="fas fa-heart"></i> My Favorite Courses</h1>
      </div>
      
      <div class="favorites-list">
        @forelse($favorites as $favorite)
          @if($favorite->course)
            <div class="favorite-item">
              <div class="favorite-badge">
                <i class="fas fa-heart"></i>
              </div>
              
              @isset($favorite->course->image)
                <div class="course-image">
                  <img src="{{ asset($favorite->course->image) }}" alt="{{ $favorite->course->title ?? '' }}">
                  <div class="image-overlay"></div>
                </div>
              @endisset
              
              <div class="course-info">
                <div class="course-meta">
                
                </div>
                <h3>{{ $favorite->course->title ?? 'Untitled Course' }}</h3>
                <p class="instructor">
                  <i class="fas fa-user"></i> {{ $favorite->course->name_cotcher ?? 'Unknown Instructor' }}
                </p>
                <p class="description">{{ $favorite->course->description ?? 'No description available' }}</p>
              </div>
              
              <div class="course-actions">
                <a href="{{ route('courses.coursedetails', $favorite->course->id) }}" class="btn btn-primary">
                  <i class="fas fa-play"></i> Start Learning
                </a>
                <button class="remove-btn" onclick="toggleFavorite('{{ $favorite->course->id }}', this)">
                  <i class="fas fa-trash-alt"></i> Remove
                </button>
              </div>
            </div>
          @endif
        @empty
          <div class="empty-state">
            <i class="far fa-heart"></i>
            <h3>No favorite courses yet</h3>
            <p>Browse courses and add your favorites here</p>
            <a href="{{ route('courses.index') }}" class="btn btn-primary">Browse Courses</a>
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
            // Animate removal
            let card = btn.closest('.favorite-item');
            card.style.transform = 'scale(0.9)';
            card.style.opacity = '0';
            setTimeout(() => {
                card.parentNode.removeChild(card);
                
                // Show empty state if no favorites left
                if(document.querySelectorAll('.favorite-item').length === 0) {
                    document.querySelector('.favorites-list').innerHTML = `
                        <div class="empty-state">
                            <i class="far fa-heart"></i>
                            <h3>No favorite courses yet</h3>
                            <p>Browse courses and add your favorites here</p>
                            <a href="{{ route('courses.index') }}" class="btn btn-primary">Browse Courses</a>
                        </div>
                    `;
                }
            }, 300);
        }
    });
}
</script>

<style>
/* Font and Base Styles */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');

body {
  font-family: 'Poppins', sans-serif;
  background: #f8fafc;
  color: #2d3748;
  line-height: 1.6;
}

/* Section Styling */
.favorites-section {
  padding: 3rem 1rem;
  max-width: 1200px;
  margin: 2rem auto;
}

.section-header {
  text-align: center;
  margin-bottom: 3rem;
}

.section-header h1 {
  font-size: 2.5rem;
  font-weight: 700;
  color: #2d4059;
  margin-bottom: 0.5rem;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.75rem;
}

.section-header h1 i {
  color:rgb(255, 144, 32);
}

.section-header .subtitle {
  font-size: 1.1rem;
  color: #718096;
  max-width: 600px;
  margin: 0 auto;
}

/* Favorites List Grid */
.favorites-list {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
  gap: 1.5rem;
  padding: 0;
}

/* Favorite Item Card */
.favorite-item {
  background: #fff;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);
  transition: all 0.3s ease;
  position: relative;
  display: flex;
  flex-direction: column;
}

.favorite-item:hover {
  transform: translateY(-5px);
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

.favorite-badge {
  position: absolute;
  top: 15px;
  right: 15px;
  background: rgba(255, 166, 33, 0.9);
  color: white;
  width: 36px;
  height: 36px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 2;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.course-image {
  position: relative;
  height: 180px;
  overflow: hidden;
}

.course-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s ease;
}

.image-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(to bottom, rgba(0,0,0,0.1), rgba(0,0,0,0.3));
}

.favorite-item:hover .course-image img {
  transform: scale(1.05);
}

.course-info {
  padding: 1.5rem;
  flex-grow: 1;
}

.course-meta {
  display: flex;
  justify-content: space-between;
  margin-bottom: 0.75rem;
  font-size: 0.85rem;
}

.category {
  background: #e2e8f0;
  color: #4a5568;
  padding: 0.25rem 0.75rem;
  border-radius: 20px;
  font-weight: 500;
}

.rating {
  color: #f6ad55;
  font-weight: 600;
}

.course-info h3 {
  font-size: 1.25rem;
  font-weight: 600;
  color: #2d3748;
  margin-bottom: 0.5rem;
}

.instructor {
  color: #718096;
  font-size: 0.9rem;
  margin-bottom: 1rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.description {
  color: #4a5568;
  font-size: 0.95rem;
  margin-bottom: 1.5rem;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.course-actions {
  display: flex;
  gap: 0.75rem;
  padding: 0 1.5rem 1.5rem;
}

.btn-primary {
  flex: 1;
  background: #4299e1;
  color: white;
  border: none;
  padding: 0.75rem;
  border-radius: 8px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
}

.btn-primary:hover {
  background: #3182ce;
  transform: translateY(-2px);
}

.remove-btn {
  flex: 1;
  background: #fed7d7;
  color: #e53e3e;
  border: none;
  padding: 0.75rem;
  border-radius: 8px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
}

.remove-btn:hover {
  background: #feb2b2;
  transform: translateY(-2px);
}

/* Empty State */
.empty-state {
  grid-column: 1 / -1;
  text-align: center;
  padding: 4rem 2rem;
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
}

.empty-state i {
  font-size: 3rem;
  color: #cbd5e0;
  margin-bottom: 1.5rem;
}

.empty-state h3 {
  font-size: 1.5rem;
  color: #2d3748;
  margin-bottom: 0.5rem;
}

.empty-state p {
  color: #718096;
  margin-bottom: 1.5rem;
  max-width: 500px;
  margin-left: auto;
  margin-right: auto;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
  .favorites-list {
    grid-template-columns: 1fr;
  }
  
  .section-header h1 {
    font-size: 2rem;
  }
}

@media (max-width: 480px) {
  .course-actions {
    flex-direction: column;
  }
}
</style>
@endsection