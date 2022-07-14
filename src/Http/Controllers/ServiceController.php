<?php

namespace Rutatiina\Qbuks\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Rutatiina\Models\Service;
use Yajra\DataTables\Facades\DataTables;

class ServiceController extends Controller
{

    public function __construct()
    {}

    public function index()
	{
		return view('admin::services.index');
	}

    public function create(Request $request)
	{
		return view('admin::services.create');
	}

    public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required|string',
			'description' => 'required|string',
			//'opening_date' => 'date_format:"Y-m-d"|required',
			//'closing_date' => 'date_format:"Y-m-d"|required',
			//'countries_available'  => 'required|array',
		]);

		if ($validator->fails()) {
			$request->flash();
			return redirect()->back()->withErrors($validator);
		}

		$Service = new Service;
		$Service->name = $request->name;
		$Service->description = $request->description;
		$Service->save();
		return redirect()->back()->with('success', 'Service created');
	}

    public function show($id)
	{
		return view('admin::services.show');
	}

    public function edit($id)
	{
		return view('admin::services.edit');
	}

    public function update($id, Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required|string',
			'description' => 'required|string',
			//'opening_date' => 'date_format:"Y-m-d"|required',
			//'closing_date' => 'date_format:"Y-m-d"|required',
			//'countries_available'  => 'required|array',
		]);

		if ($validator->fails()) {
			$request->flash();
			return redirect()->back()->withErrors($validator);
		}

		$Service = Service::findOrfail($id);
		$Service->name = $request->name;
		$Service->description = $request->description;
		$Service->save();

		return redirect()->back()->with('success', 'Service Updated');
	}

    public function destroy($id)
	{}
}
