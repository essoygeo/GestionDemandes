<?php

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

if (!function_exists('envoyerMail')) {


    function envoyerMail($destinataires, $subject, $contenu, $url = '')
    {
        if ($destinataires instanceof Collection) {
            $destinataires = $destinataires->all(); // Convertit la Collection en tableau d'objets User
        }

        if (!is_array($destinataires)) {
            $destinataires = [$destinataires];
        }

        foreach ($destinataires as $dest) {
            if (is_numeric($dest)) {
                $user = User::find($dest);
            } elseif ($dest instanceof User) {
                $user = $dest;
            } else {
                continue;
            }

            if ($user && $user->email) {
                Mail::send('emails.mail', compact('user', 'contenu', 'subject', 'url'), function ($message) use ($subject, $user) {
                    $message->to($user->email)->subject($subject);
                });
            }
        }

        return 'Mails envoyés !';
    }
}
