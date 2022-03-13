<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\Schedule;

use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        return Schedule::latest()->paginate(10);
    }

    // add schedule
    public function add(Request $request)
    {
        $request->validate([
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);
        $schedule = new Schedule([
            'title' => $request->input('title'),
            'description' => $request->input('description')
        ]);
        $schedule->save();

        return response()->json('The schedule successfully added');
    }

    // edit schedule
    public function edit($id)
    {
        $schedule = Schedule::find($id);
        return response()->json($schedule);
    }

    // update schedule
    public function update($id, Request $request)
    {
        $request->validate([
            'day' => '',
            'start_time' => '',
            'end_time' => '',
        ]);
        $schedule = Schedule::find($id);
        $schedule->update($request->all());

        return response()->json('The schedule successfully updated');
    }

    // delete schedule
    public function delete($id)
    {
        $schedule = Schedule::find($id);
        $schedule->delete();

        return response()->json('The schedule successfully deleted');
    }
}
