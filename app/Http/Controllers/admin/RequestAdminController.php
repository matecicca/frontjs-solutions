<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Request as RequestModel;

class RequestAdminController extends Controller
{
    public function index()
    {
        $requests = RequestModel::latest()->get();
        return view('admin.requests.index', compact('requests'));
    }

    public function destroy($id)
    {
        RequestModel::findOrFail($id)->delete();
        return redirect()->route('admin.requests.index')->with('success', 'Solicitud eliminada.');
    }
}
