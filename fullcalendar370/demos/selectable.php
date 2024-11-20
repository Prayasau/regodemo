<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<link href='../fullcalendar.min.css' rel='stylesheet' />
<link href='../fullcalendar.print.min.css' rel='stylesheet' media='print' />
<script src='../lib/moment.min.js'></script>
<script src='../lib/jquery.min.js'></script>
<script src='../fullcalendar.min.js'></script>
<script>

	$(document).ready(function() {
		
		$('#calendar1, #calendar2, #calendar3, #calendar4, #calendar5, #calendar6, #calendar7, #calendar8, #calendar9, #calendar10, #calendar11, #calendar12').fullCalendar({
			header: {
				left: '',
				center: 'title',
				right: ''
			},
			//defaultDate: '2017-11-12',
			contentHeight: 360,
			firstDay: 1,
			showNonCurrentDates: false,
			navLinks: true, // can click day/week names to navigate views
			selectable: true,
			selectHelper: true,
			select: function(start, end) {
				var title = prompt('Event Title:');
				var eventData;
				if (title) {
					eventData = {
						title: title,
						start: start,
						end: end
					};
					$('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
				}
				$('#calendar').fullCalendar('unselect');
			},
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			events: [
				{
					title: 'All Day Event',
					start: '2017-11-01'
				},
				{
					title: 'Long Event',
					start: '2017-11-07',
					end: '2017-11-10'
				},
				{
					id: 999,
					title: 'Repeating Event',
					start: '2017-11-09T16:00:00'
				},
				{
					id: 999,
					title: 'Repeating Event',
					start: '2017-11-16T16:00:00'
				},
				{
					title: 'Conference',
					start: '2017-11-11',
					end: '2017-11-13'
				},
				{
					title: 'Meeting',
					start: '2017-11-12T10:30:00',
					end: '2017-11-12T12:30:00'
				},
				{
					title: 'Lunch',
					start: '2017-11-12T12:00:00'
				},
				{
					title: 'Meeting',
					start: '2017-11-12T14:30:00'
				},
				{
					title: 'Happy Hour',
					start: '2017-11-12T17:30:00'
				},
				{
					title: 'Dinner',
					start: '2017-11-12T20:00:00'
				},
				{
					title: 'Birthday Party',
					start: '2017-11-13T07:00:00'
				},
				{
					title: 'Click for Google',
					url: 'http://google.com/',
					start: '2017-11-28'
				}
			]
		});
		$('#calendar1').fullCalendar( 'gotoDate', '2017-01-01');
		$('#calendar2').fullCalendar( 'gotoDate', '2017-02-01');
		$('#calendar3').fullCalendar( 'gotoDate', '2017-03-01');
		$('#calendar4').fullCalendar( 'gotoDate', '2017-04-01');
		$('#calendar5').fullCalendar( 'gotoDate', '2017-05-01');
		$('#calendar6').fullCalendar( 'gotoDate', '2017-06-01');
		$('#calendar7').fullCalendar( 'gotoDate', '2017-07-01');
		$('#calendar8').fullCalendar( 'gotoDate', '2017-08-01');
		$('#calendar9').fullCalendar( 'gotoDate', '2017-09-01');
		$('#calendar10').fullCalendar( 'gotoDate', '2017-10-01');
		$('#calendar11').fullCalendar( 'gotoDate', '2017-11-01');
		$('#calendar12').fullCalendar( 'gotoDate', '2017-12-01');





	});

</script>
<style>

	body {
		margin:0;
		padding: 30px 150px;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		font-size: 14px;
	}

	#calendar {
		max-width: 900px;
		margin: 0 auto;
	}

</style>
</head>
<body>
	<table style="width:100%;" border="0" cellspacing="10">
		<tr>
			<td>
				<div id="calendar1"></div>
			</td>
			<td>
				<div id="calendar2"></div>
			</td>
			<td>
				<div id="calendar3"></div>
			</td>
			<td>
				<div id="calendar4"></div>
			</td>
		</tr>
		<tr>
			<td>
				<div id="calendar5"></div>
			</td>
			<td>
				<div id="calendar6"></div>
			</td>
			<td>
				<div id="calendar7"></div>
			</td>
			<td>
				<div id="calendar8"></div>
			</td>
		</tr>
		<tr>
			<td>
				<div id="calendar9"></div>
			</td>
			<td>
				<div id="calendar10"></div>
			</td>
			<td>
				<div id="calendar11"></div>
			</td>
			<td>
				<div id="calendar12"></div>
			</td>
		</tr>
	</table>

