<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Equipment;
use App\RentStatus;
use Auth;

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
    public function showDashboard(){

        return redirect('/dashboard/equipment');

        return view('home');
    }

    public function showRentEquipmentPage(){
        return view('user.rent');
    }

    public function showReturnEquipmentPage(){
        return view('user.return');
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
                $rentStatus->user_rented_id = Auth::user()->id;
                $rentStatus->rented_at = \Carbon\Carbon::now();
                $rentStatus->save();

                return redirect()->back()->with('success', 'You have succesfully rented equipment with id ' . $request->barcode);
            }
        }

    }

    public function returnEquipment(Request $request){
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
            elseif($rentStatus->user_rented_id !== Auth::user()->id){
                return redirect()->back()->with('error', 'You are not registered as user who rented this equipment. This equipment is registered as rented by ' . $equipment->getUserRentedName($equipment->id));
            }
            else{
                $rentStatus->rented = false;
                $rentStatus->user_rented_id = null;
                $rentStatus->returned_at = \Carbon\Carbon::now();
                $rentStatus->save();

                return redirect()->back()->with('success', 'You have succesfully returned equipment with id ' . $request->barcode);
            }
        }
    }
}
