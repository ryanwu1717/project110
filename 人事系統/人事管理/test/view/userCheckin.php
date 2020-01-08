<?php
  include('partial/header.php');
?>
<style>
html,body{
  margin:0; padding:0;
  width:100%; height:100%;
  background-color: #c0392b;
  font-family: 'PT Sans Narrow', sans-serif;
}
.Wall{
  position:relative;
}
.calendar{
  position:absolute;
  margin:auto;
  left:0; right:0; top:20px;
  width:400px; height:450px;
  background:white;
  box-shadow: 1px 2px 10px black;
}
.frame{
  position:relative;
  width:100%;
  height:100px;
  background:#e74c3c;
}
.screw{
  position:absolute;
  width:40px; height:40px;
  background-color:#bdc3c7;
  border-radius:50px;
  top:30%;
  box-shadow: inset 0px 0px 10px #2c3e50;
  border: 1px solid #7f8c8d;
}
.left{
  left: 15px;
}
.right{
  right:15px;
}
.shine{
  position:absolute;
  background: rgba(255,255,255,0.2);
  width: 30px; height:30px;
  border-radius: 100%;
  left:5px; top:5px;
}
.line{
  position:absolute;
  width:100%; height:3px;
  background-color:#7f8c8d;
  top:18px;
  transform: rotate(20deg);
}
.rerotate{
  transform: rotate(60deg);
}
.year{
  position: absolute;
  width:100%; height:100%;
}
.year h1{ 
  text-align:center; 
  color:white;
  font-size:70px;
  margin:0; padding:0; 
  line-height: 100px; 
} 
.content{ 
  position:absolute;
  width: 100%; height:78%;
} 
.content h1{ 
  text-align:center; 
  font-size: 250px;
  margin:0; padding:0;
  line-height:200px;
}
.content h2{
  text-align:center;
  font-size: 50px;
  margin:0; padding:0;  
  line-height:100px; 
}


</style>

<div class="row">

	<div class="col-md-3">
	</div>
	<div class="col-md-6">
		<div class="Wall">
			<div class="calendar">
		  	<div class="frame">
		    	<div class="left screw">
		      	<div class="line"></div>
		      	<div class="shine"></div>
		    	</div> 
		    	<div class="right screw">
		      	<div class="rerotate line"></div>
		      	<div class="shine"></div>
		    	</div>
		    	<div class="year">
		     	<h1 id="yearCaption">1990</h1>
		    	</div>
		  	</div>   
		  	<div class="content">
		   	 <h2 id="monthCaption">May</h2>
		    	<h1 id="dayCaption">28</h1>
		  	</div>
		  	<div class="over"></div>
		 	</div>
		</div>
	</div>
	<div class="col-md-3">
	</div>
	


	<div class="col-md-4">
	</div>
	<div class="col-md-3">
		<div class ="text-center">
			<div class="card bg-light">
				<h5 class="card-title text-center">
				現在時間
				<div class="d-flex flex-wrap justify-content-center mt-2">
					<a><span class="badge hours"></span></a> :
					<a><span class="badge min"></span></a> :
					<a><span class="badge sec"></span></a>
				</div>
				</h3>

			</div>
		</div>

		<!-- <button type="button" class="btn btn-primary" data-dismiss="modal" data-id="婚姻狀態" data-toggle="modal" data-target="#firstModel">新增</button> -->
	</div>
	<div class="col-md-1" name = "workMode"></br>
		<button type = "button" class ="btn btn-primary" name = "checkInButton" data-dismiss="modal" data-id="<?=@$name?>" data-type="上" data-do="start"  data-toggle="modal" data-target="#checkInModel" style="display:none">上班打卡</button>
		<button type = "button" class ="btn btn-primary" name = "checkOutButton" data-dismiss="modal" data-id="<?=@$name?>" data-type="下" data-do="finish"  data-toggle="modal" data-target="#checkInModel" style="display:none">下班打卡</button>
	</div>
	<div class="col-md-4">
	</div>
	</br></br></br></br></br></br>
