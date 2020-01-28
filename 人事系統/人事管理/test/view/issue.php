<?php
  include('partial/header.php');
?>
<div class="accordion" name="issueAccordion">
  <!-- <div class="card">
    <div class="card-header" id="headingOne">
      <h2 class="mb-0">
        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Collapsible Group Item #1
        </button>
      </h2>
    </div>

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="[name=issueAccordion]">
      <div class="card-body">
       1
      </div>
    </div>
  </div> -->
</div>
<?php
  include('partial/footer.php');
?>
<script type="text/javascript">
	$(function(){
		$.ajax({
      url:'/issue/getIssue',
      type:'get',
      dataType:'json',
      success:function(response){
      	console.log(response);
        $(response).each(function(){

          $('[name=issueAccordion]').append(
          		'<div class="card">'+
    						'<div class="card-header" id="headingOne">'+
    							'<h2 class="mb-0">'+
    								'<button class="btn btn-link" type="button" data-toggle="collapse" data-target="[name='+this.issue_title+']" aria-expanded="true" aria-controls="'+this.issue_title+'"</button>'+
    								this.issue_title+
    							'</h2>'+
    						'</div>'+
    						'<div name="'+this.issue_title+'" class="collapse" aria-labelledby="headingOne" data-parent="[name=issueAccordion]">'+
    						'</div>'+
    					'</div>'
        	);
        });
      } 
    });
    $.ajax({
      url:'/issue/getIssueName',
      type:'get',
      dataType:'json',
      success:function(response){
      	console.log(response);
        $(response).each(function(){

          $('[name='+this.issue_title+']').append('&#9;'+'<i class="fa fa-angle-double-right" aria-hidden="true"></i>'+this.issue_name+'</br>');
        });
      } 
    });
	});
</script>