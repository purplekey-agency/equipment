<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Equipment;

class RentStatus extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rent_status';

    protected $fillable = [
        'equipment_id', 'rented' ,'user_rented_id', 'rented_at', 'returned_at', 'user_auth','number_of_times_rented'
    ];

    public function getEquipmentName($id){
        return Equipment::where('id', $id)->first()->equipment_name;
    }
}
