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
        return view('admin.printers.index', compact('printers'));
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
        ]);
        //create a site
        Printers::create([
            'site_id' => $request->site,
            'status' => $request->status,
            'name' => $request->name,
            'port' => $request->port,
            'address' => $request->address
        ]);

        return redirect('printer')->with('status', 'Printer Created Successfully');
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
        $printer = Printers::find($id);
        return view('printers.edit', compact('printer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    }
}
