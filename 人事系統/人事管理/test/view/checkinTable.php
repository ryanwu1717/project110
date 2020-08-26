<?php
  include('partial/header.php');
?>
<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">出勤紀錄</h6>
	</div>
	<div class="card-body">
		<form>
		  <div class="form-group row">
		    <label for="staticEmail" class="col-sm-2 col-form-label">開始</label>
		    <div class="col-sm-4">
		       <input class="form-control" type="date" value="" id="inputStart">
		    </div>
		    <label for="staticEmail" class="col-sm-2 col-form-label">結束</label>
		    <div class="col-sm-4">
		       <input class="form-control" type="date" value="" id="inputEnd">
		    </div>
		  </div>
		  <div class="form-group row">
		    <div class="col-sm-6 ">
				 <button type="button" id="searchCheckin" class="btn btn-primary">查詢</button>

		    </div>
		    <label for="staticEmail" class="col-sm-2 col-form-label">選擇</label>
		    <div class="col-sm-4">
		       <div class="btn-group" role="group" aria-label="Basic example">
				  <button type="button" name="searchBy" data-type="week" class="btn btn-secondary">本週</button>
				  <button type="button" name="searchBy" data-type="month" class="btn btn-secondary">本月</button>
				</div>
		    </div>
		   
		  </div>
		  
		</form>
		<div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

				<thead>
					<tr>

						<th>日期</th>
						<th>班別</th>
						<th>上班</th>
						<th>下班</th>
						<th>工時</th>
						<th>出勤狀況</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>日期</th>
						<th>班別</th>
						<th>上班</th>
						<th>下班</th>
						<th>工時</th>
						<th>出勤狀況</th>
					</tr>
				</tfoot>
				<tbody id="tbodyCheckin">
                	    
        		</tbody>
			</table>
		</div>
	</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
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

</div>
<?php
  include('partial/footer.php');
?>
<script src="/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script type='text/javascript'>
var d = new Date();

var month = d.getMonth()+1;
var day = d.getDate();

var output = d.getFullYear() + '-' +
    (month<10 ? '0' : '') + month + '-' +
    (day<10 ? '0' : '') + day;

var dayArray = {'MONDAY': '星期一' , 'TUESDAY': '星期二','WEDNESDAY': '星期三', 'THURSDAY': '星期四' ,'FRIDAY': '星期五' ,'SATURDAY': '星期六' ,'SUNDAY': '星期日'};
console.log(dayArray.MONDAY);

