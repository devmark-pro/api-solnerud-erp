<?php

namespace App\Http\Controllers\WarehouseRemains;

use App\Http\Controllers\Controller;
use App\Services\WarehouseRemains\WarehouseRemainsPurchase\WarehouseRemainsPurchaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;




class WarehouseRemainsPurchaseController extends Controller
{
    public function index(Request $request)
    {
        $requestAll = $request->all();
        return WarehouseRemainsPurchaseService::index($requestAll);
    }
}
