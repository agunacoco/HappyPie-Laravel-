<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function callpayment(){

        $http_host = "https://kapi.kakao.com";
        $adminkey = "2aec59941467f41efd86c2720cdb0c0b";
        $cid = "TC0ONETIME";
        $headers[] = 'Authorization: KakaoAk '.$adminkey;
        $headers[] = "Content-type: application/x-www-form-urlencoded;charset=utf-8";
        
        $approval_url = $http_host."/CallPaymentKakaoPaySuccess";
        $cancel_url = $http_host."/CallPaymentKakaoPayCancle";
        $fail_url = $http_host."/CallPaymentKakaoPayCancle";

        $kakao_params = array(
            'cid' => $cid,
            'partner_order_id' => 1,
            'partner_user_id' => 1,
            'item_name' => "테스트 상품",
            'quantity' => 1,
            'total_amount'=> 110,
            'tax_free_amount'=> 0,
            'vat_amount'=>10,
            'approved_url'=> $approval_url,
            'cancel_url'=> $cancel_url,
            'fail_url'=> $fail_url,
        );

        $ch = curl_init('https://kapi.kakao.com/v1/payment/ready');   
        curl_setopt($ch, CURLOPT_POST, 1);        
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);  
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($kakao_params));       //파라미터 값
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                    //return 값 반환 
        $output = curl_exec($ch);
        curl_close($ch);
        
        return $output;
    }
}
