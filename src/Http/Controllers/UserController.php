<?php

namespace Rutatiina\Qbuks\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Rutatiina\Qbuks\Models\Service;

class UserController extends Controller
{

    public function __construct()
    {}

    public function index()
	{
		return view('admin::users.index');
	}

    public function create(Request $request)
	{
		return view('admin::users.create');
	}

    public function store(Request $request)
	{}

    public function show($id)
	{
		return view('admin::users.show', [
			'user' => Auth::user(),
			'services' => Service::all()
		]);
	}

    public function edit($id)
	{
		return view('admin::users.edit');
	}

    public function update(Request $request)
	{}

    public function destroy($id)
	{}
}
