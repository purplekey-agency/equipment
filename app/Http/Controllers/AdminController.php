<?php

namespace App\Http\Controllers;

use App\User;
use App\Equipment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function showUsersPage(){
        
        $users = User::where('is_admin', false)->get();

        return view('admin.users')->with('users', $users);
    }

    public function showEquipmentPage(){
        
        $equipment = Equipment::all();

        return view('admin.equipment')->with('equipment', $equipment);
    }

    public function showAddUserPage(){
        return view('admin.adduser');
    }

    public function addUser(Request $request){
        $this->_addUser($request);
    }

    private function _addUser(Request $request){

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

    }
}
