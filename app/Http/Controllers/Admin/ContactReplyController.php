<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\ContactReply;
use App\Mail\ContactReplyMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContactReplyController extends Controller
{
    public function store(Request $request, Contact $contact)
    {
        $request->validate([
            'reply' => 'required|string'
        ]);

        $reply = ContactReply::create([
            'contact_id' => $contact->id,
            'admin_id' => Auth::id(),
            'reply' => $request->reply,
        ]);

        // SEND EMAIL (mandatory)
        Mail::to($contact->email)->send(new ContactReplyMail($reply));

        return back()->with('success', 'Reply sent and emailed successfully!');
    }
}
