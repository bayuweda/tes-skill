<?php

namespace App\Http\Controllers;

use App\Models\booking;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request, $vehicles = null)
    {
        $bookings = Booking::with(['bookingDetails.vehicle'])->get();

        $result = [];
        foreach ($bookings as $booking) {
            foreach ($booking->bookingDetails as $detail) {
                $start = Carbon::parse($detail->start_date);
                $end = Carbon::parse($detail->end_date);
                $total_days = $start->diffInDays($end);
                $price_per_day = $total_days != 0 ? $detail->sub_total / $total_days : 0;

                $result[] = [
                    'id' => $booking->id,
                    'customer_name' => $booking->customer_name,
                    'vehicle_name' => $detail->vehicle->name,
                    'vehicle_type' => $detail->vehicle->type,
                    'start_date' => $detail->start_date,
                    'end_date' => $detail->end_date,
                    'total_days' => $total_days,
                    'price_per_day' => (int) $price_per_day,
                    'sub_total' => $detail->sub_total,
                ];
            }
        }


        $vehicles = strtolower($vehicles);
        $result = array_filter($result, function ($item) use ($vehicles) {
            return strpos(strtolower($item['vehicle_name']), $vehicles) !== false ||
                strpos(strtolower($item['vehicle_type']), $vehicles) !== false;
        });


        if ($request->has('search')) {
            $search = strtolower($request->search);
            $result = array_filter($result, function ($item) use ($search) {
                return strpos(strtolower($item['customer_name']), $search) !== false;
            });
        }

        $result = array_values($result);

        return response()->json($result);
    }
}
