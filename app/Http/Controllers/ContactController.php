<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact; // 
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class ContactController extends Controller
{
    // the contact page
    public function index()
    {
        return view('contact');
    }

    //  Handle form submission
    public function send(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'message' => 'required|string|max:1000',
        ]);

        // Save message to database
        Contact::create($data);

        // email to admin
        Mail::to('originalkristiann@gmail.com')->send(new ContactFormMail($data));

        return back()->with('success', 'Your message has been sent successfully!');
    }
}
