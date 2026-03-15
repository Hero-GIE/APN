<?php

use Illuminate\Support\Facades\Mail;

if (! function_exists('sendEmail')) {
    function sendEmail($template, $data, $receiver, $subject)
    {
        try {
            Mail::send($template, $data, function($message) use ($receiver, $subject) {
                $message->to($receiver)->subject($subject);
            });

            \Log::info('Email sent successfully via SMTP:', [
                'to' => $receiver,
                'subject' => $subject
            ]);

            return true;

        } catch (\Exception $e) {
            \Log::error('sendEmail Exception: ' . $e->getMessage());
            return false;
        }
    }
}

if (! function_exists('messageAdmin')) {
    function messageAdmin($data)
    {
        sendEmail(
            'emails.admin-message',
            $data,
            'rowusu@wowlogbook.com', 
            'New Notifcation'
        );
    }
}