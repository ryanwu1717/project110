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
              		<button type="button mb-3" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-3" name="btnCheckin" data-type="onWork" data-target="#exampleModal" data-toggle="modal" >
              			<p>
              				<i class="fas fa-bell fa-fw fa-3x"></i>
              			</p>
              			上班打卡
              		</button>
              	</div>
              	<div class="col-md-6">
              		<button type="button mb-3" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-3" name="btnCheckin" data-type="offWork" data-target="#exampleModal" data-toggle="modal" >
              			<p>
              				<i class="fas fa-bell-slash  fa-fw fa-3x"></i>
              			</p>
              			下班打卡
              		</button>
              	</div>
              	<div class="col-md-6">
              		<button type="button mb-3" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-3" name="btnCheckin" data-type="makeUp" data-target="#exampleModal" data-toggle="modal">
              			<p>
              				<i class="fa fa-plus fa-3x" aria-hidden="true"></i>

              			</p>
              			補打卡
              		</button>
              	</div>
              	<div class="col-md-6">
              		<button type="button mb-3" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-3" name="btnCheckin" data-type="addWork" data-target="#exampleModal" data-toggle="modal">
              			<p>
              				<i class="fa fa-pencil-alt fa-3x" aria-hidden="true"></i>

              			</p>
              			申請加班
              		</button>
              	</div>
            </div>
		</div>
	</div>
	<!-- <h2>現在日期：<span id="nowdate"></span></h2> -->
	<!-- <h2>現在時間：<span id="nowtime"></span></h2> -->

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

<div class="modal fade" id="secondModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="secondModalLabel">Modal title</h5>
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
  include('partial/footer.php');
?>
<script type="text/javascript">
$('#checkInModel').hide();

var chineseNumA = new Array("零","一", "二", "三", "四", "五", "六", "七", "八", "九");
var chineseNumB = new Array("","十","二十","三十");
var todayYear,todayMonth,todayDate,todayDay,todayFullDate,nowFullTime,doType,nextFullTime;
var doType;

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

function inMakeUp(tmplatitude,tmplongitude){
	
	
	var tmpdate = new Date();
	tmpdate.setDate(tmpdate.getDate() - 7);
	makeupYear = tmpdate.getFullYear();
	makeupMonth = tmpdate.getMonth()+1;
	makeupDate = tmpdate.getDate();
	if(makeupMonth/10<1){
		makeupMonth = '0'+makeupMonth;
	}
	if(makeupDate/10<1){
		makeupDate = '0'+makeupDate;
	}

	if(todayMonth/10<1){
		todayMonth = '0'+todayMonth;
	}
	if(todayDate/10<1){
		todayDate = '0'+todayDate;
	}

	console.log(makeupYear+'-'+makeupMonth+'-'+(makeupDate)+'T00:00');
	$('#exampleModal .modal-body').prepend(`
		<form>
		  <div class="form-group row">
		    <label for="staticEmail" class="col-sm-2 col-form-label">補卡</label>
		    <div class="col-sm-5 my-2">
		      <div class="form-check">
				  <input class="form-check-input" type="radio" value="onWork" name='radioBtnType'>
				  <label class="form-check-label" for="defaultCheck1">
				    上班打卡
				  </label>
				</div>
			</div>
			<div class="col-sm-5 my-2">
				<div class="form-check">
				  <input class="form-check-input" type="radio" value="offWork" name='radioBtnType'>
				  <label class="form-check-label" for="defaultCheck1">
				    下班打卡
				  </label>
				</div>
		    </div>
		  </div>
		  	<div class="form-group row">
				<label for="staticEmail" class="col-sm-3 col-form-label">補卡時間</label>
			    <div class="col-sm-9">
			    	<input class="form-control" type="datetime-local" value="" id="inputDateandTime" min="${makeupYear+'-'+makeupMonth+'-'+makeupDate+'T00:00'}" max="${todayYear+'-'+todayMonth+'-'+todayDate+'T00:00'}">
			    </div>
		  	</div>
		  	<div class="form-group row">
				<label for="staticEmail" class="col-sm-3 col-form-label">補卡原因</label>
			    <div class="col-sm-9">
			    	<textarea class="form-control" style="word-wrap:break-word;width:100%;"placeholder="請在此輸入補卡原因" id="textinput"></textarea>
			    </div>
		  	</div>
		  	</div>
		  	
		 </form>

	`);
	
	console.log(todayYear+'-'+todayMonth+'-'+todayDate+'T00:00');
	// $('#inputDateandTime').attr({"min" : todayYear+'-'+todayMonth+'-'+(todayDate-7)});

	
	$('#makeUpBtn').on('click',function(e){
		var tmpType = $('[name=radioBtnType]:checked').val();
		var tmpTime = $('#inputDateandTime').val();
		var cause = $('#textinput').val();

		
		$.ajax({
	  		url:'/work/makeup/check',
	  		type:'POST',
	  		data:{
	  			data:JSON.stringify({
	  				type : tmpType,
	  				cause : cause,
	  				time : tmpTime
	  			})
			},
			dataType:'json',
	  		success:function(response){
	  			$('#secondModal .modal-title').html('補打卡');
	  			$('#secondModal .modal-body').html(response.content);
	  			$('#secondModal .modal-footer').html('<button type="button" class="btn btn-secondary" id="backBtn">返回</button>');
	  			if(response.status == 'success'){
	  				$('#secondModal .modal-footer').append('<button type="button" class="btn btn-primary" id="makeUpLastBtn">確定</button>');
	  			}
	  			$('#exampleModal').modal('hide');
	  			$('#secondModal').modal('show');

	  			$('#backBtn').on('click',function(e){
	  				$('#secondModal').modal('hide');
	  				$('#secondModal').on('hidden.bs.modal', function (e) {
	  					$('#exampleModal').modal('show');
					})
	  			});

	  			$('#makeUpLastBtn').on('click',function(e){

	  				makeup(tmpType,cause,tmpTime,tmplatitude,tmplongitude);
	  			});

	  		}
	  	});

	});	
}