$(function(){
	$('#inputStart').val(output);
	$('#inputEnd').val(output);
	$('#searchCheckin').on('click', function (e) {
		var start = $('#inputStart').val();
		var end = $('#inputEnd').val();
		$.ajax({
	  		url:`/work/checkin/term/${start}/${end}`,
	  		type:'GET',
	  		data:{
			},
	  		dataType:'json',
	  		success:function(response){
	  			insertTable(response);
	  		}
	  	});
	});
	$('[name="searchBy"]').on('click', function (e) {
		console.log($(this).data('type'));
		$.ajax({
	  		url:`/work/checkin/by/${$(this).data('type')}`,
	  		type:'GET',
	  		data:{
			},
	  		dataType:'json',
	  		success:function(response){
	  			insertTable(response);
	  		}
	  	});
	});

	$('#exampleModal').on('shown.bs.modal', function (e) {
  		var type = $(e.relatedTarget).data('type');
  		$('#exampleModal .modal-body').html(`
			<div class="spinner-border text-primary" role="status">
			  <span class="sr-only">Loading...</span>
			</div>`);
		$('#exampleModal .modal-footer').html('<button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>');

  		if(type == 'onWorkLocation'){
  			$('#exampleModal .modal-header').html(`打卡位置`);
  			onWorkLocation($(e.relatedTarget).data('latitude'),$(e.relatedTarget).data('longitude'));
		}
	});

	// $.ajax({
 //  		url:'/work/checkin',
 //  		type:'GET',
 //  		data:{
	// 	},
 //  		dataType:'json',
 //  		success:function(response){
 //  			$.each(response.info,function(){
 //  				console.log(this);
 //  				$('#tbodyCheckin').append(`
 //  					<tr>
 //  						<td>${this.checkinDate}</td>
 //  						<td></td>
 //  						<td>
 //  							${this.inTime}
 //  							<button type="button" class="btn btn-primary sm float-right" data-latitude="${this.latitude}"  data-longitude="${this.longitude}" data-type = 'onWorkLocation' data-toggle="modal" data-target="#exampleModal"><i class="fas fa-map-marker-alt"></i></button>
 //  						</td>
 //  						<td>
 //  							${this.outTime}
 //  							<button type="button" class="btn btn-primary sm float-right" data-latitude="${this.outlatitude}"  data-longitude="${this.outlongitude}" data-type = 'onWorkLocation' data-toggle="modal" data-target="#exampleModal"><i class="fas fa-map-marker-alt"></i></button>
 //  						</td>
 //  						<td></td>
 //  						<td></td>
 //  					</tr>
 //  				`);
 //  			});
  			
 //  		}
 //  	});
});
var table;
function insertTable(data){
	if(table!=undefined)
		table.destroy();
	$('#tbodyCheckin').empty();

	$.each(data.info,function(){
		var tmpDay = (this.weekDay).trim();


		if(this.checkinDate == null){
			$('#tbodyCheckin').append(`
				<tr>
					<td>${this.date}</br>(${dayArray[tmpDay]})</td>
					<td>${this.workType == null?'未設定': (this.workType == 'workOnoff'?'上班下班制':'時間制')}</td>
					<td>
						${this.checkinTime == null?'未打卡':this.checkinTime}
						<button type="button" class="btn btn-primary sm float-right" data-latitude="${this.latitude}"  data-longitude="${this.longitude}" data-type = 'onWorkLocation' data-toggle="modal" data-target="#exampleModal"><i class="fas fa-map-marker-alt"></i></button>
					</td>
					<td>
						${this.checkoutTime == null?'未打卡':this.checkoutTime}
						<button type="button" class="btn btn-primary sm float-right" data-latitude="${this.outlatitude}"  data-longitude="${this.outlongitude}" data-type = 'onWorkLocation' data-toggle="modal" data-target="#exampleModal"><i class="fas fa-map-marker-alt"></i></button>
					</td>
					<td>未打卡</td>
					<td>曠職</td>
				</tr>
			`);
		}else {
			$('#tbodyCheckin').append(`
				<tr>
					<td>${this.date}</br>(${dayArray[tmpDay]})</td>
					<td>${this.workType == null?'未設定': (this.workType == 'workOnoff'?'上班下班制':'時間制')}</td>
					<td>
						${this.checkinTime == null?'未打卡':this.checkinTime}
						<button type="button" class="btn btn-primary sm float-right" data-latitude="${this.latitude}"  data-longitude="${this.longitude}" data-type = 'onWorkLocation' data-toggle="modal" data-target="#exampleModal"><i class="fas fa-map-marker-alt"></i></button>
					</td>
					<td>
						${this.checkoutTime == null?'未打卡':this.checkoutTime}
						<button type="button" class="btn btn-primary sm float-right" data-latitude="${this.outlatitude}"  data-longitude="${this.outlongitude}" data-type = 'onWorkLocation' data-toggle="modal" data-target="#exampleModal"><i class="fas fa-map-marker-alt"></i></button>
					</td>
					<td>${(this.diff == null?'缺卡':this.diff) }</td>
					<td>${this.workType == null?'未設定班別': (this.type == 'workOnoff'?this.onoffStatus:this.hoursStatus)}</td>
				</tr>
			`);
		}
		
	
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
	      aria: {
	        "sortAscending": ": 升冪排列",
	        "sortDescending": ": 降冪排列"
	      }
	    }
 	 });
	
}
function onWorkLocation(latitude,longitude){
	if (latitude == null || longitude == null ) {
		$('#exampleModal .modal-body').html(`未打卡`);
	}else{
		$('#exampleModal .modal-body').html(
			`<div class="card-body">
			    <a onclick="window.open('https://www.google.com.tw/maps/place/${latitude+","+longitude}');" href="#" class="text-decoration-none">確認現在位置</a>

			    <iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.openstreetmap.org/export/embed.html?bbox=${longitude}%2C${latitude}%2C${longitude}%2C${latitude}&amp;layer=mapnik&amp;marker=${latitude}%2C${longitude}" style="border: 1px solid black"></iframe><br/><small><a href="https://www.openstreetmap.org/#map=13/47.5494/-52.8616">查看更大的地圖</a></small>
			    <div id="map">
			    </div>
			  </div>
	  		`);

	}

		
}
</script>

