<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\Sites;

class SitesController extends Controller
{
    public function index()
    {
        $sites = Sites::with('ip')->get();
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
            'device_ip' => 'required|string',
        ]);
        //create a site
        Sites::create([
            'bsl_cmn_sites_name' => $request->name,
            'bsl_cmn_sites_status' => $request->status,
            'bsl_cmn_sites_device_ip' => $request->device_ip
        ]);

        return redirect('sites')->with('success', 'Site Created Successfully');
    }
    public function edit(Sites $site)
    {
        return view('admin.sites.edit', ['site' => $site]);
    }
    public function update(Request $request, Sites $site)
    {

        $request->validate([
            'name'  => ['required', 'string', 'unique:permissions,name,' . $site->bsl_cmn_sites_id],
            'status' => 'required|string',
            'device_ip' => 'required|string',

        ]);

        //update permission
        $site->update([
            'bsl_cmn_sites_name' => $request->name,
            'bsl_cmn_sites_status' => $request->status,
            'bsl_cmn_sites_device_ip' => $request->device_ip
        ]);

        return redirect('sites')->with('success', 'Site Updated Successfully');
    }
    public function destroy($siteId)
    {
        $site = Sites::find($siteId);
        $site->delete();
        return redirect('sites')->with('error', 'Site Deleted Successfully');
    }
}
