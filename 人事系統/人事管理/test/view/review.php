<?php
  include('partial/header.php');
?>

<div class="row">
  	<div class="col-12">
    	<div class="nav nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
	    	<a class="nav-link active col-4" id="v-pills-home-tab" data-toggle="pill" href="#checking" role="tab" aria-controls="v-pills-home" aria-selected="true">審核中</a>
	      	<a class="nav-link col-4" id="v-pills-profile-tab" data-toggle="pill" href="#checked" role="tab" aria-controls="v-pills-profile" aria-selected="false">審核完成</a>
	      	<a class="nav-link col-4" id="v-pills-messages-tab" data-toggle="pill" href="#failCheck" role="tab" aria-controls="v-pills-messages" aria-selected="false">審核失敗</a>
    	</div>
  	</div>
  	<div class="col-12">
	    <div class="tab-content" id="v-pills-tabContent">
		    <div class="tab-pane fade show active" id="checking" role="tabpanel" aria-labelledby="v-pills-home-tab">
		    	<table class="table table-striped" id="table">
		    		<tr>
		    			<td>假單編號</td>
		    			<td>開始時間</td>
		    			<td>結束時間</td>
		    			<td>申請時間</td>
		    			<td></td>
		    		</tr>
	            </table>
		    </div>
		    <div class="tab-pane fade" id="checked" role="tabpanel" aria-labelledby="v-pills-profile-tab"></div>
		    <div class="tab-pane fade" id="failCheck" role="tabpanel" aria-labelledby="v-pills-messages-tab"></div>
    	</div>
 	</div>
</div>

<?php
  include('partial/footer.php');
?>

<script type="text/javascript">

	$(function(){
		$.ajax({
			url: '/work/holiday/checkingData',
			type: 'GET',
			dataType:'json',
			success: function(data){
                $.each(data, function(i,n){
                    console.log(n["reason"]);

                    var td1 = $('<td>').text(n["id"]);
					var td2 = $('<td>').text(n["startTime"]);
					var td3 = $('<td>').text(n["endTime"]);
					var td4 = $('<td>').text(n["now"].slice(0, 16));
					var btn = $('<button>').text('詳細資料').attr("class", "btn btn-primary");
					var tr = $('<tr>').append(td1,td2,td3,td4, btn);
					$('#table').append(tr);



                });
			}
		});
	});
	

</script>