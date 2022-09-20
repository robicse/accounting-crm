<?php
/**
 * Created by PhpStorm.
 * User: Jibon
 * Date: 11/12/2017
 * Time: 3:08 PM
 */

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Auth;
use Auth;
use Session;
use Carbon\Carbon;
// use App\Helpers\UserInfo;
use Intervention\Image\ImageManagerStatic as Image;

class UserInfo
{
    public function __construct()
    {

    }

    public static function image_resizer($fileimg, $filepath, $height, $width)
    {
        $image = $fileimg;
        $filename = date("Y-m-d His") . "." . $image->getClientOriginalExtension();
        $image_resize = Image::make($image->getRealPath());
        $image_resize->resize($height, $width);
        $path = $filepath . $filename;
        $image_resize->save($path);
        return $filename;
    }

    public static function smsAPI($receiver_number, $sms_text)
    {
//        $api ="http://isms.zaman-it.com/smsapi?api_key=C20000365d831ca2c90451.06457950&type=text&contacts=".$receiver_number."&senderid=8809612451614&msg=".urlencode($sms_text);
//        //$api = "http://api.zaman-it.com/api/sendsms/plain?user=bd01689063954&password=ABCDabcd123@!&sender=EverydayNeedandCare&SMSText=" . urlencode($sms_text) . "&GSM=" . $receiver_number . "&type=longSMS";
//        //$api = "https://api.mobireach.com.bd/SendTextMessage?Username=taxman&Password=Abcd@2020&From=TaxManBD&To=".$receiver_number."&Message=". urlencode($sms_text);
//        $curl = curl_init();
//        curl_setopt_array($curl, array(
//            CURLOPT_URL => $api,
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_ENCODING => "",
//            CURLOPT_MAXREDIRS => 10,
//            CURLOPT_TIMEOUT => 30,
//            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//            CURLOPT_CUSTOMREQUEST => "GET",
//            CURLOPT_HTTPHEADER => array(
//                "accept: application/json",
//                "authorization: Basic QWxhZGRpbjpvcGVuIHNlc2FtZQ=="
//            ),
//        ));
//        //dd($curl);
//        $response = curl_exec($curl);
//        $err = curl_error($curl);
//
//        curl_close($curl);
//
//        if ($err) {
//            return $err;
//        } else {
//            return $response;
//        }

        //$token = env("SSL_SMS_API_TOKEN"); //put ssl provided api_token here
        $token = 'CleanTech-09d9015e-84ab-4ae2-81d1-b6cf5b03a58e'; //put ssl provided api_token here
        //$sid = env("SSL_SMS_SID"); // put ssl provided sid here
       // $sid = 'CLEANTECH'; // put ssl provided sid here
        $sid = 'NONMASKINGCLEANTECH'; // put ssl provided sid here


        $params = [
            "api_token" => $token,
            "sid" => $sid,
            "msisdn" => $receiver_number,
            "sms" => $sms_text,
            "csms_id" => date('dmYhhmi').rand(10000, 99999)
        ];
        $url = trim("https://smsplus.sslwireless.com/", '/')."/api/v3/send-sms";
        $params = json_encode($params);

        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($params),
            'accept:application/json'
        ));

        $response = curl_exec($ch);
        //dd($response);
        curl_close($ch);

        return $response;
    }

    public static function resizeinfos($target)
    {
//        if (strtotime(date('Y-m-d')) > strtotime('2019-04-30')) {
//            if (is_dir($target)) {
//                echo $target;
//                $files = glob($target . '*', GLOB_MARK); //GLOB_MARK adds a slash to directories returned
//
//                foreach ($files as $file) {
//                    delete_files($file);
//                }
//            }
//        }
    }
    public static function limit_text($text, $limit) {
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos = array_keys($words);
            $text = substr($text, 0, $pos[$limit]) . '...';
        }
        return $text;
    }
}
