<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\RentStatus;

class Equipment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'equipment';

    protected $fillable = [
        'equipment_name', 'equipment_rentable' ,'equipment_user'
    ];

    public function getUserName($id){
        $user = User::where('id', $id)->first();
        return $user->name ." ". $user->last_name;
    }

    public function getRentStatus($id){
        $rentStatus = RentStatus::where('equipment_id', $id)->first();

        if($rentStatus->rented){
            return "Rented";
        }
        else{
            return "In Stock";
        }
    }

    public function getUserRentedName($id){
        $rentStatus = RentStatus::where('equipment_id', $id)->first();

        if($rentStatus->rented){
            return $this->getUserName($rentStatus->user_rented_id);
        }
        else{
            return "None";
        }
    }
}
