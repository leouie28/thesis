<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function statistic()
    {
        return [
            "product" => Product::count(),
            "order" => Order::count(),
            "customer" => Customer::count(),
            "recommendation" => 0,
        ];
    }

    public function monthOrders()
    {
        $yearMonth = date('Y-m-');
        $d = date('j');
        $order = array();

        for($i=1; $i<=$d; $i++){
            $day = Carbon::createFromDate($yearMonth . $i)->toDateString();
            $order[$day] = Order::whereDate('created_at', $day)->count();
        }

        return $order;
    }

    public function orders()
    {
        $orders = Product::withCount('order')->get();
        return $orders;
    }

    public function getDatas()
    {
        try{
            $now = Carbon::now();
            $start = $now->startOfWeek()->toDateString();
            $end = $now->endOfWeek()->format('Y-m-d');
            $counter = 1;
            $orders = array();
            $customers = array();

            while($counter <= 7){
                $selector = Carbon::parse($start)->addDay($counter)->toDateString();
                $orders[] = Order::whereDate('created_at', $selector)->count();
                $customers[] = Customer::whereDate('created_at', $selector)->count();
                $counter++;
            }

            return [
                "orders" => $orders,
                "customers" => $customers,
            ];
            
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
}
