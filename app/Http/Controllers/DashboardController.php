<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;

class DashboardController extends Controller
{
    function index() {
        $title = config('app.name') . ' | Dashboard';
        $user = User::where('role', 'admin')->get()->count();
        $item = Item::get()->count();
        return view('dashboard.index', compact('title', 'user', 'item'));
    }
}
