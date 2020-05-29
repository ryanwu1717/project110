<?php
  include('partial/header.php');
?>
	<div class="card o-hidden shadow-lg py-5">
		<div class="card-body">
			<div class="row">
				<div class="col-md-3">

				</div>
				<div class="col-md-6">
					<div class="col-md-12">
						<div class="text-center">
		                  	<h4  class="font-weight-bold" id = "nowdate"></h4>
						</div>
					</div>
					<div class="col-md-12">
						<div class="text-center">
		                  	<h1  class="font-weight-bold" id = "nowtime" style="color: #1E90FF"></h1>
						</div>
					</div>
					
				</div>
                <div class="col-md-3">
                  	
              	</div>
              	<div class="col-md-6">
              		<button type="button mb-3" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-3" name="btnCheckin" data-type="上班打卡">上班打卡</button>
                  	
              	</div>
              	<div class="col-md-6">
              		<button type="button mb-3" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-3" name="btnCheckin" data-type="下班打卡">下班打卡</button>
                  	
              	</div>
              	
            </div>
		</div>
	</div>
	<!-- <h2>現在日期：<span id="nowdate"></span></h2> -->
	<!-- <h2>現在時間：<span id="nowtime"></span></h2> -->

	<div class="modal fade" id="checkInModel" tabindex="-1" role="dialog" aria-labelledby="checkInModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" name="checkInModalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" name="showText">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
          <button type="button" class="btn btn-primary" name = "lastCheckinButton" data-toggle="modal" data-target="#lastModel">確定</button>
        </div>
      </div>
    </div>
  </div>

<?php
  include('partial/footer.php');
?>
<script type="text/javascript">
$('#checkInModel').hide();

var chineseNumA = new Array("零","一", "二", "三", "四", "五", "六", "七", "八", "九");
var chineseNumB = new Array("","十","二十","三十");
var todayYear,todayMonth,todayDate,todayDay,todayFullDate,nowFullTime,doType,nextFullTime;

showTime();	
function showTime(){
	var today = new Date();
	var hour=
	parseInt(today.getHours())<10 
	? '0'+today.getHours() 
	: today.getHours();

	var min=
	parseInt(today.getMinutes())<10 
	? '0'+today.getMinutes() 
	: today.getMinutes();

	var sec=
	parseInt(today.getSeconds())<10 
	? '0'+today.getSeconds() 
	: today.getSeconds();
	$('#nowtime').empty();
	$('#nowtime').append(hour+':'+min+':'+sec);
	nowFullTime = hour + ':'+ min + ':'+ sec;
	var tmpAdd =(min+30)/60;
	if(tmpAdd>=1){
		if(((min+30)%60)<10){
			nextFullTime = (hour+1) + ':0'+ ((min+30)%60) + ':'+ sec;
		}else{
			nextFullTime = (hour+1) + ':'+ ((min+30)%60) + ':'+ sec;
		}
		
	}else{
		nextFullTime = hour + ':'+ (min+30) + ':'+ sec;
	}
	// nextFullTime
	// var theAdd = new Date(nowFullTime);
	// nextFullTime = theAdd.setMinutes(theAdd.getMinutes() + 30);
	// console.log(nextFullTime);

}
function showPosition(position){
		tempLocation = "("+ position.coords.latitude+","+position.coords.longitude+")";
		console.log(tempLocation,todayFullDate,nowFullTime,doType);
		$.ajax({
  		url:'/work/checkin',
  		type:'POST',
  		data:{
  			data:JSON.stringify({
					 date : todayFullDate,
					 time : nowFullTime,
					 location : tempLocation,
					 type : doType
           // hours : hours,
           // minutes : minutes,
           // seconds : seconds 
  			})
			},
  		dataType:'json',
  		success:function(response){
      		// if(response.status = "success")
      		// {
      		if(response.status == 'toQuick'){
      			// $('#checkInModel').show();
      			$('[name=checkInModalLabel]').empty();
      			$('[name=showText]').empty();
      			$('[name=checkInModalLabel]').append('打卡失敗');
      			$('[name=showText]').append(response.time+'後重新嘗試');
      			$('[name=lastCheckinButton]').hide();
      			
      			$('#checkInModel').modal('show');
      			console.log(response.status);
      		}else if(response.status == 'toQuick'){
      			$('[name=checkInModalLabel]').empty();
      			// $('[name=showText]').empty();
      			$('[name=checkInModalLabel]').append('打卡成功');
      			// $('[name=showText]').append(response.time+'後重新嘗試');
      			$('[name=lastCheckinButton]').hide();
      			
      			$('#checkInModel').modal('show');
      		}
      		// }
  		}
	}); 
}

$(function(){
	setInterval(showTime,1000);
	var today = new Date();
	todayYear = today.getFullYear();
	todayMonth = today.getMonth()+1;
	todayDate = today.getDate();
	todayDay = today.getDay();
	todayFullDate = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
	$('#nowdate').append(todayMonth+'月'+todayDate+'日'+todayYear+'\t'+'星期'+chineseNumA[todayDay]);

	$('[name=btnCheckin]').on('click',function(e){
		// console.log($(this).data('type'));
		doType = $(this).data('type');
		navigator.geolocation.getCurrentPosition(showPosition);
	})

	
});

</script>