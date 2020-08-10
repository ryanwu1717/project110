<?php
  include('partial/header.php');
?>

<div class="row">

  	<div class="col-12">
    	<div class="nav nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
	    	<a class="nav-link active col-6" id="v-pills-home-tab" data-toggle="pill" href="#checking" role="tab" aria-controls="v-pills-home" aria-selected="true">審核中</a>
	      	<a class="nav-link col-6" id="v-pills-profile-tab" data-toggle="pill" href="#checked" role="tab" aria-controls="v-pills-profile" aria-selected="false">審核完成</a>
    	</div>
  	</div>
<<<<<<< HEAD
  	<div name="allClick" class="col-12">
  		<div class="custom-control custom-checkbox col-md-6">
  			<div class="col-12">
  				<input type="checkbox" class="custom-control-input" id="allCheck">
		  		<label class="custom-control-label" for="allCheck">全選</label>
		  		<button type="button" class="close" name="icon" onclick="iconAgree()" style="display:none">&#10004;
	    		</button>
	    		<button type="button" class="close" name="icon" onclick="iconRefuse()" style="display:none">
	      			&#10062;
	    		</button>
		  	</div>
		</div>
  	</div>
=======
>>>>>>> 76913eb4055500e34320b68acba05bc6d7e3fdba
  	<div class="col-12">
	    <div class="tab-content" id="v-pills-tabContent">
		    <div class="tab-pane fade show active" id="checking" role="tabpanel" aria-labelledby="v-pills-home-tab">
		    	<div class="table-responsive">
			    	<table class="table table-bordered" id="tableChecking" width="100%" cellspacing="0">
			    		<thead>
			    			<tr>
				    			<th>假單編號</th>
				    			<th>申請部門</th>
				    			<th>申請人</th>
				    			<th>類別</th>
				    			<th>詳細資料</th>
				    		</tr>
			    		</thead>
			    		<tfoot>
			    			<tr>
				    			<th>假單編號</th>
				    			<th>申請部門</th>
				    			<th>申請人</th>
				    			<th>類別</th>
				    			<th>詳細資料</th>
				    		</tr>
			    		</tfoot>
			    		<tbody name="tbody_checking">
			    		</tbody>
		            </table>
		        </div>
		    </div>
		    <div class="tab-pane fade" id="checked" role="tabpanel" aria-labelledby="v-pills-profile-tab">
		    	<div class="table-responsive">
			    	<table class="table table-bordered" id="tableChecked" width="100%" cellspacing="0">
			    		<thead>
			    			<tr>
				    			<th>假單編號</th>
				    			<th>申請部門</th>
				    			<th>申請人</th>
				    			<th>類別</th>
				    			<th>審核結果</th>
				    			<th>詳細資料</th>
				    		</tr>
			    		</thead>
			    		<tfoot>
			    			<tr>
				    			<th>假單編號</th>
				    			<th>申請部門</th>
				    			<th>申請人</th>
				    			<th>類別</th>
				    			<th>審核結果</th>
				    			<th>詳細資料</th>
				    		</tr>
			    		</tfoot>
			    		<tbody name="tbody_checked">
			    		</tbody>
		            </table>
		        </div>
		    </div>
    	</div>
 	</div>
</div>

<<<<<<< HEAD
<div class="modal fade bd-example-modal-xl" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  	<div class="modal-dialog modal-xl" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<h5 class="modal-title" id="modalLable">詳細內容</h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          			<span aria-hidden="true">&times;</span>
        		</button>
      		</div>
      		<div class="modal-body" id="modalBody">
      		</div>
      		<div class="modal-footer" id="modalfooter">
      			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agree" data-dismiss="modal" name="modAgree">&#10003;</button>
      			<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#refuse" data-dismiss="modal">&#967;</button>
        		<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      		</div>
    	</div>
  	</div>
</div>

<div class="modal fade" id="agree" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  	<div class="modal-dialog modal-dialog-centered" role="document">
    	<div class="modal-content">
      		<div class="modal-body" id="modalBody">確定要同意這假單??
      		</div>
      		<div class="modal-footer">
      			<button type="button" class="btn btn-primary" onclick="btnAgree()">&#10003;</button>
      			<button type="button" class="btn btn-danger" data-dismiss="modal">&#967;</button>
      		</div>
    	</div>
  	</div>
</div>

