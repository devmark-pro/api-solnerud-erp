<?php

namespace App\Http\Controllers\Report;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Services\Report\WarehouseRemainReportService;


class WarehouseRemainReportController extends Controller
{

    public function index(Request $request)
    {
        if (!Gate::allows('report_r')) {
            abort(403, "Не достаточно прав");
        }
        $requestAll = $request->all();
        return WarehouseRemainReportService::index($requestAll);
    }
}
