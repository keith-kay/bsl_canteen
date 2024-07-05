<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Printers;
use App\Models\Sites;

class PrintersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $printers = Printers::all();
        return view('admin.printers.index')
            ->with([
                'printers' => $printers,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sites = Sites::all();
        return view('admin.printers.create', compact('sites'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name'  => 'required|string',
            'status' => 'required|string',
            'address' => 'required|string',
            'port' => 'required|string',
            'site_id' => 'required|string',
        ]);
        //create a printer
        Printers::create([
            'site_id' => $request->site_id,
            'status' => $request->status,
            'name' => $request->name,
            'port' => $request->port,
            'address' => $request->address
        ]);

        return redirect('printers')->with('success', 'Printer Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $printer = Printers::find($id);
        return view('printers.show', compact('printer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $printers = Printers::find($id);
        $sites = Sites::all();
        return view('admin.printers.edit', compact('printers', 'sites'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string',
            'status' => 'required|string',
            'address' => 'required|string',
            'port' => 'required|string',
            'site_id' => 'required|string',
        ]);

        // Find the existing printer record by ID
        $printer = Printers::find($id);

        if ($printer) {
            // Update the printer's properties with the validated data
            $printer->name = $request->name;
            $printer->status = $request->status;
            $printer->address = $request->address;
            $printer->port = $request->port;
            $printer->site_id = $request->site_id;

            // Save the changes to the database
            $printer->save();

            // Redirect to the printer index page with a success message
            return redirect('printers')->with('success', 'Printer Updated Successfully');
        } else {
            // If the printer is not found, redirect back with an error message
            return redirect('printers')->with('error', 'Printer Not Found');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $printer = Printers::findOrFail($id);

        // Delete the printer
        $printer->delete();

        // Redirect back to the index page with a success message
        return redirect('printers')->with('error', 'Printer Deleted Successfully');
    }
}
