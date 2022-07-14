<?php

namespace Rutatiina\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class _ExampleController extends Controller
{

    public function __construct()
    {}

    public function index()
	{
		return view('admin::index');
	}

    public function create(Request $request)
	{
		return view('admin::create');
	}

    public function store(Request $request)
	{}

    public function show($id)
	{
		return view('admin::show');
	}

    public function edit($id)
	{
		return view('admin::edit');
	}

    public function update(Request $request)
	{}

    public function destroy($id)
	{}
}
