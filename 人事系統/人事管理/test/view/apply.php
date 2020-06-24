<?php
  include('partial/header.php');
?>

<div class="card o-hidden shadow-lg py-5">
    <div class="card-body">
        <form>
            <!-- Nested Row within Card Body -->
            <div class="row">
            	<div class="col-md-12">
                	<div class="text-center">
                    	<h1  class="font-weight-bold" name = "typeUpdate">我要請假</h1>
                  	</div>
                </div>
            	<div class="col-md-6">
                	<div class="text-center">
                    	<h2 class="h4 text-gray-900 mb-4">申請人:<span class="text-info"><?=@$name?></span>
                    	<button class="btn btn-primary" id="otherApply">代他人申請</button></h2>
                  	</div>
                </div>
                <div class="col-md-6">
                	<div class="text-center">
                    	<h2 class="h4 text-gray-900 mb-4">申請時間:<span class="text-info" id="applyTime"></span></h2>
                  	</div>
                </div>
                <div class="col-md-6">
                    	<div class="form-group row">
	                		<lable class="col-form-label col-md-4">假別:</lable>
	                		<div class="col-md-8">
	                    		<select name="Vacation" id="Vacation" class="m-b-10 sourceSelect2 valid">	
		                    		<option selected="" value="0">休假/特別休假</option>
		                            <option value="1">事假</option>
		                            <option value="2">病假</option>
		                            <option value="3">延長病假</option>
		                            <option value="4">婚假</option>
		                            <option value="5">喪假</option>
		                            <option value="6">5/1勞動節</option>
		                            <option value="7">家庭照顧假</option>
		                            <option value="8">暑休</option>
		                            <option value="9">寒休</option>
		                            <option value="10">公傷假</option>
		                            <option value="11">加班補休</option>
		                            <option value="12">出差補休</option>
		                            <option value="13">值班補休</option>
		                            <option value="14">公假補休</option>
		                            <option value="15">留職停薪</option>
		                            <option value="16">其他假</option>
		                            <option value="17">輪休</option>
		                        </select>
		                    </div>
	                    </div>
                </div>
                <div class="col-md-6">
                	<div class="text-center">
                		休假尚有<span name=""></span>天
                	</div>
                </div>
                <div class="col-md-12">
                	<div class="text-center">
                    	<h1  class="h4 text-gray-900 mb-4" name = "typeUpdate">請假時間</h1>
                  	</div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                      	<label class="col-form-label col-md-4">開始時間</label>
                      	<div class="col-md-8">  
                        	<div class='input-group date' id='datetimepicker1'>
			                    <input type="date" id="firstDate">
			                    <select id="firstTimeTable" class="m-b-10 sourceSelect2 valid">
			                    	<option selected="selected">請選擇</option>
			                    	<option value="00:00">00:00</option>
			                    	<option value="00:30">00:30</option>
			                    	<option value="01:00">01:00</option>
			                    	<option value="01:30">01:30</option>
			                    	<option value="02:00">02:00</option>
			                    	<option value="02:30">02:30</option>
			                    	<option value="03:00">03:00</option>
			                    	<option value="03:30">03:30</option>
			                    	<option value="04:00">04:00</option>
			                    	<option value="04:30">04:30</option>
			                    	<option value="05:00">05:00</option>
			                    	<option value="05:30">05:30</option>
			                    	<option value="06:00">06:00</option>
			                    	<option value="06:30">06:30</option>
			                    	<option value="07:00">07:00</option>
			                    	<option value="07:30">07:30</option>
			                    	<option value="08:00">08:00</option>
			                    	<option value="08:30">08:30</option>
			                    	<option value="09:00">09:00</option>
			                    	<option value="09:30">09:30</option>
			                    	<option value="10:00">10:00</option>
			                    	<option value="10:30">10:30</option>
			                    	<option value="11:00">11:00</option>
			                    	<option value="11:30">11:30</option>
			                    	<option value="12:00">12:00</option>
			                    	<option value="12:30">12:30</option>
			                    	<option value="13:00">13:00</option>
			                    	<option value="13:30">13:30</option>
			                    	<option value="14:00">14:00</option>
			                    	<option value="14:30">14:30</option>
			                    	<option value="15:00">15:00</option>
			                    	<option value="15:30">15:30</option>
			                    	<option value="16:00">16:00</option>
			                    	<option value="16:00">16:30</option>
			                    	<option value="17:00">17:00</option>
			                    	<option value="17:30">17:30</option>
			                    	<option value="18:00">18:00</option>
			                    	<option value="18:30">18:30</option>
			                    	<option value="19:00">19:00</option>
			                    	<option value="19:30">19:30</option>
			                    	<option value="20:00">20:00</option>
			                    	<option value="20:30">20:30</option>
			                    	<option value="21:00">21:00</option>
			                    	<option value="21:30">21:30</option>
			                    	<option value="22:00">22:00</option>
			                    	<option value="22:30">22:30</option>
			                    	<option value="23:00">23:00</option>
			                    	<option value="23:30">23:30</option>
			                    </select>
			                </div>
                      	</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                      	<label class="col-form-label col-md-4">結束時間</label>
                      	<div class="col-md-8">  
                        	<div class='input-group date' id='datetimepicker2'>
			                    <input type="date" id="secondDate">
			                    <select id="secondTimeTable" class="m-b-10 sourceSelect2 valid">
			                    	<option selected="selected">請選擇</option>
			                    	<option value="00:00">00:00</option>
			                    	<option value="00:30">00:30</option>
			                    	<option value="01:00">01:00</option>
			                    	<option value="01:30">01:30</option>
			                    	<option value="02:00">02:00</option>
			                    	<option value="02:30">02:30</option>
			                    	<option value="03:00">03:00</option>
			                    	<option value="03:30">03:30</option>
			                    	<option value="04:00">04:00</option>
			                    	<option value="04:30">04:30</option>
			                    	<option value="05:00">05:00</option>
			                    	<option value="05:30">05:30</option>
			                    	<option value="06:00">06:00</option>
			                    	<option value="06:30">06:30</option>
			                    	<option value="07:00">07:00</option>
			                    	<option value="07:30">07:30</option>
			                    	<option value="08:00">08:00</option>
			                    	<option value="08:30">08:30</option>
			                    	<option value="09:00">09:00</option>
			                    	<option value="09:30">09:30</option>
			                    	<option value="10:00">10:00</option>
			                    	<option value="10:30">10:30</option>
			                    	<option value="11:00">11:00</option>
			                    	<option value="11:30">11:30</option>
			                    	<option value="12:00">12:00</option>
			                    	<option value="12:30">12:30</option>
			                    	<option value="13:00">13:00</option>
			                    	<option value="13:30">13:30</option>
			                    	<option value="14:00">14:00</option>
			                    	<option value="14:30">14:30</option>
			                    	<option value="15:00">15:00</option>
			                    	<option value="15:30">15:30</option>
			                    	<option value="16:00">16:00</option>
			                    	<option value="16:00">16:30</option>
			                    	<option value="17:00">17:00</option>
			                    	<option value="17:30">17:30</option>
			                    	<option value="18:00">18:00</option>
			                    	<option value="18:30">18:30</option>
			                    	<option value="19:00">19:00</option>
			                    	<option value="19:30">19:30</option>
			                    	<option value="20:00">20:00</option>
			                    	<option value="20:30">20:30</option>
			                    	<option value="21:00">21:00</option>
			                    	<option value="21:30">21:30</option>
			                    	<option value="22:00">22:00</option>
			                    	<option value="22:30">22:30</option>
			                    	<option value="23:00">23:00</option>
			                    	<option value="23:30">23:30</option>
			                    </select>
			                </div>
                      	</div>
                    </div>
                </div>
                <div class="col-md-12">
                	<div class="text-center">
                    	<h2 class="h4 text-gray-900 mb-4">請假理由</h2>
                  	</div>
                </div>
                <div class="col-md-12">
	                <div class="form-group row">
					    <textarea class="form-control" id="reason" rows="3"></textarea>
					</div>
				</div>
                <div class="col-md-12">
                	<div class="text-center">
                    	<h2 class="h4 text-gray-900 mb-4">附件檔案</h2>
                  	</div>
                </div>
                <div class="col-md-6">
	                <div class="card">
	      				<div class="card-body p-0">
	                		<input name="inputFile" type="file" value="選擇檔案">
	                		<br/>
	                		<div id = "fileDownload"></div>
	                	</div>
	                </div>
	            </div>
	            <div class="col-md-12">
	            	<div class="text-center">
	            		</br>
	            		<button type="button" class="btn btn-primary btn-lg" onclick="go()">送出</button>
	            	</div>
				</div>
            </div>
    	</form>
  	</div>
