<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\week;
use App\Models\team;
use App\Models\emp;

class weekController extends Controller
{
    
     public function index()
    {
        return view("home");
    }

    public function team()
    {
        return view("team");
    }

    public function emp()
    {
    	$team=team::all();
        return view("emp")->with('team', $team);
    }

    public function create(Request $request)
    {
    	 $data = array(
                    'week_name' => $request->name,
                    'start_date' => date('Y-m-d', strtotime($request->start_date)),
                    'end_date' => date('Y-m-d', strtotime($request->end_date)),
                    
                );
                week::insert($data);
                return redirect('/');
    }

    public function create_team(Request $request)
    {
    	 $data = array(
                    'name' => $request->name,                   
                );
                team::insert($data);
                return redirect('/team');
    }

    public function create_emp(Request $request)
    {
    	 $data = array(
                    'name' => $request->name,
                    'team_id' => $request->team_id,
                );
                emp::insert($data);
                return redirect('/emp');
    }


public function schedule()
    {

    	$week=week::all();
        return view("schedue")->with('week', $week);
    }


}
