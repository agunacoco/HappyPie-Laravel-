<x-app-layout>

    <div class="card mb-3 p-20">
        <div>
          <p>카카오페이 결제가 정상적으로 완료되었습니다.</p>
          <p>결제일시: {{ $payment->approved_at }}</p>
          <p>주문번호: {{ $payment->order_id }}</p>
          <p>상품명: {{ $payment->item_name }}</p>
          <p>결제금액: {{ $payment->total }}</p>
        </div>
    </div>


</x-app-layout>
