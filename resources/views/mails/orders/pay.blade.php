<p>
    Мерчан: {{ $shop->title }}
</p>

<table border="1">
    <tr>
        <td>Название</td>
        <td>Стоимость</td>
        <td>Статус</td>
        <td>Order ID</td>
    </tr>

    <tr>
        <td>{{ $orderName }}</td>
        <td>{{ $orderAmount }}</td>
        <td>{{ $status }}</td>
        <td><a href="{{ $bank_order_link }}" target="_blank">{{ $bank_order_id }}</a></td>
    </tr>
</table>

<p>
    <small>
        Система получения платежей ТГПУ. <a href="https://payment.tspu.edu.ru"
                                            target="_blank">payment.tspu.edu.ru</a><br>
        Если не хотите больше получать уведомления, напишите на <a
            href="mailto:support@tspu.edu.ru">support@tspu.edu.ru</a>
    </small>
</p>
