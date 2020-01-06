<?php
 include('partial/header.php')
?>
<!-- Custom styles for this template -->
<link href="/css/ictrc-chatroom.min.css" rel="stylesheet">

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

          <div style="display:flex; justify-content:flex-end; width:100%; ">
            <div class="btn-group" id="tool_dropdown" >
              <button type="button" class="btn btn-light dropdown-toggle text-dark bg-light" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false" >
              </button>
            <div class="dropdown-menu dropdown-menu-right">
                <button class="dropdown-item" type="button-light" data-toggle="modal" data-target="#basicModal" data-type="member">成員列表</button>
                <div class="dropdown-divider"></div>
                <button class="dropdown-item" type="button" data-toggle="modal" data-target="#basicModal" data-type="delete">離開議題</button>
              </div>
            </div>
          </div>
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
//window focus
var isTabActive = true;
var titleOrg=$('title').text();
$(function(){
  titleOrg=$('title').text();
});
window.onfocus = function () { 
  window.isTabActive = true; 
  $('title').text(titleOrg);
  updateLastReadTime();
}; 

window.onblur = function () { 
  window.isTabActive = false; 
}; 
//focus end
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
var scrollable = false;
function schedule(){
  // searchChatroom();
  // searchChat();
  // clearTimeout(queue['chatroom']);
  // clearTimeout(queue['chat']);
  setTimeout(searchChatroom,1000);
  setTimeout(searchChat,1000);
}
schedule();

function updateLastReadTime(){
  if(queue['lastReadTime']!=null)
    queue['lastReadTime'].abort();
  queue['lastReadTime'] = $.ajax({
    url:'/chat/lastReadTime',
    type:'post',
    data:{chatID:chatID,_METHOD:'PATCH'},
    dataType:'json'
  })
}

function searchChatroom(){
  if(queue['chatroom']!=null)
    queue['chatroom'].abort();
  queue['chatroom'] = $.ajax({
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
        if(window.isTabActive){
          $('title').text(titleOrg);
        }
        if(this.CountUnread!='0'&&this.CountUnread!=null){
          haveUnread='<span class="badge badge-primary">有'+this.CountUnread+'則新訊息</span> ';
          if(!window.isTabActive){
            if($('title').text().indexOf('您有訊息!!')>-1)
              $('title').text(titleOrg);
            else
              $('title').text('[您有訊息!!]'+titleOrg);
          }
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
                '<p class="text-truncate chatContent">'+ (this.content==null?' ':(this.content.indexOf('<a ')>-1?'收到一個檔案':this.content)) +'</p>'+
                haveUnread +
              '</div>'+
            '</div>'+
          '</div>'
        );
      });
      if(!scrollable)
        $('.msg_history').scrollTop($('.msg_history')[0].scrollHeight);
      setTimeout(searchChatroom,1000);
    }
  });

}
var chatID=-1;
var chatName = '';

$('#tool_dropdown').hide()


function getTarget(_chatID,_chatName){
  // console.log($(div).attr("data-name"));
  // chatID=$(div).attr("data-name");
  scrollable = false;
  chatID = _chatID;
  last['count'] = 0;
  $('[name=chatBox]').html("");
  chatName = decodeURIComponent(_chatName);
  $('[name=navbarChatroomTitle]').text(chatName);
  $('#tool_dropdown').show()
  resetLimit();
  updateLastReadTime();
  schedule();
  getReadcount();
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
function searchChat(){
  if(chatID!=-1 && chatID!==undefined){
    if(queue['chat'] != null)
      queue['chat'].abort();
    queue['chat'] = $.ajax({
      url:'/chat/content/'+chatID,
      data:{data:JSON.stringify(last)},
      type:'get',
      dataType:'json',
      success:function(response){
        // $('[name=chatBox]').html("");
        if(response[response.length-1].chatID != chatID){
          return false;
        }
        response.pop();
        if(window.isTabActive)
          updateLastReadTime();
        $(response).each(function(){
          last['count'] = last['count']+1;
          if(this.diff!='me'){
            $('[name=chatBox]').append(
              '<div class="incoming_msg">'+
                '<div class="">'+this.UID+','+this.staff_name+'</div>'+
                '<div class="received_msg">'+
                  '<div class="received_withd_msg">'+
                    '<p class="text-break">'+
                      +this.content.replace(/style="color:#FFFFFF;"/g,'style="color:#646464;"')+
                      '<br>'+
                      '<a target="_blank" href="#" data-toggle="modal" data-target="#basicModal" data-type="comments" data-content="'+encodeURIComponent(this.content)+ '"data-sentTime="'+this.fullsentTime+'" data-UID="'+this.UID+'" data-readcount="'+this.Read+'" style="color:red">'+'留言'+'</a>'+
                    '</p>'+
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
                  '<p class="text-break content">'+
                    +this.content+
                    '<br>'+
                    '<a target="_blank" href="#" data-toggle="modal" data-target="#basicModal" data-type="comments" data-content="'+encodeURIComponent(this.content)+'" data-sentTime="'+this.fullsentTime+'" data-UID="'+this.UID+'" data-readcount="'+this.Read+'"  style="color:red">'+'留言'+'</a>'+
                  '</p>'+
                  '<span class="time_date" > '+this.sentTime+'</span>'+
                  '<a href="#" data-toggle="modal" data-target="#basicModal" data-type="readlist" data-content="'+encodeURIComponent(this.content)+'" data-sentTime="'+this.sentTime+'" data-UID="'+this.UID+'">已讀:'+this.Read+'</a>'+
                '</div>'+
              '</div>'
            );
          }
        });
        if(!scrollable)
          $('.msg_history').scrollTop($('.msg_history')[0].scrollHeight);
        setTimeout(searchChat,1000);
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
  });
}
function sendComment(msgsender,msgtime,data){
  console.log(msgtime);
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
        getCommentContent(data)
        console.log(response);
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
  }
});
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
      $('a[data-type=readlist]').each(function(){
        $(this).text('已讀:'+readcountElement.sum);
        if($(this).attr('data-sentTime')==readcountElement.sentTime){
          readcountElement = response.shift();
          if(readcountElement===undefined)
            return false;
        }
      });
      setTimeout(getReadcount,1000);
    }
  });
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
function getComment(relatedData){//TODO
  console.log(relatedData);
  var data = new Object();
  data['UID'] = relatedData['uid'];
  data['sentTime'] = relatedData['senttime'];
  data['content'] = decodeURIComponent(relatedData['content']);
  data['chatID'] = chatID;
  
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
        '<button class="comment_send_btn" type="button"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>'+
        '</div>'+
      '</div>'

  );
  $('.comment_send_btn').on('click',function(){
    if($("#commentinput").val()!=""){
      sendComment(relatedData['uid'],relatedData['senttime'],data);
      $("#commentinput").val("");
    }
  });
  getCommentContent(data);
}
function getCommentContent(data){
  $.ajax({
    url:'/chat/comment',
    type:'get',
    data:{data:JSON.stringify(data)},
    dataType:'json',
    success:function(response){
      console.log(response)
      $('[name=comment]').html("");
      $(response).each(function(){
        $('[name=comment]').append(
            '<div class="incoming_msg">'+
                '<div class="">'+this.sender+'</div>'+
                '<div class="received_msg">'+
                  '<div class="received_withd_msg">'+
                    '<p class="text-break">'+
                      this.content+
                    '</p>'+
                    '<span class="time_date"> '+this.sentTime+'</span>'+
                  '</div>'+
                '</div>'+
              '</div>'
          )
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