</div>
<?php
  include('partial/footer.php');
?>

<script language="javascript">


	$('[name=inputFile]').on('change',function(){
		var file_data = $(this).prop('files')[0];
		var form_data = new FormData();
		if(file_data){
			form_data.append('inputFile', file_data);
			$.ajax({
			    url: '/work/holiday/file',
			    cache: false,
			    contentType: false,
			    processData: false,
			    data: form_data,     //data只能指定單一物件
			    type: 'post',
			    dataType:'json',
			    success: function(data){
			    	console.log(data.fileID);
			    	$('#fileDownload').append("<div id = 'remove" + data.fileID + "'>");
			    	$('#remove' + data.fileID).append($('<button type = "button"></button>')
			    		.addClass("btn btn-primary")
			    		.attr('href','/work/holiday/file/' + data.fileID)
			    		.text(data.fileNameClient));
			    	$('#remove' + data.fileID).append($("<button type = 'button' ></button>")
			    		.addClass("btn btn-light text text-danger")
			    		.text("X")
			    		.attr('onclick', "del("+data.fileID+")")
			    		);
			    	$('#fileDownload').append("<div/>");
				}
			});	
			
		}else{
			$('#fileDownload').val("");
		}
		
	});


	function del(id){
		console.log(id);
		console.log($("#remove"+id));
		$("#remove"+id).remove();
	}

	function go(){
		var type;
		var startTime;
		var endTime;
		var reason;
		var fileId;
		type = $("#Vacation").val();
		startTime = $("#firstDate").val() + " " + $("#firstTimeTable").val();
		endTime = $("#secondDate").val() + " " + $("#secondTimeTable").val();
		reason = $("#reason").val();
		fileId = $('#fileDownload').text();
		$.ajax({
			url: '/work/holiday/holidayAsk',
			type: 'POST',
			dataType: 'json',
			data: {
				data:JSON.stringify({
					type : type,
					startTime : startTime,
					endTime : endTime,
					reason : reason,
        		})
			},
			success: function(e){
				$("#reason").val("");
			}
		})
	}




</script>