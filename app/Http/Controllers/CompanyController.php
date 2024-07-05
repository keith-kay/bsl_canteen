<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User_type;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = User_type::get();
        return view('admin.company.index', ['companies' => $companies]);
    }
    public function  create()
    {
        return view('admin.company.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string',
        ]);
        //create a company
        User_type::create(['bsl_cmn_user_types_name' => $request->name]);

        return redirect('companies')->with('success', 'Company Created Successfully');
    }
    public function edit(User_type $company)
    {
        return view('admin.company.edit', ['company' => $company]);
    }
    public function update(Request $request, User_type $company)
    {
        //dd($request);
        $request->validate([
            'name'  => ['required', 'string', 'unique:permissions,name,' . $company->bsl_cmn_permissions_id],

        ]);

        //update permission
        $company->update(['bsl_cmn_user_types_name' => $request->name]);

        return redirect('companies')->with('success', 'Company Updated Successfully');
    }
    public function destroy($companyId)
    {
        $company = User_type::find($companyId);
        $company->delete();
        return redirect('companies')->with('error', 'Company Deleted Successfully');
    }
}
