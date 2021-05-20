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
    foreach ($order as $value) {
        echo $value;
    }
    echo '</tr>';
}

echo '</table>';
