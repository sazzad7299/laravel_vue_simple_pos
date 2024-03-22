<?php
namespace App\Actions;

use App\Models\Sale;
use App\Models\SaleDetails;
use App\Services\SaleService;
use Illuminate\Support\Facades\DB;


class SaleStoreAction
{
    protected $saleService;
    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }
    public function execute(array $requestData)
    {
           DB::beginTransaction();
            try {
                $saleData = $requestData['sale'];
                $saleProductsData = $requestData['saleProducts'];

                $sale = $this->storeSale($saleData);
                $this->storesaleDetails($sale, $saleProductsData);

                DB::commit();

                return $sale;
                } catch (\Throwable $th) {
                DB::rollback();
                    \Log::info($th->getMessage());
                throw $th;
            }
    }

    protected function storeSale(array $saleData)
    {
        return $this->saleService->store($saleData, new Sale());
    }

    protected function storeSaleDetails($sale, array $saleProductsData)
    {
        $saleDetails = [];
        foreach ($saleProductsData as $productData) {
        $productData['sale_id'] = $sale->id;
        $saleDetails[] = $productData;
        }
        SaleDetails::insert($saleDetails);
    }

}
