<?php

namespace Rutatiina\Qbuks\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class QbuksController extends Controller
{
    public function __construct()
    {}

    public function index()
	{
		return view('admin::index');
	}

    public function create(Request $request)
	{}

    public function store(Request $request)
	{}

    public function show($id)
	{}

    public function edit($id)
	{}

    public function update(Request $request)
	{}

    public function destroy($id)
	{}
}
