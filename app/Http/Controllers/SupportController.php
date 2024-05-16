<?php

namespace App\Http\Controllers;

use App\Http\Requests\Web\Support\ContactRequest;
use App\Notifications\ContactFormSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class SupportController extends Controller
{
    public function documentation(Request $request)
    {
       abort(404);
    }

    public function contact(ContactRequest $request)
    {
        Notification::route('mail', config('app.admin_email'))
            ->notify(new ContactFormSubmitted($request->all()));

        return redirect()->back()->with(['success' => 'Your inquiry has been successfully sent!']);
    }
}
