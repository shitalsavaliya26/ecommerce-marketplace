<?php
namespace App\Helpers;


class PaymentHelper
{
	public static function requestSignature($refno,$amount){
		return hash('sha256',config('services.IPAY_MERCHANT_KEY').config('services.IPAY_MERCHANT_CODE')  . $refno . $amount . 'MYR' );
	}

}