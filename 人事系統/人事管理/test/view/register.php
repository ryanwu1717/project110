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
                    <h1  class="font-weight-bold" name = "typeUpdate">新增帳號</h1>
                    <h2 class="h4 text-gray-900 mb-4">個人資料</h2>
                  </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                      <label class="col-form-label col-md-4">部門</label>
                      <div class="col-md-8">  
                        <select required class="custom-select" name="buttonDepartment">
                          <option name = "selectDepartment" selected disabled value="">請選擇</option>
                        </select>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-form-label col-md-4">中文姓名</label>
                      <div class="col-md-8">  
                        <input required type="text" class="form-control form-control-user" name="staffName" placeholder="中文姓名">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-form-label col-md-4">身分證字號</label>
                      <div class="col-md-8">  
                        <input required type="text" class="form-control form-control-user" name="TWid" placeholder="身分證字號">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-form-label col-md-4">婚姻狀況</label>
                      <div class="col-md-8">  
                        <select required class="custom-select" name="buttonMarriage">
                          <option name = "selectMarriage" selected disabled value="">請選擇</option>
                        </select>
                      </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                      <label class="col-form-label col-md-4">職位</label>
                      <div class="col-md-8">  
                        <select required class="custom-select" name="buttonPosition">
                          <option name = "selectPosition" selected disabled value="">請選擇</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-form-label col-md-4">密碼</label>
                      <div class="col-md-8">  
                        <input required type="password" class="form-control form-control-user" name="password" placeholder="密碼">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-form-label col-md-4">性別</label>
                      <div class="col-md-8">  
                        <select required class="custom-select" name="buttonGender">
                          <option name = "selectGender" selected disabled value="">請選擇</option>
                        </select>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-form-label col-md-4">出生日期</label>
                      <div class="col-md-8">  
                        <input required type="date" class="form-control" name="staffBirthday" placeholder="出生日期"> 
                      </div>
                    </div>
                </div>


                <div class="col-md-12">
                  <div class="text-center"></br>
                    <h2 class="h4 text-gray-900 mb-4">聯絡資料</h2>
                    </br>
                  </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                      <label class="col-form-label col-md-4">公司聯絡電話</label>
                      <div class="col-md-8">  
                        <input required type="text" class="form-control form-control-user" name="companyNumber" placeholder="公司聯絡電話">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-form-label col-md-4">手機號碼</label>
                      <div class="col-md-8">  
                        <input required type="text" class="form-control form-control-user" name="phoneNumber" placeholder="手機號碼">
                      </div>
                    </div> 
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                      <label class="col-form-label col-md-4">住家電話</label>
                      <div class="col-md-8">  
                        <input required type="text" class="form-control form-control-user" name="homeNumber" placeholder="住家電話">
                      </div>
                    </div>
                </div>
                <div class="col-md-12">  
                    <div class="form-group row">
                      <label class="col-form-label col-md-2">通訊地址</label>
                      <div class="col-md-10">
                        <input required type="text" class="form-control form-control-user" name="contactAddress" placeholder="通訊地址">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-form-label col-md-2">戶籍地址</label>
                      <div class="col-md-10">
                        <input required type="text" class="form-control form-control-user" name="homeAddress" placeholder="戶籍地址">
                      </div>
                    </div>
                </div>

                <div class="col-md-12">
                  <div class="text-center"></br>
                    <h2 class="h4 text-gray-900 mb-4">職務年資</h2>
                    </br>
                  </div>
                </div>
                <div class="col-md-6">  
                    <div class="form-group row">
                      <label class="col-form-label col-md-4">投保公司</label>
                      <div class="col-md-8">
                        <select required class="custom-select" name="buttonInsuredCompany">
                          <option name = "selectInsuredCompany" selected disabled value="">請選擇</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-form-label col-md-4">員工類型</label>
                      <div class="col-md-8">
                        <select required class="custom-select" name="buttonStafftype">
                          <option name = "selectStaffType" selected disabled value=""> 請選擇</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-form-label col-md-4">離職日期</label>
                      <div class="col-md-8">
                        <input required type="date" class="form-control"name="leaveDate" > 
                      </div>
                    </div> 
                </div>
                <div class="col-md-6">  
                    <div class="form-group row">
                      <label class="col-form-label col-md-4">在職狀態</label>
                      <div class="col-md-8">
                        <select required class="custom-select" name="buttonWorkstatus">
                          <option name = "selectWorkStatus" selected disabled value="">請選擇</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-form-label col-md-4">到職日期</label>
                      <div class="col-md-8">
                        <input required type="date" class="form-control" name="endDate" > 
                      </div>
                    </div>
                </div>

                <div class="col-md-12">
                  <div class="text-center"></br>
                    <h2 class="h4 text-gray-900 mb-4">緊急聯絡人</h2>
                    </br>
                  </div>
                </div>
                <div class="col-md-6">  
                    <div class="form-group row">
                      <label class="col-form-label col-md-4">姓名</label>
                      <div class="col-md-8">
                        <input required type="text" class="form-control form-control-user" name="contactPersonName" placeholder="姓名">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-form-label col-md-4">手機</label>
                      <div class="col-md-8">
                        <input required type="text" class="form-control form-control-user" name="contactPersonPhone" placeholder="手機">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-form-label col-md-4">備註</label>
                      <div class="col-md-8">
                        <input required type="text" class="form-control form-control-user" name="contactPersonMore" placeholder="備註">
                      </div>
                    </div>
                </div>
                <div class="col-md-6">  
                    <div class="form-group row">
                      <label class="col-form-label col-md-4">電話</label>
                      <div class="col-md-8">
                        <input required type="text" class="form-control form-control-user" name="contactPersonHomeNumber" placeholder="電話">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-form-label col-md-4">關係</label>
                      <div class="col-md-8">
                        <input required type="text" class="form-control form-control-user" name="contactPersonRelation" placeholder="關係">
                      </div>
                    </div>
                </div>

                <div class="col-md-12">
                  <div class="text-center">
                    <h2 class="h4 text-gray-900">學歷</h2>
                  </div>
                </div>
                  <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-form-label col-md-4">就學期間</label>
                        <div class="col-md-8">
                          <input required type="number" class="form-control" name="educationTime" placeholder="就學期間">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-form-label col-md-4">學校</label>
                        <div class="col-md-8">
                          <input required type="text" class="form-control" name="schoolName" placeholder="學校">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-form-label col-md-4">就學狀況</label>
                        <div class="col-md-8">
                          <select required class="custom-select" name="buttonEducationCondition">
                            <option name = "selectEducationCondition" selected disabled value=""> 請選擇</option>
                          </select>
                        </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-form-label col-md-4">學制</label>
                        <div class="col-md-8">
                          <input required type="text" class="form-control" name="educationType" placeholder="學制">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-form-label col-md-4">科系</label>
                        <div class="col-md-8">
                          <input required type="text" class="form-control" name="schoolDepartment" placeholder="科系">
                        </div>
                      </div>
                  </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <button type="submit" name=registerFirstButton class="btn btn-primary btn-user btn-block">
                    註冊資料
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>
  <!-- Modal -->
  <div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" >
          <h5 class="modal-body" id = "checkRegisterModel">123</h5>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
          <button type="button" class="btn btn-primary" name = "registerButton">確定</button>
        </div>
      </div>
    </div>
  </div>

