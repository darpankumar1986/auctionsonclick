<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<meta http-equiv="Access-Control-Allow-Origin" content="*" />
<title>Test Certificate</title>
<%-- <link href="resources/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<script src="${pageContext.request.contextPath}/resources/js/angularmodule/lib/jquery.min.js"></script>
<script src="${pageContext.request.contextPath}/resources/js/angularmodule/lib/jquery.dataTables.min.js"></script>
<script src="${pageContext.request.contextPath}/resources/js/angularmodule/lib/angular.min.js"></script> --%>

<%@ page language="java" contentType="text/html;charset=UTF-8" pageEncoding="UTF-8" import='c1Library.commonFunctions'%>

<link	href="<%=request.getContextPath()%>/css/resources/bootstrap.min.css"	rel="stylesheet">
<link href="<%=request.getContextPath()%>/css/resources/jquery.dataTables.min.css" rel="stylesheet"	type="text/css">
<script>var contextPathMain='<%=request.getContextPath()%>'</script>		
<script src="<%=request.getContextPath()%>/js/resources/jquery.min.js"></script>
<script	src="<%=request.getContextPath()%>/js/resources/jquery.dataTables.min.js"></script>
<script	src="<%=request.getContextPath()%>/js/resources/angular.min.js"></script>
<script	src="<%=request.getContextPath()%>/js/resources/app.js"></script>
<script	src="<%=request.getContextPath()%>/js/resources/controller.js"></script>
<script	src="<%=request.getContextPath()%>/js/resources/ui-bootstrap-tpls-0.14.3.min.js"></script>

<script type="text/javascript">
$( document ).ready(function() {
	//var pluginURL="https://plugin.eproc.in:9193";
	var pluginURL="http://localhost:9190";
	var certtype=$('#certtype').val();
	var table =$('#certlist').dataTable( {
		  "ajax": {
		    "url": pluginURL+"/certificate/list?certtype="+certtype,
		    "type": "POST",
		  },
		  "columns": [
		                { "data": "AliasName" },
		                { "data": "IssuedBy" },
		                { "data": "SerialNo" },
		                { "data": "ExpDate" },
		                { "data": "IssuerDetail" }
		            ],
		  "bFilter": false,
		  "paging": false,
		  "autoWidth": true
		} );
	$('#certlist tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            var row =  $(this).addClass('selected');
            
          // alert(table.api().cell( row, 0 ).data());
          if(document.getElementById("selectedCertificate")!=null){
        	  window.document.getElementById("selectedCertificate").value=table.api().cell( row, 0 ).data(); 
        	  window.document.getElementById("SerialNo").value=table.api().cell( row, 2 ).data(); 
          }
          else{
        	  certSerialNo=table.api().cell( row, 0 ).data();
        	  SerialNo=table.api().cell( row, 2 ).data();
          }
          
        }
    } );
 
    
   
});
</script>
<style>
.form_bg{width:98%; float:left; background:#fff; padding:5px 1%; border-radius:5px; }
.datagrid table {width:100%; border:solid 1px #ccc;}
table.dataTable thead th {    border-right: solid 1px#ccc;  padding:10px 2%;   font-size: 12px;}
table.dataTable thead th:last-child {border-right: none;}
.datagrid table tbody td{border-right: solid 1px#ccc;}
.datagrid table tbody td:last-child{border-right: none;}
.datagrid table tbody td {font-size:9px; word-wrap:break-word; cursor:pointer;     word-break: break-all; }
.dataTables_info{float:left; font-size:10px;}
.btn{ margin:0 0; border-radius:0; font-size:12px; padding: 3px 10px!important; color:#fff;     background: #0c7e99;}
.selected{background:#F7f7f7;}
.row-custom{width:100%; float:left; background:#fff; padding:0 1%; text-align:center;}


</style>
</head>
<body>
<input type="hidden" name="certtype"  id="certtype" value="${certtype}">
<div class="form_bg">
<div class="grid_border">
<div class="datagrid">
<table id="certlist" class="display" class="cell-border wid_60">
        <thead >
            <tr>
                <th style="max-width:30%">AliasName</th>
                <th style="max-width:30%">IssuedBy</th>
                <th style="max-width:10%">SerialNo</th>
                <th style="max-width:5%">ExpDate</th>
                <th style="max-width:25%">IssuerDetail</th>
            </tr>
        </thead>
    </table>
    <div class="row-custom"><button id="button" ng-click="close()" class="btn">select certificate</button></div>
    	
    </div>
    </div>
    </div>
</body>
</html>