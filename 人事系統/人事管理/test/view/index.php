<?php
 include('partial/header.php')
?>
          <!-- Page Heading -->
<style >

@media (max-width:550px) {

  /* your conditional / responsive CSS inside this condition */

  
  .inbox_people {
    background: #f8f8f8 none repeat scroll 0 0;
    float: left;
    overflow: hidden;
    width: 40%; border-right:1px solid #c4c4c4;
  }
  .chatContent,.chat_date,.chat_img,.chat_ib button{
    display:none;
  }

  .mesgs {
    float: left;
    padding: 30px 15px 0 25px;
    width: 60%;
  }
}

@media (max-width:700px) {
  .time_date {
    color: #747474;
    display: inline;
    font-size: 12px;
    margin: 8px 0 0;
  }
  .read{
    display: inline;
  }
}

.container{max-width:1170px; margin:auto;}
img{ max-width:100%;}
.inbox_people {
  background: #f8f8f8 none repeat scroll 0 0;
  float: left;
  overflow: hidden;
  width: 29%; border-right:1px solid #c4c4c4;
  margin-left: 1px;

}
.inbox_msg {
  margin:auto;
  border: 1px solid #c4c4c4;
  clear: both;
  overflow: hidden;
}
.top_spac{ margin: 20px 0 0;}


