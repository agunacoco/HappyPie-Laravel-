<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function callpayment(Request $request){

        $http_host = "http://127.0.0.1:8000";
        $adminkey = "2aec59941467f41efd86c2720cdb0c0b";
        $cid = "TC0ONETIME";
        $headers = array(
            'Authorization: KakaoAK '.$adminkey,
            'Content-type: application/x-www-form-urlencoded;charset=utf-8'
        );

        $approval_url = $http_host."/api/payment/success";
        $cancel_url = $http_host."/happypies/shoppingcart";
        $fail_url = $http_host."/happypies/shoppingcart";

        $kakao_params = array(
            'cid' => $cid,
            'partner_order_id' => 1,
            'partner_user_id' => 1,
            'item_name' => "테스트 상품",
            'quantity' => 1,
            'total_amount'=> 110,
            'tax_free_amount'=> 0,
            'vat_amount'=>10,
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
        
        return $output;
    }

    public function store(){
        $http_host = "http://127.0.0.1:8000";
        $adminkey = "2aec59941467f41efd86c2720cdb0c0b";
        $cid = "TC0ONETIME";
        $headers = array(
            'Authorization: KakaoAK '.$adminkey,
            'Content-type: application/x-www-form-urlencoded;charset=utf-8'
        );

        $approval_url = $http_host."/api/payment/success";
        $cancel_url = $http_host."/api/payment/cancle";
        $fail_url = $http_host."/api/payment/cancle";

        $kakao_params = array(
            'cid' => $cid,
            'partner_order_id' => 1,
            'partner_user_id' => 1,
            'item_name' => "테스트 상품",
            'quantity' => 1,
            'total_amount'=> 110,
            'tax_free_amount'=> 0,
            'vat_amount'=>10,
            'approval_url'=> $approval_url,
            'cancel_url'=> $cancel_url,
            'fail_url'=> $fail_url,
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
        
        return $output;
        
    }
}
