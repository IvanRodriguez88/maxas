<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\ClientReturnRequestDataTable;
use App\Models\ReturnRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->role_id == 2) {
            return view("dashboard");
        }else{
            return view("dashboard");
        }
    }
}