</body>
</html>

<!--	 		
			/*$('#freeinput').on('keyup', function(e){
				$('#freetxt').html($(this).val());
			});
			
			$('#clearCalendar').on('click', function (e) {
				if(confirm('Clear calendar Database ?')){
				$.ajax({
					url: '../calendar/clear_calendar.php?cid=<? //=$cid?>',
					success: function(response) {
						//alert(response);
						location.reload();
					}
				})
				}
			})*/

			var initDrag = function (e) {
			// create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
			// it doesn't need to have a start or end
				var eventObject = {
					rem: $.trim(e.children('span').attr('data-rem')),
					type: $.trim(e.children('span').attr('data-type')),
					title: $.trim(e.children().text()), // use the element's text as the event title
					description: $.trim(e.children('span').attr('data-description')),
					icon: $.trim(e.children('span').attr('data-icon')),
					className: $.trim(e.children('span').attr('class')) // use the element's children as the event class
				};
				// store the Event Object in the DOM element so we can get to it later
				e.data('eventObject', eventObject);
				// make the event draggable using jQuery UI
				e.draggable({
					zIndex: 999,
					revert: true, // will cause the event to go back to its
					revertDuration: 0 //  original position after the drag
				});
			};
			
			var addEvent = function (rem, type, title, priority, description, icon) {
				rem = rem.length === 0 ? "true" : rem;
				title = title.length === 0 ? "Untitled Event" : title;
				description = description.length === 0 ? "No Description" : description;
				icon = icon.length === 0 ? " " : icon;
				priority = priority.length === 0 ? "label label-default" : priority;
				var html = $('<li><span data-rem="'+rem+'" class="'+priority+'" data-description="'+description+'" data-icon="'+icon +'">'+title+'</span></li>').prependTo('ul#external-events').hide().fadeIn();
				$("#event-container").effect("highlight", 800);
				initDrag(html);
			};
			// initialize the external events
			$('#external-events > li').each(function () {
				initDrag($(this));
			});
			    
			 $('#addEvent').click(function () {
				  var title = $('#new_th').val(),
				  		rem = 'true',
						type = 'hol',
						priority = 'bg-color-pink txt-color-white',
						description = $('#new_en').val(),
						icon = '';
				  addEvent(rem, type, title, priority, description, icon);
			 });
		
			
			
			$('#calendar:not(".fc-event")').on('contextmenu', function (e) {
				 e.preventDefault()
			})
		 	
			/* initialize the calendar */
					
			$('#calendar').fullCalendar({
				header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,agendaWeek,agendaDay'
				},
				editable: true,
				weekends: true,
				//locale: 'th',
				firstDay: 1,
				contentHeight: 600,
				droppable: true, 
				selectable: false,
				showNonCurrentDates: false,
			
			  drop: function (date, allDay) {
					// retrieve the dropped element's stored Event Object
					//var originalEventObject = $(this).data('eventObject');
					var obj = $(this).data('eventObject');
					var cobj = $.extend({}, obj);
					cobj.id = new Date().valueOf();
					var start = formatDate(date);
					var rem = cobj.rem;
					$.ajax({
						url: '../calendar/add_events.php?cid=<? //=$cid?>',
						data: 'id='+cobj.id+'&type='+cobj.type+'&start='+start+'&title='+cobj.title+'&descr='+cobj.description+'&icon='+cobj.icon+'&class='+cobj.className,
						type: "POST",
						success: function(response) {
							//alert(response);
						}
					})
					// we need to copy it, so that multiple events don't have a reference to the same object
					// assign it the date that was reported
					cobj.start = date;
					cobj.allDay = allDay;
					// render the event on the calendar
					// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
					$('#calendar').fullCalendar('renderEvent', cobj, false);

					// if true "remove after drop"
					if (rem=='true') {
						 $(this).remove();
					}
			  },
			  
			  events: "../calendar/json_events.php?cid=<? //=$cid?>",
			  
			  eventResize: function(event) {
					//alert('eventResize')
					/*var str;
					$.each(event, function(key, element) {
						 str +='key: ' + key + ' = ' + 'value: ' + element + '\n';
					});
					alert(str)*/
					var end = formatDate(event.end);
					var start = formatDate(event.start);
					$.ajax({
						url: '../calendar/update_events.php?cid=<? //=$cid?>',
						data: 'id='+event.id+'&start='+start+'&end='+end,
						type: "POST",
						success: function(response) {
							//alert(response);
						}
					})
				},
				
				eventDrop: function(event) {
					//alert('eventDrop')
					var end = formatDate(event.end);
					var start = formatDate(event.start);
					$.ajax({
						url: '../calendar/update_events.php?cid=<? //=$cid?>',
						data: 'id='+event.id+'&start='+start+'&end='+end,
						type: "POST",
						success: function(response) {
							//alert(response);
						}
					})
				},
			 
				eventRender: function (event, element, icon) {
					if (!event.description == "") {
						 element.find('.fc-title').append("<br/><span class='ultra-light'>" + event.description + "</span>");
					}
					if (!event.icon == "") {
						 //element.find('.fc-title').append("<i class='air air-top-right fa " + event.icon + " '></i>");
						 //element.find('.fc-title').append('<i class="fa fa-times"></i>');
					}
					/*element.find(".fa-times").on('click', function() {
						$('#calendar').fullCalendar('removeEvents',event._id);
						//console.log('delete');
					});*/
					
					var onClick = function(e) {
						var clicked = function() { }
						var deletes = function() { 
							$.ajax({
								url: '../calendar/delete_events.php?cid=<? //=$cid?>',
								data: 'id='+event.id,
								type: "POST",
								success: function(response) {
									//alert(response);
									$('#calendar').fullCalendar('removeEvents',event.id);
								}
							})
						}
						var items = [
							{ title: '<? //=$lng['Delete event']?>', icon: 'fa-trash', fn: deletes },
							{ title: '<? //=$lng['Cancel']?>', icon: 'fa-times', fn: clicked }
						]
						basicContext.show(items, e.originalEvent)
					}
					element.on('contextmenu', onClick);
			  },
			
			  windowResize: function (event, ui) {
					$('#calendar').fullCalendar('render');
			  },
			  
			  /*eventRightclick: function(event, jsEvent, view) {
				return false;
					//BootstrapDialog.confirm('Hi Apple, are you sure?');
					bootbox.confirm("Are you sure to delete this event ?", function(result){ 
						if(result){
							$.ajax({
								url: 'delete_events.php',
								data: 'id='+event.id,
								type: "POST",
								success: function(response) {
									//alert(response);
									$('#calendar').fullCalendar('removeEvents',event.id);
								}
							})
						}
					})
				},*/
			  
			  /*eventDragStop: function(event, jsEvent, ui, view) {
					
					$(this).draggable({
						  zIndex: 999,
						  revert: false,      // will cause the event to go back to its
						  revertDuration: 0  //  original position after the drag
					 });
					
					 var trashEl = $('#calendarTrash');
					 var ofs = trashEl.offset();
				
					 var x1 = ofs.left;
					 var x2 = ofs.left + trashEl.outerWidth(true);
					 var y1 = ofs.top;
					 var y2 = ofs.top + trashEl.outerHeight(true);
			
					 if (jsEvent.pageX >= x1 && jsEvent.pageX<= x2 && jsEvent.pageY >= y1 && jsEvent.pageY <= y2) {
						  //alert('SIII');
						  $('#calendar').fullCalendar('removeEvents', event.id);
					 }
				}*/

			    });
        
			    /* hide default buttons */
			    //$('.fc-right, .fc-left').hide();
			
				$('#calendar-buttons #btn-prev').click(function () {
				    $('.fc-prev-button').click();
				    return false;
				});
				
				$('#calendar-buttons #btn-next').click(function () {
				    $('.fc-next-button').click();
				    return false;
				});
				
				$('#calendar-buttons #btn-today').click(function () {
				    $('.fc-today-button').click();
				    return false;
				});


-->














