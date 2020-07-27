/**
     * @return currency conversion array
     */
	public function getCurrencyConversion($currency_data = array(),$isCron)
	{
		
		if(count($currency_data) == 0)
		{
			$currency_data = array("USDAUD", "USDBGN", "USDHRK", "INRUSD" ,"INREUR", "INRGBP", "INRAED", "INRAUD", "INRCAD", "INRINR");
		}
		$datastr = implode("%22,%20%22",$currency_data);
		$datatablestr = implode("','",$currency_data);
		
		$TblCurrency1 = TblCurrency::find("id IN ('".$datatablestr."') ");
		if($TblCurrency1->count() != count($currency_data) || $isCron === true)
		{
			$url='http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.xchange%20where%20pair%20in%20%28%22'.$datastr.'%22%29&format=json&env=store://datatables.org/alltableswithkeys';
		  
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$url);	
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		    	if ($debug=true)
			{
				$result['contents']=curl_exec($ch);
				$result['info']=curl_getinfo($ch);
			}  

		   	 $result =curl_exec($ch);
		    	 curl_close($ch);
	   	         $currencyArr = json_decode($result);
			

		    	foreach($currencyArr->query->results->rate as $rate)
		     	{
					$TblCurrency = new TblCurrency();  
					$TblCurrency1 = TblCurrency::findFirst("id = '".$rate->id."' ");
								  
					$dateArr = explode("/",$rate->Date);	    
			  
					$datetime = date("Y-m-d H:i:s",strtotime($dateArr[2].'-'.$dateArr[0].'-'.$dateArr[1]." ".$rate->Time));					   	
					foreach($rate as $key => $value)
					  {
						  $TblCurrency->$key = $value;
				
					  }	
				
							
					 $TblCurrency->Date = $datetime;	
				

					if($TblCurrency1)
					{
						 foreach($rate as $key => $value)
						  {
				
							$TblCurrency1->$key = $value;

						  }	
						   $TblCurrency1->Date = $datetime;
						   //echo 'update';
						   $res = $TblCurrency1->update();
					}
					else
					{			
						//echo 'save';
						$res =  $TblCurrency->save();			
					}				

			}
		}
		else
		{
			$currencyArr->query->results->rate = array();
			foreach($TblCurrency1 as $key => $row)
			{
				if(!isset($currencyArr->query->results->rate[$row->id]))
				{
					$currencyArr->query->results->rate[$row->id]->Id = $row->id;
					$currencyArr->query->results->rate[$row->id]->Name = $row->Name;
					$currencyArr->query->results->rate[$row->id]->Rate = $row->Rate;
				}
			}

		}
		
	    return $currencyArr;
	}