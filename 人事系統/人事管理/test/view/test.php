<?php 
 include('partial/header.php')
?>
<style type="text/css">
.scroll-to-down {
  position: fixed;
  right: 1rem;
  bottom: 1rem;
  display: none;
  width: 2.75rem;
  height: 2.75rem;
  text-align: center;
  color: #fff;
  background: rgba(90, 92, 105, 0.5);
  line-height: 46px;
}

.scroll-to-down:focus, .scroll-to-down:hover {
  color: white;
}

.scroll-to-down:hover {
  background: #5a5c69;
}

.scroll-to-down i {
  font-weight: 800;
}
</style>
<h3 class=" text-center">訊息</h3>
<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-lg-4">
        <div class="card" style="height:65vh">
          <div class="card-header">
            <div class="row">
              <div class="col-6">
                <h4>議題列表</h4>
              </div>
              <div class="col-6">
                <div class="btn-group float-right">
                  <button class="btn btn-secondary fa fa-folder" type="button" data-toggle="modal" data-target="#basicModal" data-type="addClass" ></button>
                  <button class="btn btn-secondary " type="button" data-toggle="modal" data-target="#basicModal" data-type="create" >+</button>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-search" aria-hidden="true"></i></span>
              </div>
              <input type="text" id="searchChatroomInput" class="form-control">
            </div>
          </div>
          <div class="card-body overflow-auto" name="inbox_chat">
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card" style="height:65vh">
          <div class="card-header">
              <nav class="navbar navbar-expand navbar-light bg-light d-flex justify-content-between">
                <a class="navbar-brand" name="navbarChatroomTitle"></a>
                <div class="btn-group" >
                  <button type="button" class="btn btn-light dropdown-toggle text-dark bg-light" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false" id="tool_dropdown" style="display:none;">
                  </button>
                  <div class="dropdown-menu dropdown-menu-right">
                    <button class="dropdown-item" type="button-light" data-toggle="modal" data-target="#basicModal" data-type="member">成員列表</button>
                    <div class="dropdown-divider"></div>
                    <button class="dropdown-item" type="button" data-toggle="modal" data-target="#basicModal" data-type="insertClass">加入議題類別</button>
                    <div class="dropdown-divider"></div>
                    <button class="dropdown-item" type="button" data-toggle="modal" data-target="#basicModal" data-type="delete">離開議題</button>
                  </div>
                </div>
              </nav>
          </div>
          <div class="card-body overflow-auto msg_history">
            <div class="h-100 d-flex flex-column">
              <div class="card flex-grow-1 mb-3">
                <div class="card-body" name="chatBox">
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="align-bottom">
              <div class="dropup">
               <div class="dropdown-menu show" aria-labelledby="dropdownMenuButton" id="tagPeople">
                  <a class="dropdown-item" href="#">Action</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <a class="dropdown-item" href="#">Something else here</a>
                </div>
              </div>
              <div class="d-flex">
                <a class="scroll-to-down rounded">
                  <i class="fas fa-angle-down"></i>
                </a>
                <div class="w-100">
                  <textarea class="form-control" style="word-wrap:break-word;width:100%;"placeholder="請在此輸入訊息，ENTER可以換行&#13;&#10;SHIFT+ENTER送出訊息" id="textinput"></textarea>
                </div>
                <input style="display:none;" type="file" name="inputFile">
                <div class="flex-shrink-1  align-self-center ml-1">
                    <button class="btn btn-secondary btn-block far fa-paper-plane msg_send_btn" name="ButtonMsgSend" type="button"></button>
                </div>
                <div class="flex-shrink-1  align-self-center ml-1">
                    <button class="btn btn-secondary " type="button"onclick="uploadFile(this)">+</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<!-- Basic Modal-->
<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ready to Leave?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">關閉</button>
      </div>
    </div>
  </div>
</div>

<!-- Basic Modal-->
<div class="modal fade" id="loadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">通知</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">讀取中.....請稍候</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">關閉</button>
      </div>
    </div>
  </div>
</div>
<?php
 include('partial/footer.php')
?>
<script type='text/javascript'>
//window focus
var isTabActive = true;
var titleOrg=$('title').text();
$(function(){
  titleOrg=$('title').text();
});
var notify = [];
window.onfocus = function () { 
  window.isTabActive = true; 
  updateLastReadTime();
}; 

window.onblur = function () { 
  window.isTabActive = false; 
};






var tagboolean = false;
var tmpTag;
var nowkey;
var tagPeople = "";
var tagDepartment = "";
$('.dropup').hide();

// $('#textinput').on('compositionupdate', function(e) {
//     console.log(e);
//     console.log(e.target.value);
// });


$('#textinput').keyup(function(event) {
  // console.log(event.key);
  if(event.key == "@"||(event.keyCode == 229&&$("#textinput").val().charAt($("#textinput").getCursorPosition()-1)=="@")){
    if($("#textinput").getCursorPosition() == 1 || $("#textinput").val().charAt($("#textinput").getCursorPosition()-2)==" "){
      getAllEmployee();
    }
  }else if (event.key == "#"||(event.keyCode == 229&&$("#textinput").val().charAt($("#textinput").getCursorPosition()-1)=="#")){
    if($("#textinput").getCursorPosition() == 1 || $("#textinput").val().charAt($("#textinput").getCursorPosition()-2)==" "){
      getDepartment();
    }
  }
  // $('#textinput').on('compositionupdate', function(e) {

  //   // console.log(e);
  //   console.log(e.target.value);
  //   console.log(e.target.value.indexOf("＠"));
  //   if($("#textinput").getCursorPosition() == 1 || $("#textinput").val().charAt($("#textinput").getCursorPosition()-2)==" "){
  //     if(e.target.value.indexOf("＠") >= 0){
  //       getAllEmployee();
  //     }else if(e.target.value.indexOf("＃") >= 0){
  //       getDepartment();
  //     }
  //   }
  //   // if(e.target.value.indexOf("＠") >= 0){
  //   //   // console.log($("#textinput").getCursorPosition());
  //   //   // $("textarea#textinput").val($("#textinput").val().substr(0, i-1)+"@"+tagname+" "+$("#textinput").val().substr(i));
  //   //   // $("#textinput").replace("＠" ,"@");

      
  //   // }
  // });
  // // console.log("in");
  tmpSplit=$('#textinput').val().split(" ");
  $(tmpSplit).each(function(){
    if(this.indexOf("@") == 0  || this.indexOf("＠") == 0 ){
      tagboolean = true;
      tmpTag= this;
      nowkey = this.substr(1);
      var choose = null;
      choose = setTimeout(function(){
        $('[name=dropdownitemTag]').each(function(){
          // console.log(tmpTag.substr(1));
          if($(this).data('name').indexOf(tmpTag.substr(1))>-1){
            $(this).show();
          }else{
            $(this).hide();
          }
        });
      },300);
    }else if (this.indexOf("#") == 0 || this.indexOf("＃") == 0 ){
      tagboolean = true;
      tmpTag= this;
      nowkey = this.substr(1);
      var choose = null;
      choose = setTimeout(function(){
        $('[name=dropdownitemTag]').each(function(){
          // console.log(tmpTag.substr(1));
          if($(this).data('name').indexOf(tmpTag.substr(1))>-1){
            $(this).show();
          }else{
            $(this).hide();
          }
        });
      },300);
    }
  });
  if(tagboolean == false){
      $('.dropup').hide();
  }
  tagboolean = false;
});

