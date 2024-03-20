<?php
namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use App\Services\SMSService;
use App\Services\SettingsService;
use App\Http\Requests\UpdateSMSRequest;
use App\Http\Requests\UpdateSmtpRequest;
use App\Http\Requests\StoreSettingsRequest;
use App\Http\Requests\UpdateSettingsRequest;
use App\Http\Requests\UpdateGeneralInfoRequest;

class SettingsController extends Controller
{
    protected $settings;
    protected $sms;
    public function __construct(SettingsService $settings, SMSService $sms)
    {
        $this->settings = $settings;
        $this->sms = $sms;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreSettingsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Settings $settings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Settings $settings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSettingsRequest $request, Settings $settings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Settings $settings)
    {
        //
    }

    public function smtp()
    {

        $smtpConfig = $this->settings->smtp();

        return $this->respondSuccess($smtpConfig, 'SMTP Retrieved Successfully');
    }

    public function smtpUpdate(UpdateSmtpRequest $request){
        try {
            $this->settings->updateSettings($request);
            $this->settings->updateEnvFile($request->validated());
            return $this->respondSuccess('','SMTP Updated Successfully');
        } catch (\Throwable $th) {
            return $this->respondError($th->getMessage());
        }

    }
    public function generalinfo()
    {

        $info = $this->settings->getCompanySettings();

        return $this->respondSuccess($info, 'Company Info Retrieved Successfully');
    }
    public function generalinfoUpdate(UpdateGeneralInfoRequest $request){
        try {
            $this->settings->updateSettings($request);
            return $this->respondSuccess('','Company infromation Updated');
        } catch (\Throwable $th) {
            return $this->respondError($th->getMessage());
        }

    }
    public function smsinfo()
    {

        $smtpConfig = $this->settings->smsinfo();
        
        return $this->respondSuccess($smtpConfig, 'SMS DATA Retrieved Successfully');
    }
    public function smsinfoUpdate(UpdateSMSRequest $request){
        try {
            $this->settings->updateSettings($request);
            $this->settings->updateEnvFile($request->validated());
            return $this->respondSuccess('','SMS SYSTEM  Updated Successfully');
        } catch (\Throwable $th) {
            return $this->respondError($th->getMessage());
        }

    }
}