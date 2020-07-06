<?php
  include('partial/header.php');
?>

<div class="card o-hidden shadow-lg py-5">
    <div class="card-body">
    	<form>
    		<div class="col-md-12">
    			<div class="row">
    				<div class="col-lg-6">
    					<div class="form-group row">
		            		<lable class="col-form-label col-4">部門:</lable>
		            		<div class="col-8">
		                		<select id="department" class="form-control valid">
		                            <option selected="" disabled>請選擇</option>
		                        </select>
		                    </div>
	                    </div>
	                </div>
	                <div class="col-lg-6">
	                	<div class="form-group row">
		                    <lable class="col-form-label col-4">編號:</lable>
		            		<div class="col-5">
		            			<input type="text" class="form-control" id="UID">
		            			<div class="invalid-feedback" name="invalid"></div>
		            		</div>
		                    <div class="col-3">
		                		<button type="button" class="btn btn-primary btn-block" onclick="add()">新增</button>
		                	</div>
	                    </div>
                    </div>
                </div>
            </div>
        	</br></br>
            <div class="col-md-12 table-responsive">
            	<table class="table table-striped" id="table">
            		<thead>
            			<tr>
            				<th>層級</th>
            				<th>編號</th>
            				<th>姓名</th>
            				<th>部門</th>
            				<th>刪除</th>
            			</tr>
            		</thead>
            		<tbody></tbody>
            	</table>
            </div>
            <div class="col-md-12">
            	<button type="button" id="sentBtn" class="btn btn-primary btn-block" onclick="sent()">送出</button>
            </div>
    	</form>
    </div>
</div>

<?php
  include('partial/footer.php');
?>

<script type="text/javascript">
	$(function(){
		if($("#department").val() == null){
			$("#table thead").hide();
		}
		$("#sentBtn").hide();
	  	$.ajax({
			url: '/staff/department/get',
			type: 'GET',
			dataType: 'json',
			success: function(response){
				$(response).each(function(index) {
					$("#department").append(`
						<option value="${this.department_id}"> 
							${this.department_name}
						</option>
					`);
				});

			}
		})
		$("#department").change(function() {
			$("#table").find('tbody').empty();
			$("#table thead").show();
			$("#sentBtn").show();
			$.ajax({
				url: '/management/holiday/list/' + $("#department").val(),
				type: 'GET',
				dataType: 'json',
				beforeSend: function(){
				},
				success: function(response){
					console.log(response);
					if(response.length == 0){
						var td = $('<td colspan="5">').text("資料是空的");
						var tr = $('<tr>').append(td);
						$('#table tbody').append(tr);
					}
					$(response).each(function(i,n){
						var tr = $(`
							<tr>
								<td>
									<select name="levelSelect" class="form-control valid"></select>
								</td>
								<td name = 'id'></td>
								<td name = 'name'></td>
								<td name = 'department_name'></td>
								<td>
									<button type="button" name="delBtn${i}" class="btn btn-danger m-1" onclick="del(${i})">刪除</button>
								</td>
							</tr>
						`);

						$.each(n, function(j, x) {
							$(tr).find('td[name = '+ j + ']').text(x);
						});
						
						$('#table tbody').append(tr);
					});
					for(var k = 1; k<=response.length; k++){
						$("[name='levelSelect']").append('<option value='+k+'>' + k +'</option>');
					};
					$("[name='levelSelect']").each(function(index, value) {
						$(value[index]).attr("selected", true);
					});
				}

			})
		});


	});

	//level 判斷在前端
	function sent(){
		var tableList = new Array();
		$.each($("#table tbody").children(), function(i,n){
			var temp = {};
			temp.level = $($(n).find("td")[0]).children().val();
			temp.num = $($(n).find("td")[1]).text();
			temp.named = $($(n).find("td")[2]).text();
			temp.department = $("#department").val();
			tableList.push(temp);
		});
		var isLevel = true;
		for(var i = 0; i<tableList.length; i++){
			for(var j = i + 1; j < tableList.length; j++){
				if(tableList[i].level == tableList[j].level){
					isLevel = false;
				}
			}
		}
		if(isLevel){
			$.ajax({
				url: '/management/holiday/levelTable',
				type: 'POST',
				dataType: 'json',
				data: {
					data:JSON.stringify({
						tableList
	        		})
				},
				success: function(){
					alert("送出成功");
				}
			});
		}else{
			alert("層級錯誤");
		}
		
	}

	function del(i){
		$("[name='delBtn"+i+"']").parent().parent().remove();
		$("[name='levelSelect']").empty();
		for(var k = 1; k<=$("#table tbody").children().length; k++){
			$("[name='levelSelect']").append('<option value=' + k + '>' + k +'</option>');
		};
		$("[name='levelSelect']").each(function(index, value) {
			$(value[index]).attr("selected", true);
		});
	}

	function add(){
		if($("#table tbody").text()=='資料是空的'){
			$("#table tbody").find("tr").remove()
		}
		var department = $("#department").val();
		var UID = $("#UID").val();
		var isAdd = true;
		$.each($("#table tbody tr"), function(i,n){
			if($($(n).find("td")[1]).text() == UID){
				isAdd = false;
				$("#UID").addClass("is-invalid");
				$("[name='invalid']").text("編號已重複");
			}
		})
		if(isAdd){
			$.ajax({
				url: '/management/holiday/levelAdd',
				type: 'POST',
				dataType: 'json',
				data: {
					data:JSON.stringify({
						department : department,
						UID : UID,
	        		})
				},
				success: function(response){
					$("#UID").removeClass('is-invalid');
					if(response['name'] == null){
						$("#UID").addClass("is-invalid");
						$("[name='invalid']").text("查無此人");
					}else{
						var td1 = $('<td>').append('<select name="levelSelect" class="form-control valid"></select>')
						var td2 = $('<td>').text(UID);
						var td3 = $('<td>').text(response["name"]);
						var td4 = $('<td>').text(response["department"]);
						var btn = $('<button>').text('刪除').attr({
								class:"btn btn-danger m-1", 
								name:"delBtn"+UID,
								type:"button",
								onclick:"del('"+UID+"')"
							});
						var td5 = $('<td>').append(btn);
						var tr = $('<tr>').append(td1,td2,td3,td4, td5);
						$('#table tbody').append(tr);
						$("[name='levelSelect']").empty();
						for(var k = 1; k<=$("#table tbody").children().length; k++){
							$("[name='levelSelect']").append('<option value=' + k + '>' + k +'</option>');
						};
						$("[name='levelSelect']").each(function(index, value) {
							$(value[index]).attr("selected", true);
						});
						$("#UID").val("");
					}
				}
			})
		}
	}
</script>