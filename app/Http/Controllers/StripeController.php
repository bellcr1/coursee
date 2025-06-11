<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class StripeController extends Controller
{


    public function index()
    {
        $payments = Payment::with('user', 'course')->get();
        return view('admin.payment.dashbordpayment', compact('payments'));
    }
    public function createCharge(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        $price = $request->input('price');
        $courseId = $request->course_id;

    
        try {
            $paymentIntent = PaymentIntent::create([
                'amount' =>  intval($price * 100),
                'currency' => 'usd',
                'payment_method' => $request->payment_method,
                //'confirmation_method' => 'manual', // ما تستعملش مع automatic_payment_methods
                'confirm' => true,
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never',
                ],
            ]);
            
            $userId = $request->user_id;

            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'error' => 'User ID missing'
                ]);
            }           
            // نحسب عدد المحاولات (مثلاً 1 دائماً هنا لكن ممكن تزيد لو تعمل إعادة محاولة)
            $attemptCount = 1;
    
            // نسجل الدفع في قاعدة البيانات
            Payment::updateOrCreate(
                ['payment_id' => $paymentIntent->id],
                [
                    'user_id' => $userId,
                    'course_id' => $courseId,
                    'amount' => $paymentIntent->amount,
                    'currency' => $paymentIntent->currency,
                    'status' => $paymentIntent->status,
                    'payment_method' => $paymentIntent->payment_method,
                    'attempt_count' => $attemptCount,
                ]
            );
    
            return response()->json([
                'success' => true,
                'paymentIntent' => $paymentIntent
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
    
}

