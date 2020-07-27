'use strict';
var useAction; 
var certSerialNo="";
var contextPath=contextPathMain;
var    uibModalInstance=null;
//var pluginURL=document.getElementById("pluginURL").value;alert("pluginURL in controller "+pluginURL);
//var pluginURL="https://plugin.eproc.in:9193";
var pluginURL="http://localhost:9190";
postApp.controller('controller',['$scope','$window','$http','$uibModal',function($scope, $window, $http,$uibModal) {
	//alert("hiiiiii");	
	 $scope.getDataHash=function(controlValss,alogtype){
		//alert(controlValss+"<=====>"+alogtype);
		var retval;
		var qs = {data:controlValss,hashAlg:alogtype};
       	$.ajax({
	    		 url: "http://localhost:9190/data/getHash", 
	    		 type: "GET",
	    		 data:qs,
	    		 success: function(result){
	    		 console.log(result);
	    		 //alert(result);
	    		 retval=result;
	    	    }});
       	//return retval;
	}
	$scope.getCertPopUp=function(temp){
		/*$scope.cCeed=cCeed;
		$scope.id=id;*/
		console.log("Inside popup function");
		useAction=temp;
		var certtype;
		if(useAction=="Encrypt" || useAction=="Encrypt2" || useAction=="Decrypt" || useAction=="encDetail"){
			certtype="ENC";
		}else{
			certtype="DS";
		}
		uibModalInstance=$uibModal.open({
	     	id: 'complexDialog',
	         title: 'A Complex Modal Dialog',
				templateUrl: contextPath+'/TestApplets?certtype='+certtype,controller:'controller',scope: $scope
			});
	}
				
								$scope.close = function () {
									uibModalInstance.close();
								//	console.log($scope.cCeed);
									console.log(certSerialNo);
									if(useAction=='getLoginSignature'){
										var cCeed=document.getElementById("cCeed").value;
										var id=document.getElementById("proId").value;
					      	    	//	var qs = {data:$scope.cCeed,alias:certSerialNo};
					      	    		var qs = {data:cCeed,alias:certSerialNo};
				              		 	$.ajax({
				              	    		// url: "http://localhost:9190/data/signature", 
				              	    		 url: pluginURL+"/data/getNormalSignature",
				              	    		 type: "GET",
				              	    		 data:qs,
				              	    		 success: function(result){
				              	    		 var cCeed=result;
				              	    		 if(cCeed=='certExpired'){
				              	  			 document.forms[0].callValue_Login.value="regCertificate";
				              	  			 document.forms[0].certExpired.value="1";
				              	  			 document.forms[0].certType.value="DS";
				              	  		 }else {
				              	  			 document.forms[0].newCHash.value=cCeed;
				              	  			 document.forms[0].btnSubmit.disabled=true;
				              	  	         document.forms[0].vparam.value=id;
				              	  	         document.forms[0].callValue_Login.value="validatePassword";
				              	  	         if(document.forms[0].callId!=null && document.forms[0].callId!=undefined)
				              	  	         document.forms[0].callId.value=id;
				              	  		 }
				              	    		if(document.getElementById('Enckey')!=null){
				              	 			 document.getElementById('Enckey').value=Enckey;
				              	 			}
				              	    		if(document.getElementById('buyerIp')!=null){
				              	 			 var buyerIp=document.getElementById('buyerIp').value;
				              	 			// alert(userCategory+":::"+loginIp+":::"+buyerIp);
				              	 			 if(loginIp==buyerIp || buyerIp==""){
				              	 				 document.forms[0].action='loginUserN';
				              	 			 }else if(userCategory=="S" && loginIp!=buyerIp){
				              	 				 document.forms[0].action='loginUserN';
				              	 			 }else{
				              	 				 alert("Invalid Login");
				              	 				 document.forms[0].action='publicDash';
				              	 			 }
				              	 		 }else{
				              	 			 document.forms[0].action='loginUserN';
				              	 		 }
				              	  		 submitPage11(document.forms[0]);
				              	    	    }}); 
									}
									else if (useAction=='signingDetail' || useAction=='encDetail'){ // block getting certList
										var qs = {alias:certSerialNo};
                	           		 	$.ajax({
	                	           	    		 url: pluginURL+"/certificate/detail"+qs, 
	                	           	    		 type: "GET",
	                	           	    		 data:qs,
	                	           	    		 success: function(result){
	                	           	    		 console.log(result);
	                	           	    		 var obj = jQuery.parseJSON(result); 
	                	           	    		 if(obj.SerialNo!=null){
		                	           	    		window.document.getElementById("thumbPrint").value="Not Required";
		                	           	    		window.document.getElementById("subjectDN").value=obj.SubjectDN;
		                	           	    		window.document.getElementById("serialNum").value=obj.SerialNo; // Serial No
		                	           	    		window.document.getElementById("issuerName").value=obj.CertIssuer;
		                	           	    		window.document.getElementById("publicKey").value=obj.publicKey;
		                	           	    		window.document.getElementById("validFrom").value=obj.IssueDate;
		                	           	    		window.document.getElementById("validTo").value=obj.ExpDate;
		                	           	    		window.document.getElementById("certKeyUses").value=obj.KeyUses;
		                	           	    		
		                	           	    		window.document.getElementById("thumbPrint").focus();
		                	           	    		window.document.getElementById("subjectDN").focus();
		                	           	    		window.document.getElementById("serialNum").focus(); 
		                	           	    		window.document.getElementById("issuerName").focus();
		                	           	    		window.document.getElementById("publicKey").focus();
		                	           	    		window.document.getElementById("validFrom").focus();
		                	           	    		window.document.getElementById("validTo").focus();
	                	           	    		     
		                	           	    		window.document.getElementById("subjectDNHidden").value=obj.SubjectDN;
		                	           	    		window.document.getElementById("serialNumHidden").value=obj.SerialNo; // Serial No
		                	           	    		window.document.getElementById("issuerNameHidden").value=obj.CertIssuer;
		                	           	    		window.document.getElementById("publicKeyHidden").value=obj.publicKey;
		                	           	    		window.document.getElementById("validFromHidden").value=obj.IssueDate;
		                	           	    		window.document.getElementById("validToHidden").value=obj.ExpDate;
		                	           	    		
		                	           	    		if(obj.CertIssuer==null || "null"==obj.CertIssuer || ""==obj.CertIssuer){
		                	    						alert("Kindly select certificate to register.");
	                	           	    		    }
		                	           	    	    else{
		                	           	    			window.document.getElementById("saveId").style.display='';
		                	           	    			window.document.getElementById("regCert").style.display='none';
		                	           	    		 }
	                	           	    		 }
	                	           	    		
		                	           	    		
                	           	    		
                	           	    		 }});
									}
									
									else if(useAction=='DocSignature'){
			            	          	var exSerialNo=window.opener.document.forms[0].strCertSerialNo.value;
			    						var exCertIssuer=window.opener.document.forms[0].strCertIssuer.value;
			    						var hashText=document.getElementById("docHash").value;
			    						var uploadFlag=document.getElementById("uploadFlag").value;
			    						var ermsg=document.getElementById("errormessage").value;
			    						
			    						var retVal;
			            	           	var qs = {hashtext:hashText,ExSerialNo:exSerialNo,ExCertIssuer:exCertIssuer,alias:certSerialNo};
			            	           		 	$.ajax({
			            	           	    		 url: pluginURL+"/data/getDocSignature", 
			            	           	    		 type: "GET",
			            	           	    		 data:qs,
			            	           	    		 success: function(result){
			            	           	    			 retVal=result;
						            	           		 if(retVal.trim()=='Use Default Digital Certificate For Signing'){
						            							alert(ermsg);
						            							return false;
						            					 }
						            	           		 else if(retVal.trim()==''){
						            	           			 alert("Document is not signed.");
						            	           		 }
						            	           		 else if(hashText.trim()==''){
						            	           			alert("Document cannot be signed.");
						            	           		 }
						            	           		 else{
						            	           			 
						            	           			document.getElementById("docSign").value=result.trim();
						            	           		 	if(uploadFlag=='done')
						            	           		 		{
						            	           		 	         
						            	           		 		document.getElementById("signDoc").style.display = "none";
						            	           		 		   ShowCompleteMsgNew();
						            	           		 		 }
						            	           		 }
			            	           	    	       
			            	           	    	    }});
			            	           		 
			                       		}
									 
									  else if(useAction=='Signature'){
			            	           	var DefaultSerialNo=document.getElementById("DefaultSerialNo").value;
			            	    		var DefaultCertIssuer=document.getElementById("DefaultCertIssuer").value;
			    						var hashText=document.getElementById("hdnformhash").value;
			    						var ermsg=document.getElementById("errormessage").value;
			    						var OutPutString;
			    						var retval=false;
			            	           	var qs = {hashtext:hashText,ExSerialNo:DefaultSerialNo,ExCertIssuer:DefaultCertIssuer,alias:certSerialNo};
			            	           		 	$.ajax({
			            	           	    		 url: pluginURL+"/data/getDocSignature", 
			            	           	    		 type: "GET",
			            	           	    		 data:qs,
			            	           	    		 async:false,
			            	           	    		  success: function(result){
			            	           	    		  OutPutString=result;
			            	           	    		  if(OutPutString.trim()=='Use Default Digital Certificate For Signing'){
			            	           	 			       alert(ermsg)
			            	           	 			       retval= "false";
			            	           	 		      }
			            	           	 		      else{	
			            	           	 			    //OutPutString=OutPutString.replace(/\s+/g,"");
			            	           	 		    	 
				            	           	 			document.getElementById("signString").value=OutPutString;
				            	           	 		    retval="true";
			            	           	 		      }
			            	           	    		  
			            	           	    	}});
			            	           		 if(retval=="true" )
		            	           			 {
			            	           			submitPage(document.forms[0],'1');
		            	           			 }
			                       		}
									  else if(useAction=='BidFormSignature'){
				            	           	var DefaultSerialNo=document.getElementById("DefaultSerialNo").value;
				            	    		var DefaultCertIssuer=document.getElementById("DefaultCertIssuer").value;
				    						var hashText=document.getElementById("hdnformhash").value;
				    						var ermsg=document.getElementById("errormessage").value;
				    						var OutPutString;
				    						var retval=false;
				            	           	var qs = {hashtext:hashText,ExSerialNo:DefaultSerialNo,ExCertIssuer:DefaultCertIssuer,alias:certSerialNo};
				            	           		 	$.ajax({
				            	           	    		 url: pluginURL+"/data/getDocSignature", 
				            	           	    		 type: "GET",
				            	           	    		 data:qs,
				            	           	    		 async:false,
				            	           	    		  success: function(result){
				            	           	    		  OutPutString=result;
				            	           	    		  
				            	           	    		  if(OutPutString.trim()=='Use Default Digital Certificate For Signing'){
				            	           	 			       alert(ermsg)
				            	           	 			       retval= "false";
				            	           	 		      }
				            	           	 		      else{	
				            	           	 			    //OutPutString=OutPutString.replace(/\s+/g,"");
					            	           	 			document.getElementById("signString").value=OutPutString;
					            	           	 		    retval="true";
				            	           	 		      }
				            	           	    		  
				            	           	    	}});
				            	           		 if(retval=="true" )
			            	           			 {
				            	           			//submitPage(document.forms[0],'1');
			            	           			 }
				                       		}
									  else if(useAction=='DynFormSignature'){
				            	           	var DefaultSerialNo=document.getElementById("DefaultSerialNo").value;
				            	    		var DefaultCertIssuer=document.getElementById("DefaultCertIssuer").value;
				    						var hashText=document.getElementById("hdnformhash").value;
				    						var ermsg=document.getElementById("errormessage").value;
				    						var OutPutString;
				    						var retval=false;
				            	           	var qs = {hashtext:hashText,ExSerialNo:DefaultSerialNo,ExCertIssuer:DefaultCertIssuer,alias:certSerialNo};
				            	           		 	$.ajax({
				            	           	    		 url: pluginURL+"/data/getDocSignature", 
				            	           	    		 type: "GET",
				            	           	    		 data:qs,
				            	           	    		 async:false,
				            	           	    		  success: function(result){
				            	           	    		  OutPutString=result;
				            	           	    		  
				            	           	    		  if(OutPutString.trim()=='Use Default Digital Certificate For Signing'){
				            	           	 			       alert(ermsg)
				            	           	 			       retval= "false";
				            	           	 		      }
				            	           	 		      else{	
				            	           	 			    //OutPutString=OutPutString.replace(/\s+/g,"");
				            	           	 		    	 // alert("OutPutString at controller==>>"+OutPutString);
					            	           	 			  document.getElementById("signString").value=OutPutString;
					            	           	 		      document.getElementById("syncFlag").value="true";
					            	           	 		    retval="true";
				            	           	 		      }
				            	           	    		  
				            	           	    	}});
				            	           		 if(retval=="true" )
			            	           			 {
				            	           			document.getElementById("syncFlag").value="true";
				            	           			document.getElementById("angularFlag").value="false";
				            	           			var contorls=document.getElementById("tot_control_length").value;
				            	           		     saveForm(contorls);
				            	           			//submitPage(document.forms[0],'1');
			            	           			 }
				                       		}
									  else if(useAction=='PBSignature'){
				            	           	var DefaultSerialNo=document.getElementById("DefaultSerialNo").value;
				            	    		var DefaultCertIssuer=document.getElementById("DefaultCertIssuer").value;
				    						var hashText=document.getElementById("hdnformhash").value;
				    						var ermsg=document.getElementById("errormessage").value;
				    						var OutPutString;
				    						var retval=false;
				            	           	var qs = {hashtext:hashText,ExSerialNo:DefaultSerialNo,ExCertIssuer:DefaultCertIssuer,alias:certSerialNo};
				            	           		 	$.ajax({
				            	           	    		 url: pluginURL+"/data/getDocSignature", 
				            	           	    		 type: "GET",
				            	           	    		 data:qs,
				            	           	    		 async:false,
				            	           	    		  success: function(result){
				            	           	    		  OutPutString=result;
				            	           	    		  
				            	           	    		  if(OutPutString.trim()=='Use Default Digital Certificate For Signing'){
				            	           	 			       alert(ermsg)
				            	           	 			       retval= "false";
				            	           	 		      }
				            	           	 		      else{	
				            	           	 			    //OutPutString=OutPutString.replace(/\s+/g,"");
				            	           	 		    	// alert("OutPutString at controller==>>"+OutPutString);
					            	           	 			  document.getElementById("signString").value=OutPutString;
					            	           	 		      document.getElementById("syncFlag").value="true";
					            	           	 		      
					            	           	 		    retval="true";
				            	           	 		      }
				            	           	    		  
				            	           	    	}});
				            	           		 if(retval=="true" )
			            	           			 {
				            	           			document.getElementById("syncFlag").value="true";
				            	           			document.getElementById("angularFlag").value="false";
				            	           			var pageNo=document.getElementById("currentPage").value;
				            	           			clickSave(pageNo);
				            	           			//submitPage(document.forms[0],'1');
			            	           			 }
				                       		}
									      else if(useAction=='WithSerialSignature'){  // use with only serialno
				            	           	var DefaultSerialNo=document.getElementById("DefaultSerialNo").value;
				    						var hashText=document.getElementById("hdnformhash").value;
				    						var ermsg=document.getElementById("errormessage").value;
				    						var OutPutString;
				    						var retval=false;
				    						
				            	           	var qs = {hashtext:hashText,ExSerialNo:DefaultSerialNo,alias:certSerialNo};
				            	           		 	$.ajax({
				            	           	    		 url: pluginURL+"/data/SerialNoSignature", 
				            	           	    		 type: "GET",
				            	           	    		 data:qs,
				            	           	    		 async:false,
				            	           	    		  success: function(result){
				            	           	    		  OutPutString=result;
				            	           	    		  //alert("OutPutString for new Signing function "+OutPutString);
				            	           	    		  if(OutPutString.trim()=='Use Default Digital Certificate For Signing'){
				            	           	 			       alert(ermsg)
				            	           	 			       retval= "false";
				            	           	 		      }
				            	           	 		      else{	
				            	           	 			    //OutPutString=OutPutString.replace(/\s+/g,"");
					            	           	 			document.getElementById("signString").value=OutPutString;
					            	           	 		    document.getElementById("signComment").value=OutPutString;
						            	           			submitPage(document.forms[0]);
				            	           	 		      }
				            	           	    		  
				            	           	    		  
				            	           	    	}});
				            	           		 
				                       		}
									      else if(useAction=='OpeningCommitteeSignature'){
					            	           	var DefaultSerialNo=document.getElementById("DefaultSerialNo").value;
					            	    		var DefaultCertIssuer=document.getElementById("DefaultCertIssuer").value;
					    						var hashText=document.getElementById("hdnformhash").value;
					    						var ermsg=document.getElementById("errormessage").value;
					    						var OutPutString;
					    						var retval=false;
					            	           	var qs = {hashtext:hashText,ExSerialNo:DefaultSerialNo,ExCertIssuer:DefaultCertIssuer,alias:certSerialNo};
					            	           		 	$.ajax({
					            	           	    		 url: pluginURL+"/data/getDocSignature", 
					            	           	    		 type: "GET",
					            	           	    		 data:qs,
					            	           	    		 async:false,
					            	           	    		  success: function(result){
					            	           	    		  OutPutString=result;
					            	           	    		  
					            	           	    		  if(OutPutString.trim()=='Use Default Digital Certificate For Signing'){
					            	           	 			       alert(ermsg)
					            	           	 			       retval= "false";
					            	           	 		      }
					            	           	 		      else{	
					            	           	 			    //OutPutString=OutPutString.replace(/\s+/g,"");
					            	           	 		    	 // alert("OutPutString OpeningCommitteeSignature"+OutPutString);
						            	           	 			document.getElementById("signature").value=OutPutString;
						            	           	 		    retval="true";
					            	           	 		      }
					            	           	    		  
					            	           	    	}});
					            	           		 if(retval=="true" )
				            	           			 {
					            	           			document.getElementById("syncFlag").value="true";
					            	           			document.getElementById("angularFlag").value="false";
					            	           			submitPage(document.forms[0]);
				            	           			 }
					                       		}
									      else if(useAction=='OpenBidSignature'){ //when signed for more than one envelope
									    	    var DefaultSerialNo=document.getElementById("DefaultSerialNo").value;
					            	    		var DefaultCertIssuer=document.getElementById("DefaultCertIssuer").value;
					            	    		var currentEnvNum=document.getElementById("currentEnvNum").value;
					    						var hashText=document.getElementById("hdnformhash").value;
					    						var ermsg=document.getElementById("errormessage").value;
					    						var envelopeLength=document.getElementById("envelopelength").value;
					    						var signStringFieldName=document.getElementById("Signing"+currentEnvNum).value;
					    						var submitFlag=document.getElementById("submitFlag").value;
					    						var OutPutString;
					    						var retval=false;
					            	           	var qs = {hashtext:hashText,ExSerialNo:DefaultSerialNo,ExCertIssuer:DefaultCertIssuer,alias:certSerialNo};
					            	           		 	$.ajax({
					            	           	    		 url: pluginURL+"/data/getDocSignature", 
					            	           	    		 type: "GET",
					            	           	    		 data:qs,
					            	           	    		 async:false,
					            	           	    		  success: function(result){
					            	           	    		  OutPutString=result;
					            	           	    		  if(OutPutString.trim()=='Use Default Digital Certificate For Signing'){
					            	           	 			       alert(ermsg)
					            	           	 			       retval= "false";
					            	           	 		      }
					            	           	 		      else{	
					            	           	 			    //OutPutString=OutPutString.replace(/\s+/g,"");
					            	           	 		    	 // alert("OutPutString Signature"+OutPutString);
						            	           	 			document.getElementById(""+signStringFieldName).value=OutPutString;
						            	           	 		    retval="true";
					            	           	 		      }
					            	           	    		  
					            	           	    	}});
					            	           		 if(retval=="true" && submitFlag=="true" )	
				            	           			 {
					            	           			submitPage(document.forms[0],'1');
				            	           			 }
					                       		}
									       else if(useAction=='EvaluationSignature'){  // use with only serialno
					            	           	var DefaultSerialNo=document.getElementById("DefaultSerialNo").value;
					    						var hashText=document.getElementById("hdnformhash").value;
					    						var ermsg=document.getElementById("errormessage").value;
					    						var OutPutString;
					    						var retval=false;
					    						
					            	           	var qs = {hashtext:hashText,ExSerialNo:DefaultSerialNo,alias:certSerialNo};
					            	           		 	$.ajax({
					            	           	    		 url: pluginURL+"/data/SerialNoSignature", 
					            	           	    		 type: "GET",
					            	           	    		 data:qs,
					            	           	    		 async:false,
					            	           	    		  success: function(result){
					            	           	    		  OutPutString=result;
					            	           	    		  //alert("OutPutString for new Signing function "+OutPutString);
					            	           	    		  if(OutPutString.trim()=='Use Default Digital Certificate For Signing'){
					            	           	 			       alert(ermsg)
					            	           	 			       retval= "false";
					            	           	 		      }
					            	           	 		      else{	
					            	           	 			    //OutPutString=OutPutString.replace(/\s+/g,"");
					            	           	 			    document.getElementById("signComment").value=OutPutString;
					            	           	 		        document.getElementById("signCommentClient").value=OutPutString;
							            	           			submitPage(document.forms[0]);
					            	           	 		      }
					            	           	    		  
					            	           	    		  
					            	           	    	}});
					            	           		 
					                       		}
									       else if(useAction=='VendorApproverSignature'){  // use with only serialno
					            	           	var DefaultSerialNo=document.getElementById("DefaultSerialNo").value;
					    						var hashText=document.getElementById("hashComm").value;
					    						var ermsg=document.getElementById("errormessage").value;
					    						var OutPutString;
					    						var retval=false;
					    						
					            	           	var qs = {hashtext:hashText,ExSerialNo:DefaultSerialNo,alias:certSerialNo};
					            	           		 	$.ajax({
					            	           	    		 url: pluginURL+"/data/SerialNoSignature", 
					            	           	    		 type: "GET",
					            	           	    		 data:qs,
					            	           	    		 async:false,
					            	           	    		  success: function(result){
					            	           	    		  OutPutString=result;
					            	           	    		  //alert("OutPutString for new Signing function "+OutPutString);
					            	           	    		  if(OutPutString.trim()=='Use Default Digital Certificate For Signing'){
					            	           	 			       alert(ermsg)
					            	           	 			       retval= "false";
					            	           	 		      }
					            	           	 		      else{	
					            	           	 			    //OutPutString=OutPutString.replace(/\s+/g,"");
					            	           	 		    	document.getElementById("signedComm").value =OutPutString;
					            	           	 		        document.getElementById("syncFlag").value="true";
					            	           	 		        document.getElementById("angularFlag").value="false";
					            	           	 		         var regid=document.getElementById("userId").value
					            	           	 		         var roleId=document.getElementById("ROLEID").value
					            	           	 		        ApproveReg(regid,roleId);
							            	           			//submitPage(document.forms[0]);
					            	           	 		      }
					            	           	    		  
					            	           	    		  
					            	           	    	}});
					            	           		 
					                       		}
									       else if(useAction=='AmendSignature'){
					            	           	var DefaultSerialNo=document.getElementById("DefaultSerialNo").value;
					            	    		var DefaultCertIssuer=document.getElementById("DefaultCertIssuer").value;
					    						var hashText=document.getElementById("hdnformhash").value;
					    						var ermsg=document.getElementById("errormessage").value;
					    						var OutPutString;
					    						var retval=false;
					            	           	var qs = {hashtext:hashText,ExSerialNo:DefaultSerialNo,ExCertIssuer:DefaultCertIssuer,alias:certSerialNo};
					            	           		 	$.ajax({
					            	           	    		 url: pluginURL+"/data/getDocSignature", 
					            	           	    		 type: "GET",
					            	           	    		 data:qs,
					            	           	    		 async:false,
					            	           	    		  success: function(result){
					            	           	    		  OutPutString=result;
					            	           	    		  
					            	           	    		  if(OutPutString.trim()=='Use Default Digital Certificate For Signing'){
					            	           	 			       alert(ermsg)
					            	           	 			       retval= "false";
					            	           	 		      }
					            	           	 		      else{	
					            	           	 			    //OutPutString=OutPutString.replace(/\s+/g,"");
					            	           	 		    	 //alert("OutPutString at controller AmendSignature==>>"+OutPutString);
						            	           	 			  document.getElementById("signString").value=OutPutString;
						            	           	 		      document.getElementById("syncFlag").value="true";
						            	           	 		      
						            	           	 		    retval="true";
					            	           	 		      }
					            	           	    		  
					            	           	    	}});
					            	           		 if(retval=="true" )
				            	           			 {
					            	           			document.getElementById("syncFlag").value="true";
					            	           			document.getElementById("angularFlag").value="false";
					            	           			callfromController();
					            	           			//submitPage(document.forms[0],'1');
				            	           			 }
					                       		}
									       else if(useAction=='OpeningDateSignature'){ //for defining and signing opening dates
									    	    var DefaultSerialNo=document.getElementById("DefaultSerialNo").value;
					            	    		var DefaultCertIssuer=document.getElementById("DefaultCertIssuer").value;
					    						var hashText=document.getElementById("tenderHash").value;
					    						var ermsg=document.getElementById("errormessage").value;
					    						var OutPutString;
					    						var retval=false;
					    						//alert("Going to sign");
					            	           	var qs = {hashtext:hashText,ExSerialNo:DefaultSerialNo,ExCertIssuer:DefaultCertIssuer,alias:certSerialNo};
					            	           		 	$.ajax({
					            	           	    		 url: pluginURL+"/data/getDocSignature", 
					            	           	    		 type: "GET",
					            	           	    		 data:qs,
					            	           	    		 success: function(result){
					            	           	    			 retVal=result;
								            	           		 if(retVal.trim()=='Use Default Digital Certificate For Signing'){
								            							alert(ermsg);
								            							return false;
								            					 }
								            	           		 else{
								            	           			document.getElementById("tenderSignature").value=result.trim();
						            	           		 	        document.getElementById("signDoc").style.display = "none";
						            	           		 	        loadTenderDetails();
								            	           		 		 
								            	           		 }
					            	           	    	       
					            	           	    	    }});
					            	           		 
					                       		}
								  }

						} ]);