<div class="modal fade" id="refuse" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  	<div class="modal-dialog modal-dialog-centered" role="document">
    	<div class="modal-content">
      		<div class="modal-body" id="modalBody">確定要拒絕這假單??
      		</div>
      		<div class="modal-footer">
      			<button type="button" class="btn btn-primary" onclick="btnRefuse()">&#10003;</button>
      			<button type="button" class="btn btn-danger" data-dismiss="modal">&#967;</button>
      		</div>
    	</div>
  	</div>
</div>

=======
>>>>>>> 76913eb4055500e34320b68acba05bc6d7e3fdba
<?php
  include('partial/footer.php');
?>

<script src="/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
	$(function(){
		$.ajax({
			url: '/work/holiday/checkedData',
			type: 'GET',
			dataType:'json',
<<<<<<< HEAD
			success: function(source){
                $.each(source, function(i,n){
                	var td0 = "<td></td>";
=======
			success: function(data){
                $.each(data, function(i,n){
>>>>>>> 76913eb4055500e34320b68acba05bc6d7e3fdba
                    var td1 = $('<td>').text(n["id"]);
					var td2 = $('<td>').text(n["staff_id"]);
					var td3 = $('<td>').text(n["name"]);
					var td6 = $('<td>').text(n["department_name"]);
					var btn = $('<button>').text('詳細資料').attr({	class:"btn btn-primary",'data-toggle':"modal",
						'data-target':"#modalDetail",
						onclick:"modalDetail("+n['id']+")"
						});
					var td4 = $('<td>').append(btn);
<<<<<<< HEAD
					var td5;
					var tr
					if(n['isCheck'] == 2){
						td5 = $('<td>').text("成功").attr("class","text-success");
						tr = $('<tr>').append(td0,td1,td6,td2,td3,td5,td4);
					}else if(n['isCheck'] == 3){
						td5 = $('<td>').text("失敗").attr("class","text-danger");;
						tr = $('<tr>').append(td0,td1,td6,td2,td3,td5,td4);
					}else{
						tr = $('<tr>').append(td0,td1,td6,td2,td3,td4);
					}
=======
					var tr = $('<tr>').append(td1,td2,td3,td4);
>>>>>>> 76913eb4055500e34320b68acba05bc6d7e3fdba
					if(n["isCheck"] == 1){
						$('[name=tbody_checking]').append(tr);
					}else{
						$('[name=tbody_checked]').append(tr);
					}
                });

<<<<<<< HEAD
                $('#tableChecking').DataTable({
				    columnDefs: [{
				        orderable: false,
				        targets: 0,
						'render': function (data, type, full, meta){
						 return '<input type="checkbox" name="id[]" class="form-control" value="' + $('<div/>').text(meta.row).html() + '">';
						}
				    }],
				    // select: {
				    //     style: 'os',
				    //     selector: 'td:first-child'
				    // },
			        order: [[1, 'asc']],
=======
                $('#tableChecking').DataTable({ 
>>>>>>> 76913eb4055500e34320b68acba05bc6d7e3fdba
                	language: {
			            "emptyTable": "無資料...",
			            "processing": "處理中...",
			            "loadingRecords": "載入中...",
			            "lengthMenu": "顯示 _MENU_ 項結果",
			            "zeroRecords": "沒有符合的結果",
			            "info": "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
			            "infoEmpty": "顯示第 0 至 0 項結果，共 0 項",
			            "infoFiltered": "(從 _MAX_ 項結果中過濾)",
			            "infoPostFix": "",
			            "search": "搜尋:",
			            "paginate": {
			              "first": "第一頁",
			              "previous": "上一頁",
			              "next": "下一頁",
			              "last": "最後一頁"
			            },
			            "aria": {
			              "sortAscending": ": 升冪排列",
			              "sortDescending": ": 降冪排列"
			            }
			        }
        		});
<<<<<<< HEAD
        		$('#tableChecked').DataTable({
        			"columnDefs": [
        				{
	                		"visible": false,
	        				"targets": 0,
	        			},
        			],
=======

        		$('#tableChecked').DataTable({ 
>>>>>>> 76913eb4055500e34320b68acba05bc6d7e3fdba
                	language: {
			            "emptyTable": "無資料...",
			            "processing": "處理中...",
			            "loadingRecords": "載入中...",
			            "lengthMenu": "顯示 _MENU_ 項結果",
			            "zeroRecords": "沒有符合的結果",
			            "info": "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
			            "infoEmpty": "顯示第 0 至 0 項結果，共 0 項",
			            "infoFiltered": "(從 _MAX_ 項結果中過濾)",
			            "infoPostFix": "",
			            "search": "搜尋:",
			            "paginate": {
			              "first": "第一頁",
			              "previous": "上一頁",
			              "next": "下一頁",
			              "last": "最後一頁"
			            },
			            "aria": {
			              "sortAscending": ": 升冪排列",
			              "sortDescending": ": 降冪排列"
			            }
			        }
        		});

	    		$("input[name='id[]']").change(function() {
					if($(this).is(':checked')){
						$("[name='icon']").attr('style',"display:block");
					}else{
						$("input[name='id[]']").each(function (index, item) {
					        if($("input[name='id[]']").is(':checked')){
								$("[name='icon']").attr('style',"display:block");
					        }else{
					        	$("[name='icon']").attr('style',"display:none");
					        }
					    });
					}
				});
				// if($("input [type='checkbox']:checked")){
				// 	console.log("231");
				// }

			}
		});
	});
<<<<<<< HEAD

	function modalDetail(j){
		$.ajax({
			url: '/work/holiday/checkingData',
			type: 'GET',
			dataType:'json',
			success: function(data){
				$.each(data, function(i,n){
					if(n['id'] == j){
						$("#modalBody").html(`<dl class="row">
								<dt class="col-sm-3">假單編號:</dt>
								<dd class="col-sm-9">`+n['id']+`</dd>
								<dt class="col-sm-3">假別:</dt>
								<dd class="col-sm-9">`+n['name']+`</dd>
								<dt class="col-sm-3">開始時間:</dt>
								<dd class="col-sm-9">`+n['startTime']+`</dd>
								<dt class="col-sm-3">結束時間:</dt>
								<dd class="col-sm-9">`+n['endTime']+`</dd>
								<dt class="col-sm-3">理由:</dt>
								<dd class="col-sm-9">`+n['reason']+`</dd>
								<dt class="col-sm-3">申請時間:</dt>
								<dd class="col-sm-9">`+n['now'].slice(0, 16)+`</dd>
							</dl>`
						);
						$("[name='modAgree']").attr('data-id',n['id']);

						if(n['isCheck'] != 1){
							$("#modalfooter").attr("style","visibility:hidden");
						}else{
							$("#modalfooter").attr("style","visibility:block");
						}
					}

				});

			}
		});
	}

	function btnAgree(){
		var dataID = $("[name='modAgree']").attr('data-id');
		$.ajax({
			url: '/work/holiday/agree/' + dataID,
			type:'patch',
		    dataType:'json',
		    data: {
				data:JSON.stringify({
					id : dataID,
					ischeck : 2,
        		})
			},
		    success: function(data){
		    	location.reload();
		    }
		})
	}

	function btnRefuse(){
		var dataID = $("[name='modAgree']").attr('data-id');
		$.ajax({
			url: '/work/holiday/refuse/' + dataID,
			type:'patch',
		    dataType:'json',
		    data: {
				data:JSON.stringify({
					id : dataID,
					ischeck : 3,
        		})
			},
		    success: function(data){
		    	location.reload();
		    }
		})
	}

	function iconAgree(){
		$("input[name='id[]']").each(function(){
			if ($(this).is(":checked")){
				var dataID = $($(this).parent().parent().children()[1]).text();
				$.ajax({
					url: '/work/holiday/agree/' + dataID,
					type:'patch',
				    dataType:'json'
				    data: {
						data:JSON.stringify({
							id : dataID,
							ischeck : 2,
		        		})
					},
				})
			}
		})
		location.reload();
	}

	function iconRefuse(){
		$("input[name='id[]']").each(function(){
			if ($(this).is(":checked")){
				var dataID = $($(this).parent().parent().children()[1]).text();
				$.ajax({
					url: '/work/holiday/refuse/' + dataID,
					type:'patch',
				    dataType:'json'
				    data: {
						data:JSON.stringify({
							id : dataID,
							ischeck : 3,
		        		})
					},
				})
			}
		})
		location.reload();
	}

	$("#allCheck").click(function(){
		if($("#allCheck").prop("checked")){
			$("input[name='id[]']").each(function() {
				$(this).prop("checked", true);
				$("[name='icon']").attr('style',"display:block");
			});
		}else{
			$("input[name='id[]']").each(function() {
				$(this).prop("checked", false);
				$("[name='icon']").attr('style',"display:none");
			});
		}
	});

	$("#v-pills-profile-tab").click(function(){
		$("[name='allClick']").attr('style',"display:none")
	})
	$("#v-pills-home-tab").click(function(){
		$("[name='allClick']").attr('style',"display:block")
	})

	

	


=======
>>>>>>> 76913eb4055500e34320b68acba05bc6d7e3fdba
</script>