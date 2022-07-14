<?php

namespace Rutatiina\Qbuks\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Rutatiina\Qbuks\Models\ServiceUser;
use Yajra\DataTables\Facades\DataTables;

class ServiceUserController extends Controller
{

    public function __construct()
    {}

    public function index()
	{}

    public function create(Request $request)
	{}

    public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'service_id' => 'required|array',
			'user_id' => 'required|numeric',
			//'opening_date' => 'date_format:"Y-m-d"|required',
			//'closing_date' => 'date_format:"Y-m-d"|required',
			//'countries_available'  => 'required|array',
		]);

		if ($validator->fails()) {
			$request->flash();
			return redirect()->back()->withErrors($validator);
		}

		foreach ($request->service_id as $serviceId) {
			$ServiceUser = new ServiceUser;
			$ServiceUser->service_id = $serviceId;
			$ServiceUser->user_id = $request->user_id;
			$ServiceUser->tenant_id = 1; //Test account tenant id
			$ServiceUser->save();
			return redirect()->back()->with('success', 'User given access to service test account');
		}

	}

    public function show($id)
	{}

    public function edit($id)
	{}

    public function update($id, Request $request)
	{}

    public function destroy($id)
	{}
}
