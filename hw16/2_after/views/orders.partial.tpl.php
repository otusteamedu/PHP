<?php

echo '<table>
    <tr>
        <th>Order number</th>
        <th>Order state</th>
        <th>Payment state</th>
        <th>Shipping state</th>
        <th>Date</th>
    </tr>';

foreach ($orders as $order) {

    echo '<tr>';
    foreach ($order as $key => $value) {
        if ($key === 'created_at') {
            echo \Carbon\Carbon::parse($value)->format('d.m.Y H:i:s');
        } else {
            echo $value;
        }
    }
    echo '</tr>';
}

echo '</table>';
