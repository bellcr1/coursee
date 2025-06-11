<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\User;
use App\Models\Course;
use App\Models\CourseUser;
use Illuminate\Support\Str; // Corrected Str import
use Illuminate\Support\Facades\Auth; // Added Auth facade import
use Illuminate\Support\Facades\Log;


class CertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courseUsers = CourseUser::where('complete', true)->get();   
        return view('admin.certificate.dashbordcertificate', compact('courseUsers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $userId = Auth::id();
        $CourseUser = CourseUser::where('course_id', $id)
                        ->where('user_id', $userId)
                        ->first();
    
       // Log::info("R ss:", ['response' => $CourseUser]);
       // Log::info("R id:", ['response' => $userId]);
        
        if ($CourseUser->complete == false) {
    
            $verify = Str::random(6) . $id . $userId;
            $CourseUser->verify = $verify;
            $CourseUser->complete = true;
            $CourseUser->save();
    
    
        }
    
        $verify=$CourseUser->verify;
    
        return redirect()->route('certificate.show', ['verify' => $verify]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $verify)
{

    $courseUser = CourseUser::where('verify', $verify)
                    ->first();

    if (!$courseUser || !$courseUser->verify) {
        abort(404, "Certificate not found.");
    }

    $qrCode = QrCode::size(100)->generate("http://127.0.0.1:8000/certificate/verify/".$courseUser->verify);
    $verify = $courseUser->verify;
    $user = User::find($courseUser->user_id);
    $course = Course::find($courseUser->course_id );
    Log::info("R name:", ['response' => $course]);
    return view('certificate', compact('qrCode', 'verify','user','courseUser','course'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


}
