<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shifts;

class ShiftController extends Controller
{
    //
    //
    public function index()
    {
        $shifts = Shifts::get();
        return view('admin.shifts.index', ['shifts' => $shifts]);
    }

    public function create()
    {
        return view('admin.shifts.create');
    }
    public function store(Request $request)
    {

        $request->validate([
            'name'  => 'required|string',
            'status' => 'required|string',
            'starttime' => 'required|string',
            'endtime' => 'required|string',
            'noofmeals' => 'required|string',
        ]);
        //create a shift
        Shifts::create([
            'bsl_cmn_shifts_name' => $request->name,
            'status' => $request->status,
            'bsl_cmn_shifts_starttime' => $request->starttime,
            'bsl_cmn_shifts_endtime' => $request->endtime,
            'bsl_cmn_shifts_mealsnumber' => $request->noofmeals
        ]);


        return redirect('shifts')->with('success', 'Shift Created Successfully');
    }
    public function edit(Shifts $shift)
    {
        return view('admin.shifts.edit', ['shift' => $shift]);
    }
    public function update(Request $request, Shifts $shift)
    {

        $request->validate([
            'name'  => 'required|string',
            'starttime' => 'required|string',
            'endtime' => 'required|string',
            'noofmeals' => 'required|string',
        ]);

        //update shift
        $shift->update([
            'bsl_cmn_shifts_name' => $request->name,
            'bsl_cmn_shifts_starttime' => $request->starttime,
            'bsl_cmn_shifts_endtime' => $request->endtime,
            'bsl_cmn_shifts_mealsnumber' => $request->noofmeals
        ]);

        return redirect('shifts')->with('success', 'Shift Updated Successfully');
    }
    public function destroy($shiftId)
    {
        $shift = Shifts::find($shiftId);
        $shift->delete();
        return redirect('shifts')->with('error', 'Shift Deleted Successfully');
    }
}
