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
  	<div class="col-12">
	    <div class="tab-content" id="v-pills-tabContent">
		    <div class="tab-pane fade show active" id="checking" role="tabpanel" aria-labelledby="v-pills-home-tab">
		    	<div class="table-responsive">
			    	<table class="table table-bordered" id="tableChecking" width="100%" cellspacing="0">
			    		<thead>
			    			<tr>
				    			<th>假單編號</th>
				    			<th>申請人</th>
				    			<th>類別</th>
				    			<th>詳細資料</th>
				    		</tr>
			    		</thead>
			    		<tfoot>
			    			<tr>
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
				    			<th>假單編號</th>
				    			<th>申請人</th>
				    			<th>類別</th>
				    			<th>詳細資料</th>
				    		</tr>
			    		</thead>
			    		<tfoot>
			    			<tr>
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

<?php
  include('partial/footer.php');
?>

<script src="/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
	$(function(){
		$.ajax({
			url: '/work/holiday/checkingData',
			type: 'GET',
			dataType:'json',
			success: function(data){
                $.each(data, function(i,n){
                    var td1 = $('<td>').text(n["id"]);
					var td2 = $('<td>').text(n["staff_id"]);
					var td3 = $('<td>').text(n["name"]);
					var btn = $('<button>').text('詳細資料').attr({	class:"btn btn-primary",'data-toggle':"modal",
						'data-target':"#modalDetail",
						onclick:"modalDetail("+n['id']+")"
						});
					var td4 = $('<td>').append(btn);
					var tr = $('<tr>').append(td1,td2,td3,td4);
					if(n["isCheck"] == 1){
						$('[name=tbody_checking]').append(tr);
					}else{
						$('[name=tbody_checked]').append(tr);
					}
                });

                $('#tableChecking').DataTable({ 
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
</script>