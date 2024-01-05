<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\FormContactRequest;
use App\Mail\SendContactMail;
use App\Models\ContactRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function contact()
    {
        return view('frontend.pages.contact.index');
    }

    public function contactSendRequest(FormContactRequest $request)
    {
        $data = $request->validated();
        try {
            ContactRequest::create([
                'fullName'=>$data['fullName'],
                'email'=>$data['email'],
                'subject'=>$data['subject'],
            ]);

            $fromAddress =  config('mail.main_email');
            $toAddress =  config('mail.main_email_to');
            $fromName = 'Admin';
            $mail = new SendContactMail($data);
            $mail->from($fromAddress, $fromName);
            Mail::to($toAddress)->send($mail);

            return response()->json([
                'success' => true,
                'data' => '',
                'message' => 'Your request has been sent'
            ]);
        }catch (\Exception $e) {
            dd($e->getMessage());
            Log::channel('frontend')->error($e->getMessage());
            return response()->json([
                'success' => false,
                'data' => '',
                'message' => $e->getMessage()
            ]);
        }

    }

}
