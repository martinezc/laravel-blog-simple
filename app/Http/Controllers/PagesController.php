<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Mail;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex() {
        $posts = Post::latest('created_at')->limit(4)->get();
        return view('pages.welcome', compact('posts'));
    }

    public function getAbout() {
        return view('pages.about');
    }

    public function getContact() {
        return view('pages.contact');
    }

    public function postContact(Request $request) {
        $request->validate([
            'email'         => 'required|email',
            'subject'       => 'min:3',
            'message'       => 'min:10'
        ]);

        $data = array(
            'email' => $request->email,
            'subject' => $request->subject,
            'bodyMessage' => $request->message
        );
            
        Mail::send('emails.contact', $data, function($message) use ($data) {
            $message->from($data['email']);
            $message->to('cmartinez@thefilipinomall.com');
            $message->subject($data['subject']);
        });

        return redirect('/')->with('success', 'Your Email was Sent!');
    }
}