</div>

 <!-- Modal -->
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
	$(function(){
		var tempLocation;
		var time;
		var todayDate;
		var tmpId;
		var checkType;
		var doType;
		var date = new Date(); 
		var month = new Array();
		month[0] = "January";
		month[1] = "February";
		month[2] = "March";
		month[3] = "April";
		month[4] = "May";
		month[5] = "June";
		month[6] = "July";
		month[7] = "August";
		month[8] = "September";
		month[9] = "October";
		month[10] = "November";
		month[11] = "December";
		$('#yearCaption').empty();
	    $('#yearCaption').append(date.getFullYear());
	    $('#monthCaption').empty();
	    $('#monthCaption').append(month[date.getMonth()]);
	    $('#dayCaption').empty();
	    $('#dayCaption').append(date.getDate());

	    todayDate = date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate();
	    tmpId = $('[name=checkInButton]').data('id');
		console.log(todayDate);
		$.ajax({
	        url:'/management/work/check/'+tmpId+"/"+todayDate,
	        type:'get',
	        dataType:'json',
	        success:function(response){
	        	// console.log(response);
	          if(response.checkin){
	          	$('[name=checkInButton]').hide();
	          	$('[name=checkOutButton]').show();
	          }else{
			    $('[name=checkInButton]').show();
			    $('[name=checkOutButton]').hide();
	          }
	        }
	    });
	    $.ajax({
	        url:'/management/work/checkAll/'+tmpId+"/"+todayDate,
	        type:'get',
	        dataType:'json',
	        success:function(response){
	        	// console.log(response);
	          if(response.checkin){
	          	$('[name=checkInButton]').hide();
	          	$('[name=checkOutButton]').hide();
	          	$('[name=checkInModalLabel]').append("下班了");

	          }
	        }
	    });

	    $('#checkInModel').on('show.bs.modal',function(e){
      		checkType = $(e.relatedTarget).data('type');
      		doType = $(e.relatedTarget).data('do');
      		console.log(checkType);
      		$('[name=checkInModalLabel]').empty();
      		$('[name=checkInModalLabel]').append(checkType+"班打卡");
      		time = date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
      		$('[name=showText]').empty();
      		$('[name=showText]').append("打卡時間:　"+time);
      		if (navigator.geolocation) {
				// console.log("success");
				navigator.geolocation.getCurrentPosition(showPosition);
			} else { 
				console.log("Geolocation is not supported by this browser.");
			}
  		  	$("button[name=lastCheckinButton]").on('click', function(e){

  		  		navigator.geolocation.getCurrentPosition(checkin);
	      		
	    	});
      	});
      	function checkin(position) {
      		tempLocation = "("+ position.coords.latitude+","+position.coords.longitude+")";
      		$.ajax({
        		url:'/management/work/checkin',
        		type:'POST',
        		data:{
        			data:JSON.stringify(
        				{
        					staff_id : tmpId,
						 	checkinDate : todayDate,
							checkinTime : time,
							location : tempLocation,
							type : doType
        				}
    				)
      			},
        		dataType:'json',
        		success:function(response){
	          		if(response.checkout)
	          		{
	          			window.location.href='/management/checkin'; 
	          		}
        		}
			}); 
      	}
      	
		function showPosition(position) {
			$('[name=showText]').append("</br>"+"Latitude: " + position.coords.latitude + 
		  	"<br>Longitude: " + position.coords.longitude);
		  	// tempLocation = "("+ position.coords.latitude+","+position.coords.longitude+")";
		  	// return (tempLocation);
		}
	});
	// var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
	console.log()
	$(document).ready(function() {
		setInterval( function() {
		var hours = new Date().getHours();
		$(".hours").html(( hours < 10 ? "0" : "" ) + hours);
		}, 1000);
		setInterval( function() {
		var minutes = new Date().getMinutes();
		$(".min").html(( minutes < 10 ? "0" : "" ) + minutes);
		},1000);
		setInterval( function() {
		var seconds = new Date().getSeconds();
		$(".sec").html(( seconds < 10 ? "0" : "" ) + seconds);
		},1000);
	});
	
</script>
