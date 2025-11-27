<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactReplyMail;
use App\Models\ContactReply;

class ContactReplyController extends Controller
{
    public function store(Request $request, $id)
{
    $request->validate([
        'reply' => 'required|string',
    ]);

    $contact = Contact::findOrFail($id);

    // 1. Save reply in DB with admin_id
    $reply = ContactReply::create([
        'contact_id' => $contact->id,
        'admin_id'   => Auth::id(),  // <-- add this
        'reply'      => $request->reply,
    ]);

    // 2. Send email using the reply model
    Mail::to($contact->email)->send(new ContactReplyMail($reply));

    return redirect()->back()->with('success', 'Reply sent successfully!');
 }
}