.recent_heading {float: left; width:40%;}
.srch_bar {
  display: inline-block;
  text-align: right;
  width: 60%; padding:
}
.tool_bar{
  display: inline-block;
  text-align: right;
  width: 60%;
}
.headind_srch{ padding:10px 29px 10px 20px; overflow:hidden; border-bottom:1px solid #c4c4c4;}

.recent_heading h4 {
  color: #05728f;
  font-size: 21px;
  margin: auto;
}
.srch_bar input{ border:1px solid #cdcdcd; border-width:0 0 1px 0; width:80%; padding:2px 0 4px 6px; background:none;}
.srch_bar .input-group-addon button {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  padding: 0;
  color: #707070;
  font-size: 18px;
}
.srch_bar .input-group-addon { margin: 0 0 0 -27px;}

.chat_ib h5{ font-size:15px; color:#464646; margin:0 0 8px 0;}
.chat_ib h5 span{ font-size:13px; float:right;}
.chat_ib p{ font-size:14px; color:#989898; margin:auto}
.chat_img {
  float: left;
  width: 11%;
}
.chat_ib {
  float: left;
  padding: 0 0 0 15px;
  width: 88%;
}

.chat_people{ overflow:hidden; clear:both;}
.chat_list {
  border-bottom: 1px solid #c4c4c4;
  margin: 0;
  padding: 19px 16px 10px;
}
.inbox_chat { 
  height: 60vh; overflow-y: scroll;}

.active_chat{ background:#ebebeb;}

.incoming_msg_img {
  display: inline-block;
  width: 6%;
}
.received_msg {
  display: inline-block;
  padding: 0 0 0 10px;
  vertical-align: top;
  width: 92%;
 }
 .received_withd_msg p {
  background: #ebebeb none repeat scroll 0 0;
  border-radius: 3px;
  color: #646464;
  font-size: 14px;
  margin: 0;
  padding: 5px 10px 5px 12px;
  width: 100%;
}
.time_date {
  color: #747474;
  display: inline;
  font-size: 12px;
  margin: 8px 0 0;
}
.read{
  display: inline;
}
.received_withd_msg { width: 57%;}
.mesgs {
  float: left;
  padding: 30px 15px 0 25px;
  width: 70%;
}

.sent_msg p.content {
  background: #05728f none repeat scroll 0 0;
  border-radius: 3px;
  font-size: 14px;
  margin: 0; color:#fff;
  padding: 5px 10px 5px 12px;
  width:100%;
}
.outgoing_msg{ overflow:hidden; margin:26px 0 26px;}
.sent_msg {
  float: right;
  width: 46%;
}
.input_msg_write input {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  color: #4c4c4c;
  font-size: 15px;
  min-height: 48px;
  width: 100%;
}

.type_msg {border-top: 1px solid #c4c4c4;position: relative;}
.msg_send_btn {
  background: #05728f none repeat scroll 0 0;
  border: medium none;
  border-radius: 50%;
  color: #fff;
  cursor: pointer;
  font-size: 17px;
  height: 33px;
  position: absolute;
  right: 0;
  top: 11px;
  width: 33px;
}
.msg_attach_btn {
  background: #05728f none repeat scroll 0 0;
  border: medium none;
  border-radius: 50%;
  color: #fff;
  cursor: pointer;
  font-size: 17px;
  height: 33px;
  position: absolute;
  right: 33px;
  top: 11px;
  width: 33px;
}
.messaging { padding: 0 0 50px 0;}
.msg_history {
  height: 50vh;
  overflow-y: auto;
}
.circleBase {
    border-radius: 50%;
    behavior: url(PIE.htc); /* remove if you don't care about IE8 */
}

.type2 {
    width: 25px;
    height: 25px;
    background: #ccc;
    border: 3px solid #000;
}
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
<div class="messaging">
  <div class="inbox_msg">
    <div class="inbox_people">
      <div class="headind_srch">
        <div class="recent_heading">
          <h4>議題列表</h4>
        </div><!-- 
        <div class="srch_bar">
          <div class="stylish-input-group">
            <input type="text" class="search-bar"  placeholder="Search" >
            <span class="input-group-addon">
            <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
            </span> 
          </div>
        </div> -->
        <div class="tool_bar btn-group">
          <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#basicModal" data-type="create">+</button>
        </div>
      </div>
      <div class="inbox_chat" name=inbox_chat>
        <!-- ajax 動態更新擴增 -->
      </div>
    </div>
    <div class="mesgs">
      <div class="sticky-top">
        <nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color: #e3f2fd;">
          <a class="navbar-brand" name="navbarChatroomTitle"></a>
        </nav>
      </div>
      <div class="msg_history" name=chatBox>
        
        
      </div>
        <a class="scroll-to-down rounded">
          <i class="fas fa-angle-down"></i>
        </a>
      <div class="type_msg">
        <div class="input_msg_write">
          <textarea style="word-wrap:break-word;width:100%;"placeholder="請在此輸入訊息，ENTER可以換行&#13;&#10;SHIFT+ENTER送出訊息" id="textinput"></textarea>
          <!-- <input id="textinput"type="text" /> -->
          <input style="display:none;" type="file" name="inputFile">
          <input style="display:none;" type="file" name="inputPicture" accept="image/*" >
          <button class="msg_attach_btn" type="button" data-toggle="modal" data-target="#basicModal" data-type="attach"><i class="fa fa-plus" aria-hidden="true"></i></button>
           <!-- name="buttonAttchFile" -->
          <button class="msg_send_btn" type="button"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
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
<?php
 include('partial/footer.php')
?>
<script type='text/javascript'>
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
  });
  $('.scroll-to-down').unbind().on('click',function(){
      scrollable = false;
    $('.msg_history').scrollTop($('.msg_history')[0].scrollHeight);
  });
var queue = [];
queue['chatroom'] = null;
var scrollable = false;
function schedule(){
  // searchChatroom();
  // searchChat();
  clearTimeout(queue['chatroom']);
  clearTimeout(queue['chat']);
  queue['chatroom'] = setTimeout(searchChatroom,1000);
  queue['chat'] = setTimeout(searchChat,1000);
}
schedule();

function updateLastReadTime(){
  $.ajax({
    url:'/chat/lastReadTime',
    type:'post',
    data:{chatID:chatID,_METHOD:'PATCH'},
    dataType:'json'
  })
}

function searchChatroom(){
  $.ajax({
    url:'/chat/chatroom',
    type:'get',
    data:{},
    dataType:'json',
    success:function(response){
      // console.log($($('.chat_list')[0]).attr('data-name'));
      // console.log(response[0].chatID);
      // if(parseInt($($('.chat_list')[0]).attr('data-name'))==parseInt(response[0].chatID)){
      //   return;
      // }
      $('[name=inbox_chat]').html("");
      $(response).each(function(){
        var chatName ='';
        if (this.chatToWhom==null){
          chatName=this.chatName;
        }
        else{
          chatName=this.staff_name;
        }
        var haveUnread ='';
        if(this.CountUnread!='0'&&this.CountUnread!=null){
          haveUnread='<span class="badge badge-primary">有'+this.CountUnread+'則新訊息</span> '
        }
        else{
          haveUnread ='<span class="badge badge-primary" style="display:none;">有'+this.CountUnread+'則新訊息</span> ';
        }
        $('[name=inbox_chat]').append(
          '<div class="chat_list" onclick="getTarget('+this.chatID+',\''+encodeURIComponent(chatName)+'\');" data-name="'+this.chatID+'">'+
            '<div class="chat_people">'+
              '<div class="chat_img">'+
                '<div class="circleBase type2"></div>'+
              '</div>'+
              '<div class="chat_ib">'+
                '<h5>'+chatName+
                  '<span class="chat_date">'+ (this.LastTime==null?' ':this.LastTime) +'</span>'+
                '</h5>'+
                '<button type="button" class="close" aria-label="Close" data-toggle="modal" data-target="#basicModal" data-type="delete">'+
                  '<span aria-hidden="true">&times;</span>'+
                '</button>'+
                '<button type="button" class="close" aria-label="Close" data-toggle="modal" data-target="#basicModal" data-type="member">'+
                  '<span aria-hidden="true">&equiv;</span>'+
                '</button>'+
                '<p class="text-truncate chatContent">'+ (this.content==null?' ':this.content) +'</p>'+
                haveUnread +
              '</div>'+
            '</div>'+
          '</div>'
        );
      });
    },
    complete:function(){
      queue['chatroom'] = setTimeout(searchChatroom,1000);
    }
  });

}
var chatID=-1;
var chatName = '';
function getTarget(_chatID,_chatName){
  // console.log($(div).attr("data-name"));
  // chatID=$(div).attr("data-name");
  scrollable = false;
  chatID = _chatID;
  last['count'] = 0;
  $('[name=chatBox]').html("");
  chatName = decodeURIComponent(_chatName);
  $('[name=navbarChatroomTitle]').text(chatName);
  updateLastReadTime();
  schedule();
}
var last = new Object();
last['limit'] = 20;
last['count'] = 0;
function searchChat(){
  if(chatID!=-1 && chatID!==undefined){
    queue['ajaxChat']=$.ajax({
      url:'/chat/content/'+chatID,
      data:{data:JSON.stringify(last)},
      type:'get',
      dataType:'json',
      success:function(response){
        $(response).each(function(){
          last['count'] = last['count']+1;
          if(this.diff!='me'){
            $('[name=chatBox]').append(
              '<div class="incoming_msg">'+
                '<div class="">'+this.UID+','+this.staff_name+'</div>'+
                '<div class="received_msg">'+
                  '<div class="received_withd_msg">'+
                    '<p class="text-break">'+this.content+'</p>'+
                    '<span class="time_date"> '+this.sentTime+'</span>'+
                    '<span class="read">'+
                      '<a target="_blank" href="#" data-toggle="modal" data-target="#basicModal" data-type="readlist" data-content="'+encodeURIComponent(this.content)+'" data-sentTime="'+this.sentTime+'" data-UID="'+this.UID+'">已讀:'+this.Read+'</a>'+
                    '</span>'+
                  '</div>'+
                '</div>'+
              '</div>'
            );
          }
          else{
            $('[name=chatBox]').append(
              '<div class="outgoing_msg">'+
                '<div class="sent_msg">'+
                  '<p class="text-break content">  '+this.content+'  </p>'+
                  '<span class="time_date" > '+this.sentTime+'</span>'+
                  '<a href="#" data-toggle="modal" data-target="#basicModal" data-type="readlist" data-content="'+encodeURIComponent(this.content)+'" data-sentTime="'+this.sentTime+'" data-UID="'+this.UID+'">已讀:'+this.Read+'</a>'+
                '</div>'+
              '</div>'
            );
          }
        });
        if(!scrollable)
          $('.msg_history').scrollTop($('.msg_history')[0].scrollHeight);
      },
      complete:function(){
        queue['chat'] = setTimeout(searchChat,1000);
      }
    });
  }
}
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
function sendMsg(){
  Msg=$("#textinput").val();
  Msg = Msg.replace(/\r?\n/g, '<br />');
    $.ajax({
      url:'/chat/message',
      type:'post',
      data:{Msg:Msg,
            chatID:chatID,_METHOD:'PATCH'},
      dataType:'json',
      success:function(response){
        // getTarget(chatID,chatName);
    }
  })

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
  }
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
function getReadlist(relatedData){
  $('#basicModal .modal-title').text('已讀清單');
  $('#basicModal .modal-body').html(
    '<h5>已讀</h5>'+
    '<div name="readList"></div>'+
    '<hr>'+
    '<h5>未讀</h5>'+
    '<div name="unreadList"></div>'
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
          $('[name=unreadList]').append('<p>'+this.staff_name+'</p>')
      });
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
            '<button class="btn btn-secondary" onclick="Chatroom(\'update\');">修改議題</button>'+
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
</script>