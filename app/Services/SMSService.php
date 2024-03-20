<?php
namespace App\Services;

class SMSService{
    
  public function releans($message, $to)
  {
      $curl = curl_init();
  
      $from = env('RELEANS_API_FROM'); // Get sender ID from environment variable
      curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.releans.com/v2/message",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => "sender=$from&mobile=$to&content=$message",
          CURLOPT_HTTPHEADER => array(
              "Authorization: Bearer " . env('RELEANS_API_KEY') // Get API key from environment variable
          ),
      ));
  
      $response = curl_exec($curl);
  
      curl_close($curl);
      echo $response;
  }
}