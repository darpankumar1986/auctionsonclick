<?PHP
$record_array=explode("-",$hash);
$email=$record_array['1'];
$hash=urlencode($hash);
$url=base_url()."registration/forgot_password_do-".$hash; 


$content="<p>Hello,</p>";

$content.="<p>A request has been made to reset your Bankeauction account password.
	</p>";
	
	$message='<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Untitled Document</title>
	</head>

	<body style="background:#eee; margin-bottom:0px; margin-left:0px; margin-right:0px; margin-top:0px;"><table width="700" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
	  <tr>
		<td align="left" valign="top">
		<table width="700" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td align="left" valign="top" width="20" style="border-bottom:10px solid #fff; border-top:10px solid #fff;">&nbsp;</td>
		<td align="left" valign="top" style="border-bottom:10px solid #fff; border-top:10px solid #fff;"><img src="http://bankauction.afaqsdelhi.com/images/logo.png" style="border:0; outline:0;" /></td>
		<td align="left" valign="top" style="border-bottom:10px solid #fff; border-top:10px solid #fff;">&nbsp;</td>
	  </tr>
	  
	</table>

		</td>
	  </tr>
		<tr>
		<td align="left" valign="top" bgcolor="0068b7" height="5"></td>
	  </tr>
	   <tr>
		<td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; border-left:10px solid #fff; border-right:10px solid #fff; border-bottom:10px solid #fff; border-top:10px solid #fff;">';
		$message.=$content;
		$message.='</td>
	  </tr>
	  <tr>
		<td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; border-left:10px solid #fff; border-right:10px solid #fff; border-bottom:10px solid #fff; border-top:10px solid #fff;">
		
		</td>
	  </tr>	
	  <tr>
		<td align="left" valign="top"><table width="660" border="0" align="center" cellpadding="0" cellspacing="0">
		   <tr>
			 <td colspan="2" align="left" valign="top" height="10"></td>
			</tr>
			<tr>
			 <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold; color:#333;">Email :';			
			 //$message.=$url;
			//$message.='<a href="';
			//$message.=$url;
			//$message.='">';
			//$message.=$url;
			//$message.='</a>';
			$message.= $email;
			 
			 $message.='</td>
		   </tr>
		   <tr>
			 <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold; color:#333;">Password :';			
			 //$message.=$url;
			//$message.='<a href="';
			//$message.=$url;
			//$message.='">';
			//$message.=$url;
			//$message.='</a>';
			$message.= $password;
			 
			 $message.='</td>
		   </tr>
			
			<tr>
			 <td colspan="2" align="left" valign="top" height="10"></td>
			</tr>
			
		    <tr>
			 <td colspan="2" align="left" valign="top" height="10"><p><b>Regards,</b></p> 
			    <p><b>Bankeauction Admin </b></p></td>
			</tr>
			
			<tr>
			 <td colspan="2" align="left" valign="top" height="10"></td>
			</tr>
			
		</table>
		</td>
	  </tr>
	  <tr>
		<td align="center" valign="middle" bgcolor="0068b7" height="30" style="color:#fff; font-size:15px;">&copy; 2015 by Bankeauction
	</td>
	  </tr>
	</table>
	</body>
	</html>';
	
	$to=$email;
	$subject="Your Bankeauction password reset url " ;
	$from="admin@bankeauction.com";
	
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$headers .= "From:$from\r\n";
    $headers .= "X-Mailer: PHP v".phpversion()."\n";

	@mail($to,$subject,$message,$headers,"-f $from");
	
?>