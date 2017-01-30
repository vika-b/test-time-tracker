<?php

namespace App\Http\Controllers;

use App\RecTime;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RecsTimeController extends Controller
{
    public function index()
    {
        $_time = [];
        $i = 0;
        $time = RecTime::with(['user' => function ($query) {
            $query->where('id', "=", Auth::user()->id);
        }])->get();
        foreach ($time as $t) {
            if($t['user_id'] ==  Auth::user()->id ) {
                $_time[$i++] = $t;
            }
        }
        return $_time;
    }

    public function store() {
        $data = Request::all();
        $rectime = new RecTime();
        $rectime->fill($data);
        $rectime->save();
    }

    public function update($id) {
        $rectime = RecTime::find($id);
        $data = Request::all();
        $rectime->fill($data);
        $rectime->save();
    }

    public function destroy($id) {
        $rectime = RecTime::find($id);
        $rectime->delete();
    }
}
