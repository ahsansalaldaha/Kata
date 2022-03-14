<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\CurrentAvailabilityInterface;
use App\Interfaces\AvailabilityInterface;
use App\Interfaces\NextAvailabilityInterface;
use Illuminate\Support\Carbon;

class ShopTimingController extends Controller
{
    public function isOpenNow(CurrentAvailabilityInterface $availability_calculator)
    {
        $data = $availability_calculator->isOpen();
        return response()->json([
            'is_open' => $data,
            'datetime' => Carbon::now()
        ]);
    }

    public function isOpenOn(Request $request, AvailabilityInterface $availability_calculator)
    {
        $request->validate([
            'date' => 'required|date',
        ]);
        $date = Carbon::parse($request->get('date'));
        $data =  $availability_calculator->isOpenOn($date);
        return response()->json([
            'is_open' => $data,
            'datetime' => $date
        ]);
    }

    public function nearestOpenDate(NextAvailabilityInterface $availability_calculator)
    {
        $next_open =  $availability_calculator->nextAvailability();
        if (!$next_open) {
            return response()->json(['message' => 'No open dates found. Either open already or schedule not known'], 404);
        }
        $data =  $next_open->diffForHumans();
        return response()->json([
            'nearest_open' => $data
        ]);
    }
}
