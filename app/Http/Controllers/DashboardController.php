<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\ClientReturnRequestDataTable;
use App\Models\ReturnRequest;
use App\Models\Client;

class DashboardController extends Controller
{
    public function index()
    {
		$user = auth()->user();
        if ($user->role_id == 2) {
            $client = Client::where("user_id", auth()->user()->id)->first();
            return view("dashboard-client", compact("client"));
        }else{
            return view("dashboard");
        }
    }
}
