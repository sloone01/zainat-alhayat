<?php

namespace App\Providers;
class MessageConstants
{
    const query_waiting = 0;
    const comment_reply = 1;
    const ticket_resolved = 2;
    const ticket_closed = 3;
    const ticket_assigned = 4;
    const log_commented = 5;
    const ticket_re_opened = 6;

    const messages = array(
        'You have query waiting answer',
        'replied to your Comment',
        'Ticket resolved',
        'Ticket Closed',
        'New Ticket Assigned',
        'New Log Comment',
        'Ticket Re-Opened'
    );

}
