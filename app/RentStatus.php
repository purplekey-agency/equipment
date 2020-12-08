<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RentStatus extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rent_status';

    protected $fillable = [
        'equipment_id', 'rented' ,'user_rented_id', 'rented_at', 'returned_at'
    ];
}
