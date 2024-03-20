<?php

namespace App\Http\Controllers\API\V1;

use Exception;
use Throwable;
use Illuminate\Http\Request;
use App\Services\LanguageService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class LanguageController extends Controller
{
    protected $language;
    public function __construct(LanguageService $language)
    {
        $this->language = $language;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lang = $this->language->get();
        return $this->respondSuccess($lang, 'Retrive language');
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
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $this->language->store($request);
            DB::commit();

            return response()->json('Add Successfully!', 201);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();

            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $code)
    {
        try {
            $this->language->delete($code);

            return $this->respondSuccess('','Language deleted successfully');
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }
    public function allCodes()
    {
        try {
            $data = $this->language->allCodes();

            return $this->respondSuccess($data,'get all codes');
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }
    public function updateStatus(Request $request)
    {
        try {
            $this->language->updateStatus($request);

            return $this->respondSuccess('','Update Status');
        } catch (\Throwable $e) {
            return $this->respondError($e->getMessage());
        }
    }
    public function getTranslate($code)
    {
        try {
            $data = $this->language->getTranslateData($code);

            return $this->respondSuccess($data,'Load language key successfully');
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            return response()->json($e->getMessage(), 500);
        }
    }
    //this is for single translate
    // public function translateSubmit(Request $request, $code)
    // {
    //     try {
    //         $this->language->translateSubmit($request, $code);
    //         return $this->respondSuccess('','Updated Translate Key');
    //     } catch (\Throwable $e) {
        
    //         return response()->json($e->getMessage(), 500);
    //     }
    // }

    // this for all code translate singe time
    public function translateSubmit(Request $request, $code)
    {
        try {
             $code =  $this->language->translateSubmit($request, $code);
            return $this->respondSuccess($code,'Updated Translate Key');
        } catch (\Throwable $e) {
        
            return $this->respondError($e->getMessage());
        }
    }

    


}