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
  	<div>
  		<div class="custom-control custom-checkbox">
		  	<input type="checkbox" class="custom-control-input" id="allCheck">
		  	<label class="custom-control-label" for="allCheck">全選</label>
		</div>
  	</div>
  	<div class="col-12">
	    <div class="tab-content" id="v-pills-tabContent">
		    <div class="tab-pane fade show active" id="checking" role="tabpanel" aria-labelledby="v-pills-home-tab">
		    	<div class="table-responsive">
			    	<table class="table table-bordered" id="tableChecking" width="100%" cellspacing="0">
			    		<thead>
			    			<tr>
			    				<th></th>
				    			<th>假單編號</th>
				    			<th>申請人</th>
				    			<th>類別</th>
				    			<th>詳細資料</th>
				    		</tr>
			    		</thead>
			    		<tfoot>
			    			<tr>
			    				<th></th>
				    			<th>假單編號</th>
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
			    				<th></th>
				    			<th>假單編號</th>
				    			<th>申請人</th>
				    			<th>類別</th>
				    			<th>詳細資料</th>
				    		</tr>
			    		</thead>
			    		<tfoot>
			    			<tr>
			    				<th></th>
				    			<th>假單編號</th>
				    			<th>申請人</th>
				    			<th>類別</th>
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
      		<div class="modal-footer">
      			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agree" data-dismiss="modal">&#10003;</button>
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
      			<button type="button" class="btn btn-primary">&#10003;</button>
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
      			<button type="button" class="btn btn-primary">&#10003;</button>
      			<button type="button" class="btn btn-danger" data-dismiss="modal">&#967;</button>
      		</div>
    	</div>
  	</div>
</div>

<?php
  include('partial/footer.php');
?>

<script src="/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js
"></script>

<script type="text/javascript">
	$(function(){
		$.ajax({
			url: '/work/holiday/checkingData',
			type: 'GET',
			dataType:'json',
			success: function(data){
                $.each(data, function(i,n){
                	var td0 = "<td></td>";
                    var td1 = $('<td>').text(n["id"]);
					var td2 = $('<td>').text(n["staff_id"]);
					var td3 = $('<td>').text(n["name"]);
					var btn = $('<button>').text('詳細資料').attr({	class:"btn btn-primary",'data-toggle':"modal",
						'data-target':"#modalDetail",
						onclick:"modalDetail("+n['id']+")"
						});
					var td4 = $('<td>').append(btn);
					var tr = $('<tr>').append(td0,td1,td2,td3,td4);
					if(n["isCheck"] == 1){
						$('[name=tbody_checking]').append(tr);
					}else{
						$('[name=tbody_checked]').append(tr);
					}
                });

                $('#tableChecking').DataTable({
				    columnDefs: [{
				        orderable: false,
				        targets: 0,
						'render': function (data, type, full, meta){
						 return '<input type="checkbox" name="id[]" class="form-control" value="' + $('<div/>').text(data).html() + '">';
						}
				    }],
				    select: {
				        style: 'os',
				        selector: 'td:first-child'
				    },
			        order: [[ 1, 'asc' ]],
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

        		$('#tableChecked').DataTable({
        			"columnDefs": [
        				{
	                		"visible": false,
	        				"targets": 0,
	        			},
        			],
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


			}
		});
	});

	function modalDetail(j){
		console.log(j);
		$.ajax({
			url: '/work/holiday/checkingData',
			type: 'GET',
			dataType:'json',
			success: function(data){
				$.each(data, function(i,n){
					console.log(n);
					if(n['id'] == j){
						$("#modalBody").html(`<dl class="row">
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
					}
				});
				
			}
		});
	}


</script>