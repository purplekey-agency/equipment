<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

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
}
