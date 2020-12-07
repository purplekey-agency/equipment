<?php

namespace App\Http\Controllers;

use App\User;
use App\Equipment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DNS1D;

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

        return view('admin.equipment')->with([
            'equipment'=>$equipment
            
            ]);
    }

    public function showAddEquipmentPage(){
        $users = User::where('is_admin', false)->get();
        return view('admin.addequipment')->with([
            'users'=>$users,
        ]);
    }

    public function addEquipment(Request $request){
        if($this->_addEquipment($request)){
            return \redirect()->back()->with('success', 'You have succesfully registered equipment.');
        }
        else{
            return \redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    private function _addEquipment(Request $request){
        
        #dd($request);

        if($request->type === "0"){
            $equipentName = $request->equipment_name;
        }
        else{
            $equipentName = $request->type;
        }

        $equipment = new Equipment();
        $equipment->equipment_name = $equipentName;

        if($request->rentable === "0"){
            $equipment->equipment_rentable = 0;
            $equipment->equipment_user = $request->nonrentabile_user;
        }
        else{
            $equipment->equipment_rentable = ¸1;
            $equipment->equipment_user = null;
        }

        if($equipment->save()){
            return true;
        }
        else{
            return false;
        }

    }

    public function printLabel(Request $request){

        $equipment = Equipment::where('id', $request->print_label_equipment)->first();

        $barcode = "";

        if($equipment->id < 10){
            $barcode = "0000000" . $equipment->id;
        }
        else if($equipment->id >=10 && $equipment->id < 100){
            $barcode = "000000" . $equipment->id;
        }
        else if($equipment->id >=100 && $equipment->id < 1000){
            $barcode = "00000" . $equipment->id;
        }
        else if($equipment->id >=1000 && $equipment->id < 10000){
            $barcode = "0000" . $equipment->id;
        }

        $barcodeImage = DNS1D::getBarcodeHTML($barcode, 'C128');

        echo $barcodeImage;
        echo $barcode;
        dd();

    }

    public function showAddUserPage(){

        return view('admin.adduser');
    }

    public function addUser(Request $request){
        
        if($this->_addUser($request)){
            return \redirect()->back()->with('success', 'You have succesfully added user.');
        }
        else{
            return \redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    private function _addUser(Request $request){

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'ends_with:purplematrix.co.uk'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = new User();
        $user->name = $validatedData["name"];
        $user->last_name = $validatedData["lastname"];
        $user->email = $validatedData["email"];
        $user->password = Hash::make($validatedData["password"]);

        if($user->save()){
            return true;
        }
        else{
            return false;
        }

    }

    public function showStatisticsPage(){
        return view('admin.statistics');
    }
}
