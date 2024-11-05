<?php

namespace App\Mail;

use Illuminate\Support\Facades\Mail;

class MailHelper
{
    public const login_credentials_message = 'Your login credentials';
    public const registered_subject = 'You Have been Registered to Log Book App';
    public const reset_pass_subject = 'Your Password Has Been Reset Successfully';
    public const query_answerd_message = 'Your Query has been Answered';
    public const query_waiting_message = 'You have query waiting your answer';
    public const ticket_interaction_creator_subject = "someone commented in your log";
    public const ticket_interaction_non_creator_subject = "An interaction with Ticket you working on";
    public const ticket_created_subject = "New Ticket Created";
    public const ticket_created_message = "New Ticket waiting your assignment";
    public const ticket_assigned_message = "New Ticket Assigned to you";
    public const ticket_closed_message = "Ticket Closed";
    public const ticket_resolved_message ="Ticket Resolved";

    public static function SendTicketInteractionEmail($message, $workLog, $rec)
    {
        
        self::SendTicketEmail(self::ticket_interaction_creator_subject,$message,$workLog,$workLog->tech->email);
        
    }

    public static function SendTicketEmail($subject, $message, $ref, $rec){
        $mailable = new TicketEmail();
        $mailable->reference_no = 'Ticket Subject: '.$ref->subject.'  <br>  Ticket Id:' .$ref->id;
        $mailable->subject = $subject;
        $mailable->message = $message;
        Mail::to($rec)->send($mailable);
    }
    public static function SendUserEmail($subject, $message, $ref, $rec){
        $mailable = new TicketEmail();
        $mailable->reference_no = 'Email: '.$ref->email.'   <br> Password: '.$ref->password;
        $mailable->subject = $subject;
        $mailable->message = $message;
        Mail::to($rec)->send($mailable);
    }

    public static function EmailMany(string $ticket_created_subject, string $ticket_created_message, \App\Models\Ticket $ticket, array $users1)
    {
        for ($i = 0;$i<sizeof($users1);$i++)
        {
           self::SendTicketEmail($ticket_created_subject,$ticket_created_message,$ticket,$users1[$i]);
        }

    }
}
