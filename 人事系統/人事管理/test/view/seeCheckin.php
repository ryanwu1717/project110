<?php
  include('partial/header.php');
?>
<div class="card o-hidden shadow-lg py-5">
  <div class="card-body">
    <form>
      <div class="row">
        <div class="col-md-12">
          <div class="text-center">
            <h1  class="font-weight-bold" name = "typeUpdate">查看打卡</h1></br>
          </div>
        </div>
        <div class="col-md-1">
        </div>
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-form-label col-md-4">上班時數</label>
            <div class="col-md-8">  
              <select required class="custom-select" name="buttonType">
                <option name = "selectType" selected disabled value="">請選擇</option>
                <option value="8H">8H</option>
                <option value="9H">9H</option>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-1">
        </div>
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-form-label col-md-4">打卡日期</label>
            <div class="col-md-8">
              <input required type="date" class="form-control"name="viewCheckinDate" > 
            </div>
          </div>
        </div>
        <div class="col-md-2">
          <div class="text-center">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#basicModal" >查看</button>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="text-center" name=addList>
            
          </div>
        </div>
      </div>
    </form>
 </div> 
<!-- Basic Modal-->
<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">選擇員工</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
      </div> 
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" name = "checkButton">確定</button>
        <button class="btn btn-secondary" type="button" data-dismiss="modal">關閉</button>
      </div>
    </div>
  </div>
</div>


<?php
  include('partial/footer.php');
?>

<script type="text/javascript">
  var queue = [];
$(function(){
  $('#basicModal').on('show.bs.modal',function(e){
    $('#basicModal .modal-body').empty();
    $('#basicModal .listBox').empty();
    $('#basicModal .modal-body').append(
      '<div class="card">'+
        '<div class="card-body">'+
          '<h5 class="card-title">'+ 
            '<div class="srch_bar">'+
              '<div class="stylish-input-group">'+
                '<input type="text" class="search-bar searchInput" placeholder="搜尋" >'+
                '<span class="input-group-addon">'+
                  '<button type="button">'+
                    '<i class="fa fa-search" aria-hidden="true"></i>'+
                  '</button>'+
                '</span>'+
              '</div>'+
            '</div>'+
          '</h5>'+
          '<h6 class="card-subtitle mb-2 text-muted listBox">'+
          '</h6>'+
        '</div>'+
      '</div>'
    );
   
    queue['search'] = null;
    $('.searchInput').unbind().on('keyup',function(){
      clearTimeout(queue['search']);
      queue['search'] = setTimeout(function(){
        $('.listItem').each(function(){
          if($(this).find('.listName').val().indexOf($('.searchInput').val())>-1){
            $(this).show();
          }else{
            $(this).hide();
          }
        });
      },300);
    });
    $.ajax({
      url:'/management/checkin/list',
      type:'get',
      dataType:'json',
      success:function(response){
        $(response).each(function(){
          $('#basicModal .listBox').append(
            '<div class="input-group mb-3 listItem">'+
              '<div class="input-group-prepend">'+
                '<div class="input-group-text">'+
                  '<input type="checkbox" class="checkItem" data-name='+this.id+'>'+
                '</div>'+
                '<input type="text" class="form-control listID" disabled value='+this.id+'>'+
                '<input type="text" class="form-control listName" disabled value='+this.name+'>'+
              '</div>'+
            '</div>'
          );
        });
      }
    }); 
  });
  $('[name=checkButton]').unbind().on('click',function(){
      $('[name=addList]').empty()
      var checkDate = $('[name=viewCheckinDate]').val();
      var checkType = $('[name=buttonType]').val();
      console.log(checkDate);
      $('#basicModal .checkItem:checked').each(function(){
        tmpId = $(this).data('name');
        $.ajax({
          url:'/management/checkin/getCheckin/'+tmpId+'/'+checkDate+'/'+checkType,
          type:'get',
          dataType:'json',
          success:function(response){
            console.log(response.correspond);
            
            if(response.status=='failed'){
              $('[name=addList]').append("<label>查無此打卡紀錄</label></br>");
            }else{
              $('[name=addList]').append("<label>員工: "+response.data[0].staff_name+"</label></br>");
              $('[name=addList]').append("<label>打卡日期: "+checkDate+"</label></br>");
              $('[name=addList]').append("<label>上班打卡時間: "+response.data[0].checkintime+"</label></br>");
              $('[name=addList]').append("<label>上班打卡地點: "+response.data[0].checkinlocation+"</label></br>");
              $('[name=addList]').append("<label>下班打卡時間: "+response.data[0].checkouttime+"</label></br>");
              $('[name=addList]').append("<label>下班打卡地點: "+response.data[0].checkoutlocation+"</label></br>");
              $('[name=addList]').append("<label>考勤: "+response.correspond+"</label></br>");
            }
          }
        });
      });
      $('#basicModal').modal('hide');
    });
});


</script>