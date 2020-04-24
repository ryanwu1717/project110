<?php
  include('partial/header.php');
?>
<style>

.calendar, .calendar_weekdays, .calendar_content {
    max-width: 300px;
}
.calendar {
    margin: auto;
    font-family:'Muli', sans-serif;
    font-weight: 400;
}
.calendar_content, .calendar_weekdays, .calendar_header {
    position: relative;
    overflow: hidden;
}
.calendar_weekdays div {
    display:inline-block;
    vertical-align:top;
}
.calendar_weekdays div, .calendar_content div {
    width: 14.28571%;
    overflow: hidden;
    text-align: center;
    background-color: transparent;
    color: #6f6f6f;
    font-size: 14px;
}
.calendar_content div {
    border: 1px solid transparent;
    float: left;
}
.calendar_content div:hover {
    border: 1px solid #dcdcdc;
    cursor: default;
}
.calendar_content div.blank:hover {
    cursor: default;
    border: 1px solid transparent;
}
.calendar_content div.past-date {
    color: #d5d5d5;
}
.calendar_content div.today {
    font-weight: bold;
    font-size: 14px;
    color: #87b633;
    border: 1px solid #dcdcdc;
}
.calendar_content div.selected {
    background-color: #f0f0f0;
}
.calendar_header {
    width: 100%;
    text-align: center;
}
.calendar_header h2 {
    padding: 0 10px;
    font-family:'Muli', sans-serif;
    font-weight: 300;
    font-size: 18px;
    color: #87b633;
    float:left;
    width:70%;
    margin: 0 0 10px;
}
button.switch-month {
    background-color: transparent;
    padding: 0;
    outline: none;
    border: none;
    color: #dcdcdc;
    float: left;
    width:15%;
    transition: color .2s;
}
button.switch-month:hover {
    color: #87b633;
}
</style>
<div class="row">
	<!-- <div class="col-md-6">
		<div class="card mb-3">
		  	<div class="card-body">
			  	<div class="container">
					<div class="row">
						<div class="calendar calendar-first" id="calendar_first">
						    <div class="calendar_header">
						        <button class="switch-month switch-left"> <i class="fa fa-chevron-left"></i></button>
						         <h2></h2>
						        <button class="switch-month switch-right"> <i class="fa fa-chevron-right"></i></button>
						    </div>
						    <div class="calendar_weekdays"></div>
						    <div class="calendar_content"></div>
						</div>
					</div>
				</div>
		  	</div>
		</div>
	</div> -->
	<div class="col-md-12">
		<div class="card mb-3">
			<div class="card-body">
				<div class="container">
					<div class="row ">
						<div class="col-12">
							<div class="col-auto m-3">
								<div class ="text-center">
									<div class="card bg-light">
										<h5 class="card-title text-center m-3">
											現在時間
										</h5>
										<div class="card-body">
											<div class="justify-content-center mt-2">
												<a><span class="badge hours"></span></a> :
												<a><span class="badge min"></span></a> :
												<a><span class="badge sec"></span></a>
											</div>
										</h5>

									</div>
								</div>

								<!-- <button type="button" class="btn btn-primary" data-dismiss="modal" data-id="婚姻狀態" data-toggle="modal" data-target="#firstModel">新增</button> -->
							</div>
						</div>
						<div class="col-12">
							<div class="col-auto text-center" name = "workMode">
								<button type = "button" class ="btn btn-primary" name = "checkInButton" data-dismiss="modal" data-id="<?=@$name?>" data-type="上" data-do="start"  data-toggle="modal" data-target="#checkInModel" >上班打卡</button>
								<button type = "button" class ="btn btn-primary" name = "checkOutButton" data-dismiss="modal" data-id="<?=@$name?>" data-type="下" data-do="finish"  data-toggle="modal" data-target="#checkInModel" >下班打卡</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	

 <!-- Modal -->
  <div class="modal fade" id="checkInModel" tabindex="-1" role="dialog" aria-labelledby="checkInModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" name="checkInModalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" name="showText">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
          <button type="button" class="btn btn-primary" name = "lastCheckinButton" data-toggle="modal" data-target="#lastModel">確定</button>
        </div>
      </div>
    </div>
  </div>
