<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');
define('AUCTION_EXTENDED_TIME_BEFORE_AUCTION_END',		'5');
define('BIDDER_AUCTION_END_MESSAGE_TIME','10'); // time in second

define('JDA_TITLE','Property Auctions :: Auction'); // time in second
//define('BRAND_NAME','Development Authority');
define('BRAND_NAME','AuctionsOnClick');
//echo $_SERVER['HTTP_HOST'];
if($_SERVER['HTTP_HOST'] == 'propertyauctions.com' || $_SERVER['HTTP_HOST'] == 'www.propertyauctions.com' || $_SERVER['HTTP_HOST'] == 'property.easyauctions.in:8080'|| $_SERVER['HTTP_HOST'] =='125.63.68.28:8080' || $_SERVER['HTTP_HOST'] =='192.168.10.122:8080' || $_SERVER['HTTP_HOST'] == 'propertyauctions.c1india.com') // && false
{
	define('LOCAL_URL', true);
}
else
{
	define('LOCAL_URL', false);
}

$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
{
	define('MOBILE_VIEW',true);
}
else
{
	define('MOBILE_VIEW',false);
}


/* Axis bank payment gateway contants Start*/
define('AXIS_KEY','axis');
define('AXIS_ENCRYPTION_KEY','axisbank12345678');
define('AXIS_PAYMENT_URL','https://uat-etendering.axisbank.co.in/index.php/api/payment');
/* Axis bank payment gateway contants End*/


/* device id*/
define('DEVICE_ID','lenovo_vibe_k6_pwr_9875');

/* PAYU GATEWAY */
define('PAYU_MERCHANT_KEY','gtKFFx'); // PAYU MERCHANT_KEY
define('PAYU_SALT','eCwWELxi'); // PAYU SALT
define('PAYU_BASE_URL','https://test.payu.in'); // PAYU PAYU_BASE_URL
//define('PAYU_BASE_URL','https://secure.payu.in'); // PAYU PAYU_BASE_URL
/* End payment */


define('REGISTRATION_FEE','1000'); // PAYMENT REGISTRATION AMOUNT 1800 18 324 2124
define('TAX_RATE','18'); // PAYMENT REGISTRATION AMOUNT 1800 18 324 2124
define('TAX_AMOUNT','180'); // PAYMENT REGISTRATION AMOUNT 1800 18 324 2124
define('REGISTRATION_AMOUNT','1180'); // PAYMENT REGISTRATION AMOUNT 1800 18 324 2124


define('SITE_LOGO','logo.png');

define('BANK_PROCESSING_FEE','2950');
define('ADMINISTRATIVE_FEE','0');


//C1india SMS API 
//define('SMSAPIURL',"http://43.240.66.10/unified.php?usr=24934&pwd=~C1@india~&ph=%%mobile%%&sndr=SCWIND&text=%%msg%%");
define('SMSAPIURL',"");


/* Ccavenue payment gateway contants Start Testing Auction Fee*/
define('CCAV_WORKING_KEY_AUCTION_FEE','DB0BDA650FCB149AA540BFF9EC4A1DB0');
define('CCAV_ACCESS_CODE_AUCTION_FEE','AVWP78FF71BP95PWPB');
define('CCAV_MERCHANT_ID_AUCTION_FEE','179729');
define('CCAV_PAYMENT_URL_AUCTION_FEE',' https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction');

/* Ccavenue bank payment gateway contants End*/

/* Ccavenue payment gateway contants Start Testing Registration Fee*/
define('CCAV_WORKING_KEY','DB0BDA650FCB149AA540BFF9EC4A1DB0');
define('CCAV_ACCESS_CODE','AVWP78FF71BP95PWPB');
define('CCAV_MERCHANT_ID','179729');
define('CCAV_PAYMENT_URL',' https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction');

/* Ccavenue bank payment gateway contants End*/



/* Ccavenue payment gateway contants Start Live Auction Fee*/
/*
define('CCAV_WORKING_KEY_AUCTION_FEE','450D0B495197008E998FEC4B31085224');
define('CCAV_ACCESS_CODE_AUCTION_FEE','AVDE85GE17AM97EDMA');
define('CCAV_MERCHANT_ID_AUCTION_FEE','217909');
define('CCAV_PAYMENT_URL_AUCTION_FEE','https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction');
*/
/* Ccavenue bank payment gateway contants End*/


/* Ccavenue payment gateway contants Start Live Registration Fee*/
/*
define('CCAV_WORKING_KEY','E1360243327072C7BC86CB4881E471A4');
define('CCAV_ACCESS_CODE','AVMV84GD80BT95VMTB');
define('CCAV_MERCHANT_ID','216019');
define('CCAV_PAYMENT_URL','https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction');
*/
/* Ccavenue bank payment gateway contants End*/


define('NEFT_STATUS_CHECK_DAYS','15');

/* Payment Gateway on/off flag */
define('IS_PAYMENT_GATEWAY_OFF',FALSE);


$random = '67894567345';
$random = rand(1000000000,9999999999);
define('CACHE_RANDOM',$random);

define('FREE_SUBSCRIPTION_TIME','+1 days');
//define('FREE_SUBSCRIPTION_TIME','+1 months');

/* End of file constants.php */
/* Location: ./application/config/constants.php */
