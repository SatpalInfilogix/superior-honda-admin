<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductSoldExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $request = $this->request;

        $ordersQuery = Order::query();

        if ($request->filterValue == 'Day') {
            $ordersQuery->whereDate('created_at', $request->date);
        } elseif ($request->filterValue == 'Week' || $request->filterValue == 'Month') {
            $ordersQuery->whereBetween('created_at', [$request->startDate, $request->endDate]);
        }

        $orders = $ordersQuery->get();

        $products_in_order = [];
        foreach ($orders as $order) {
            $cart = json_decode($order->cart_items, true);
            if ($cart && isset($cart['products'])) {
                $product_ids = array_column($cart['products'], 'id');
                $products_for_order = Product::whereNull('deleted_at')->whereIn('id', $product_ids)->get()->toArray();
                $products_in_order = array_merge($products_in_order, $products_for_order);
            }
        }

        $unique_products = array_values(array_unique($products_in_order, SORT_REGULAR));

        $formattedData = collect($unique_products)->map(function ($product) {
            return [
                'id' => $product['id'],
                'product_name' => $product['product_name'] ?? 'N/A',
                'quantity' => $product['quantity'],
                'cost_price' => $product['cost_price']
            ];
        });

        return $formattedData;
    }

    public function headings(): array
    {
        return [
            'ID',     
            'Product Name', 
            'Quantity',    
            'Price',
        ];
    }
}