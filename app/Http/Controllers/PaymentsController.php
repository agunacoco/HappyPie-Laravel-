<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Payment;
use App\Models\User;
use App\Models\Delivery;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function callpayment(Request $request)
    {

        $name = $request->itemsName;
        $http_host = "http://127.0.0.1:8000";
        $adminkey = env("MIX_KAKAO_ADMIN_KEY");
        $cid = "TC0ONETIME";
        $headers = array(
            'Authorization: KakaoAK ' . $adminkey,
            'Content-type: application/x-www-form-urlencoded;charset=utf-8'
        );

        $approval_url = $http_host . "/happypies/payment/success";
        $cancel_url = $http_host . "/happypies/shoppingcart";
        $fail_url = $http_host . "/happypies/shoppingcart";

        $kakao_params = array(
            'cid' => $cid,
            'partner_order_id' => $request->partner_order_id,
            'partner_user_id' => $request->user_id,
            'item_name' => $name,
            'item_code' => $request->itemsId,
            'quantity' => $request->quantity,
            'total_amount' => $request->total_amount,
            'tax_free_amount' => 0,
            'vat_amount' => 0,
            'approval_url' => $approval_url,
            'cancel_url' => $cancel_url,
            'fail_url' => $fail_url,
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

    public function approve(Request $request)
    {

        $adminkey = env("MIX_KAKAO_ADMIN_KEY");
        $cid = "TC0ONETIME";
        $headers = array(
            'Authorization: KakaoAK ' . $adminkey,
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

    public function store(Request $request)
    {

        $payment = Payment::create([
            'aid' => $request->aid,
            'user_id' => $request->partner_user_id,
            'order_id' => $request->partner_order_id,
            'item_code' => $request->item_code,
            'item_name' => $request->item_name,
            'approved_at' => $request->approved_at,
            'total' => $request->amount['total'],
            'quantity' => $request->quantity,
        ]);

        $userid = auth()->user()->id;
        $menuIds = explode(',',  $request->item_code);
        $payment->menus()->toggle($menuIds);

        if ($request->directPayment) {
            Menu::find($request->item_code)->payments()->updateExistingPivot($payment->id, ['count' => $request->quantity]);
        } else {
            foreach ($menuIds as $menuId) {
                $originalCount = User::find($userid)->menus()->where('menu_id', $menuId)->value('count');
                $cart = Menu::find($menuId)->payments()->updateExistingPivot($payment->id, ['count' => $originalCount]);
            }
            $user = User::find(auth()->user()->id);
            $user->menus()->detach();
        }

        $delivery = Delivery::create([
            'user_id' => auth()->user()->id,
            'payment_id' => $payment->id,
            'addr1' => $request->addr1,
            'addr2' => $request->addr2,
            'detailaddr' => $request->zip,
            'phone' => $request->phoneNum,
            'receiver' => $request->receiver,
        ]);



        return $payment;
    }

    public function showReceipt($order_id)
    {

        $payment = Payment::find($order_id);

        return view('happypies.receipt', ['payment' => $payment]);
    }

    public function index()
    {

        $payments = Payment::where('user_id', auth()->user()->id)->with(['menus', 'delivery', 'user'])->latest()->paginate(3);

        return $payments;
    }
}
