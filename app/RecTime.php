<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecTime extends Model
{
    //
    protected $table = 'rec_time';

    protected $fillable = ['user_id', 'start_time', 'end_time', 'task_title'];
    protected $hidden = ['user_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
