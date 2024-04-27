<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\Sites;

class SitesController extends Controller
{
    public function index()
    {
        $sites = Sites::get();
        return view('admin.sites.index', ['sites' => $sites]);
    }
    public function  create()
    {
        return view('admin.sites.create');
    }
    public function store(Request  $request)
    {
        $request->validate([
            'name'  => 'required|string',
            'status' => 'required|string',
        ]);
        //create a site
        Sites::create([
            'bsl_cmn_sites_name' => $request->name,
            'bsl_cmn_sites_status' => $request->status
        ]);

        return redirect('sites')->with('status', 'Site Created Successfully');
    }
    public function edit(Sites $site)
    {
        return view('admin.sites.edit', ['site' => $site]);
    }
    public function update(Request $request, Sites $site)
    {
        //dd($request);
        $request->validate([
            'name'  => ['required', 'string', 'unique:permissions,name,' . $site->bsl_cmn_sites_id],
            'status' => 'required|string',

        ]);

        //update permission
        $site->update([
            'bsl_cmn_sites_name' => $request->name,
            'bsl_cmn_sites_status' => $request->status
        ]);

        return redirect('sites')->with('status', 'Site Updated Successfully');
    }
    public function destroy($siteId)
    {
        $site = Sites::find($siteId);
        $site->delete();
        return redirect('sites')->with('status', 'Site Deleted Successfully');
    }
}