<?php
  include('partial/footer.php');
?>

<script type="text/javascript">
  var url = new URL(window.location.href);
  var isUpdate = url.searchParams.get("id");
  var checkPassword;
  if (isUpdate != null){
    $('[name=typeUpdate]').empty();
    $('[name=typeUpdate]').append("修改資料");
    $.ajax({
        url:'/table/update/post',
        type:'POST',
        data:{data:JSON.stringify({
            staff_id : isUpdate
        })},
        dataType:'json',
        success:function(data){
          console.log(data);
          $('[name=selectDepartment]').empty();
          $('[name=selectDepartment]').append(data[0].staff_department);
          $('[name=selectPosition]').empty();
          $('[name=selectPosition]').append(data[0].staff_position);
          $("[name=staffName]").val(data[0].staff_name);
          $("[name=TWid]").val(data[0].staff_TWid);
          $('[name=selectGender]').empty();
          $('[name=selectGender]').append(data[0].staff_gender);
          $('[name=selectMarriage]').empty();
          $('[name=selectMarriage]').append(data[0].staff_marriage);
          $("[name=staffBirthday]").val(data[0].staff_birthday);
          $("[name=companyNumber]").val(data[0].contact_companyNumber);
          $("[name=homeNumber]").val(data[0].contact_homeNumber);
          $("[name=phoneNumber]").val(data[0].contact_phoneNumber);
          $("[name=contactAddress]").val(data[0].contact_contactAddress);
          $("[name=homeAddress]").val(data[0].contact_homeAddress);
          $('[name=selectInsuredCompany]').empty();
          $('[name=selectInsuredCompany]').append(data[0].seniority_insuredCompany);
          $('[name=selectStaffType]').empty();
          $('[name=selectStaffType]').append(data[0].seniority_staffType);
          $('[name=selectWorkStatus]').empty();
          $('[name=selectWorkStatus]').append(data[0].seniority_workStatus);
          $("[name=leaveDate]").val(data[0].seniority_leaveDate);
          $("[name=endDate]").val(data[0].seniority_endDate);
          $("[name=contactPersonName]").val(data[0].contactPerson_name);
          $("[name=contactPersonHomeNumber]").val(data[0].contactPerson_homeNumber);
          $("[name=contactPersonPhone]").val(data[0].contactPerson_phone);
          $("[name=contactPersonRelation]").val(data[0].contactPerson_relation);
          $("[name=contactPersonMore]").val(data[0].contactPerson_more);
          $("[name=educationTime]").val(data[0].education_time);
          $("[name=educationType]").val(data[0].education_type);
          $("[name=schoolName]").val(data[0].education_school);
          $("[name=schoolDepartment]").val(data[0].education_department);
          $('[name=selectEducationCondition]').empty();
          $('[name=selectEducationCondition]').append(data[0].education_status);

          $('[name=registerFirstButton]').empty();
          $('[name=registerFirstButton]').append("修改資料");
        },
        error:function(jqXHR, textStatus, errorThrown){
          console.log(jqXHR);
          console.log(textStatus);
          console.log(errorThrown);
          console.log("failed");
          // window.location.href='register.html';
        },complete:loadType
    });
    $("button[name=registerFirstButton]").on('click', function(e){
      e.preventDefault();
      ch();
    });
    $("button[name=registerButton]").on('click', function(){
      modify();
    });
  }else{
    loadType();
    $("button[name=registerFirstButton]").on('click', function(e){
      e.preventDefault();
      ch();
    });
    $("button[name=registerButton]").on('click', function(){
      regis();
    });
    

  }

  function ch(){
    $('#exampleModalLabel').empty();
    $('#checkRegisterModel').empty();
    var data = new Object();
    data['staff_id'] = isUpdate;
    $('input').each(function(eachid,eachdata){
      data[eachdata.name] = $(eachdata).val();
    });
    $('select').each(function(eachid,eachdata){
      data[eachdata.name] = $(eachdata).val();
    });
    $.ajax({
      url:'/staff/checkRegister/post',
      type:'POST',
      
      data:{data:JSON.stringify(data)},
      
      dataType:'json',
      success:function(data){
        var i = 0;
        // var JdataJSON.parse(options.cartlist);
        var Jdata =data.content.split(" ");
        // $('#exampleModalLabel').empty();
        
        // $('#exampleModalLabel').append('你的id為'+ staff_department + staff_position + count);
        $.each(Jdata, function() {
          $("#checkRegisterModel").append(Jdata[i]+"</br>");
          i++;
        });
        if(data.status == false){ 
          $('#exampleModalLabel').text('錯誤');
          $('[name=registerButton]').hide();

        }else{
          $('#exampleModalLabel').text('訊息');
          $('[name=registerButton]').show();

          if (isUpdate == null){
            var staff_department = $('[name=buttonDepartment]').val();
            var staff_position = $('[name=buttonPosition]').val();
            var count;
            $.ajax({
              url:'/staff/staffNum/get',
              type:'get',
              async: false,
              dataType:'json',
              success:function(response){
                count = paddingLeft(response.num,4); 
                $('#checkRegisterModel').prepend('你的id為'+ staff_department + staff_position + count+"</br>");
              } 
            });  
          }
        }
        $('#basicExampleModal').modal('show');
      },
      error:function(jqXHR, textStatus, errorThrown){
        console.log(jqXHR);
        console.log(textStatus);
        console.log(errorThrown);
        console.log("failed");
        // window.location.href='register.html';

      }
    });
  }
  function regis(){
    var count;
      $.ajax({
        url:'/staff/staffNum/get',
        async: false,
        type:'get',
        dataType:'json',
        success:function(response){
          count = paddingLeft(response.num,4);
        }
      });
      var data = new Object();
      data['staff_id'] = $('[name=buttonDepartment]').val() + $('[name=buttonPosition]').val() + count;
      $('input').each(function(eachid,eachdata){
        data[eachdata.name] = $(eachdata).val();
      });
      $('select').each(function(eachid,eachdata){
        data[eachdata.name] = $(eachdata).val();
      });
      $.ajax({
        url:'/staff/register/post',
        type:'POST',
        data:{data:JSON.stringify(data)},        
        dataType:'json',
        success:function(data){
           if(data.status=='success'){
            window.location='/table';
           }
        },
        error:function(jqXHR, textStatus, errorThrown){
          console.log("failed");
          // window.location.href='register.html';
        }
      });
  }
  function modify(){
    var count;
      $.ajax({
        url:'/staff/staffNum/get',
        async: false,
        type:'get',
        dataType:'json',
        success:function(response){
          count = paddingLeft(response.num,4);      
        } 
      });
      var data = new Object();
      data['staff_id'] = isUpdate;
      $('input').each(function(eachid,eachdata){
        data[eachdata.name] = $(eachdata).val();
      });
      $('select').each(function(eachid,eachdata){
        data[eachdata.name] = $(eachdata).val();
      });
      $.ajax({
        url:'/staff/modify/post',
        type:'POST',
        data:{data:JSON.stringify(data)},        
        dataType:'json',
        success:function(data){
           console.log("success");
        },
        error:function(jqXHR, textStatus, errorThrown){
          console.log("failed");
          // window.location.href='register.html';
        }
      });
  }


  function paddingLeft(str,lenght){
    if(str.length >= lenght)
      return str;
    else
      return paddingLeft("0" +str,lenght);
  }
  function loadType(){

    $.ajax({
        url:'/staff/department/get',
        type:'get',
        dataType:'json',
        success:function(response){
          $(response).each(function(eachid){
            $('[name=buttonDepartment]').append('<option value="'+this.department_id+'">'+this.department_name+'</option>');
            if($('[name=selectDepartment]').text()==this.department_name){
              $($('[name=buttonDepartment] option')[eachid+1]).attr('selected',true);
            }
          });
        } 
      });

    $.ajax({
      url:'/staff/position/get',
      type:'get',
      dataType:'json',
      success:function(response){
        $(response).each(function(eachid){
          $('[name=buttonPosition]').append('<option value="'+this.position_id+'">'+this.position_name+'</option>');
            if($('[name=selectPosition]').text()==this.position_name){
              $($('[name=buttonPosition] option')[eachid+1]).attr('selected',true);
            }
        });
      } 
    }); 

    $.ajax({
      url:'/staff/gender/get',
      type:'get',
      dataType:'json',
      success:function(response){
        $(response).each(function(eachid){
          $('[name=buttonGender]').append('<option value="'+this.id+'">'+this.type+'</option>');
          if($('[name=selectGender]').text()==this.type){
            $($('[name=buttonGender] option')[eachid+1]).attr('selected',true);
          }
        });
      } 
    }); 

      $.ajax({
        url:'/staff/marriage/get',
        type:'get',
        dataType:'json',
        success:function(response){
          $(response).each(function(eachid){
            $('[name=buttonMarriage]').append('<option value="'+this.id+'">'+this.type+'</option>');
            if($('[name=selectMarriage]').text()==this.type){
              $($('[name=buttonMarriage] option')[eachid+1]).attr('selected',true);
            }
          });
        } 
      }); 

       $.ajax({
        url:'/staff/insuredcompany/get',
        type:'get',
        dataType:'json',
        success:function(response){
          $(response).each(function(eachid){
            $('[name=buttonInsuredCompany]').append('<option value="'+this.companyId+'">'+this.companyName+'</option>');
            if($('[name=selectInsuredCompany]').text()==this.companyName){
              $($('[name=buttonInsuredCompany] option')[eachid+1]).attr('selected',true);
            }
          });
        } 
      }); 

      $.ajax({
        url:'/staff/workStatus/get',
        type:'get',
        dataType:'json',
        success:function(response){
          $(response).each(function(eachid){
            $('[name=buttonWorkstatus]').append('<option value="'+this.id+'">'+this.status+'</option>');
            if($('[name=selectWorkStatus]').text()==this.status){
              $($('[name=buttonWorkstatus] option')[eachid+1]).attr('selected',true);
            }
          });
        } 
      }); 

      $.ajax({
        url:'/staff/staffType/get',
        type:'get',
        dataType:'json',
        success:function(response){
          $(response).each(function(eachid){
            $('[name=buttonStafftype]').append('<option value="'+this.id+'">'+this.type+'</option>');
            if($('[name=selectStaffType]').text()==this.type){
              $($('[name=buttonStafftype] option')[eachid+1]).attr('selected',true);
            }
          });
        } 
      }); 

      $.ajax({
        url:'/staff/educationCondition/get',
        type:'get',
        dataType:'json',
        success:function(response){
          $(response).each(function(eachid){
            $('[name=buttonEducationCondition]').append('<option value="'+this.id+'">'+this.type+'</option>');
            if($('[name=selectEducationCondition]').text()==this.type){
              $($('[name=buttonEducationCondition] option')[eachid+1]).attr('selected',true);
            }
          });
        } 
      });
    
  }
</script>

 
