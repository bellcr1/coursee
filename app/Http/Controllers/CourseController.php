<?php

namespace App\Http\Controllers;

use App\Models\ChapterUser;
use App\Models\Course;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Chapter;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use App\Jobs\TranscribeChapterVideo;
use App\Jobs\GenerateQuizContentJob;



class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        $categories = Category::all();
        return view('courses.index', compact('courses','categories'));
    }

    public function call(Request $request)
    {
        $query = Course::query();
        $categories = Category::all();
    
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('name_cotcher', 'LIKE', "%{$searchTerm}%");
            });
        }
    
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }
    
        $courses = $query->with('favorites')->get();
        $selectedCategory = $request->has('category') ? Category::find($request->category) : null;
    
        return view('courses', compact('courses', 'categories', 'selectedCategory'));
    }



    public function create()
    {
        $categories = Category::all();
        return view('courses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'name_cotcher' => 'required',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|mimes:mp4,webm,ogg|max:20480',
        ]);
    
        $data = $request->except(['chapter', 'titles', 'lessons']); // Exclude chapter-related fields
        $data['user_id'] = Auth::id();
    
        // Handle file uploads
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/courses'), $imageName);
            $data['image'] = 'images/courses/' . $imageName;
        }
    
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $videoName = time() . '_video.' . $video->getClientOriginalExtension();
            $video->move(public_path('videos/courses'), $videoName);
            $data['video'] = 'videos/courses/' . $videoName;
        }
    
        // Create the course first
        $course = Course::create($data);
    
        // Handle chapters and lessons
        // Inside the store method, update the chapter creation part:
        // Store created chapter IDs in order
        $createdChapterIds = [];




















        
    
        if ($request->has('chapters')) {

                    ini_set('max_execution_time', 0);
        set_time_limit(0);
            foreach ($request->chapters as $chapterIndex => $chapterData) {
                if (!isset($chapterData['title']) || empty($chapterData['title'])) {
                    continue;
                }
    
                $chapterAttributes = [
                    'title' => $chapterData['title'],
                    'course_id' => $course->id,
                    'order' => $chapterIndex
                ];
    
                // Handle chapter video upload and AI transcription
                if (isset($request->file('chapters')[$chapterIndex]['video'])) {
                    $video = $request->file('chapters')[$chapterIndex]['video'];
                    $videoName = time() . '_chapter_' . $chapterIndex . '.' . $video->getClientOriginalExtension();
                    $video->move(public_path('videos/chapters'), $videoName);
                    $chapterAttributes['video'] = 'videos/chapters/' . $videoName;
                    // Do NOT call AI here, just save chapter and dispatch job
                } else {
                    $chapterAttributes['script'] = $chapterData['script'] ?? null;
                }
    
                $chapter = Chapter::create($chapterAttributes);
                $createdChapterIds[$chapterIndex] = $chapter->id;
    
                // Dispatch AI transcription job if video exists
                if (isset($chapterAttributes['video'])) {
                    \App\Jobs\TranscribeChapterVideo::dispatch($chapter);
                }
            }
        }
    
        // Now create lessons for each chapter using the correct chapter ID
        for ($i = 0; $i <= $request->titleIndex; $i++) {
            $y = 0;
            while (isset($request->chapters[$i][$y])) {
                $lessonAttributes = [
                    'title' => $request->chapters[$i][$y],
                    'chapter_id' => $createdChapterIds[$i] ?? null,
                    'order' => $y,
                    'start_time' => $request->time[$i][$y] ?? null
                ];
                // Only create lesson if chapter_id is valid
                if ($lessonAttributes['chapter_id']) {
                    Lesson::create($lessonAttributes);
                }
                $y++;
            }
        }
    
        return redirect()->route('courses.index')->with('success', 'Course created successfully');
    }

    public function downloadPdf($pdfId)
    {
        // اسم الملف المبني على pdfId
        $fileName = "chapter{$pdfId}.pdf";

        // المسار داخل storage/app/public
        $filePath = storage_path("app/public/{$fileName}");

        // نتحقّق من وجود الملف
        if (!file_exists($filePath)) {
            abort(404, 'PDF not found.');
        }

        // نبعثو للمستخدم كتحميل
        return response()->download($filePath, $fileName, [
            'Content-Type' => 'application/pdf',
        ]);
    }




    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'category' => 'required',  // Add this line
            'name_cotcher' => 'required',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|mimes:mp4,webm,ogg|max:20480'
        ]);
    
        $course = Course::findOrFail($id);
        $data = $request->all();
    
        if ($request->hasFile('image')) {
            if ($course->image && file_exists(public_path($course->image))) {
                unlink(public_path($course->image));
            }
    
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/courses'), $imageName);
            $data['image'] = 'images/courses/' . $imageName;
        }
    
        if ($request->hasFile('video')) {
            if ($course->video && file_exists(public_path($course->video))) {
                unlink(public_path($course->video));
            }
    
            $video = $request->file('video');
            $videoName = time() . '_video.' . $video->getClientOriginalExtension();
            $video->move(public_path('videos/courses'), $videoName);
            $data['video'] = 'videos/courses/' . $videoName;
        }

        
        
    
        $course->update($data);
        return redirect()->route('courses.index')->with('success', 'Course updated successfully');
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        
        if ($course->image && file_exists(public_path($course->image))) {
            unlink(public_path($course->image));
        }
    
        if ($course->video && file_exists(public_path($course->video))) {
            unlink(public_path($course->video));
        }
    
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully');
    }


    
    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $categories = Category::all();
        return view('courses.edit', compact('course','categories'));
    }
    public function show($id)
    {
        $course = Course::findOrFail($id);
        $chapters = Chapter::where('course_id', $course->id)->get();
        $chapterCount = Chapter::where('course_id', $course->id)->count();
        $chapteruserCount = ChapterUser::where('user_id', auth()->id())->get();
        $lessons = Lesson::whereIn('chapter_id', $chapters->pluck('id'))->get();
        $coaches = User::where('role', 'coach')->get();
        $categories = Category::all(); 


    
        // Get quiz_passed status for each chapter for the current user
        $user = auth()->user();
        $quizStatus = [];
        foreach ($chapters as $chapter) {
            $pivot = \App\Models\ChapterUser::where('user_id', $user->id)
                ->where('chapter_id', $chapter->id)
                ->first();
            $quizStatus[$chapter->id] = $pivot && $pivot->quiz_passed ? true : false;
        }
    
        return view('courses.show', compact('course', 'chapters', 'lessons', 'quizStatus','course', 'coaches', 'categories', 'chapterCount', 'chapteruserCount'));
    }

    public function showquiz($id)
    {
        $course = Course::findOrFail($id);
        $quiz = \Illuminate\Support\Facades\Cache::get('quiz') ?? [];
        return view('courses.show', compact('course', 'quiz'));
    }
    
    public function launchQuiz(Request $request)
    {
        $script = $request->input('script');
        $id = $request->input('id');
        \Illuminate\Support\Facades\Log::info("R id:", ['response' => $id ]);
        \Illuminate\Support\Facades\Log::info("Réponse générée:", ['response' => $script]);
        GenerateQuizContentJob::dispatchSync($script, $id);

        return redirect()->back()->with('success', 'Quiz généré avec succès');
    }


    



    public function courseDetails($id)
    {
        $chapters = Chapter::where('course_id', $id)->get();
        $lessons = Lesson::all();
        $course = Course::findOrFail($id);
        $categories = Category::all();
        $buycours = Chapter::where('course_id', $id)->get();
        
        $user = Auth::user();
        $favoriteboolean = 0;
        
        if ($user) {
            $favoriteExists = Favorite::where('user_id', $user->id)->where('course_id', $id)->first();

            $favoriteboolean = $favoriteExists ? 1 : 0;
        }






        return view('coursedetails', compact('course', 'categories', 'chapters', 'lessons','favoriteboolean'));
    }









    public function checkout($id)
    {
        $course = Course::findOrFail($id);
        return view('checkout', compact('course'));
    }
    public function purchase(Request $request, $courseId)
    {
        $user = auth()->user();
        $course = Course::findOrFail($courseId);
    
        // Attach user to course if not already purchased
        if (!$user->purchasedCourses()->where('course_id', $course->id)->exists()) {
            $user->purchasedCourses()->attach($course->id);
    
            // Increment purchase_count
            $course->increment('purchase_count');
        }
    
        return redirect()->route('courses.show', $course->id)->with('success', 'Course purchased successfully!');
    }
    public function submitQuiz(Request $request)
    {
        $user = auth()->user();
        $chapterId = $request->input('chapter_id');
        \Illuminate\Support\Facades\Log::info("Réponse id:", ['response' => $chapterId]);
        $quizPassed = $request->input('quiz_passed'); // true, false, or null
    
        $user->chapters()->syncWithoutDetaching([
            $chapterId => ['quiz_passed' => $quizPassed]
        ]);
    
        return response()->json(['status' => 'ok']);
    }
   
}


