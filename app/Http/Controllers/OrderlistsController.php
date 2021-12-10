<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class OrderlistsController extends Controller
{
    public function index(){

        $payments = Payment::with(['delivery', 'user', 'menus'])->latest()->paginate(3);

        return $payments;
    }
    public function updateStatus(Request $request, $payment_id){

        $status = $request->status;
        $payments = Payment::with(['user','delivery', 'menus'])->latest()->paginate(3); 
        $payment = Payment::find($payment_id);
        if($status == "접수완료"){
            $payment->update([ 'order_status' => "주문준비중" ]);
            $paymentOne = Payment::where('id', $payment_id)->with(['user','delivery', 'menus'])->first();
            return $paymentOne;

        }else if($status == "준비완료"){
            $payment->update([ 'order_status' => "배송중" ]);
            return $payments;
            
        }
        
    }
    public function show($payment_id){
        $paymentOne = Payment::where('id', $payment_id)->with(['user','delivery', 'menus'])->first();
        return $paymentOne;
    }

}
