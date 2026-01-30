<?php

namespace App\Http\Controllers\Report;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Report\SaleReportService;
// use App\Services\Report\SaleReportServise;
use Illuminate\Support\Facades\Gate;


class SaleReportController extends Controller
{

    public function index(Request $request)
    {
        if (!Gate::allows('report_r')) {
            abort(403, "Не достаточно прав");
        }
        $requestAll = $request->all();
        return SaleReportService::index($requestAll);
    }
}
