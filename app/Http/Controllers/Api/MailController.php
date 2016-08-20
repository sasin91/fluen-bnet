<?php

namespace App\Http\Controllers\Api;

use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    /**
     * @var Mailer
     */
    protected $mailer;
    
    /**
     * MailController constructor.
     * 
     * 
     * @param Mailer $mailer
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;        
    }
    
    /**
     * Dispatches a welcome mail to the new User.
     *
     *
     * @return void
     */
    public function sendWelcomeMail()
    {
        $user = Auth::user();
        
        $this->mailer->send('user.welcome', compact('user'), function (Message $message) use($user) {
            $message
                ->to($user->email)
                ->subject('Welcome! hope you enjoy your stay. :)');
        });
    }

    /**
     * Dispatches a goodbye mail to the leaving User.
     * 
     * 
     * @return void
     */
    public function sendGoodbyeMail()
    {
        $user = Auth::user();

        $this->mailer->send('user.goodbye', compact('user'), function (Message $message) use($user) {
            $message
                ->to($user->email)
                ->subject('Sorry to see you leave...');
        });
    }
}
