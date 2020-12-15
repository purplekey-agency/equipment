<?php

namespace App\Http\Controllers;

use App\User;
use App\Equipment;
use App\RentStatus;
use App\Statistics;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DNS1D;
use PDF;
use Storage;
use Auth;

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
        $users = User::all();
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

        $html = '';
        $html .= '<style>';
        $html .= '.page-break{';
        $html .= 'page-break-after: always';
        $html .= '}';
        $html .= '</style>';
        $html .= '<div class="margin:auto;">' . $barcodeImage . '</div>';
        $html .= '<div class="margin:auto;"><p>' . $barcode . '</p></div>';
        $html .= '<div class="page-break"></div>';

        return PDF::loadHTML($html)->setPaper($customPaper, 'landscape')->setWarnings(false)->download($barcode . '.pdf');
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
        ]);

        $user = new User();
        $user->name = $validatedData["name"];
        $user->last_name = $validatedData["lastname"];
        $user->email = $validatedData["email"];

        if($user->save()){
            return true;
        }
        else{
            return false;
        }

    }

    public function showRentEquipmentPage(){

        $users = User::where('id', '!=', Auth::user()->id)->get();

        return view('user.rent')->with(['users'=>$users]);
    }

    public function showReturnEquipmentPage(){

        $users = User::all();

        return view('user.return')->with(['users'=>$users]);;
    }

    public function showUserReportPage(){
        return view('user.report');
    }

    public function rentEquipment(Request $request){

        $id = $request->barcode - 38700000;
        
        $equipment = Equipment::where('id', $id)->first();

        if(!$equipment->equipment_rentable){
            return redirect()->back()->with('error', 'Equipment is not rentable');
        }
        else{
            $rentStatus = RentStatus::where('equipment_id', $id)->first();
            if($rentStatus->rented){
                return redirect()->back()->with('error', 'Equipment is already registered as rented by:' . $equipment->getUserRentedName($equipment->id));
            }
            else{
                $rentStatus->rented = true;
                $rentStatus->user_rented_id = $request->user;
                $rentStatus->rented_at = \Carbon\Carbon::now();
                $rentStatus->user_auth = Auth::user()->id;
                $rentStatus->number_of_times_rented = $rentStatus->number_of_times_rented+1;
                $rentStatus->save();

                $statistics = new Statistics();
                $statistics->auth_id = Auth::user()->id;
                $statistics->renting_user_id = $request->user;
                $statistics->renting_equipment_id = $id;
                $statistics->rented_at = \Carbon\Carbon::now();
                $statistics->save();

                $user = User::where('id', $request->user)->first();
                $user->number_of_items_rented = $user->number_of_items_rented + 1;
                $user->save();

                return redirect()->back()->with('success', 'You have succesfully rented equipment with id ' . $request->barcode);
            }
        }

    }

    public function returnEquipment(Request $request){

        #dd($request);

        $id = $request->barcode - 38700000;

        $equipment = Equipment::where('id', $id)->first();

        if(!$equipment->equipment_rentable){
            return redirect()->back()->with('error', 'Equipment is not rentable.');
        }
        else{
            $rentStatus = RentStatus::where('equipment_id', $id)->first();
            if(!$rentStatus->rented){
                return redirect()->back()->with('error', 'Equipment is not registered as rented.');
            }
            else{
                $rentStatus->rented = false;
                $rentStatus->user_rented_id = null;
                $rentStatus->returned_at = \Carbon\Carbon::now();
                $rentStatus->save();

                $statistics = Statistics::where('renting_equipment_id', $id)->first();
                $statistics->returned_at = \Carbon\Carbon::now();
                $statistics->save();

                return redirect()->back()->with('success', 'You have succesfully returned equipment with id ' . $request->barcode);
            }
        }
    }

    public function showStatisticsPage(){


        //basic statistics
        $nonrentabileEq = count(Equipment::where('equipment_rentable', false)->get());
        $rentabileEq = count(Equipment::where('equipment_rentable', true)->get());

        //rented statistics
        $rentedEq = count(RentStatus::where('rented', true)->get());
        $nonRentedEq = count(RentStatus::where('rented', false)->get());

        //most rented item
        $mostRentedItems = RentStatus::orderBy('number_of_times_rented', 'desc')->take(5)->get();
        $items = [];
        $number = [];
        foreach($mostRentedItems as $item){
            array_push($items, ($item->getEquipmentName($item->equipment_id)));
            array_push($number, $item->number_of_times_rented);
        }


        //most renting user
        $mostRentingUser = User::orderBy('number_of_items_rented', 'desc')->take(5)->get();
        $users = [];
        $userNumber = [];
        foreach($mostRentingUser as $user){
            array_push($users, ($user->name . " " . $user->last_name));
            array_push($userNumber, $user->number_of_items_rented);
        }




        return view('admin.statistics')->with([

            'nonrenteq'=>$nonrentabileEq,
            'renteq'=>$rentabileEq,

            'rentedEq'=>$rentedEq,
            'nonRentedEq'=>$nonRentedEq,

            'mostRentedItems'=>$items,
            'mostRentedItemsNuber'=>$number,


            'mostRentingUser'=>$users,
            'mostRentingUserNumber'=>$userNumber,

        ]);
    }
}
