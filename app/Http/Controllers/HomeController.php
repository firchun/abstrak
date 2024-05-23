<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'admin' => User::where('role', 'Admin')->count(),
            'mahasiswa' => User::where('role', 'Mahasiswa')->count(),
            'upt' => User::where('role', 'UPT')->count(),
        ];
        return view('admin.dashboard', $data);
    }
}