<?php
  include('partial/footer.php');
?>

<script type="text/javascript">

//calendar init
$(document).ready(function () {
  	if (window.innerWidth <= 700) $('.navbar-collapse').removeClass('show');
    function c(passed_month, passed_year, calNum) {
        var calendar = calNum == 0 ? calendars.cal1 : calendars.cal2;
        makeWeek(calendar.weekline);
        calendar.datesBody.empty();
        var calMonthArray = makeMonthArray(passed_month, passed_year);
        var r = 0;
        var u = false;
        while (!u) {
            if (daysArray[r] == calMonthArray[0].weekday) {
                u = true
            } else {
                calendar.datesBody.append('<div class="blank"></div>');
                r++;
            }
        }
        for (var cell = 0; cell < 42 - r; cell++) { // 42 date-cells in calendar
            if (cell >= calMonthArray.length) {
                calendar.datesBody.append('<div class="blank"></div>');
            } else {
                var shownDate = calMonthArray[cell].day;
                var iter_date = new Date(passed_year, passed_month, shownDate);
                if (
                (
                (shownDate != today.getDate() && passed_month == today.getMonth()) || passed_month != today.getMonth()) && iter_date < today) {
                    var m = '<div class="past-date">';
                } else {
                    var m = checkToday(iter_date) ? '<div class="today">' : "<div>";
                }
                calendar.datesBody.append(m + shownDate + "</div>");
            }
        }

        var color = "#444444";
        calendar.calHeader.find("h2").text(i[passed_month] + " " + passed_year);
        calendar.weekline.find("div").css("color", color);
        calendar.datesBody.find(".today").css("color", "#87b633");

        // find elements (dates) to be clicked on each time
        // the calendar is generated
        var clicked = false;
        selectDates(selected);

        clickedElement = calendar.datesBody.find('div');
        clickedElement.on("click", function () {
            clicked = $(this);
            var whichCalendar = calendar.name;

            if (firstClick && secondClick) {
                thirdClicked = getClickedInfo(clicked, calendar);
                var firstClickDateObj = new Date(firstClicked.year,
                firstClicked.month,
                firstClicked.date);
                var secondClickDateObj = new Date(secondClicked.year,
                secondClicked.month,
                secondClicked.date);
                var thirdClickDateObj = new Date(thirdClicked.year,
                thirdClicked.month,
                thirdClicked.date);
                if (secondClickDateObj > thirdClickDateObj && thirdClickDateObj > firstClickDateObj) {
                    secondClicked = thirdClicked;
                    // then choose dates again from the start :)
                    bothCals.find(".calendar_content").find("div").each(function () {
                        $(this).removeClass("selected");
                    });
                    selected = {};
                    selected[firstClicked.year] = {};
                    selected[firstClicked.year][firstClicked.month] = [firstClicked.date];
                    selected = addChosenDates(firstClicked, secondClicked, selected);
                } else { // reset clicks
                    selected = {};
                    firstClicked = [];
                    secondClicked = [];
                    firstClick = false;
                    secondClick = false;
                    bothCals.find(".calendar_content").find("div").each(function () {
                        $(this).removeClass("selected");
                    });
                }
            }
            if (!firstClick) {
                firstClick = true;
                firstClicked = getClickedInfo(clicked, calendar);
                selected[firstClicked.year] = {};
                selected[firstClicked.year][firstClicked.month] = [firstClicked.date];
            } else {
                secondClick = true;
                secondClicked = getClickedInfo(clicked, calendar);

                // what if second clicked date is before the first clicked?
                var firstClickDateObj = new Date(firstClicked.year,
                firstClicked.month,
                firstClicked.date);
                var secondClickDateObj = new Date(secondClicked.year,
                secondClicked.month,
                secondClicked.date);

                if (firstClickDateObj > secondClickDateObj) {

                    var cachedClickedInfo = secondClicked;
                    secondClicked = firstClicked;
                    firstClicked = cachedClickedInfo;
                    selected = {};
                    selected[firstClicked.year] = {};
                    selected[firstClicked.year][firstClicked.month] = [firstClicked.date];

                } else if (firstClickDateObj.getTime() == secondClickDateObj.getTime()) {
                    selected = {};
                    firstClicked = [];
                    secondClicked = [];
                    firstClick = false;
                    secondClick = false;
                    $(this).removeClass("selected");
                }


                // add between dates to [selected]
                selected = addChosenDates(firstClicked, secondClicked, selected);
            }
            selectDates(selected);
        });

    }

    function selectDates(selected) {
        if (!$.isEmptyObject(selected)) {
            var dateElements1 = datesBody1.find('div');
            var dateElements2 = datesBody2.find('div');

            function highlightDates(passed_year, passed_month, dateElements) {
                if (passed_year in selected && passed_month in selected[passed_year]) {
                    var daysToCompare = selected[passed_year][passed_month];
                    for (var d in daysToCompare) {
                        dateElements.each(function (index) {
                            if (parseInt($(this).text()) == daysToCompare[d]) {
                                $(this).addClass('selected');
                            }
                        });
                    }

                }
            }

            highlightDates(year, month, dateElements1);
            highlightDates(nextYear, nextMonth, dateElements2);
        }
    }

    function makeMonthArray(passed_month, passed_year) { // creates Array specifying dates and weekdays
        var e = [];
        for (var r = 1; r < getDaysInMonth(passed_year, passed_month) + 1; r++) {
            e.push({
                day: r,
                // Later refactor -- weekday needed only for first week
                weekday: daysArray[getWeekdayNum(passed_year, passed_month, r)]
            });
        }
        return e;
    }

    function makeWeek(week) {
        week.empty();
        for (var e = 0; e < 7; e++) {
            week.append("<div>" + daysArray[e].substring(0, 3) + "</div>")
        }
    }

    function getDaysInMonth(currentYear, currentMon) {
        return (new Date(currentYear, currentMon + 1, 0)).getDate();
    }

    function getWeekdayNum(e, t, n) {
        return (new Date(e, t, n)).getDay();
    }

    function checkToday(e) {
        var todayDate = today.getFullYear() + '/' + (today.getMonth() + 1) + '/' + today.getDate();
        var checkingDate = e.getFullYear() + '/' + (e.getMonth() + 1) + '/' + e.getDate();
        return todayDate == checkingDate;

    }

    function getAdjacentMonth(curr_month, curr_year, direction) {
        var theNextMonth;
        var theNextYear;
        if (direction == "next") {
            theNextMonth = (curr_month + 1) % 12;
            theNextYear = (curr_month == 11) ? curr_year + 1 : curr_year;
        } else {
            theNextMonth = (curr_month == 0) ? 11 : curr_month - 1;
            theNextYear = (curr_month == 0) ? curr_year - 1 : curr_year;
        }
        return [theNextMonth, theNextYear];
    }

    function b() {
        today = new Date;
        year = today.getFullYear();
        month = today.getMonth();
        var nextDates = getAdjacentMonth(month, year, "next");
        nextMonth = nextDates[0];
        nextYear = nextDates[1];
    }

    var e = 480;

    var today;
    var year,
    month,
    nextMonth,
    nextYear;

    var r = [];
    var i = [
        "一月",
        "二月",
        "三月",
        "四月",
        "五月",
        "六月",
        "七月",
        "八月",
        "九月",
        "十月",
        "十一月",
        "十二月"];
    var daysArray = [
        "日",
        "一",
        "二",
        "三",
        "四",
        "五",
        "六"];

    var cal1 = $("#calendar_first");
    var calHeader1 = cal1.find(".calendar_header");
    var weekline1 = cal1.find(".calendar_weekdays");
    var datesBody1 = cal1.find(".calendar_content");

    var cal2 = $("#calendar_second");
    var calHeader2 = cal2.find(".calendar_header");
    var weekline2 = cal2.find(".calendar_weekdays");
    var datesBody2 = cal2.find(".calendar_content");

    var bothCals = $(".calendar");

    var switchButton = bothCals.find(".calendar_header").find('.switch-month');

    var calendars = {
        "cal1": {
            "name": "first",
                "calHeader": calHeader1,
                "weekline": weekline1,
                "datesBody": datesBody1
        },
            "cal2": {
            "name": "second",
                "calHeader": calHeader2,
                "weekline": weekline2,
                "datesBody": datesBody2
        }
    }


    var clickedElement;
    var firstClicked,
    secondClicked,
    thirdClicked;
    var firstClick = false;
    var secondClick = false;
    var selected = {};

    b();
    c(month, year, 0);
    c(nextMonth, nextYear, 1);
});
//init end


	$(function(){
		var tempLocation;
		var time;
		var todayDate;
		var tmpId;
		var checkType;
		var doType;
		var date = new Date();

	    todayDate = date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate();
	    tmpId = $('[name=checkInButton]').data('id');
	    $('[name=checkInButton]').show();
	    $('[name=checkOutButton]').hide();
		console.log(todayDate);
		$.ajax({
	        url:'/work/check/'+todayDate,
	        type:'get',
	        dataType:'json',
	        success:function(response){
	        	// console.log(response);
	          if(response.checkin){
	          	$('[name=checkInButton]').hide();
	          	$('[name=checkOutButton]').show();
	          }
	        }
	    });
	    $.ajax({
	        url:'/work/checkAll/'+todayDate,
	        type:'get',
	        dataType:'json',
	        success:function(response){
	        	// console.log(response);
	          if(response.checkin){
	          	$('[name=checkInButton]').hide();
	          	$('[name=checkOutButton]').hide();
	          	$('[name=checkInModalLabel]').append("下班了");

	          }
	        }
	    });

	    $('#checkInModel').on('show.bs.modal',function(e){
      		checkType = $(e.relatedTarget).data('type');
      		doType = $(e.relatedTarget).data('do');
      		console.log(checkType);
      		$('[name=checkInModalLabel]').empty();
      		$('[name=checkInModalLabel]').append(checkType+"班打卡");
      		time = date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
            hours = date.getHours();
            minutes = date.getMinutes();
            seconds = date.getSeconds();
      		$('[name=showText]').empty();
      		$('[name=showText]').append("打卡時間:　"+time);
      		if (navigator.geolocation) {
				// console.log("success");
				navigator.geolocation.getCurrentPosition(showPosition);
			} else { 
				console.log("Geolocation is not supported by this browser.");
			}
  		  	$("button[name=lastCheckinButton]").on('click', function(e){

  		  		navigator.geolocation.getCurrentPosition(checkin);
	      		
	    	});
      	});
      	function checkin(position) {
      		tempLocation = "("+ position.coords.latitude+","+position.coords.longitude+")";
      		$.ajax({
        		url:'/work/checkin',
        		type:'POST',
        		data:{
        			data:JSON.stringify({staff_id : tmpId,
        								 checkinDate : todayDate,
        								 checkinTime : time,
        								 location : tempLocation,
        								 type : doType,
                                         hours : hours,
                                         minutes : minutes,
                                         seconds : seconds 
        			})
      			},
        		dataType:'json',
        		success:function(response){
	          		if(response.status = "success")
	          		{
	          			window.location.href='/checkin'; 
	          		}
        		}
			}); 
      	}
      	
		function showPosition(position) {
			$('[name=showText]').append("</br>"+"Latitude: " + position.coords.latitude + 
		  	"<br>Longitude: " + position.coords.longitude);
		  	// tempLocation = "("+ position.coords.latitude+","+position.coords.longitude+")";
		  	// return (tempLocation);
		}
	});
	// var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
	console.log()
	$(document).ready(function() {
		setInterval( function() {
		var hours = new Date().getHours();
		$(".hours").html(( hours < 10 ? "0" : "" ) + hours);
		}, 1000);
		setInterval( function() {
		var minutes = new Date().getMinutes();
		$(".min").html(( minutes < 10 ? "0" : "" ) + minutes);
		},1000);
		setInterval( function() {
		var seconds = new Date().getSeconds();
		$(".sec").html(( seconds < 10 ? "0" : "" ) + seconds);
		},1000);
	});
	
</script>
