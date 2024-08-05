<?php

namespace App\Http\Controllers\Admin\Manage;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Request as ModelsRequest;

class Request extends Controller
{
    public function getRequests($limit, $offset)
    {
        return ModelsRequest::limit($limit)
            ->offset($offset * $limit)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getTotalRequests()
    {
        return ModelsRequest::count();
    }

    public function deleteRequest($id)
    {
        DB::transaction(function () use ($id) {
            $request = ModelsRequest::find($id);
            $request->delete();
        });
    }

    public function show()
    {
        return view('admin.manage.request.index');
    }
}
