<?php
  include('partial/header.php');
?>
<div class="card o-hidden shadow-lg py-5">
	<div class="card-body">
		<form id="formWorkType" name="formWorkType">
			<div class="form-group row">
				<label class="col-sm-2 col-form-label" for="staticEmail">部門</label>
				<div class="col-sm-10">
					<select class="custom-select" name="buttonDepartment" required="">
						<option disabled selected value="">
							請選擇
						</option>
					</select>
				</div>
			</div>
			<div class="form-group row" id="rowEmployee" style="display:none">
				<label class="col-sm-2 col-form-label" for="inputPassword">員工</label>
				<div class="col-sm-10">
					<select class="custom-select" name="buttonEmployee">
						<option disabled selected value="">
							請選擇
						</option>
					</select>
				</div>
			</div>
		</form>
	</div>
</div>
<?php
  include('partial/footer.php');
?>
<script type="text/javascript">
var selectUID="0";
$(function(){

	// $('#exampleModal').on('shown.bs.modal', function (e) {
	// 	$('#exampleModal .modal-footer').html(`<button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>`);

	// 	var type = $(e.relatedTarget).data('type');
  		
 //  		inInsert();
  				
	// });
	// $('#formWorkType').on('submit', function(e){
	//     // validation code here
	//     $('#exampleModal').modal('show');
	//      e.preventDefault();
	//  });
	

	$.ajax({
        url:'/staff/department/get',
        type:'get',
        dataType:'json',
        success:function(response){

	         $(response).each(function(eachid){
	            $('[name=buttonDepartment]').append('<option value="'+this.department_id+'">'+this.department_name+'</option>');
	           
	         });
        } 
     });
	$( '[name="buttonDepartment"]').change(function() {
		$('#rowEmployee').show();
	    getEmployee($('[name="buttonDepartment"] option:selected' ).val());
	    selectUID="0";
	});
	

	// $('[name="radioWorkType"]').on('change', function() {
 //      	console.log($('[name="radioWorkType"]:checked' ).val());
 //      	// // getWorkType();
 //      	// if($('[name="radioWorkType"]:checked' ).val() == 'workOnoff'){
 //      	// 	$('#rowOnoff').show();
 //      	// 	$('#rowHours').hide();

 //      	// }else if ($('[name="radioWorkType"]:checked' ).val() == 'workHours'){
 //      	// 	$('#rowOnoff').hide();
 //      	// 	$('#rowHours').show();
 //      	// }
	// });
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
				selectUID = $('[name="buttonEmployee"] option:selected' ).val();
				getWorkType();
			});
        } 
     });
}

</script>