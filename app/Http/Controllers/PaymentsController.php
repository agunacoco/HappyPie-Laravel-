<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function callpayment(Request $request){

        $name = $request->itemsName;
        $array_itemsId = explode(',', $name);
        $http_host = "http://127.0.0.1:8000";
        $adminkey = "2aec59941467f41efd86c2720cdb0c0b";
        $cid = "TC0ONETIME";
        $headers = array(
            'Authorization: KakaoAK '.$adminkey,
            'Content-type: application/x-www-form-urlencoded;charset=utf-8'
        );

        $approval_url = $http_host."/happypies/payment/success";
        $cancel_url = $http_host."/happypies/shoppingcart";
        $fail_url = $http_host."/happypies/shoppingcart";

        $kakao_params = array(
            'cid' => $cid,
            'partner_order_id' => $request->partner_order_id,
            'partner_user_id' => $request->user_id,
            'item_name' => $name,
            'item_code' => $request->itemsId,
            'quantity' => count($array_itemsId),
            'total_amount'=> $request->total_amount,
            'tax_free_amount'=> 0,
            'vat_amount'=>0,
            'approval_url'=> $approval_url,
            'cancel_url'=> $cancel_url,
            'fail_url'=> $fail_url,
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://kapi.kakao.com/v1/payment/ready");    
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);     
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);  
        curl_setopt($ch, CURLOPT_POSTFIELDS,  http_build_query($kakao_params));       //파라미터 값
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
        curl_setopt($ch, CURLOPT_POST, true);  
        $output = curl_exec($ch);
        curl_close($ch);
        // dd(json_decode($output)->tid);
        
        return response($output)->cookie('tid', json_decode($output)->tid, 1000, null, null, false, false);
    }

    public function approve(Request $request){

        $adminkey = "2aec59941467f41efd86c2720cdb0c0b";
        $cid = "TC0ONETIME";
        $headers = array(
            'Authorization: KakaoAK '.$adminkey,
            'Content-type: application/x-www-form-urlencoded;charset=utf-8'
        );

        $kakao_params = array(
            'cid' => $cid,
            'tid' => $request->tid,
            'partner_order_id' => $request->order_id,
            'partner_user_id' => $request->user_id,
            'pg_token' => $request->pg_token,
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://kapi.kakao.com/v1/payment/approve");    
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);     
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);  
        curl_setopt($ch, CURLOPT_POSTFIELDS,  http_build_query($kakao_params));       //파라미터 값
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
        curl_setopt($ch, CURLOPT_POST, true);  
        $output = curl_exec($ch);
        curl_close($ch);
        
        return json_decode($output);
    }

    public function store(Request $request){

        $this->validate($request, [
            'aid' => 'required',
            'user_id' => 'required',
            'order_id' => 'required',
            'item_code'=> 'required',
            'item_name' => 'required',
            'approved_at' => 'required',
            'total' => 'required',
            'quantity' => 'required',
        ]);

        $payment = Payment::create([
            'aid' => $request->input('aid'),
            'user_id' => $request->input('partner_user_id'),
            'order_id' => $request->input('partner_order_id'),
            'item_code'=> $request->input('item_code'),
            'item_name' => $request->input('item_name'),
            'approved_at' => $request->input('approved_at'),
            'total' => $request->amount->input('total'),
            'quantity' => $request->input('quantity'),
        ]);

        return $payment;
    }

}
