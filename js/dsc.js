        var c1WrapObj;
		if (window.location.protocol == "https" || true) {
			//var  pluginURL = "https://plugin.bankeauctions.com:9193";
			var pluginURL="http://127.0.0.1:9190";
			//var pluginURL="http://192.168.4.98:9190";
			
		}else{
			var pluginURL="http://127.0.0.1:9190";
		}
        
        //check DSC when normal bid submission Process when complete bid submission is done
        function CheckvalidDSC(auctionId){
            $('#spMsg').html("");
            var mStatus = false;
            
            if($('#dscsecure_checkbox'+auctionId).is(":checked")){
            
            $.ajax({
                url: "/owner/checkbidderlogindSC",
                data: {auctionId:auctionId},
                 type:"post",
                success: function (msg) { 
                  if (msg == 2) { 
                        $('#spMsg'+auctionId).text("Please Login to continue!");
                    } else {
                        if (msg == 1) {
                              c1WrapObj = document.applets.C1SignerWrapper;
                             OutPutString = c1WrapObj.getCertDetails('DS');
                             var cert_serial_no=OutPutString[2];
                              var falid_from=OutPutString[6];
                              var valid_to=OutPutString[5];
                              var signature=OutPutString[1];
                              var cert_file=OutPutString[3];
                              var thum_print=OutPutString[4];
                              
                            if (OutPutString[2] == null) {
                               $('#spMsg'+auctionId).text("Please select a valid certificate.");
                            } else {
                              // if( validateParticipate()){
                                 $.ajax({
                                url: "/owner/checkvaliddsc",
                                data: {
                                    auctionId:auctionId,
                                    cert_file:cert_file,
                                    cert_serial_no:cert_serial_no,
                                    falid_from:falid_from,
                                    valid_to:valid_to,
                                    signature:signature,
                                    thum_print:thum_print,
                                
                                },
                                 type:"post",
                                success: function (msg) {
                                   if(msg==1){ 
                                      $('#spMsg'+auctionId).text("Your DSC details have saved successfully");
                                      window.location.reload();
                                     return true;
                                  }if(msg==3){
                                     $('#spMsg'+auctionId).text("Your Dsc is not verified");  
                                      return false;
                                  }
                                  if(msg==5){ 
                                     $('#spMsg'+auctionId).text("DSC Expired");  
                                     return false;
                                  }
                                   if(msg==0){ 
                                     $('#spMsg'+auctionId).text("No Dsc Regarding this auction Found");  
                                     return false;
                                  }
                                }}); 
                           }
                           
                        } 
                        else if (msg == 3) {
                            $('#spMsg'+auctionId).text("Your account has been disabled, Please contact to Auction Administrator !!");
                        }
                        
                    }
                },
                failure: function (response) {
                    alert('Service call failed: ' + response.status + ' Type :' + response.statusText);
                }
            }); 
        }else{
            $('#spMsg'+auctionId).text("Please Accept Terms and condition");
           }
        } 


		 //check DSC when normal bid submission Process when complete bid submission is done
        function CheckvalidNewDSC(){			
				$('#spMsg').html("");
				var selected = $("#certlist_ac").find("tr").hasClass('selected');
				if(selected)
				{
					var auctionId = $("#check_dsc_auctionID_ac").val();
					//alert(auctionId + " | " +certSerialNo);
					//return false;
				   
					var mStatus = false;
					$.ajax({
						url: "/owner/checkbidderlogindSC",
						data: {auctionId:auctionId},
						 type:"post",
						success: function (msg) {
						  if (msg == 2) { 
								$('#spMsg'+auctionId).text("Please Login to continue!");
							} else {
								if (msg == 1) {
									var qs = {alias: certSerialNo};
									$.ajax({
											 url: pluginURL+"/certificate/detail", 
											 type: "GET",
											 data: qs,
											 success: function(result){
												// result1 =JSON.parse(result);
											// console.log(result1);
											// return false;
											 
											  var obj = jQuery.parseJSON(result);

											  var cert_serial_no=obj.SerialNo;
											  var falid_from=obj.IssueDate;
											  var valid_to=obj.ExpDate;
											  var signature=obj.Owner;
											  var cert_file=obj.publicKey;
											  var thum_print=obj.Thumbprint;
											  //alert(cert_serial_no);
											if (typeof cert_serial_no == 'undefined' || cert_serial_no == '') {
											   $('#spMsg'+auctionId).text("Please select a valid certificate.");
											   //alert('Please select a valid certificate.');	
											   swal('Error','Please select a valid certificate.','error')										   
											} else {
											  // if( validateParticipate()){
												 $.ajax({
												url: "/owner/checkvaliddsc",
												data: {
													auctionId:auctionId,
													cert_file:cert_file,
													cert_serial_no:cert_serial_no,
													falid_from:falid_from,
													valid_to:valid_to,
													signature:signature,
													thum_print:thum_print,
												
												},
												 type:"post",
												success: function (msg) {
													$.colorbox.close();
												   if(msg==1){ 
													  $('#spMsg'+auctionId).text("Your DSC details have saved successfully");
													  //alert("Your DSC details have saved successfully");
													  swal('Success','Your DSC details have saved successfully','success')

													  setTimeout(function(){
														  window.location.reload();
													  },2000);
													 return true;
												  }if(msg==3){
													 $('#spMsg'+auctionId).text("Your DSC is not verified"); 
													 //alert("Your Dsc is not verified");
													 swal('Error','Your DSC is not verified','error')
													  return false;
												  }
												  if(msg==5){ 
													 $('#spMsg'+auctionId).text("Your DSC is expired");
													 //alert("Your Dsc is expired");
													 swal('Error','Your DSC is expired','error')
													 return false;
												  }
												   if(msg==0){ 
													 $('#spMsg'+auctionId).text("No Dsc Regarding this auction Found");  
													 //alert("No Dsc Regarding this auction Found");
													 swal('Error','No DSC Regarding this auction found','error')
													 return false;
												  }
												}}); 
										   }
										  
										   
										} 
										});
										
									}
									else if (msg == 3) {
										$('#spMsg'+auctionId).text("Your account has been disabled, Please contact to Auction Administrator !!");
										//alert("Your account has been disabled, Please contact to Auction Administrator !!");
										swal('Error','Your account has been disabled, Please contact to Auction Administrator !!','error')
									}
								
							}
							
						},
						failure: function (response) {
							//alert('Service call failed: ' + response.status + ' Type :' + response.statusText);
							swal('Error','Service call failed: ' + response.status + ' Type :' + response.statusText,'error')
						}
					}); 			
				} 
				else
				{
					//alert("Kindly select certificate");
					swal('Error','Kindly select certificate.','error')
				}
			}
			
		


         //check DSC when  bidder is added through Help Desk Executive
          function CheckvalidDSC_helpdesk(auctionId){
              $('#spMsg').html("");
              var mStatus = false;
            if($('#dscsecure_checkbox'+auctionId).is(":checked")){
                $.ajax({
                url: "/owner/checkbidderlogindSC",
                data: {auctionId:auctionId},
                 type:"post",
                success: function (msg) { 
                  if (msg == 2) { 
                        $('#spMsg'+auctionId).text("Please Login to continue!");
                    } else {
                        if (msg == 1) {
                              c1WrapObj = document.applets.C1SignerWrapper;
                             OutPutString = c1WrapObj.getCertDetails('DS');
                             var cert_serial_no=OutPutString[2];
                              var falid_from=OutPutString[6];
                              var valid_to=OutPutString[5];
                              var signature=OutPutString[1];
                              var cert_file=OutPutString[3];
                              var thum_print=OutPutString[4];
                              
                            if (OutPutString[2] == null) {
                               $('#spMsg'+auctionId).text("Please select a valid certificate.");
                            } else {
                                 $.ajax({
                                url: "/owner/checkdsclogin_helpdesk",
                                data: {
                                    auctionId:auctionId,
                                    cert_file:cert_file,
                                    cert_serial_no:cert_serial_no,
                                    falid_from:falid_from,
                                    valid_to:valid_to,
                                    signature:signature,
                                    thum_print:thum_print,
                                    },
                                 type:"post",
                                success: function (msg) {
                                   if(msg==1){ 
                                      $('#spMsg'+auctionId).text("Your DSC details have saved successfully");
                                      window.location.reload();
                                     return true;
                                  }if(msg==3){
                                     $('#spMsg'+auctionId).text("Your DSC is not verified");  
                                      return false;
                                  }
                                  if(msg==5){ 
                                     $('#spMsg'+auctionId).text("DSC Expired");  
                                     return false;
                                  }
                                   if(msg==0){ 
                                     $('#spMsg'+auctionId).text("No DSC Regarding this auction Found");  
                                     return false;
                                  }
                                }}); 
                           }
                        } 
                        else if (msg == 3) {
                            $('#spMsg'+auctionId).text("Your account has been disabled, Please contact to Auction Administrator !!");
                        }
                        
                    }
                },
                failure: function (response) {
                    alert('Service call failed: ' + response.status + ' Type :' + response.statusText);
                }
            }); 
        }else{
            $('#spMsg'+auctionId).text("Please Accept Terms and condition");
           }
        } 
        function validatDSCform(auctionId) {
            $('#spMsg').html("");
            var mStatus = false;
            $.ajax({
                url: "/owner/checkbidderlogindSC",
                data: {auctionId:auctionId},
                 type:"post",
                success: function (msg) { 
                    if (msg == 2) { 
                        $('#spMsg').text("Please Login to continue!");
                    } else {
                        if (msg == 1) { 
                    //   if(validateParticipate('final_save')){
                              c1WrapObj = document.applets.C1SignerWrapper;
                              OutPutString = c1WrapObj.getCertDetails('DS');
                              var cert_serial_no=OutPutString[2];
                              var falid_from=OutPutString[6];
                              var valid_to=OutPutString[5];
                              var signature=OutPutString[1];
                              var cert_file=OutPutString[3];
                              var thum_print=OutPutString[4];
                            if (OutPutString[2] == null) {
                              $('#spMsg').text("Please select a valid certificate.");
                            }
                            else {
                                 $.ajax({
                                url: "/owner/checkdsclogin",
                                data: {
                                    auctionId:auctionId,
                                    cert_file:cert_file,
                                    cert_serial_no:cert_serial_no,
                                    falid_from:falid_from,
                                    valid_to:valid_to,
                                    signature:signature,
                                    thum_print:thum_print,
                                
                                },
                                 type:"post",
                                success: function (msg) {
                                   if(msg==1){ 
                                    $('#spMsg').text("Your DSC details have saved successfully");
                                    window.location.reload();
                                      return true;
                                  }if(msg==3){
                                     $('#spMsg').text("Your Dsc is expired");  
                                      return false;
                                  }
                                  if(msg==2){
                                     $('#spMsg').text("DSC already implemented");  
                                     return false;
                                  }
                                }}); 
                            }
                        //}
                        }
                        else if (msg == 3) {
                            $('#spMsg').text("Your account has been disabled, Please contact to Auction Administrator !!");
                        }
                    }
                },
                failure: function (response) {
                    alert('Service call failed: ' + response.status + ' Type :' + response.statusText);
                }
            });
        }


	function checkDSC(auctionId) {	
		//alert(auctionId);			
		var selected = $("#certlist").find("tr").hasClass('selected');
		if(selected)
		{
			//alert(certSerialNo); 
			//return false;
            $('#spMsg').html("");
            var mStatus = false;
            $.ajax({
                url: "/owner/checkbidderlogindSC",
                data: {auctionId:auctionId},
                 type:"post",
                success: function (msg) {
                    if (msg == 2) { 
                        $('#spMsg').text("Please Login to continue!");
                    } else {
                        if (msg == 1) { 
							
							var qs = {alias: certSerialNo};
							$.ajax({
									 url: pluginURL+"/certificate/detail", 
									 type: "GET",
									 data:qs,
									 success: function(result){
										// result1 =JSON.parse(result);
									// console.log(result1);
									// return false;
									 
									  var obj = jQuery.parseJSON(result);

	 
									  var cert_serial_no=obj.SerialNo;
									  var falid_from=obj.IssueDate;
									  var valid_to=obj.ExpDate;
									  var signature=obj.Owner;
									  var cert_file=obj.publicKey;
									  var thum_print=obj.Thumbprint;
								  if (typeof cert_serial_no == 'undefined' || cert_serial_no == '') {
									  $('#spMsg').text("Please select a valid certificate.");
									  //alert("Please select a valid certificate.");
									  swal('Error','Please select a valid certificate.','error')
									}
									else {
										$('.participateBtn').css('display','none');
										$('.rfq-loader').css('display','block');
										$.ajax({
										url: "/owner/checkdsclogin",
										data: {
											auctionId:auctionId,
											cert_file:cert_file,
											cert_serial_no:cert_serial_no,
											falid_from:falid_from,
											valid_to:valid_to,
											signature:signature,
											thum_print:thum_print,
										
										},
										 type:"post",
										success: function (msg) {
											$.colorbox.close();
										   if(msg==1){ 											
											$('#spMsg').text("Your DSC details have saved successfully");
											//alert("Your DSC details have saved successfully");
											swal('Success','Your DSC details have saved successfully','success')
											setTimeout(function(){												
												$('.rfq-loader').css('display','none');
												window.location.reload();
											},2000);
											  return true;
										  }if(msg==3){
											 $('#spMsg').text("Your Dsc is expired");  
											// alert("Your Dsc is expired");
											 swal('Error','Your DSC is expired','error')
											 $('.participateBtn').css('display','block');
											 $('.rfq-loader').css('display','none');
											 return false;
											  }
											  if(msg==2){
												 $('#spMsg').text("DSC already implemented");  
												 //alert("DSC already implemented");
												 swal('Error','DSC already implemented','error')
												 $('.participateBtn').css('display','block');
												 $('.rfq-loader').css('display','none');
												 return false;
											  }
											}}); 
										}
									 }
								
								 });
							}
							else if (msg == 3) {
								$('#spMsg').text("Your account has been disabled, Please contact to Auction Administrator !!");
								//alert("Your account has been disabled, Please contact to Auction Administrator !!");
								swal('Error','Your account has been disabled, Please contact to Auction Administrator !!','error')
							}
						}
					},
					failure: function (response) {
						//alert('Service call failed: ' + response.status + ' Type :' + response.statusText);
						swal('Error','Service call failed: '+ response.status + ' Type :' + response.statusText,'error')
					}
				});
			}
			else
			{
				//alert("Kindly select certificate to participate.");
				swal('Error','Kindly select certificate to participate.','error')
			}
        }
