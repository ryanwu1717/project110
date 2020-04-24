<?php
  include('partial/header.php');
?>
<div class="card o-hidden shadow-lg py-5">
	<div class="card-body">
		<div class="row">
			<div class="col-md-12">
				<div class="text-center">
                    <div class="form-group row" name = "allDepartment">
	                  	<label class="col-form-label col-md-4">部門</label>
	                  	<div class="col-md-8">  
	                    	<select required class="custom-select" name="buttonDepartment">
	                      		<option name = "selectDepartment" selected disabled value="">請選擇</option>
	                    	</select>
		                </div>
                  	</div>
                 </div>
			</div>
			
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="text-center">
                    <div class="form-group row" name = "allEmployee">
	                  	<label class="col-form-label col-md-4">員工</label>
	                  	<div class="col-md-8">  
	                    	<select required class="custom-select" name="buttonEmployee">
	                      		<option name = "selectEmployee" selected disabled value="">請選擇</option>
	                    	</select>
		                </div>
                  	</div>
                 </div>
			</div>
			
		</div>
		<div class="row">
            <div class="col-md-12">
            	<div class="text-center">
	              	<button type="submit" name=btnGetDepartment class="btn btn-primary btn-user btn-block">
	                確認
	             	</button>
	             	<button type="submit" name=btnGetPerson class="btn btn-primary btn-user btn-block">
	                確認
	             	</button>
	             </div>
            </div>
      </div>
	</div>
</div>
<?php
  include('partial/footer.php');
?>
<script type="text/javascript">
$('[name=allEmployee]').hide();
$('[name=btnGetPerson]').hide();
$(function(){
	$.ajax({
        url:'/staff/department/get',
        type:'get',
        dataType:'json',
        success:function(response){
	         $(response).each(function(eachid){
	            $('[name=buttonDepartment]').append('<option value="'+this.department_id+'">'+this.department_name+'</option>');
	            // console.log(eachid);
	            if($('[name=selectDepartment]').text()==this.department_name){
	              	$($('[name=buttonDepartment] option')[eachid+1]).attr('selected',true);
	            }
	         });
        } 
     });
	$('[name=btnGetDepartment]').on('click', function(e){
      	// e.preventDefault();
      	console.log($('[name=buttonDepartment]').val());
      	$('[name=allEmployee]').show();
		$('[name=btnGetPerson]').show();
		$('[name=allDepartment]').hide();
		$('[name=btnGetDepartment]').hide();

      	var tmpDepartment = $('[name=buttonDepartment]').val();
      	$.ajax({
	        url:'/staff/name/'+tmpDepartment+'/department',
	        type:'get',
	        dataType:'json',
	        success:function(response){
	        	console.log(response);
		         $(response).each(function(eachid){
		            $('[name=buttonEmployee]').append('<option value="'+this.staff_id+'">'+this.staff_name+'</option>');
		            // console.log(eachid);
		            if($('[name=selectEmployee]').text()==this.department_name){
		              	$($('[name=buttonDepartment] option')[eachid+1]).attr('selected',true);
		            }
		         });
	        } 
	     });
    });
});


</script>