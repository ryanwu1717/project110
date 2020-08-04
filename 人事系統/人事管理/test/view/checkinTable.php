<?php
  include('partial/header.php');
?>
<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">出勤紀錄</h6>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table cellspacing="0" class="table table-bordered display"  id="dataTable" width="100%" >
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
<script type='text/javascript'>
$(function(){
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



	$.ajax({
  		url:'/work/checkin',
  		type:'GET',
  		data:{
		},
  		dataType:'json',
  		success:function(response){
  			$.each(response.info,function(){
  				console.log(this);
  				$('#tbodyCheckin').append(`
  					<tr>
  						<td>${this.checkinDate}</td>
  						<td></td>
  						<td>
  							${this.inTime}
  							<button type="button" class="btn btn-primary sm float-right" data-latitude="${this.latitude}"  data-longitude="${this.longitude}" data-type = 'onWorkLocation' data-toggle="modal" data-target="#exampleModal"><i class="fas fa-map-marker-alt"></i></button>
  						</td>
  						<td>
  							${this.outTime}
  							<button type="button" class="btn btn-primary sm float-right" data-latitude="${this.outlatitude}"  data-longitude="${this.outlongitude}" data-type = 'onWorkLocation' data-toggle="modal" data-target="#exampleModal"><i class="fas fa-map-marker-alt"></i></button>
  						</td>
  						<td></td>
  						<td></td>
  					</tr>
  				`);
  			});
  			
  		}
  	});
});

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

