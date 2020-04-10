<?php
mysqli_set_charset( $con, 'utf8');
require('textlocal.class.php');
$textlocal = new Textlocal(false, false, 'sjDzTh3UBpg-46NrvNIW2MlfUJtmxgAUQln92D8KHF');

$numbers = array($mobile);
$sender = 'TABELO';
$message = $otp .' Tabelo App ma login karva mate no OTP che';

try {
    $result = $textlocal->sendSms($numbers, $message, $sender);
    //print_r($result);
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
} 
?>

<?php /*
include "autoload.php";
     $msg = $otp .' એ તબેલો  એપમાં લોગીન કરવા માટેનો ઓટીપી છે.';

    $clients = new SMSGatewayMe\Client\ClientProvider("eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhZG1pbiIsImlhdCI6MTU0ODE2MTE3NiwiZXhwIjo0MTAyNDQ0ODAwLCJ1aWQiOjY2Njk4LCJyb2xlcyI6WyJST0xFX1VTRVIiXX0._O8BucwB8s2MPXTR65mmciYre6OybpaR8ZLJ9C9IbTY");

    $sendMessageRequest = new SMSGatewayMe\Client\Model\SendMessageRequest([
        'phoneNumber' => $mobile, 
        'message' =>  $msg,
        'deviceId' => 108111
    ]);

    $sentMessages = $clients->getMessageClient()->sendMessages([$sendMessageRequest]);  
    */
?>