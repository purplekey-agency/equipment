<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DNS1D;
use Auth;

class PagesController extends Controller
{

    public function __construct(){
        $this->middleware('admin');
    }

    public function showIndexPage(){

        if(Auth::user()){
            return \redirect('dashboard');
        }

        return view('welcome');

    }

    public function showLogin(){
        return \redirect('/');
    }
}
