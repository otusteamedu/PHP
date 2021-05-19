<?php
declare(strict_types=1);

namespace CodeArchitecture\After\Formatters;

use Carbon\Carbon;

class OrderBriefFormatter implements FormatterInterface
{
    /**
     * @param array $orders
     *
     * @return string
     */
    public function format(array $orders): string
    {
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