function addDepartmentTag(tagname,tagID){
  var textAreaContent = $("#textinput").val();
  for (i = $("#textinput").getCursorPosition();i >0;i--)
  {
    if($("#textinput").val().charAt(i-1) == "#" || $("#textinput").val().charAt(i-1) == "＃"){
        $("textarea#textinput").val($("#textinput").val().substr(0, i-1)+"#"+tagname+" "+$("#textinput").val().substr(i));
        break;
    }else{
      $("textarea#textinput").val($("#textinput").val().substr(0, i-1)+$("#textinput").val().substr(i));
    }
  }
  $('.dropup').hide();
  tagDepartment = tagDepartment+tagID+" ";
  console.log(tagname);
}

function addTag(tagname,tagID){
  var textAreaContent = $("#textinput").val();
  // console.log(textAreaContent);
  for (i = $("#textinput").getCursorPosition();i >0;i--)
  {
    if($("#textinput").val().charAt(i-1) == "@" || $("#textinput").val().charAt(i-1) == "＠"){
        $("textarea#textinput").val($("#textinput").val().substr(0, i-1)+"@"+tagname+" "+$("#textinput").val().substr(i));
        break;
    }else{
      $("textarea#textinput").val($("#textinput").val().substr(0, i-1)+$("#textinput").val().substr(i));
    }
  }
  $('.dropup').hide();
  tagPeople = tagPeople+tagID+" ";
  // console.log(tagPeople);
}
(function ($, undefined) {
    $.fn.getCursorPosition = function() {
        var el = $(this).get(0);
        var pos = 0;
        if('selectionStart' in el) {
            pos = el.selectionStart;
        } else if('selection' in document) {
            el.focus();
            var Sel = document.selection.createRange();
            var SelLength = document.selection.createRange().text.length;
            Sel.moveStart('character', -el.value.length);
            pos = Sel.text.length - SelLength;
        }
        return pos;
    }
})(jQuery);
var tmpTagMsg= "";
function notificationOnclick(chatID,chatName,id,attr){

  tmpTagMsg = $(attr).data('time');
  getTarget(chatID,chatName);
  // console.log($(attr).data('time'));

  // console.log($('.ml-1[data-senttime="'+$(attr).data('time')+'"]'));
  $.ajax({
      url:'/chat/notification/'+id,
      type:'post',
      data:{_METHOD:'PATCH'},
      dataType:'json',
      success:function(response){
        // getTarget(chatID,chatName);
    }
  });
}

$('[name=bellbtn]').parent().show();
$(function(){
  $('[name=bellbtn]').unbind().on('click',function(){
    // console.log("in");
    getNotification();
  });
});
  
function getNotification(){
  $('[name=bellDropdown]').empty();
  $.ajax({
    url:'/chat/notification/',
    type:'get',
    dataType:'json',
    success:function(response){
      // console.log(response);
      $('[name=bellDropdown]').append('<h6 class="dropdown-header">通知中心</h6>');
      $(response).each(function(){
        // console.log(this.sendtime);
        $('[name=bellDropdown]').append(
          '<a class="dropdown-item d-flex align-items-center" id="notification'+this.id+'" style=" z-index:9999;" data-time="'+this.fullsendTime+'" onclick="notificationOnclick('+this.chatID+',\''+encodeURIComponent(this.chatName)+'\','+this.id+',this);"'+
            '<div class="mr-3">'+
              '<div class="icon-circle bg-primary">'+
                '<i class="fas fa-file-alt text-white"></i>'+
              '</div>'+
            '</div>'+
            '<div>'+
              '<div class="small text-gray-500">'+
                this.sendtime+
              '</div>'+
              '<span class="font-weight-bold">'+
                this.detail+
              '</span>'+
            '</div>'+
          '</a>'
        );
        if(this.unread == true){
          // console.log("unread");
          $("#notification"+this.id).css("background-color", "#F0F8FF");
        }else{
          $("#notification"+this.id).css("background-color", "#FFFFFF");
        }
      });
      $('[name=bellDropdown]').append('<a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>');
    }
  });
}

// $( "#textinput" ).change(function(){
//   console.log(this.val());
//   console.log('.on(change) = ' + $(this).val());
// });


if (window.innerWidth <= 700) $('.navbar-collapse').removeClass('show');
  var basicModalFooter = '<button class="btn btn-secondary" type="button" data-dismiss="modal">關閉</button>';
  $('.msg_history').on("scroll",function(){
    if($(this)[0].scrollHeight-500>$(this).scrollTop()){
      $(".scroll-to-down").fadeIn(); 
      scrollable = true;
    }else{
      $(".scroll-to-down").fadeOut()
      scrollable = false;
    }
    if($(this).scrollTop()==0){
      expendLimit();
    }
  });
  $('.scroll-to-down').unbind().on('click',function(){
      scrollable = false;
    $('.msg_history').scrollTop($('.msg_history')[0].scrollHeight);
  });
var queue = [];
queue['chatroom'] = null;
queue['commentreadtime'] = null;
var scrollable = false;

queue['search-bar'] = null;
$('.search-bar').unbind().on('keyup',function(){
  clearTimeout(queue['search-bar']);
  queue['search-bar'] = setTimeout(function(){
    $('.listItem').each(function(){
      if($(this).find('.listName').val().indexOf($('.searchInput').val())>-1){
        $(this).show();
      }else{
        $(this).hide();
      }
    });
  },300);
});

