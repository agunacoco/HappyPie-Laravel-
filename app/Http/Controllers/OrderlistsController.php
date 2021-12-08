<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderlistsController extends Controller
{
    public function index(){

        $payments = Payment::all();

        //dd($payments);

        return $payments;

    }
}
