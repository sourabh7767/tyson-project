<?php

namespace App\Console\Commands;

use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SendClockInReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:clockin-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification to users who have not clocked in today';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $currentTime = Carbon::now('America/Denver');
        $currentHour = $currentTime->hour;
        if ($currentTime->isSunday()) {
            $this->info("Today is Sunday. Reminders are not sent on Sundays.");
            return true;
        }
        $settings = Setting::first();

        if(!empty($settings)){
            if($settings->is_cron_on == 1){
                $loginReminderHour = Carbon::parse($settings->start_time)->hour;
                // dd($loginReminderHour);
                $logoutReminderHour = Carbon::parse($settings->end_time)->hour;
                $loginMessage = $settings->start_message;
                $logoutMessage = $settings->end_message;
                echo "Current Hour: $currentHour\n";
                if ($currentHour == $loginReminderHour) {
                    // 8 AM - Check who has not logged in
                    $usersNotLoggedIn = User::where('is_logged_in', 2)->get();
        
                    foreach ($usersNotLoggedIn as $user) {
                        $configResult = $this->fireBaseConfig();
                        // $message = "You have not logged in today. Please remember to log in.";
                        $this->sendFireBasePushNotification($configResult->access_token, $user->fcm_token, "Reminder", $loginMessage);
                    }
        
                    $this->info('Log-in reminders sent successfully.');
                    return true;
                } elseif ($currentHour == $logoutReminderHour) {
                    
                    // 7 PM - Check who has not logged out
                    $usersNotLoggedOut = User::where('is_logged_in', 1)->get();
        
                    foreach ($usersNotLoggedOut as $user) {
                        $configResult = $this->fireBaseConfig();
                        // $message = "You have not logged out yet. Please remember to log out.";
                        $this->sendFireBasePushNotification($configResult->access_token, $user->fcm_token, "Reminder", $logoutMessage);
                    }
        
                    $this->info('Log-out reminders sent successfully.');
                    return true;
                }else{
                    $this->info('No reminders sent. Current timing is not in the reminder timing.');
                }
            }else{
                $this->info('Cron is Turned Off from Admin Side.');
                return true;
            }
        }else{
            $this->info("Cron Timings are not set yet!");
        }
        
        
    }
    public function fireBaseConfig()
{
    $filePath = base_path('service-success-app-firebase-adminsdk-xlhck-8d3d67b876.json');
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
    // dd($response);

    curl_close($curl);
    return $response;

}
}