var todatDate = null;
function init(){
  todayDate = Date.now();
  $.ajax({
    url:'/chat/init/'+todayDate,
    type:'get',
    dataType:'json',
    success:function(response){
      if(response.status=='success'){
        $.each(response,function(key,value){
          if(key=='class'){
            changeClass('init',value);
          }
          else if(key=='chatroom'){
            changeChatroom('init',value);
          }else if(key == 'notification'){
            changeNotification('init',response.notification);
          }
        });
      }
      // routine();
    }
  });
}
init();
var ajax = null;
function routine(){
  if(ajax!=null)
    ajax.abort();
  ajax = $.ajax({
    url:'/chat/routine/'+todayDate+'/'+chatID,
    type:'get',
    dataType:'json',
    success:function(response){
      if(response.status=='success'){
        $.each(response.result,function(key,value){
          if(key=='class'){
            changeClass('routine',value,response.class);
          }else if(key=='chatroom'){
            changeChatroom('routine',response);
          }else if(key=='chat'){
            changeChat('routine',response);
          }else if(key == 'notification'){
            changeNotification('routine',response.notification);
          }else if(key=='readCount'){
            changeReadCount('routine',response);
          }
        });
      }
      $('#loadModal').modal('hide');
      if(tmpTagMsg!=""){
        // console.log("in");
        console.log(tmpTagMsg);
        // console.log($('.incoming_msg[data-senttime="'+tmpTagMsg+'"]')[0].scrollHeight);
        // console.log($('.sent_msg[data-senttime="'+tmpTagMsg+'"]')[0].scrollHeight);
// 
        
        scrollToTag()
      }
      routine();
    }
  });
}
function scrollToTag(){
  if($('.outgoing_msg[data-senttime = "'+tmpTagMsg+'"]').length>0)
    $('.msg_history').scrollTop($('.outgoing_msg[data-senttime = "'+tmpTagMsg+'"]')[0].offsetTop-$('.msg_history')[0].offsetTop);
  else if($('.incoming_msg[data-senttime = "'+tmpTagMsg+'"]').length>0)
    $('.msg_history').scrollTop($('.incoming_msg[data-senttime = "'+tmpTagMsg+'"]')[0].offsetTop-$('.msg_history')[0].offsetTop);
  tmpTagMsg = "";
}
function getDepartment(){
  $('#tagPeople').empty();
  $.ajax({
    url:'/chat/department/'+chatID,
    type:'get',
    dataType:'json',
    success:function(response){
      console.log(response);
      $(response).each(function(){
        $('#tagPeople').append(
          '<button class="dropdown-item" name="dropdownitemTag" data-id='+this.id+ ' data-name= '+this.name+' href="#" onclick="addDepartmentTag(\''+this.name+'\',\''+this.id+'\');">'+this.name+"   "+this.id+
          '</button>'
        );
      });
    }
  });
  $('.dropup').show();

}


function getAllEmployee(){
  $('#tagPeople').empty();
  $.ajax({
    url:'/chat/member/'+chatID,
    type:'get',
    dataType:'json',
    success:function(response){
      console.log(response);
      $(response).each(function(){
        $('#tagPeople').append(
          '<button class="dropdown-item" name="dropdownitemTag" data-id='+this.id+ ' data-name= '+this.name+' href="#" onclick="addTag(\''+this.name+'\',\''+this.id+'\');">'+this.name+"   "+this.id+
          '</button>'
        );
      });
    }
  });
  $('.dropup').show();
}


function changeReadCount(type,data){
  if(data.result.readCount.new.length!=0 || data.result.readCount.change.length!=0 ||data.result.readCount.delete.length!=0 ){
    var readcountElement = data.readCount.shift();
    if(readcountElement===undefined)
      return false;
    $('a[data-type=readlist]').each(function(){
      $(this).html('<i class="fa fa-eye" aria-hidden="true"></i>'+readcountElement.sum);
      if($(this).attr('data-senttime')==readcountElement.sentTime){
        readcountElement = data.readCount.shift();
        if(readcountElement===undefined)
          return false;
      }
    });
  }
}
// function schedule(){
//   // searchChatroom();
//   // searchChat();
//   // clearTimeout(queue['chatroom']);
//   // clearTimeout(queue['chat']);
//   setTimeout(searchChatroom,1000);
//   setTimeout(searchChat,1000);
// }
// schedule();

function changeNotification(type,data){
  if(type == 'init'){
    // console.log('init');
    console.log(data[0].count);
    $('[name=notificationNum]').empty();
    $('[name=notificationNum]').append(data[0].count);
  }else if(type == 'routine'){
    console.log('routine');
    $('[name=notificationNum]').empty();
    $('[name=notificationNum]').append(data[0].count);
  }
}

var dd = '';

