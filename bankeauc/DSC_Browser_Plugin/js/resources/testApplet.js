   var action; 
   var uibModalInstance =null;
var PopupDemo = angular.module('PopupDemo', ['ui.bootstrap']);
	  // angular.module('PopupDemo', ['ui.bootstrap']);
        PopupDemo.controller('PopupDemoCont', ['$scope','$uibModal',function ($scope, $uibModal) {
		/*//javascript code for simple popup 
           $scope.simplepopup = function (){
                var uibModalInstance = $uibModal.open({
                    templateUrl: 'template/Popup.html',
                });
			}*/
		//javascript code for popup with close button
        	 
			$scope.popupwithclose = function (temp){
				//alert("--->"+hi);
				action=temp;
				var contex=window.document.getElementById("contex").value.trim();
				var certtype;
				if(action=="Encrypt" || action=="Encrypt2" || action=="Decrypt" || action=="certDetailEnc"){
					certtype="ENC";
				}else{
					certtype="DS";
				}
				
				var url=contex+"/TestApplets?certtype="+certtype;
				alert("popup url==>"+url);
				alert("action--->"+action);
			                  uibModalInstance = $uibModal.open({
			                	id: 'complexDialog',
			                    title: 'A Complex Modal Dialog',
                    templateUrl: url,
					  controller: 'PopupCont11',
                });
			}
			$scope.getHash = function (){
				alert("--->getHash");
				var decryptedData=window.document.getElementById("decryptedData").value.trim();
	           	alert(decryptedData);
	           	var hashAlgo=window.document.getElementById("hashAlgo").value.trim();
	           	alert("hashAlgo==>"+hashAlgo);
	           	//var qs = {data:decryptedData,alias:hashAlgo};
	           	var qs = {data:decryptedData,alias:hashAlgo};
	           	$.ajax({
      	    		 url: "http://localhost:9190/data/getHash", 
      	    		 type: "GET",
      	    		 data:qs,
      	    		 success: function(result){
      	    		 console.log(result);
      	    	     window.document.getElementById("hashedData").value=result.trim();
      	    	    }});
			}
			
			$scope.verifySignature = function (){
				alert("--->verifySignature");
				var hashedData=window.document.getElementById("hashedData").value.trim();
	           	alert(hashedData);
				
				var signedData=window.document.getElementById("signedData").value.trim();
	           	alert(signedData);
	           	//var hashAlgo=window.document.getElementById("hashAlgo").value.trim();
	           //	alert("hashAlgo==>"+hashAlgo);
	           	//var qs = {data:decryptedData,alias:hashAlgo};
	           	var qs = {data:hashedData,signature:signedData};
	           	$.ajax({
      	    		 url: "http://localhost:9190/data/verifysignature", 
      	    		 type: "GET",
      	    		 data:qs,
      	    		 success: function(result){
      	    		 console.log(result);
      	    	     window.document.getElementById("verifiedData").value=result.trim();
      	    	    }});
			}
			$scope.generateKey = function (){
				alert("--->generateKey");
				var keyType=window.document.getElementById("keyType").value.trim();
	           	alert(keyType);
				
	           	var qs = {keytype:keyType};
	           	$.ajax({
      	    		 url: "http://localhost:9190/data/generateKey", 
      	    		 type: "GET",
      	    		 data:qs,
      	    		 success: function(result){
      	    		 console.log(result);
      	    		var obj = jQuery.parseJSON(result);
      	    				alert( obj.key1);
      	    		alert( obj.key2);
      	    		if( obj.key1!="undefined" ||  obj.key1!=""){
      	    	     window.document.getElementById("data").value= obj.key1.trim();
      	    	   $scope.streetName = window.document.getElementById("data").value;
      	    		alert( "11111111111"+$scope.streetName);
      	    		}
      	    		
      	    		
      	    		if( obj.key2!="undefined" ||  obj.key2!="")
         	    	     window.document.getElementById("data2").value= obj.key2.trim();
      	    	    }});
			}
			$scope.generateDocKey = function (){
				alert("--->generateDocKey");
				var keyType="1";
	           	var qs = {keytype:keyType};
	           	$.ajax({
      	    		 url: "http://localhost:9190/data/generateKey", 
      	    		 type: "GET",
      	    		 data:qs,
      	    		 success: function(result){
      	    		 console.log(result);
      	    		var obj = jQuery.parseJSON(result);
      	    				alert( obj.key1);
      	    		alert( obj.key2);
      	    		if( obj.key1!="undefined" ||  obj.key1!="")
      	    	     window.document.getElementById("DocKey").value= obj.key1.trim();
      	    	    }});
			}
			$scope.EncryptFile = function (){
				alert("--->EncryptFile");
				var EncryptUploadFile=window.document.getElementById("EncryptUploadFile").value.trim();
	           	alert(EncryptUploadFile);
				var DocKey=window.document.getElementById("DocKey").value.trim();
				alert(DocKey);
	           	var qs = {filepath:EncryptUploadFile,dockey:DocKey};
	           	$.ajax({
      	    		 url: "http://localhost:9190/data/encdoc", 
      	    		 type: "GET",
      	    		 data:qs,
      	    		 success: function(result){
      	    		 console.log(result);
      	    	    }});
			}
			$scope.DecryptFile = function (){
				alert("--->DecryptFile");
				var DecryptUploadFile=window.document.getElementById("DecryptUploadFile").value.trim();
	           	alert(DecryptUploadFile);
				var decDocKey=window.document.getElementById("decDocKey").value.trim();
				alert(decDocKey);
	           	var qs = {filepath:DecryptUploadFile,dockey:decDocKey};
	           	$.ajax({
      	    		 url: "http://localhost:9190/data/decdoc", 
      	    		 type: "GET",
      	    		 data:qs,
      	    		 success: function(result){
      	    		 console.log(result);
      	    	    }});
			}
			
			
			/*//javascript code for popuup with passing parameter
				$scope.popupwithparameter = function (titlename){	
				   var uibModalInstance = $uibModal.open({
                    templateUrl: 'template/Popup2.html',
                    controller: 'PopupCont1',
                    resolve: {
                        titlename2: function () {
                            return titlename;
                        }
                    }
                });
				}*/
        }]);
		
		    // controller for popup1.html view for close button
		        PopupDemo.controller('PopupCont11',function ($scope, $uibModalInstance) {
            $scope.close = function () {
            	//alert("closing");
            	alert("action--->"+action);
                
            	if(action=="Encrypt" || action=="Encrypt2" || action=="Decrypt" || action=="getSignature" || action=="DocSignature" || action=="verifyDocSignature"){
	                var certSerialNo=window.document.getElementById("selectedCertificate").value;
	                console.log("certSerialNo-->"+certSerialNo);
	                uibModalInstance.close();
            	}
           	
           	if(action=="Encrypt"){
	           	var planeData=window.document.getElementById("data").value.trim();
	           	var qs = {data:planeData,alias:certSerialNo};
	           		 	$.ajax({
	           	    		 url: "http://localhost:9190/data/encrypt"+qs, 
	           	    		 type: "GET",
	           	    		 data:qs,
	           	    		 success: function(result){
	           	    		 console.log(result);
	           	    	     window.document.getElementById("encrypteddata").value=result.trim();
	           	    	    }});
           		}else if(action=="Encrypt2"){
    	           	var planeData=window.document.getElementById("data2").value.trim();
    	           	var qs = {data:planeData,alias:certSerialNo};
    	           		 	$.ajax({
    	           	    		 url: "http://localhost:9190/data/encrypt", 
    	           	    		 type: "GET",
    	           	    		 data:qs,
    	           	    		 success: function(result){
    	           	    		 console.log(result);
    	           	    	     window.document.getElementById("encrypteddata").value=result.trim();
    	           	    	    }});
               		}
           	else if(action=="Decrypt"){
    	           	var encrypteddata=window.document.getElementById("encrypteddata").value.trim();
    	           	alert(encrypteddata);
    	           	var qs = {data:encrypteddata,alias:certSerialNo};
    	           		 	$.ajax({
    	           	    		 url: "http://localhost:9190/data/decrypt", 
    	           	    		 type: "GET",
    	           	    		 data:qs,
    	           	    		 success: function(result){
    	           	    		 console.log(result);
    	           	    	     window.document.getElementById("decryptedData").value=result.trim();
    	           	    	    }});
               		}else if(action=="getSignature"){
        	           	var hashedData=window.document.getElementById("hashedData").value.trim();
        	           	alert(hashedData);
        	           	var qs = {data:hashedData,alias:certSerialNo};
//        	           	var qs="?data="+encrypteddata+"&alias="+certSerialNo;
        	           		 	$.ajax({
        	           	    		 url: "http://localhost:9190/data/signature", 
        	           	    		 type: "GET",
        	           	    		 data:qs,
        	           	    		 success: function(result){
        	           	    		 console.log(result);
        	           	    	     window.document.getElementById("signedData").value=result.trim();
        	           	    	    }});
                   		}else if(action=="DocSignature"){
            	           	var docFile=window.document.getElementById("docFile").value.trim();
            	           	alert(docFile);
            	           	var qs = {filepath:docFile,alias:certSerialNo};
//            	           	var qs="?data="+encrypteddata+"&alias="+certSerialNo;
            	           		 	$.ajax({
            	           	    		 url: "http://localhost:9190/data/signfile", 
            	           	    		 type: "GET",
            	           	    		 data:qs,
            	           	    		 success: function(result){
            	           	    		 console.log(result);
            	           	    	     window.document.getElementById("sign_doc").value=result.trim();
            	           	    	    }});
                       		}else if(action=="verifyDocSignature"){
                	           	var verifyDocFile=window.document.getElementById("verifyDocFile").value.trim();
                	           	alert(verifyDocFile);
                	           	var docsign=window.document.getElementById("sign_doc").value;
                	           	var qs = {Signature:docsign,filepath:verifyDocFile,alias:certSerialNo};
//                	           	var qs="?data="+encrypteddata+"&alias="+certSerialNo;
                	           		 	$.ajax({
                	           	    		 url: "http://localhost:9190/data/verifysignfile", 
                	           	    		 type: "GET",
                	           	    		 data:qs,
                	           	    		 success: function(result){
                	           	    		 console.log(result);
                	           	    	     window.document.getElementById("verifyDoc").value=result.trim();
                	           	    	    }});
                           		}
           //	added by sanchit
                       		else if(action=="getSignatureNormal"){
                	           
                	           	var docsign=window.document.getElementById("sign_doc").value;
                	           	var qs = {getdata:data};
//                	           	var qs="?data="+encrypteddata+"&alias="+certSerialNo;
                	           		 	$.ajax({
                	           	    		 url: "http://localhost:9190/data/getNormalSignature", 
                	           	    		 type: "GET",
                	           	    		 data:qs,
                	           	    		 success: function(result){
                	           	    		 console.log(result);
                	           	    	    // window.document.getElementById("verifyDoc").value=result.trim();
                	           	    	    }});
                           		}
           	
           	
           	else{
           			alert("Function not available");
           		}
            };
           
        });
		        PopupDemo.filter('trim', function () {
		            return function(value) {
		                if(!angular.isString(value)) {
		                    return value;
		                }  
		                return value.replace(/^\s|\s+$/g, ''); // you could use .trim, but it's not going to work in IE<9
		            };
		        });       
		        
		/*//angular.module('PopupDemo')
		        PopupDemo.controller('PopupCont1',function ($scope, $uibModalInstance, titlename2) {
            $scope.title1 = titlename2;
            $scope.close = function () {
                $uibModalInstance.dismiss('cancel');
            };
		   });*/