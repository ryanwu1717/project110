<?php
  include('partial/header.php');
?>
<div class="card o-hidden shadow-lg py-5">
	<div class="card-body">
		<form id="formWorkType">
		  <div class="form-group row">
		    <label for="staticEmail" class="col-sm-2 col-form-label">部門</label>
		    <div class="col-sm-10">
		     	<select required class="custom-select" name="buttonDepartment">
              		<option name = "selectDepartment" selected disabled value="">請選擇</option>
            	</select>

		    </div>
		  </div>
		  <div class="form-group row" style="display:none" id="rowEmployee">
		    <label for="inputPassword" class="col-sm-2 col-form-label">員工</label>
		    <div class="col-sm-10">
		      	<select  class="custom-select" name="buttonEmployee">
              		<option name = "selectDepartment" selected disabled value="">請選擇</option>
            	</select>

		    </div>
		  </div>
		  <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-2 pt-0">班別種類</legend>
		      <div class="col-sm-10">
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="radioWorkType" id="onoff" value="workOnoff" required>
		          <label class="form-check-label" for="gridRadios1" >
		            上班下班制
		          </label>
		        </div>
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="radioWorkType" id="workHours" value="workHours" required>
		          <label class="form-check-label" for="gridRadios2">
		            時間制
		          </label>

		        </div>
		      </div>
		    </div>
		  </fieldset>

		  <div class="form-row" id="rowOnoff" style="display:none">
		    <div class="form-group col-md-2">
		      <label for="inputEmail4">上班時間</label>
		    </div>
		    <div class="form-group col-md-4">
		      <input type="time" name="inputOnwork" class="form-control" />
		    </div>
		    <div class="form-group col-md-2" >
		      <label for="inputPassword4">下班時間</label>
		    </div>
		    <div class="form-group col-md-4">
				 <input type="time" name="inputOffwork" class="form-control" />
		    </div>
		  </div>

		  <div class="form-group row" id="rowHours" style="display:none">
		    <label class="form-group col-md-2">上班時數</label>
		    <div class="form-group col-md-10">
		     	<select class="custom-select" name="selectedHours">
              		<option name = "selectDepartment" selected disabled value="">請選擇</option>
              		<option name = "select8Hours" value="8">8小時</option>

              		<option name = "select9Hours" value="9">9小時</option>

            	</select>
		    </div>
		  </div>
		  <div class="text-center">
		  	<button type="submit" class="btn btn-primary col-md-4" id="btnFirstInsert"  data-type="insert">新增</button>
		  </div>
		</form>
	</div>
</div>
	
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
  include('partial/footer.php');
?>
<script type='text/javascript'>
var selectUID="0";
$(function(){

	$('#exampleModal').on('shown.bs.modal', function (e) {
		$('#exampleModal .modal-footer').html(`<button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>`);

		var type = $(e.relatedTarget).data('type');
  		
  		inInsert();
  				
	});
	$('#formWorkType').on('submit', function(e){
	    // validation code here
	    $('#exampleModal').modal('show');
	     e.preventDefault();
	 });
	

	$.ajax({
        url:'/staff/department/get',
        type:'get',
        dataType:'json',
        success:function(response){

	         $(response).each(function(eachid){
	            $('[name=buttonDepartment]').append('<option value="'+this.department_id+'">'+this.department_name+'</option>');
	            // console.log(eachid);
	            // if($('[name=selectDepartment]').text()==this.department_name){
	            //   	$($('[name=buttonDepartment] option')[eachid+1]).attr('selected',true);
	            // }
	         });
        } 
     });
	$( '[name="buttonDepartment"]').change(function() {
		$('#rowEmployee').show();
	    getEmployee($('[name="buttonDepartment"] option:selected' ).val());
	    selectUID="0";
	});
	

	$('[name="radioWorkType"]').on('change', function() {
      	console.log($('[name="radioWorkType"]:checked' ).val());
      	// getWorkType();
      	if($('[name="radioWorkType"]:checked' ).val() == 'workOnoff'){
      		$('#rowOnoff').show();
      		$('#rowHours').hide();

      	}else if ($('[name="radioWorkType"]:checked' ).val() == 'workHours'){
      		$('#rowOnoff').hide();
      		$('#rowHours').show();
      	}
	});
});

function insertWorkType(){
	$.ajax({
  		url:'/management/worktype',
  		type:'POST',
  		data:{
  			data:JSON.stringify({
  				department : $('[name="buttonDepartment"]').val(),
  				UID : selectUID,
  				type:$('[name="radioWorkType"]:checked').val(),
  				onworkTime : $('[name="inputOnwork"]').val(),
  				offworkTime : $('[name="inputOffwork"]').val(),
  				hours : $('[name="selectedHours"]').val()
  			})
		},
		dataType:'json',
  		success:function(response){

  			$('#exampleModal').modal('hide');
  		}
  	});
}

function inInsert(){
	$('#exampleModal .modal-title').html(`新增班別`);
	var checkArr = {
					"type":$('[name="radioWorkType"]:checked').val(),
					"age":30,
					"cars":[ "Ford", "BMW", "Fiat" ]
					}
					console.log();
	$.ajax({
  		url:'/management/worktype/check',
  		type:'POST',
  		data:{
  			data:JSON.stringify({
  				department : $('[name="buttonDepartment"]').val(),
  				UID : selectUID,
  				type:$('[name="radioWorkType"]:checked').val(),
  				onworkTime : $('[name="inputOnwork"]').val(),
  				offworkTime : $('[name="inputOffwork"]').val(),
  				hours : $('[name="selectedHours"]').val()

  			})
		},
		dataType:'json',
  		success:function(response){
			$('#exampleModal .modal-body').html(response.content);

  			if(response.status == 'success'){
				$('#exampleModal .modal-footer').append(`<button type="button" class="btn btn-primary" name="btnLastInsert">確定新增</button>`);
  			}
  			$('[name=btnLastInsert]').unbind().on('click',function(){
  				insertWorkType();
  			});
  		}
  	});

}

function getWorkType(){
	$.ajax({
        url:'/management/worktype/'+selectUID,
        type:'get',
        dataType:'json',
        success:function(response){
        	console.log(response);
        	if(response.type == 'workOnoff'){
        		$(`[name=radioWorkType][value='workOnoff']`).prop("checked", true);
        		$('[name="inputOnwork"]').val(response.onWorkTime);
        		$('[name="inputOffwork"]').val(response.offWorkTime);
        		$('#rowOnoff').show();
      			$('#rowHours').hide();

        	}else if(response.type == 'workHours'){
        		$(`[name=radioWorkType][value='workHours']`).prop("checked", true);
				$(`[name="select${response.workHours}Hours"]`).attr('selected', true);
				$('#rowOnoff').hide();
      			$('#rowHours').show();
        	}

        } 
     });
}

function getEmployee(departmentID){
	$.ajax({
        url:'/staff/name/'+departmentID+'/department',
        type:'get',
        dataType:'json',
        success:function(response){
        	$('[name=buttonEmployee]').html(`<option name = "selectDepartment" selected disabled value="">請選擇</option>`);
        	
	         $(response).each(function(eachid){
	            $('[name=buttonEmployee]').append(`<option value="${this.staff_id}">${this.staff_id}&nbsp;&nbsp;${this.staff_name}</option>`);
	         });
	         $( '[name="buttonEmployee"]').change(function() {
				selectUID = $('[name="buttonEmployee"] option:selected' ).val();
				getWorkType();
			});
        } 
     });
}
</script>