function changeClass(type,data,oldClass){
  function addClass(key,value){
    // console.log(value);
    $('[name=inbox_chat]').append(
      '<div class="card" name = "class'+value.id+'">'+
        '<div class="card-header" id="headingOne">'+
          '<h2 class="mb-0">'+
            '<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#class'+value.id+'" aria-expanded="true" aria-controls="class'+value.id+'">'+
              value.name +
            '</button>'+
          '</h2>'+
        '</div>'+
        '<div id= "class'+value.id+'" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">'+
        '</div>'+
      '</div>'
    );
  }
  function deleteClass(key,value){
    $('[name=class'+value.id+']').find('.chat_list').each(function(){
      $('#class0').append($(this).parent());
    });
    $('[name=class'+value.id+']').remove();
  }
  if(type=='init'){
    $('[name=inbox_chat]').append(
      '<div class="accordion" id="accordionExample" name="accordionExample">'+
      '</div>'
    );
    $(data).each(addClass);
    $('[name=inbox_chat]').append($('[name=class0]'));
    // addClass(null,{id:0,name:"未分類議題"});
  }else if(type=='routine'){
    $.each(data.change,function(){
      $('[name=class'+this.id+']').find('button').text(this.name);
    });
    // $(oldClass).each(addClass);
    $.each(oldClass,function(){
      $('[name=inbox_chat]').append( $('[name=class'+this.id+']'));
    });
    $(data.new).each(addClass);
    $('[name=inbox_chat]').append( $('[name=class0]'));
    // $.each(data.class,function(){
    //   console.log(this.id);
    // });
    $(data.delete).each(deleteClass);
  }
}
function changeChatroom(type,data){
  function addChatRoom(key,value){
    // console.log(value);
    var tmpClass = (value.classID==null?0:value.classID);
    var chatName ='';
    if (this.chatName==''){
      chatName=this.staff_name;
    }
    else{
      chatName=this.chatName;
    }
    var haveUnread ='';
    
    clearTimeout(notify['Unread']);
    $('title').text(titleOrg);
    if(value.CountUnread!='0'&&value.CountUnread!=null){
      haveUnread='<span class="badge badge-primary">'+value.CountUnread+'</span> ';
      clearTimeout(notify['Unread']);
      notify['Unread'] = setTimeout(notifyUnread,1000);
    }
    else{
      haveUnread ='<span class="badge badge-primary" style="display:none;">'+value.CountUnread+'</span> ';
    }
    $('#class'+tmpClass).append(
      '<div class="card" style="height:10vh" name="room'+value.chatID+'">'+
        '<div class="card-body chat_list" name="beSearchRoom" onclick="getTarget('+value.chatID+',\''+encodeURIComponent(chatName)+'\');" data-name="'+value.chatID+'" data-roomName="'+chatName+'">'+
          '<div class="d-flex">'+
            '<div class="p-2 flex-shrink-1 ">123</div>'+
            '<div class="p-2 flex-grow-1  text-body chatName">'+
              chatName+
              haveUnread +
            '</div>'+
            '<div class="p-2 text-body">'+
              '<small>'+ 
                (value.LastTime==null?' ':value.LastTime) +
              '</small>'+
            '</div>'+
          '</div>'+
        '</div>'+
      '</div>'
    );
  }
  if(type=='init'){
    $(data).each(addChatRoom);
  }else if(type=='routine'){
    $.each(data.result.chatroom.new,function(){
      $(this).each(addChatRoom);
    });
    $.each(data.result.chatroom.delete,function(){
      $('[name=room'+this.chatID+']').remove();
      // $(this).each(addChatRoom);
    });
    // $(data.result.chatroom.new).each(addChatRoom);
    clearTimeout(notify['Unread']);
    $('title').text(titleOrg);
    $.each(data.chatroom,function(){
      var room = $('[name=room'+this.chatID+']');
      if($('[name=room'+this.chatID+']').length==1){
        if($('#class'+this.classID).length==0){
          $('#class0').append($('[name=room'+this.chatID+']'));
        }else{
          $('#class'+this.classID).append($('[name=room'+this.chatID+']'));
        }
        var chatName ='';
        if (this.chatName==''){
          chatName=this.staff_name;
        }
        else{
          chatName=this.chatName;
        }
        room.find('.chat_list').attr('onclick','getTarget('+this.chatID+',\''+encodeURIComponent(chatName)+'\');');
        room.find('.chat_list').attr('data-name',this.chatID);
        if(this.CountUnread!='0'&&this.CountUnread!=null){
          haveUnread='<span class="badge badge-primary">'+this.CountUnread+'</span> ';
          clearTimeout(notify['Unread']);
          notify['Unread'] = setTimeout(notifyUnread,1000);
        }
        else{
          haveUnread ='<span class="badge badge-primary" style="display:none;">'+this.CountUnread+'</span> ';
        }
        room.find('.chatName').html(
          chatName+
          haveUnread
        );
      }
    });
  }
}
function notifyUnread(){
  if($('title').text().indexOf('您有訊息!!')>-1)
    $('title').text(titleOrg);
  else
    $('title').text('[您有訊息!!]'+titleOrg);
  notify['Unread'] = setTimeout(notifyUnread,1000);
}
function changeChat(type,data){
  
  $('[name=msgSendNow]').remove();
  // $('[name=chatBox]').html("");
  if(chatID==-1){
    return;
  }
  var newChat = [];
  if(!data.result.chat.comchatID){
    $('[name=chatBox]').html("");
    newChat = data.chat;
  }else{
    for(var i = 0; i<parseInt(data.result.chat.count) ; i++){
      newChat.push(data.chat[data.chat.length-(1+i)]);
    }
  }
  $(newChat).each(function(){
    var mydate = this.fullsentTime.split(' ')[0];
    if(dd != mydate){
      $('[name=chatBox]').append(
        '<div class="alert alert-success text-center" role="alert">'+
          this.fullsentTime.split(' ')[0] +
        '</div>'
      );
    }
    dd = mydate;
    if(this.diff!='me'){
      $('[name=chatBox]').append(
        '<div class="text-left">'+
          '<div class="d-flex bd-highlight">'+
            '<div class="p-2 bd-highlight bg-dark text-white rounded-pill">'+
            this.content.replace(/style="color:#FFFFFF;"/g,'style="color:#646464;"').replace('<a href="/chat/','<a href="#" data-toggle="modal" data-target="#basicModal" data-type="file" data-href="/chat/')+
            '</div>'+
          '</div>'+
          '<small>'+this.sentTime+'</small>'+
          '<a target="_blank" href="#" data-toggle="modal" data-target="#basicModal" data-type="readlist" data-content="'+encodeURIComponent(this.content)+'" data-sentTime="'+this.fullsentTime+'" data-UID="'+this.UID+'"><i class="fa fa-eye" aria-hidden="true"></i>'+this.Read+'</a>'+
          '<a class="badge badge-light ml-1" href="#" data-toggle="modal" data-target="#basicModal"><i class="fa fa-reply" aria-hidden="true"></i></a>'+
          '<a class="badge badge-danger ml-1" name="badgeLike" href="#"><i class="fa fa-heart mr-1" aria-hidden="true"></i>1</a>'+
        '</div>'
      );
    }
    else{
      $('[name=chatBox]').append(
        '<div class="text-right outgoing_msg" data-sentTime="'+this.fullsentTime+'">'+
          '<div class="d-flex flex-row-reverse bd-highlight">'+
            '<div class="p-2 bd-highlight bg-secondary text-white rounded-pill">'+
              this.content.replace('<a href="/chat/','<a href="#" data-toggle="modal" data-target="#basicModal" data-type="file" data-href="/chat/')+
            '</div>'+
          '</div>'+
          '<small>'+this.sentTime+'</small>'+
          '<a target="_blank" href="#" data-toggle="modal" data-target="#basicModal" data-type="readlist" data-content="'+encodeURIComponent(this.content)+'" data-sentTime="'+this.fullsentTime+'" data-UID="'+this.UID+'"><i class="fa fa-eye" aria-hidden="true"></i>'+this.Read+'</a>'+
          '<a class="badge badge-light ml-1" href="#" data-toggle="modal" data-target="#basicModal" data-type="comments" data-likeID="'+this.likeID+'" data-content="'+encodeURIComponent(this.content)+ '"data-sentTime="'+this.fullsentTime+'" data-UID="'+this.UID+'" data-readcount="'+this.Read+'" ><i class="fa fa-reply" aria-hidden="true"></i></a>'+
          '<a class="badge badge-danger ml-1" name="badgeLike" href="#" data-content="'+encodeURIComponent(this.content)+'" data-sentTime="'+this.fullsentTime+'" data-UID="'+this.UID+'" onclick=\'addLike(\"'+this.content+'\",\"'+this.fullsentTime+'\",\"'+this.UID+'\",'+this.likeID+');\'><i class="fa fa-heart mr-1" aria-hidden="true"></i>'+
            this.LikeCount+
          '</a>'+
        '</div>'
      );
    }
  });
  if(!scrollable)
    $('.msg_history').scrollTop($('.msg_history')[0].scrollHeight);
}

