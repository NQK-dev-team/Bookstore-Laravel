<?php

namespace App\Http\Controllers\General;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

class File extends Controller
{
    public function handleImage(Request $request)
    {
        // Decode the path
        $path = urldecode($request->path);

        $pathToFile = storage_path('app/' . $path);
        $headers = [
            'Content-Type' => mime_content_type($pathToFile),
            'Content-Length' => filesize($pathToFile),
        ];

        return response()->file($pathToFile, $headers);
    }

    public function handlePDF(Request $request)
    {
        if (!auth()->check())
            abort(401);
        else {
            if (!auth()->user()->is_admin) {
                $id = $request->id;

                if (
                    !Order::where(function (Builder $query) use ($id) {
                        $query->orWhereHas('physicalOrder.physicalCopies', function (Builder $sub_query) use ($id) {
                            $sub_query->where('physical_copies.id', $id);
                        })->orWhereHas(
                            'fileOrder.fileCopies',
                            function (Builder $sub_query) use ($id) {
                                $sub_query->where('file_copies.id', $id);
                            }
                        );
                    })
                        ->where([
                            ['customer_id', '=', auth()->id()],
                            ['status', '=', 'true']
                        ])->exists()
                )
                    abort(403);
            }

            // Decode the path
            $path = urldecode($request->path);

            $pathToFile = storage_path('app/' . $path);
            $headers = [
                'Content-Type' => mime_content_type($pathToFile),
                'Content-Length' => filesize($pathToFile),
            ];

            return response()->file($pathToFile, $headers);
        }
    }
}
