<?php

namespace CodeArchitecture\Before;

use PDO;
use Carbon\Carbon;

class Orders
{
    /**
     * @var PDO
     */
    private $db;

    /**
     * Orders constructor.
     *
     * @param string $file
     * @throws \Exception
     */
    public function __construct($file = 'db_settings.ini')
    {
        if (!$settings = parse_ini_file($file, TRUE))
            throw new \Exception('Unable to open ' . $file . '.');

        $dsn = $settings['database']['driver'] .
            ':host=' . $settings['database']['host'] .
            ((!empty($settings['database']['port'])) ? (';port=' . $settings['database']['port']) : '') .
            ';dbname=' . $settings['database']['schema'];

        $this->db = new \PDO($dsn);
    }

    /**
     * @param $orderNumber
     * @param string $date1
     * @param string $date2
     *
     * @return string
     */
    public function getOrdersBrief($orderNumber, $date1, $date2)
    {
        $orderQuery = 'SELECT oh.id, oh.orderNumber, oh.orderState, oh.paymentState, oh.shippingState, oh.created_at, sum(oi.total) as order_total 
                        FROM `order_history` oh
                        LEFT JOIN `sylius_order_item` oi ON oi.order_id = oh.id
                        WHERE oh.orderNumber = ' . $orderNumber . 'AND oh.created_at BETWEEN ' . $date1 . ' AND ' . $date2 . ';';

        $statement = $this->db->query($orderQuery);

        $orders = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $output = '<table><tr><th>Order number</th><th>Order state</th><th>Payment state</th><th>Shipping state</th><th>Date</th></tr>';

        foreach ($orders as $order) {
            $output .= '<tr>';
            foreach ($order as $key => $value) {
                if ($key === 'created_at') {
                    $output .= '<td>' . Carbon::parse($value)->format('d.m.Y H:i:s') . '</td>';
                }
                $output .= '<td>' . $value . '</td>';
            }
            $output .= '</tr>';
        }

        $output .= '</table>';

        return $output;
    }
}