function addLike(content,senttime,UID,likeID){
  $.ajax({
    url:'/chat/likeID',
    type:'post',
    data:{data:JSON.stringify({content:content,
          senttime:senttime,
          UID:UID,
          chatID:chatID,
          likeID:likeID})},
    dataType:'json'
  });
// $.ajax({
// url:'/chat/addLike',
// type:'get',
// data:{content:content,
//       senttime:senttime,
//       UID:UID},
// dataType:'json'
// })
}

function updateLastReadTime(){
  if(queue['lastReadTime']!=null)
    queue['lastReadTime'].abort();
  queue['lastReadTime'] = $.ajax({
    url:'/chat/lastReadTime',
    type:'post',
    data:{chatID:chatID,_METHOD:'PATCH'},
    dataType:'json',
    success:function(response){
//      routine();
    }
  });
}
function updateCommentReadTime(data){
  //console.log("UPDATE CMT")
  if(queue['commentreadtime']!=null){
    queue['commentreadtime'].abort();
  }
  queue['commentreadtime'] = $.ajax({
    url:'/chat/commentReadTime',
    type:'patch',
    data:{data:JSON.stringify(data)},
    dataType:'json'
  });
}



var chatID=-1;
var chatName = '';

$('#tool_dropdown').hide();


function getTarget(_chatID,_chatName){
  // // console.log($(div).attr("data-name"));
  // // chatID=$(div).attr("data-name");
  // scrollable = false;
  // last['count'] = 0;
  // $('[name=chatBox]').html("");
  start = Date.now();
  if(chatID!=_chatID)
    $('[name=chatBox]').html(
      '<div class="spinner-border text-primary" role="status">'+
        '<span class="sr-only">Loading...</span>'+
      '</div>'
    );
  chatName = decodeURIComponent(_chatName);
  $('[name=navbarChatroomTitle]').text(chatName);
  $('#tool_dropdown').show();
  // resetLimit();
  if(chatID != _chatID){
    chatID = _chatID;
    routine(); 
  }else{
    scrollToTag();
  }
  updateLastReadTime();
  $(document).scrollTop(document.body.scrollHeight);
  // schedule();
  // getReadcount();
  
}

function expendLimit(){
  last['limit']+=5;
}

function resetLimit(){
  last['limit']=20;
}
var last = new Object();
last['limit'] = 20;
last['count'] = 0;
last['countchat'] = 0;
last['clientClass'] ={};
last['chatClientInfo'] = {};
var Msg ="";
$('.msg_send_btn').on('click',function(){
  if(!$.trim($("#textarea").val()) && $("#textinput").val()!="" && chatID!=-1){
    sendMsg();
    $("#textinput").val("");
  }
});
$("#textinput").keypress(function(e){
  var code=e.which;
  if((code&&e.shiftKey) &&code==13){
    e.preventDefault();
    $('.msg_send_btn').click();
  }
});
$("#textinput").keyup(function(e){
  var code=e.which;
  if((code&&e.shiftKey) &&code==13){
  }
});
function uploadFile(button){
  $('#basicModal').modal('hide');
  $('[name=inputFile]').val('');
  $('[name=inputFile]').click();
}
function uploadPicture(button){
  $('#basicModal').modal('hide');
  $('[name=inputPicture]').click();
}
$('[name=inputFile]').on('change',function(){
  var file_data = $(this).prop('files')[0];
  var form_data = new FormData();
  form_data.append('inputFile', file_data);
  $.ajax({
    url: '/chat/file/'+chatID,
    cache: false,
    contentType: false,
    processData: false,
    data: form_data,     //data只能指定單一物件                 
    type: 'post',
    success: function(data){
      
    }
  });
});
$('[name=inputPicture]').on('change',function(){
  var file_data = $(this).prop('files')[0];
  var form_data = new FormData();
  form_data.append('inputFile', file_data);
  $.ajax({
    url: '/chat/picture/'+chatID,
    cache: false,
    contentType: false,
    processData: false,
    data: form_data,     //data只能指定單一物件                 
    type: 'post',
    success: function(data){
      
    }
  });
});
function tagNotification(type,tagPerson,chatName,tmpTime){
  // console.log(type,tagPerson,chatName,tmpTime);
  if(type == "person"){
    $.ajax({
      url:'/chat/notification/tag',
      type:'POST',
      data:{data:JSON.stringify({
              type:type,
              chatID:chatID,
              id : tagPerson,
              chatName : chatName,
              tmpTime : tmpTime
              // name : groupname
            })},
      dataType:'json',
      success:function(response){
        console.log(response);
      } 
    });
  }else if(type == "department"){
    $.ajax({
      url:'/staff/name/'+tagPerson+'/departmentMember/'+chatID,
      type:'GET',
      dataType:'json',
      success:function(response){
       
        $(response).each(function(){
          tagNotification("person",this.id,chatName,tmpTime)
          console.log(this.id);
        });
      } 
    });

    // $.ajax({
    //   url:'/chat/notification/tag',
    //   type:'POST',
    //   data:{data:JSON.stringify({
    //           type:type,
    //           chatID:chatID,
    //           id : tagPerson,
    //           chatName : chatName,
    //           tmpTime : tmpTime
    //           // name : groupname
    //         })},
    //   dataType:'json',
    //   success:function(response){
    //     console.log(response);
    //   } 
    // });
  }
  
}

function beforeTag(tmpSplit,tmpFullTime){
  
  // console.log(tmpSplit);
  if(tagDepartment != ""){
    var checkTagDepartmentID = tagDepartment.split(" ");
    $(checkTagDepartmentID).each(function(){
      // console.log(this);
      var tagItem=this;
      
        if(this != ""){
          $.ajax({
            url:'/staff/department/'+this,
            type:'get',
            dataType:'json',
            success:function(response){
            // getTarget(chatID,chatName);
              $(tmpSplit).each(function(){
                console.log(this);
                if("#"+response[0].department_name == this)
                {
                  console.log("success");
                  tagNotification("department",tagItem,chatName,tmpFullTime);
                }
              });
            }
          });
        }
    });
  }
  if(tagPeople != ""){
    var checkTagID = tagPeople.split(" ");
    $(checkTagID).each(function(){
      
      var tagPerson=this;
      
      if(this != ""){
        $.ajax({
          url:'/staff/name/'+this+'/tag',
          type:'get',
          dataType:'json',
          success:function(response){
          // getTarget(chatID,chatName);
            $(tmpSplit).each(function(){
              if("@"+response[0].staff_name == this)
              {
                // console.log("in");
                tagNotification("person",tagPerson,chatName,tmpFullTime);
              }
            });
          }
        });
      }
    });
  }
  tagDepartment="";
  tagPeople = "";
}

