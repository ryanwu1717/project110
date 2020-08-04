<?php
  include('partial/header.php');
?>
<div class="card o-hidden shadow-lg py-5">
	<div class="card-body">
		<form>
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
		      	<select required class="custom-select" name="buttonEmployee">
              		<option name = "selectDepartment" selected disabled value="">請選擇</option>
            	</select>

		    </div>
		  </div>
		  <fieldset class="form-group">
		    <div class="row">
		      <legend class="col-form-label col-sm-2 pt-0">班別種類</legend>
		      <div class="col-sm-10">
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1" checked>
		          <label class="form-check-label" for="gridRadios1">
		            上班下班制
		          </label>
		        </div>
		        <div class="form-check">
		          <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2">
		          <label class="form-check-label" for="gridRadios2">
		            時間制
		          </label>

		        </div>
		      </div>
		    </div>
		  </fieldset>

		  <div class="form-row">
		    <div class="form-group col-md-2">
		      <label for="inputEmail4">上班時間</label>
		    </div>
		    <div class="form-group col-md-4">
		      <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
		    </div>
		    <div class="form-group col-md-2">
		      <label for="inputPassword4">下班時間</label>
		    </div>
		    <div class="form-group col-md-4">
		      <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
		    </div>
		  </div>

		  <div class="form-group row">
		    <label for="staticEmail" class="col-sm-2 col-form-label">上班時間</label>
		    <div class="col-sm-10">
		     	<select required class="custom-select" name="buttonDepartment">
              		<option name = "selectDepartment" selected disabled value="">請選擇</option>
              		<option name = "selectDepartment" selected value="">8hr</option>

              		<option name = "selectDepartment" selected  value="">9hr</option>

            	</select>
		    </div>
		  </div>
		</form>
	</div>
</div>
	
<?php
  include('partial/footer.php');
?>
<script type='text/javascript'>
var selectUID;

$(function(){


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
      	console.log($('[name="buttonDepartment"] option:selected' ).val());
	});



});
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
				selectUID = $('[name="buttonEmployee"] option:selected' ).val()
		      	console.log(selectUID);
			});
        } 
     });
}
</script>

