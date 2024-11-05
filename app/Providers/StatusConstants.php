<?php

namespace App\Providers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class StatusConstants
{
    public const query_answered = 'Answered';
    public const query_waiting = 'Waiting';

    public const ticket_query_waiting = 'Waiting Answer';
    public const process_resolved = 'Resolved';
    public const process_doing = 'Doing';
    public const process_pending = 'Pending';
    public const process_query = 'Query';
    public const process_closed = 'Closed';
    public const comment_type_query = 'Query';
    public const resolve_type_resolved = 'Resolved';
    public const resolve_type_user_close = 'User Close';
    public const resolve_type_no_problem = 'NoProblem';
    public const comment_type_resolved = 'Resolved';
    public const comment_type_no_problem = 'No Problem';
    public const comment_type_admin_re_open = 'Re Open';

}

