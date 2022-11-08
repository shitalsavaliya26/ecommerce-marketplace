<?php
namespace App\Helpers;

use DB;
use Log;
use Auth;
use Exception;
use Edujugon\PushNotification\PushNotification;

class NotificationHelper {

	const FIREBASE_API_KEY = 'AAAAcg_aI7o:APA91bGc8DT1a9hMsyOk09veTLItxRYIj9azbQ9UVbCm6kmun2E0P-6n_Zr7KFldxoT_gGe7VL7PLg3XuuJ_-5DErnQIvdeCYAv9-T5pcYOoY2NBaRHzwzBs23VWDsnjsPlNRUlY85Ty';

	public static function send_pushnotification($user,$title,$message,$is_multiple = 0,$data = null,$type = 1){
		try
		{
			$apnUsers = array();
			$fcmUsers = array();
			$notifyTitle   = $title;
			$notifyMessage = ($message) ? $message: 'New message arrived';
			$apnCertFile = dirname(__FILE__)."/MrWho Push Distribution.pem";
			$unread = 0;

			if($is_multiple == 1){
				foreach($user as $sendUser){
					if($sendUser->device_type == 'ios' && $sendUser->device_token != '' ) {
						$apnUsers[] = $sendUser->device_token;
						$unread = $sendUser->notifications()->whereNull('read_at')->count();
					}

					if($sendUser->device_type == 'android' && $sendUser->device_token != '') {
						$fcmUsers[] = $sendUser->device_token;
						$unread = $sendUser->notifications()->whereNull('read_at')->count();

					}
				}
			}else{

				if($user->device_type == 'ios' && $user->device_token != '' ) {
					$apnUsers[] = $user->device_token;
					$unread = $user->notifications()->whereNull('read_at')->count();
				}

				if($user->device_type == 'android' && $user->device_token != '') {
					$fcmUsers[] = $user->device_token;
					$unread = $user->notifications()->whereNull('read_at')->count();
				}
			}

			if(count($apnUsers)>0)
			{
				$apnPush = self::send_method_in_fcm_service($apnUsers, $notifyTitle, $notifyMessage,$data,$unread,$type);

				Log::info('APN push notification result:');
				Log::info($apnPush);
			}

			if(count($fcmUsers)>0)
			{
				$fcmPush = self::send_method_in_fcm_service($fcmUsers, $notifyTitle, $notifyMessage,$data,$unread,$type);
				Log::info('FCM push notification result:');
				Log::info($fcmPush);
			}
// print_r($apnPush);echo "<br>";print_r($fcmPush);die();

			$apnUsers = array();
			$fcmUsers = array();
		}
		catch (Exception $e)
		{
			echo $e->getMessage();
			Log::info("push notifty send exception:".$e->getMessage()."\n".$e->getTraceAsString());
		}  
	}

	/*new function for send FCM & APN notification*/
	public static function send_method_in_apn_service($userlist, $title, $message,$data)
	{
		// print_r($userlist);die();
		$array = ['type' => 0];
		if($data){
			$array = [
				'type' => 1,
				'order_id' => $data
			];
		}
		$push = new PushNotification('apn');
		$message = [
			'aps' => [
				'alert' => [
					'title' => $title,
					'body'  => $message
				],
				'sound' => 'default',
			],
			'data' => ['type' => 0]
		];
		$push->setMessage($message)
		->setDevicesToken($userlist); 
		$push = $push->send();
		// print_r($push->getFeedback());die();
		return $push->getFeedback()->tokenFailList;
	}

	public static function send_method_in_fcm_service($userlist, $title, $message,$data,$unread,$type)
	{
		$push = new PushNotification('fcm');
		$array = [
			'title' => $title,
			'message'  => $message,
			'type' => 0,
			'badge' => $unread,
			'sound' => 'default'
		];
		if($data){
			$array = [
				'title' => $title,
				'message'  => $message,
				'type' => ($type) ? $type : 1,
				'order_id' => $data,
				'badge' => $unread,
				'sound' => 'default'
			];
		}
		// print_r(json_encode($array));die();
		$push->setMessage([
			'notification' => [
				'title' => $title,
				'body'  => $message,
				'sound' => 'default',
				'badge' => $unread,
			],
			'data' => $array
		])
		->setApiKey(self::FIREBASE_API_KEY)
		->setDevicesToken($userlist)
		->send();
				// print_r($push->getFeedback());die();

		return (isset($push->getFeedback()->results)) ? $push->getFeedback()->results : $push->getFeedback()->error;
	}
}