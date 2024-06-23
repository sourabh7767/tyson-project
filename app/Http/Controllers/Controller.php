<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Mail;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendEmail($toEmail,$toName,$subject,$body,$viewName='mail',$param=array()){

        // $fromEmail = ;
        try {
            Mail::send($viewName, $param, function ($m) use ($toEmail,$toName,$subject) {
            $m->from(env('MAIL_FROM_ADDRESS','smtp@itechnolabs.tech'), env('MAIL_FROM_NAME','Safe Exam'));

            $m->to($toEmail, $toName)->subject($subject);
        }); 
    }catch (Exception $ex) {
            \Log::info($ex->getMessage());
        }
            
    }
    public function fireBaseConfig()
{
    $filePath = base_path('service-success-app-firebase-adminsdk-xlhck-0530286d04.json');
    $authConfigString = file_get_contents($filePath);
    // Parse service account details
    $authConfig = json_decode($authConfigString);
    // return $authConfig->client[0]->api_key[0]->current_key;
    // Read private key from service account details
    $secret = openssl_get_privatekey($authConfig->private_key);
    
    // Create the token header
    $header = json_encode([
        'typ' => 'JWT',
        'alg' => 'RS256'
    ]);
    
    // Get seconds since 1 January 1970
    $time = time();
    
    
    $payload = json_encode([
        "iss" => $authConfig->client_email,
        "scope" => "https://www.googleapis.com/auth/firebase.messaging",
        "aud" => "https://oauth2.googleapis.com/token",
        "exp" => $time + 3600,
        "iat" => $time
    ]); 
    
    // Encode Header
    $base64UrlHeader = $this->base64UrlEncode($header);
    
    // Encode Payload
    $base64UrlPayload = $this->base64UrlEncode($payload); 
    
    
    // Create Signature Hash
    $result = openssl_sign($base64UrlHeader . "." . $base64UrlPayload, $signature, $secret, OPENSSL_ALGO_SHA256);
    
    // Encode Signature to Base64Url String
    $base64UrlSignature = $this->base64UrlEncode($signature);
    
    // Create JWT
    $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    
    //-----Request token------
    $options = array('http' => array(
        'method'  => 'POST',
        'content' => 'grant_type=urn:ietf:params:oauth:grant-type:jwt-bearer&assertion='.$jwt,
        'header'  =>
            "Content-Type: application/x-www-form-urlencoded"
    ));
    $context  = stream_context_create($options);
    $responseText = file_get_contents("https://oauth2.googleapis.com/token", false, $context);
    
    return json_decode($responseText);
}
function base64UrlEncode($text)
{
    return str_replace(
        ['+', '/', '='],
        ['-', '_', ''],
        base64_encode($text)
    );
}

public function sendFireBasePushNotification($authToken,$fcmToken,$title = "",$message = "",$extraData = []){
    // $data = json_encode([
    //     "message" => [
    //         "token" => $fcmToken,
    //         "notification" => [
    //             "body" => $message,
    //             "title" => $title,
    //             ""
    //         ],
    //         "data" => [
    //             "key" => "skjfdsnf",
    //         ],
    //     ]
    // ]);
    $encodedData = json_encode($extraData);
    $data = '{
   "message":{
      "token":"'.$fcmToken.'",
      "notification":{
        "body":"'.$message.'",
        "title":"'.$title.'"
      },
      "data":{
        "key":"'.$encodedData.'"
      }
   }
}';
   $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://fcm.googleapis.com/v1/projects/service-success-app/messages:send',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $data,
    CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer $authToken",
        'Content-Type: application/json'
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;

}
}
