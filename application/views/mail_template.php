<?PHP

$content="Thank you for joining Bankeauction";
	
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
		<td align="left" valign="top" style="border-bottom:10px solid #fff; border-top:10px solid #fff;"><img src="http://bankauction.afaqsdelhi.com/images/logo.jpg" style="border:0; outline:0;" /></td>
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
		<td align="left" valign="top"><table width="660" border="0" align="center" cellpadding="0" cellspacing="0">
		  <tr>
			<td align="left" valign="top" width="30%">Your credential is:</td>
			<td align="left" valign="top" height="70%">&nbsp;</td>
		  </tr>
		  <tr>
			<td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold; color:#333;">User Name</td>
			<td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:normal; color:#333;">';
			$message.=$email_id;
			
			$message.='</td>
		  </tr>
		   <tr>
			 <td colspan="2" align="left" valign="top" height="10"></td>
			</tr>
		   <tr>
			 <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold; color:#333;">Password</td>
			 <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:normal; color:#333;">';
			 $message.=$password;
			 
			 $message.='</td>
		   </tr>
		  
		  <tr>
			 <td colspan="2" align="left" valign="top" height="10"></td>
			</tr>
		</table>
		</td>
	  </tr>
	  <tr>
		<td align="center" valign="middle" bgcolor="0068b7" height="30" style="color:#fff; font-size:15px;">© 2015 by Bankeauction</td>
	  </tr>
	</table>
	</body>
	</html>';
	//echo $message;
	
	$to=$email_id; 
	$subject="Bankeauction Registration Details" ;
	$from="admin@outlookBusiness.com";
	
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$headers .= "From:$from\r\n";
    $headers .= "X-Mailer: PHP v".phpversion()."\n";

	@mail($to,$subject,$message,$headers,"-f $from");
	
?>