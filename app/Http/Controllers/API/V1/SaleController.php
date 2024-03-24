<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Sale;
use Illuminate\Http\Request;
use App\Services\SaleService;
use App\Actions\SaleStoreAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;

class SaleController extends Controller
{
    protected $saleService;
    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sale = $this->saleService->index($request);

        return $this->respondSuccess($sale, 'Purchase Retrieved Successfully');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSaleRequest $request, SaleStoreAction $saleStoreAction)
    {
        try {
                $requestedData = $request->all();
                // return $requestedData;
                 $saleStoreAction->execute($requestedData);
                $saleinfo = '';
                return $this->respondCreated($saleinfo, 'Purchase Inserted Successfully!');
        } catch (\Throwable $th) {
            \Log::info($th->getMessage());
            return $this->respondError("Sale Faild, Try again later");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $sale = $this->saleService->show($id);

        return $this->respondSuccess($sale, 'Sale Inserted Successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSaleRequest $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
    }
}