function sendMsg(){
  // var tmpMsg;
  // console.log(tagDepartment,tagPeople);
  
  Msg=$("#textinput").val();
  console.log("append");
  $('[name=chatBox]').append(
    '<div class="text-right outgoing_msg" name="msgSendNow" data-sentTime="">'+
      '<div class="d-flex flex-row-reverse bd-highlight">'+
        '<div class="p-2 bd-highlight bg-secondary text-white rounded-pill">'+
          Msg +
        '</div>'+
      '</div>'+
    '</div>'
  );
  if(!scrollable){
    $('.msg_history').scrollTop($('.msg_history')[0].scrollHeight);
  }
  var tmpFullTime;
  var tmpSplit=$('#textinput').val().split(" ");
  Msg = Msg.replace(/\r?\n/g, '<br />');
    $.ajax({
      url:'/chat/message',
      type:'post',
      data:{Msg:Msg,
            chatID:chatID,_METHOD:'PATCH'},
      dataType:'json',
      success:function(response){
        // getTarget(chatID,chatName);
        tmpFullTime = response.time;

        // console.log(tmpFullTime);
        beforeTag(tmpSplit,tmpFullTime);
    }
  });
  // console.log(tmpFullTime);

  
  
  
  
}
function sendComment(msgsender,msgtime,data){
  Msg=$("#commentinput").val();
  Msg = Msg.replace(/\r?\n/g, '<br />');
    $.ajax({
      url:'/chat/comment',
      type:'post',
      data:{Msg:Msg,
            chatID:chatID,
            chatOrigin:msgsender,
            chatTime:msgtime,
            _METHOD:'PATCH'},
      dataType:'json',
      success:function(response){
        getCommentContent(data);
    }
  });
}
$('#basicModal').on('show.bs.modal',function(e){
  $('#basicModal .modal-footer').html(basicModalFooter);
  var type = $(e.relatedTarget).data('type');
  if(type=='create'){
    Chatroom(type);
  }else if(type=='update'){
    Chatroom(type);
  }else if(type=='member'){
    getMember();
  }else if(type=='delete'){
    Chatroom(type);
  }else if(type=='readlist'){
    getReadlist($(e.relatedTarget).data());
  }else if(type=='attach'){
    attachType();
  }else if(type=='photo'){
    viewPhoto($(e.relatedTarget).data('src'));
  }else if(type=='comments'){
    getComment($(e.relatedTarget).data());
  }else if(type=='addClass'){
    addIssue();
  }else if(type=='chooseIssues'){
    Chatroom(type);
  }else if(type=='insertClass'){
    insertIssue();
  }else if(type=='file'){
    getFile($(e.relatedTarget).data());
  }
});
function getFile(relatedData){
  $('#basicModal .modal-title').text('讀取中...');
  $('#basicModal .modal-body').html('<div class="spinner-border" role="status"> <span class="sr-only">Loading...</span> </div>');
  $.ajax({
    url:relatedData['href'].replace(/chat\/file/g,'chat\/fileFormat'),
    type:'get',
    dataType:'json',
    success:function(response){
      if(response.type=='file'){
        var win = window.open(relatedData['href']);
        if (win) {
            //Browser has allowed it to be opened
            win.focus();
        } 
        setTimeout(function(){ $('#basicModal').modal('hide'); },3000);
      }else if(response.type=='picture'){
        viewPhoto(relatedData['href'].replace(/chat\/file/g,'chat\/picture'));
      }
    }
  });
}
function insertIssue(){
   $('#basicModal .modal-title').text('選擇分類');
   console.log(chatID);
   $('#basicModal .modal-body').html('<h6 class="card-subtitle mb-2 text-muted listBox">');
   $.ajax({
    url:'/chat/class/',
    type:'GET',
    dataType:'json',
    success:function(response){
      $(response).each(function(){
        $('#basicModal .listBox').append(
          '<div class="input-group mb-2 listItem">'+
            '<div class="input-group-prepend">'+
              '<button type="button" class="btn btn-dark" name="buttonInsetClass" data-id='+this.id+'>'+
                this.name+
              '</button>'+
            '</div>'+
          '</div>'
        );
      });
      $('[name=buttonInsetClass]').on('click',function(e){
        var classId = $(this).data('id');
        var newclass;
        $.ajax({
          url:'/chat/class/'+classId+'/',
          type:'GET',
          dataType:'json',
          success:function(response){
            newclass = this.name;
          }
        });

        $.ajax({
          url:'/chat/class/'+classId+'/'+chatID+'/',
          type:'POST',
          data:{_METHOD:'patch'},
          dataType:'json',
          success:function(response){
            var extendObject = $('[name=chatBox]').children().clone(true);
            extendObject.find('[name="room'+classId+'"]').remove();
            $('[name="'+newclass+'"]').append(
              '<div class="card-body" name="room'+classId+'">'+
              '</div>'
            );
            $('[name="room'+classId+'"]').append(extendObject);
            // $(function(){
            //   $('#copy').clone().appendTo('#copied');
            // });
          } 
        });
        $('#basicModal').modal('hide');
      });
    }
  });
   $('#basicModal .modal-footer').html('<button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>'
  );
}
function addIssue(){
  $('#basicModal .modal-title').text('新增議題群組'); 
  $('#basicModal .modal-body').html(
    '<div class="sticky-top">'+
      '<div class="input-group mb-3">'+
        '<span class="input-group-text" id="inputGroup-sizing-default">分類名稱</span>'+
        '<input type="text" class="form-control" name="inputAddClassName" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">'+
        '<button type="button" class="btn btn-dark" name="buttonAddClass">新增</button>'+
      '</div>'+
      '<h6 class="card-subtitle mb-2 text-muted listBox">'+
    '</div>'
  );
  $('#basicModal .modal-footer').html('<button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>'
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
    url:'/chat/class/',
    type:'GET',
    dataType:'json',
    success:function(response){
      $(response).each(function(){
        $('#basicModal .listBox').append(
          '<div class="input-group mb-2 listItem">'+
            '<div class="input-group-prepend">'+
              '<input type="text" class="form-control listName" disabled value='+this.name+'>'+
              '<button type="button" class="btn" name="buttonDeleteClass" data-id='+this.id+'>'+
               '<i class="fa fa-times" aria-hidden="true"></i>'+
              '</button>'+
            '</div>'+
          '</div>'
        );
      });
      $('[name=buttonDeleteClass]').on('click',function(e){
        var classId = $(this).data('id');
        console.log(classId);
        $.ajax({
          url:'/chat/class/'+classId+'/',
          type:'POST',
          data:{_METHOD:'delete'},
          dataType:'json',
          success:function(response){
            console.log(response);
          } 
        });
        addIssue();
      });
    }
  }); 
  $('[name=buttonAddClass]').on('click',function(e){
    var groupname = $('[name=inputAddClassName]').val();
    $.ajax({
      url:'/chat/class/',
      type:'POST',
      data:{data:JSON.stringify({
              name : groupname
            })},
      dataType:'json',
      success:function(response){
        console.log(response);
      } 
    });
     $('#basicModal').modal('hide');
  });
}
function viewPhoto(src){
  $('#basicModal .modal-title').text('圖片');
  $('#basicModal .modal-body').html('<img class="img-fluid"/>');
  $('#basicModal .modal-body img').attr('src',src);
  $('#basicModal .modal-dialog').addClass('modal-xl');
  $('#basicModal .modal-body').addClass('text-center');
}
$('#basicModal').on('hidden.bs.modal',function(e){
  $('#basicModal .modal-dialog').removeClass('modal-xl');
    $('#basicModal .modal-body').removeClass('text-center');
});
function attachType(){
  $('#basicModal .modal-title').text('檔案類型'); 
  $('#basicModal .modal-body').html(
    '<div class="container-fluid">'+
      '<div class="row">'+
        '<div class="col-6">'+
          '<button type="button" class="btn btn-secondary float-right" onclick="uploadPicture(this)">分享圖片</button>'+
        '</div>'+
        '<div class="col-6">'+
          '<button type="button" class="btn btn-secondary" onclick="uploadFile(this)">上傳檔案</button>'+
        '</div>'+
      '</div>'+
    '</div>'
  );
}
function getReadcount(){
  var data = new Object();
  data['chatID'] = chatID;
  if(queue['readcount'] != null)
    queue['readcount'].abort();
  queue['readcount'] = $.ajax({
    url:'/chat/readcount',
    type:'get',
    data:{data:JSON.stringify(data)},
    dataType:'json',
    success:function(response){
      if(response[response.length-1].chatID != chatID){
        return false;
      }
      response.pop();
      var readcountElement = response.shift();
      if(readcountElement===undefined)
        return false;
      $('a[data-type=readlist]').each(function(){
        $(this).html('<i class="fa fa-eye" aria-hidden="true"></i>'+readcountElement.sum);
        if($(this).attr('data-sentTime')==readcountElement.sentTime){
          readcountElement = response.shift();
          if(readcountElement===undefined)
            return false;
        }
      });
      setTimeout(getReadcount,3000);
    }
  });
}
function getReadlist(relatedData){
  $('#basicModal .modal-title').text('已讀清單');
  $('#basicModal .modal-body').html(
    '<h5>已讀</h5>'+
    '<div name="readList"></div>'+
    '<hr>'+
    '<div class="alert alert-secondary" role="alert">'+
      '<h5 class="font-weight-bold">未讀</h5>'+
      '<div name="unreadList"></div>'+
    '</div>'
  );

  var data = new Object();
  data['UID'] = relatedData['uid'];
  data['sentTime'] = relatedData['senttime'];
  data['content'] = decodeURIComponent(relatedData['content']);
  data['chatID'] = chatID;
  $.ajax({
    url:'/chat/readlist',
    type:'get',
    data:{data:JSON.stringify(data)},
    dataType:'json',
    success:function(response){
      $('[name=readList]').html("");
      $('[name=unreadList]').html("");
      $(response).each(function(){
        if(this.checkread=='true')
          $('[name=readList]').append('<p>'+this.staff_name+'</p>')
        else
          $('[name=unreadList]').append('<p class="font-weight-bold">'+this.staff_name+'</p>')
      });
    }
  });
}
function getComment(relatedData){//TODO
  //console.log(relatedData);
  var scrollableComment = false;
  var data = new Object();
  data['UID'] = relatedData['uid'];
  data['sentTime'] = relatedData['senttime'];
  data['content'] = decodeURIComponent(relatedData['content']);
  data['chatID'] = chatID;
  updateCommentReadTime(data);
  getCommentReadList(data);
  
  $('#basicModal .modal-title').text('留言板');
  $('#basicModal .modal-body').html(
    '<h5>訊息</h5>'+
    '<div name="message">'+decodeURIComponent(relatedData['content'])+'</div>'+
    '已讀:'+relatedData['readcount']+
    '<hr>'+
    '<h5>留言</h5>'+
    '<div name="comment"></div>'+
    '<div class="type_msg">'+
      '<div class="input_msg_write">'+
        '<textarea style="word-wrap:break-word;width:100%;"placeholder="請在此輸入訊息，ENTER可以換行&#13;&#10;SHIFT+ENTER送出訊息" id="commentinput"></textarea>'+
        '<button class="msg_send_btn" type="button" id="commentbutton"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>'+
        '</div>'+
      '</div>'

  );
  $('#commentbutton').unbind().on('click',function(){
    if($("#commentinput").val()!=""){
      sendComment(relatedData['uid'],relatedData['senttime'],data);
      $("#commentinput").val("");
    }
  });
  $("#commentinput").unbind().keypress(function(e){
    var code=e.which;
    if((code&&e.shiftKey) &&code==13){
      e.preventDefault();
      $('#commentbutton').click();
    }
  });
  $("#commentinput").keyup(function(e){
    var code=e.which;
    if((code&&e.shiftKey) &&code==13){
    }
  });
}
function getCommentContent(data,readlist){
  $.ajax({
    url:'/chat/comment',
    type:'get',
    data:{data:JSON.stringify(data)},
    dataType:'json',
    success:function(response){
      console.log(response)
      $('[name=comment]').html("");
      $(response).each(function(){
        var count = 0;
        for (var i = 0; i < readlist.length; i++) {
          if(readlist[i].lasttime > this.sentTime)count++;
        }
        $('[name=comment]').append(
            '<div class="incoming_msg" "data-sentTime="'+this.fullsentTime+'">'+
                '<div class="">'+this.sender+'</div>'+
                '<div class="received_msg">'+
                  '<div class="received_withd_msg">'+
                    '<p class="text-break">'+
                      this.content+
                    '</p>'+
                    '<span class="time_date"> '+this.formatTime+'</span>'+
                    '<i class="fa fa-eye" aria-hidden="true"></i>'+count+
                  '</div>'+
                '</div>'+
              '</div>'
          )
      });    
      //TODO, scroll to bottom, bootstrap bug??
      /*
      $('#basicModal .modal-content').css('overflow','hidden');
      $('#modal').animate({ scrollTop: $('#modal .modal-content').height() }, 'slow');
      console.log($('#basicModal .modal-content').height());
      console.log($('#basicModal .modal-content'));
      console.log($('#basicModal').height());
      */
      //$('#basicModal .modal-content').scrollTop($('#basicModal .modal-content').height());
      //console.log($('#basicModal .modal-content'));
    }
  });
}
function getCommentReadList(data){//TODO : promise
  $.ajax({
    url:'/chat/commentReadList',
    type:'get',
    data:{data:JSON.stringify(data)},
    dataType:'json',
    success:function(response){
      console.log(response)
      getCommentContent(data,response);
    }
  });
}
function getMember(){
  $('#basicModal .modal-title').text('議題成員');
  $('#basicModal .modal-body').html('<div class="spinner-border" role="status"> <span class="sr-only">Loading...</span> </div>');
  $.ajax({
    url:'/chat/member/'+chatID,
    type:'get',
    dataType:'json',
    success:function(response){
      $('#basicModal .modal-body').html('');
      $('#basicModal .modal-body').append(
        '<div class="card">'+
          '<div class="card-body">'+
            '<button class="btn btn-secondary" onclick="Chatroom(\'update\');">修改議題</button></br>'+
            '<p class="card-text">'+
              '<h6 class="card-subtitle mb-2 text-muted listBox">'+
              '</h6>'+
            '</p>'+
          '</div>'+
        '</div>'
      );
      $(response).each(function(){
        $('#basicModal .listBox').append(
          '<div class="input-group mb-3 listItem">'+
            '<input type="text" class="form-control listID" disabled value='+this.id+'>'+
            '<input type="text" class="form-control listName" disabled value='+this.name+'>'+
          '</div>'
        );
      });
    }
  });
}
function Chatroom(type){
  var _chatID = '';
  if(type=='delete'){
    $('#basicModal .modal-title').text('離開議題');
    $('#basicModal .modal-body').html('');
    $('#basicModal .modal-body').append('確定要離開此議題嗎？');
    $('#basicModal .modal-footer').prepend('<button class="btn btn-dark" name="buttonDeleteChatroom">確認</button>');
    $('[name=buttonDeleteChatroom]').unbind().on('click',function(){
      var data = new Object();
      data['chatID'] = chatID;
      $.ajax({
        url:'/chat/chatroom',
        type:'post',
        data:{data:JSON.stringify(data),_METHOD:'DELETE'},
        dataType:'json',
        success:function(response){
          $('#basicModal').modal('hide');
        }
      });
    });
    return;
  }else if(type=='create'){
    $('#basicModal .modal-title').text('新增議題');
    $('#basicModal .modal-body').html('');
    $('#basicModal .modal-body').append(
      '<div class="sticky-top">'+
        '<div class="input-group mb-3">'+
          '<span class="input-group-text" id="inputGroup-sizing-default">議題名稱</span>'+
          '<input type="text" class="form-control" name="inputChatroomTitle" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">'+
          '<button type="button" class="btn btn-dark buttonChatroomCreate">新增</button>'+
        '</div>'+
      '</div>'
    ); 
    $('#basicModal .buttonChatroomCreate').unbind().on('click',function(){
      var data = new Object();
      data['title'] = $('#basicModal [name=inputChatroomTitle]').val();
      data['member'] = [];
      $('#basicModal .checkItem:checked').each(function(){
        var member = new Object();
        member['UID'] = $(this).data('name');
        data['member'].push(member);
      });
      $.ajax({
        url:'/chat/chatroom',
        type:'post',
        data:{data:JSON.stringify(data)},
        dataType:'json',
        success:function(response){
          if(response.status=='success'){
            $('#basicModal').modal('hide');
          }else{
            $('#basicModal').modal('hide');
          }
        }
      });
    });
  }else if(type=='update'){ 
    _chatID = '/'+chatID;
    $('#basicModal .modal-title').text('修改議題');
    $('#basicModal .modal-body').html('');
    $('#basicModal .modal-body').append(
      '<div class="sticky-top">'+
        '<div class="input-group mb-3">'+
          '<span class="input-group-text" id="inputGroup-sizing-default">議題名稱</span>'+
          '<input type="text" class="form-control" name="inputChatroomTitle" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">'+
          '<button type="button" class="btn btn-dark buttonChatroomUpdate">修改</button>'+
        '</div>'+
      '</div>'
    );
    $.ajax({
      url:'/chat/chatroom/title/'+chatID,
      type:'get',
      dataType:'json',
      success:function(response){
        if(response.length>0){
          $('#basicModal [name=inputChatroomTitle]').val(response[0]['chatName']);
        }
      }
    });
    $('#basicModal .buttonChatroomUpdate').unbind().on('click',function(){
      var data = new Object();
      data['title'] = $('#basicModal [name=inputChatroomTitle]').val();
      data['member'] = [];
      data['chatID'] = chatID;
      $('#basicModal .checkItem:checked').each(function(){
        var member = new Object();
        member['UID'] = $(this).data('name');
        data['member'].push(member);
      });
      $.ajax({
        url:'/chat/chatroom',
        type:'post',
        data:{data:JSON.stringify(data),_METHOD:'PATCH'},
        dataType:'json',
        success:function(response){
          if(response.status=='success'){
            $('#basicModal').modal('hide');
          }else{
            $('#basicModal').modal('hide');
          }
        }
      });
    });
  }else if(type=='choooseIssues'){
    $('#basicModal .modal-title').text('選擇分類');
    $('#basicModal .modal-body').html('');

  }
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
    url:'/chat/list'+_chatID,
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
}
$("#textinput").on('paste', function (e) {
    var clipboardData = e.originalEvent.clipboardData;
    var items = clipboardData.items;
    for (var i = 0; i < items.length; i++) {
      if (items[i].type.indexOf("image") == -1) continue;
      var file_data = items[i].getAsFile();
      var form_data = new FormData();
      form_data.append('inputFile', file_data);
      $.ajax({
        url: '/chat/file/'+chatID,
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,     //data只能指定單一物件                 
        type: 'post',
        success: function(data){
          
        }
      });
    }
});
var searchBar = null;
$('#searchChatroomInput').on('keyup',function(){
  if(searchBar!=null){
    clearTimeout(searchBar);
  }
  if($('#searchChatroomInput').val()==''){
    $('.chat_list').parent().show();
  }
  searchBar = setTimeout(function(){
    $('.chat_list').each(function(){
      if($(this).find('.chatName').text().indexOf($('#searchChatroomInput').val())>-1){
        $(this).parent().show();
      }else{
        $(this).parent().hide();
      }
    });
  },500);
});
</script>
