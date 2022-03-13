<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\CurrentAvailabilityInterface;
use App\Interfaces\AvailabilityInterface;
use App\Interfaces\NextAvailabilityInterface;
use Carbon\Carbon;

class ShopTimingController extends Controller
{
    public function isOpenNow(CurrentAvailabilityInterface $availability_calculator)
    {
        return $availability_calculator->isOpen();
    }

    public function isOpenOn(Request $request, AvailabilityInterface $availability_calculator)
    {
        $request->validate([
            'date' => 'required|date',
        ]);
        return $availability_calculator->isOpenOn(Carbon::parse($request->input('date')));
    }

    public function nearestOpenDate(NextAvailabilityInterface $availability_calculator)
    {
        $next_open =  $availability_calculator->nextAvailability();
        if (!$next_open) {
            return response()->json(['message' => 'No open dates found'], 404);
        }
        return $next_open->diffForHumans();
    }
}