function makeup(tmpType,cause,time,tmplatitude,tmplongitude){
	var timeArr = time.split('T');
		console.log(timeArr);
	$.ajax({
  		url:'/work/makeup',
  		type:'POST',
  		data:{
  			data:JSON.stringify({
  				type : tmpType,
  				cause : cause,
  				date : timeArr[0],
  				time : timeArr[1]+':00',
  				latitude : tmplatitude,
  				longitude : tmplongitude
  			})
		},
		dataType:'json',
  		success:function(response){
  			$('#secondModal').modal('hide');
  		}
  	});
}

function onWork(position){
	tempLocation = "("+ position.coords.latitude+","+position.coords.longitude+")";

	$('#exampleModal .modal-footer').prepend('<button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>');
	$('#exampleModal .modal-body').html(
		`<div class="card-body">
		    <a onclick="window.open('https://www.google.com.tw/maps/place/${position.coords.latitude+","+position.coords.longitude}');" href="#" class="text-decoration-none">確認現在位置</a>

		    <iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.openstreetmap.org/export/embed.html?bbox=${position.coords.longitude}%2C${position.coords.latitude}%2C${position.coords.longitude}%2C${position.coords.latitude}&amp;layer=mapnik&amp;marker=${position.coords.latitude}%2C${position.coords.longitude}" style="border: 1px solid black"></iframe><br/><small><a href="https://www.openstreetmap.org/#map=13/47.5494/-52.8616">查看更大的地圖</a></small>
		    <div id="map">
		    </div>
		  </div>
  		`);
	if(doType == 'makeUp'){
		inMakeUp(position.coords.latitude,position.coords.longitude);
	}
	

	$('#onWorkBtn').on('click',function(e){
		$.ajax({
	  		url:'/work/checkin',
	  		type:'POST',
	  		data:{
	  			data:JSON.stringify({
						 date : todayFullDate,
						 time : nowFullTime,
						 location : tempLocation,
						 type : doType,
						 latitude:position.coords.latitude,
						 longitude: position.coords.longitude
	  			})
			},
	  		dataType:'json',
	  		success:function(response){
	      		// if(response.status = "success")
	      		// {
	      		if(response.status == 'toQuick'){
	      			// $('#checkInModel').show();
	      			$('#exampleModal .modal-body').html('打卡失敗</br>');
	      			$('#exampleModal .modal-body').append(response.time+'後重新嘗試');
	      			$('#exampleModal .modal-footer').html('<button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>');
	      		}else if(response.status == 'success'){
	      			$('#exampleModal .modal-body').html('打卡成功</br>');
	      			$('#exampleModal .modal-footer').html('<button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>');
	      		}
	      		// }
	  		}
	  	});

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
	$('#nowdate').append(todayYear+'年'+todayMonth+'月'+todayDate+'日\t'+'星期'+chineseNumA[todayDay]);


 

	
	$('#exampleModal').on('shown.bs.modal', function (e) {
		
		
  		var type = $(e.relatedTarget).data('type');
  		if(type == 'onWork'){
  			$('#exampleModal .modal-body').html(`
			<div class="spinner-border text-primary" role="status">
			  <span class="sr-only">Loading...</span>
			</div>`);
  			$('#exampleModal .modal-title').html('上班打卡');
  			$('#exampleModal .modal-footer').html('<button type="button" class="btn btn-primary" id = "onWorkBtn">確定</button>');
  			navigator.geolocation.getCurrentPosition(onWork);
  			doType = 'onWork';
  			// onWork();
  		}else if(type == 'offWork'){
  			$('#exampleModal .modal-body').html(`
			<div class="spinner-border text-primary" role="status">
			  <span class="sr-only">Loading...</span>
			</div>`);
  			$('#exampleModal .modal-title').html('下班打卡');
  			$('#exampleModal .modal-footer').html('<button type="button" class="btn btn-primary" id = "onWorkBtn">確定</button>');
  			navigator.geolocation.getCurrentPosition(onWork);
  			doType = 'offWork';
  		}else if(type == 'makeUp'){
  			$('#exampleModal .modal-body').html(`
			<div class="spinner-border text-primary" role="status">
			  <span class="sr-only">Loading...</span>
			</div>`);
  			$('#exampleModal .modal-title').html('補打卡');
  			$('#exampleModal .modal-footer').html('<button type="button" class="btn btn-primary" id = "makeUpBtn">確定</button>');
  			navigator.geolocation.getCurrentPosition(onWork);
  			doType = 'makeUp';
  		}

	});

	// $('[name=btnCheckin]').on('click',function(e){
	// 	// console.log($(this).data('type'));
	// 	doType = $(this).data('type');
		// navigator.geolocation.getCurrentPosition(showPosition);
	// })

	
});

</script>