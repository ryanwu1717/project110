<?php 
 include('partial/header.php')
?>
<div class="card shadow mb-4">
	<div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">匯入工時</h6>
    </div>
    <div class="card-body inline">
    	<form>
    		<div class="row">
	    		<div class="form-group col-md-4 text-center">
	    			<a href="/workTime/file" target="_blank" class="btn btn-primary mb-2 " id="btnExample" type="button">查看範例</a>
	    		</div>
			  	<div class="form-group col-md-8 ">
			    	<!-- <label for="exampleFormControlFile1">Example file input</label> -->
			    	<div class="input-group mb-3">
			    		
			    		<div class="input-group-prepend">
						    <span class="input-group-text">選擇檔案</span>
						</div>
						<div class="custom-file">
						    <input type="file" class="custom-file-input" id="inputFile">
						    <label class="custom-file-label" for="inputFile">請選擇excel</label>
						</div>
			    	</div>
			    	
			    	<!-- <input type="file" class="form-control-file" id="exampleFormControlFile1"> -->
			  	</div>
			  	<div class="form-group col-md-4 text-center">
	    			<button   class="btn btn-success mb-2 " id="" type="button" data-type="check" data-toggle="modal" data-target="#exampleModal">新增</button>
	    		</div>
			  </div>
		</form>
		<div>
			<table class="table" id="dataTable">
			  <thead>
			    <tr>
			      <th scope="col">員工編號</th>
			      <th scope="col">員工姓名</th>
			      <th scope="col">請假時數</th>
			      <th scope="col">年度</th>
			    </tr>
			  </thead>
			  <tbody>
			   <!--  <tr>
			      <th scope="row">1</th>
			      <td>Mark</td>
			      <td>Otto</td>
			    </tr>
			    <tr>
			      <th scope="row">2</th>
			      <td>Jacob</td>
			      <td>Thornton</td>
			    </tr> -->
			   
			  </tbody>
			  <tfoot>
			    <tr>
			      <th scope="col">員工編號</th>
			      <th scope="col">員工姓名</th>
			      <th scope="col">請假時數</th>
			      <th scope="col">年度</th>
			    </tr>
			  </tfoot>
			</table>
		</div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<?php 
 include('partial/footer.php')
?>
<script src="/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
var table;
$(function(){
	
	$('#exampleModal').on('show.bs.modal', function (e) {
  		var type = $(e.relatedTarget).data('type');
  		$('#exampleModal .modal-body').html(`
			<div class="spinner-border text-primary" role="status">
			  <span class="sr-only">Loading...</span>
			</div>`);
		$('#exampleModal .modal-footer').html('<button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>');

  		if(type == 'check'){
  			$('#exampleModal .modal-header').html(`確認新增`);
  			// onWorkLocation($(e.relatedTarget).data('latitude'),$(e.relatedTarget).data('longitude'));
  			check();
		}
	});


	$("#inputFile").unbind().on('change',function(e){
	    var ext = $("#inputFile").val().split(".").pop().toLowerCase();
	    if(table!=undefined)
			table.destroy();
	    if($.inArray(ext, ["csv"]) == -1) {
		    // alert('Upload CSV');
		    return false;
		} 
	    if (e.target.files != undefined) {
		    var reader = new FileReader();
			reader.onload = function(e) {
			    var lines = e.target.result.split('\r\n');
			    lines.shift();
			    $('tbody').html('');
			    $.each(lines, function(i,val){      
			      	var tmparr = val.split(',');
			      	// console.log(tmparr);
					$('tbody').append(`
						<tr name="inputData"> 
					      <td data-type="id">${tmparr[0]}</td>
					      <td data-type="name">${tmparr[1]}</td>
					      <td data-type="time">${tmparr[2]}</td>
					      <td data-type="year">${tmparr[3]}</td>
					    </tr>
					`);
				}); 

		        table = $('#dataTable').DataTable({  
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
		    };
		    reader.readAsText(e.target.files.item(0));
	    }
	    return false;
	});
});
var data;
function check(){
	data = [];
	$('[name="inputData"]').each(function(){
      	// console.log($(this).find('[data-type="id"]').text());
      	tmpID =$(this).find('[data-type="id"]').text() ;
      	tmpName =$(this).find('[data-type="name"]').text() ;
      	tmpTime =$(this).find('[data-type="time"]').text() ;
      	tmpYear =$(this).find('[data-type="year"]').text() ;
      	var tmpjson= {
		        "id": tmpID,
		        "name": tmpName,
		        "time": tmpTime,
		        "year" : tmpYear };
		data.push(tmpjson);
    });
    $.ajax({
  		url:`/workTime/check`,
  		type:'POST',
  		data:{
  			data:JSON.stringify({data})
		},
  		dataType:'json',
  		success:function(response){
  			if(response.status == 'success'){
  				$('#exampleModal .modal-body').html(`${response.message}`);
  				$('#exampleModal .modal-footer').append(`
  					<button type="button" class="btn btn-primary" id="sureInsert">確定</button>

  					`);
  			}else{
  				$('#exampleModal .modal-body').html(`${response.message}`);
  			}
  			$("#sureInsert").unbind().on('click',function(e){
  				inserTime();
  			});

  		}
  	});
}
function inserTime(){
	 $.ajax({
  		url:`/workTime`,
  		type:'POST',
  		data:{
  			data:JSON.stringify({data})
		},
  		dataType:'json',
  		success:function(response){
  			$('#exampleModal').modal('hide');
  		}
  	});
}

</script>