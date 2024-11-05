<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use App\Providers\RoleHelper;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GeneralController extends Controller
{
    public function getUserData()
    {
    
        $admins = User::where('roles','like','%Admin%')->get();
        $data = array(
            'pending_tickets'=> 0,
            'all_tickets'=>0,
            'admins'=> $admins,
            'closed_tickets'=>0,
        );

      //  $tickets_by_problem = DB::table('tickets')
        //    ->join('problems','tickets.problem_id','problems.id')
       //     ->select('problems.title', DB::raw('count(*) as total'))
         //   ->groupBy('problem_id','title')
         //   ->get()->toArray();




        $chart = (new LarapexChart)->barChart()
            ->setTitle('Tickets By Department')
            ->addData('Tickets', [6, 9, 3, 4, 10, 8])
            ->setXAxis(['January', 'Fesbruary', 'March', 'April', 'May', 'June']);


        if (RoleHelper::haveRole('Admin')){
            $data['tickets_by_problem'] = 0;

            $data['tickets_by_department'] = 0;
        }

        return view('index',['data' => $data],compact('chart'));

    }
}
