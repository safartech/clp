
  $(document).ready(function() {
    

    /* initialize the external events
    -----------------------------------------------------------------*/
    $('#external-events .fc-event').each(function() {

      // store data so the calendar knows to render an event upon drop
      $(this).data('event', {
        title: $.trim($(this).text()), // use the element's text as the event title
        stick: true, // maintain when user navigates (see docs on the renderEvent method)
        color: '#00bcd4'
      });

      // make the event draggable using jQuery UI
      $(this).draggable({
        zIndex: 999,
        revert: true,      // will cause the event to go back to its
        revertDuration: 0  //  original position after the drag
      });

    });



    var options = {
        header: {
            left: 'prev,next today, custom1',
            center: 'title',
            // right: 'month,basicWeek,basicDay',
            right: 'custom2, month,agendaWeek,agendaDay,listWeek',
            // right: 'custom2, month,basicWeek,basicDay,listWeek',
        },

        customButtons: {
            custom1: {
                text: 'Sem. basique',
                click: function() {
                    $('#calendar').fullCalendar('changeView', 'basicWeek');
                }
            },
            custom2: {
                text: 'Journ. basique',
                click: function() {
                    $('#calendar').fullCalendar('changeView', 'basicDay');
                }
            }
        },



        selectable: true,
        nowIndicator: true,
        selectHelper: true,
        unselectAuto: true,

        fixedWeekCount: false,
        showNonCurrentDates: false,
        slotDuration: '00:30:00',
        slotLabelFormat: 'h(:mm)a',
        // minTime: "07:00:00",
        // maxTime: "18:00:00",
        // noEventsMessage: "0 events",
        // dayPopoverFormat:"DD",
        // scrollTime: "10:00:00",
        /*slotLabelInterval:{
            duration:"01:00"
        },*/


        allDaySlot: true,
        allDayText: "Toute la journée",
        slotEventOverlap: true,

        titleFormat: "D MMMM YYYY",
        today:    'Aujourd\'hui',
        month:    'mois',
        week:     'semaine',
        day:      'jour',
        list:     'list',

        firstDay: 1,
        locale: 'fr',
        weekends: false,
        timeFormat: 'h:mm',
        displayEventTime: true,

        eventRender: function(event, element) {
          // alert(element)
           /* element.qtip({
                // content: event.description
            });*/
        },
        select: function(startDate, endDate) {
            // alert('selected ' + startDate.format() + ' to ' + endDate.format());
        },
        eventDestroy:function(event, element){},
        dayClick: function(date, jsEvent, view) {
            // alert('Clicked on: ' + date.format());
            // alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
            // alert('Current view: ' + view.name);
            // change the day's background color just for fun
            // $(this).css('background-color', 'red');
        },
        navLinkDayClick: function(date, jsEvent) {
            $('#calendar').fullCalendar('changeView', 'agendaDay');
            // console.log('day', date.format()); // date is a moment
            // console.log('coords', jsEvent.pageX, jsEvent.pageY);
        },
        navLinkWeekClick: function(weekStart, jsEvent) {
            alert('week start', weekStart.format()); // weekStart is a moment
            alert('coords', jsEvent.pageX, jsEvent.pageY);
        },
        drop: function(date) {
            // alert("Dropped on " + date.format());
            // is the "remove after drop" checkbox checked?
            if ($('#drop-remove').is(':checked')) {
                // if so, remove the element from the "Draggable Events" list
                // alert();
                $(this).remove();
            }
        },




        views: {
            agendaFourDay: {
                type: 'agenda',
                duration: { days: 4 },
                buttonText: '4 day',
                dayCount: 4,
            },
            basic: {
                // options apply to basicWeek and basicDay views
            },
            agenda: {
                // options apply to agendaWeek and agendaDay views
            },
            month:{
                // titleFormat: 'YYYY, MM, DD'
            },
            week: {
                // options apply to basicWeek and agendaWeek views
            },
            day: {
                // options apply to basicDay and agendaDay views
            }
        },

        defaultDate: '2015-05-12',
        navLinks: true, // can click day/week names to navigate views
        editable: true,
        droppable: true, // this allows things to be dropped onto the calendar
        eventLimit: true, // allow "more" link when too many events
        // businessHours: true,
        events: [
            {
                title: 'All Day Event',
                start: '2015-05-08',
                color: '#9c27b0',
                // rendering: 'background',

            },
            {
                title: 'Long Event',
                start: '2015-05-07',
                end: '2015-05-10',
                color: '#e91e63'
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: '2015-05-09T16:00:00',
                color: '#ff1744'
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: '2015-05-16T16:00:00',
                color: '#aa00ff'
            },
            {
                title: 'Conference',
                start: '2015-05-3',
                end: '2015-05-5',
                color: '#01579b'
            },
            {
                title: 'Meeting',
                start: '2015-05-12T10:30:00',
                end: '2015-05-12T12:30:00',
                color: '#2196f3'
            },
            {
                title: 'Lunch',
                start: '2015-05-12T12:00:00',
                color: '#ff5722'
            },
            {
                title: 'Meeting',
                start: '2015-05-12T14:30:00',
                color: '#4caf50'
            },
            {
                title: 'Happy Hour',
                start: '2015-05-12T17:30:00',
                color: '#03a9f4'
            },
            {
                title: 'Dinner',
                start: '2015-05-12T20:00:00',
                color: '#009688'
            },
            {
                title: 'Birthday Party',
                start: '2015-05-13T07:00:00',
                color: '#00bcd4'
            }
        ]
    };

    /* initialize the calendar
    -----------------------------------------------------------------*/
    var calendar = $('#calendar').fullCalendar(options,{
        locale: 'fr',
        isRTL: true
    });

      $('#calendar').fullCalendar('render');

      /*calendar.fullCalendar('changeView', 'agenda', {
          start: '2017-06-01',
          end: '2017-06-05'
      });*/

      // $('#calendar').fullCalendar('changeView', 'agendaWeek', '2017-06-01');

      // calendar.next();

      var full_options = {
          aspectRatio: 1.2,//Float, default: 1.35//Sets the width-to-height aspect ratio of the calendar.
          handleWindowResize: true,
          windowResize: function(view) {
              alert('The calendar has adjusted to a window resize');
          },

          fixedWeekCount: false,//Determines the number of weeks displayed in a month view.
          showNonCurrentDates: true, // In month view, whether dates in the previous or next month should be rendered at all.

          buttonText:{
              today:    'today',
              month:    'month',
              week:     'week',
              day:      'day',
              list:     'list'
          },
          monthNames: ['January', 'February', 'March', 'April', 'Mai', 'June', 'July',
              'August', 'September', 'October', 'November', 'December'],
          monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
              'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
          dayNames: ['Sunday', 'Monday', 'Tuesday', 'Wednesday',
              'Thursday', 'Friday', 'Saturday'],
          dayNamesShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],

      }
    
  });
