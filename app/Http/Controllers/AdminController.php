<?php

namespace App\Http\Controllers;

use App\User;
use App\Equipment;
use App\RentStatus;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DNS1D;
use PDF;
use Storage;

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

        $rentStatus = "";

        if($request->rentable === "0"){
            $equipment->equipment_rentable = 0;
            $equipment->equipment_user = $request->nonrentabile_user;
            if($equipment->save()){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            $equipment->equipment_rentable = 1;
            $equipment->equipment_user = null;

            $rentStatus = new RentStatus();
            
            if($equipment->save()){
                $rentStatus->equipment_id = $equipment->id;
                if($rentStatus->save()){
                    return true;
                }
                else{
                    return false;
                }
            }
            else{
                return false;
            }
        }



    }

    public function printLabel(Request $request){

        $equipment = Equipment::where('id', $request->print_label_equipment)->first();

        $barcode = "";

        if($equipment->id < 10){
            $barcode = "3870000" . $equipment->id;
        }
        else if($equipment->id >=10 && $equipment->id < 100){
            $barcode = "387000" . $equipment->id;
        }
        else if($equipment->id >=100 && $equipment->id < 1000){
            $barcode = "38700" . $equipment->id;
        }
        else if($equipment->id >=1000 && $equipment->id < 10000){
            $barcode = "3870" . $equipment->id;
        }

        $barcodeImage = DNS1D::getBarcodeHTML($barcode, 'C128');
        $customPaper = array(0,0,141.90,212.85);

        return PDF::loadHTML('<div class="margin:auto;">' . $barcodeImage . '</div>')->setPaper($customPaper, 'landscape')->setWarnings(false)->download($barcode . '.pdf');
    }

    public function printBulkLabel(Request $request){
        if($this->_printBulkLabel()){
            return redirect()->back()->with('pdf', true);
        }
        else{
            return \redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    private function _printBulkLabel(){

        $equipment = Equipment::all();

        $html = "";
        $barcode = "";

        $num = 1;

        $barcodeImage = "";
        $customPaper = "";

        foreach($equipment as $eq){
            if($eq->id < 10){
                $barcode = "3870000" . $eq->id;
            }
            else if($eq->id >=10 && $eq->id < 100){
                $barcode = "387000" . $eq->id;
            }
            else if($eq->id >=100 && $eq->id < 1000){
                $barcode = "38700" . $equipment->id;
            }
            else if($eq->id >=1000 && $eq->id < 10000){
                $barcode = "3870" . $eq->id;
            }

            $barcodeImage = DNS1D::getBarcodeHTML($barcode, 'C128');
            $customPaper = array(0,0,141.90,212.85);

            if($num%2 === 0){
                $html .= '<style>';
                $html .= '.page-break{';
                $html .= 'page-break-after: always';
                $html .= '}';
                $html .= '</style>';
                $html .= '<div class="margin:auto;">' . $barcodeImage . '</div>';
                $html .= '<div class="margin:auto;"><p>' . $barcode . '</p></div>';
                $html .= '<div class="page-break"></div>';
            }
            else{
                $html .= '<style>';
                $html .= '.page-break{';
                $html .= 'page-break-after: always';
                $html .= '}';
                $html .= '</style>';
                $html .= '<div class="margin:auto;">' . $barcodeImage . '</div>';
                $html .= '<div class="margin:auto;"><p>' . $barcode . '</p></div>';
                $html .= '<div class="page-break"></div>';
            }

            $num++;

        }

        if (file_exists( public_path() . '/all.pdf')) {
            unlink(public_path() . '/all.pdf');
        }

        if(PDF::loadHTML($html)->setPaper($customPaper, 'landscape')->setWarnings(false)->save('all.pdf')){
            return true;
        }
        else{
            return false;
        }

    }

    public function deleteEquipment(Request $request){
        if($this->_deleteEquipment($request)){
            return redirect()->back()->with('success', 'You have succesfully deleted equipment.');
        }
        else{
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    private function _deleteEquipment(Request $request){

        $equipment = Equipment::where('id', $request->delete_equipment_id)->first();
        
        if($equipment->delete()){
            return true;
        }
        else{
            return false;
        }

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


        //basic statistics
        $nonrentabileEq = count(Equipment::where('equipment_rentable', false)->get());
        $rentabileEq = count(Equipment::where('equipment_rentable', true)->get());


        return view('admin.statistics')->with([

            'nonrenteq'=>$nonrentabileEq,
            'renteq'=>$rentabileEq,

        ]);
    }
}
