@extends('layouts.admin')

@section('title')Bookings @endsection

@section('content')
 
<style>
  #calendar {
max-width: 1100px;
margin: 40px auto;
} 
</style>

    <!-- Main content -->
    <section>

      <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('user.home')}}">Home</a>
                                    </li>
                                    <!-- <li class="breadcrumb-item"><a href="{{route('users.index')}}">Bookings</a>
                                    </li> -->
                                    <li class="breadcrumb-item active">Booking List
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
      </div>
       
      <div>

        <div class="row">
          <div id='calendar'></div>
       </div>    
      </div>
      <!-- /.container-fluid -->
    </section>
   
  

  @push('page_script')

      
      <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
      <script>

        document.addEventListener('DOMContentLoaded', function() {
          var calendarEl = document.getElementById('calendar');
          // var calendar = new FullCalendar.Calendar(calendarEl, {
          // //   initialView: 'dayGridMonth',
          //    headerToolbar: { center: 'dayGridMonth,timeGridWeek' }, // buttons for switching between views
  
          // //     views: {
          // //         dayGridMonth: { // name of view
          // //             titleFormat: { year: 'numeric', month: '2-digit', day: '2-digit' }
          // //             // other view-specific options here
          // //         }
          // //     }
          //         initialView: 'timeGridWeek',
          //             slotMinTime: '8:00:00',
          //             slotMaxTime: '19:00:00',
          //             events: @json($events),
          // });
          // var calendar = new FullCalendar.Calendar(calendarEl, {
          //     headerToolbar: { center: 'dayGridMonth,timeGridWeek' },
          //     initialDate: '2023-08-10',
          //     initialView: 'dayGridMonth',
          //     events: [
          //         {
          //         start: '2023-08-10T10:00:00',
          //         end: '2023-08-10T16:00:00',
          //         display: 'background'
          //         }
          //     ]
          //     });
  
          var calendar = new FullCalendar.Calendar(calendarEl, {
                  initialView: 'dayGridMonth',
                  //initialDate: '2023-07-07',
                  headerToolbar: {
                      left: 'prev,next today',
                      center: 'title',
                      right: 'dayGridMonth,timeGridWeek,timeGridDay'
                  },
                  events: @json($data),
                //   [
                //       {
                //       title: 'All Day Event',
                //       start: '2023-07-01',
                //       description: 'Hurrayyyyyyyyyy',
                //       extendedProps: {
                //               department: 'BioChemistry'
                //           },
                //       },
                //       {
                //       title: 'Long Event',
                //       start: '2023-07-07',
                //       end: '2023-07-10',
                //       description: 'Hurrayyyyyyyyyy',
                //       extendedProps: {
                //               department: 'BioChemistry'
                //           },
                //       },
                //       {
                //       groupId: '999',
                //       title: 'Repeating Event',
                //       start: '2023-07-09T16:00:00',
                //       description: 'Hurrayyyyyyyyyy',
                //       extendedProps: {
                //               department: 'BioChemistry'
                //           },
                //       },
                //       {
                //       groupId: '999',
                //       title: 'Repeating Event',
                //       start: '2023-07-16T16:00:00',
                //       description: 'Hurrayyyyyyyyyy',
                //       extendedProps: {
                //               department: 'BioChemistry'
                //           },
                //       },
                //       {
                //       title: 'Conference',
                //       start: '2023-07-11',
                //       end: '2023-07-13',
                //       description: 'Hurrayyyyyyyyyy',
                //       extendedProps: {
                //               department: 'BioChemistry'
                //           },
                //       },
                //       {
                //       title: 'Meeting',
                //       start: '2023-07-12T10:30:00',
                //       end: '2023-07-12T12:30:00',
                //       description: 'Hurrayyyyyyyyyy',
                //       extendedProps: {
                //               department: 'BioChemistry'
                //           },
                //       },
                //       {
                //       title: 'Lunch',
                //       start: '2023-07-12T12:00:00',
                //       description: 'Hurrayyyyyyyyyy',
                //       extendedProps: {
                //               department: 'BioChemistry'
                //           },
                //       },
                //       {
                //       title: 'Meeting',
                //       start: '2023-07-12T14:30:00',
                //       description: 'Hurrayyyyyyyyyy',
                //       extendedProps: {
                //               department: 'BioChemistry'
                //           },
                //       },
                //       {
                //       title: 'Birthday Party',
                //       start: '2023-07-13T07:00:00',
                //       description: 'Hurrayyyyyyyyyy',
                //       extendedProps: {
                //               department: 'BioChemistry'
                //           },
                //       },
                //       {
                //       title: 'Click for Google',
                //       url: 'https://google.com/',
                //       start: '2023-07-28',
                //       description: 'Hurrayyyyyyyyyy',
                //       extendedProps: {
                //               department: 'BioChemistry'
                //           },
                //       }
                //   ],
                //   eventDidMount: function(info) {
                //       //console.log("info--------------------",info.event.extendedProps.department)
                //       //var statusText = info.event.extendedProps.status;
                //       // info.el.setAttribute("data-id", 123);
                //       $(info.el).find('.fc-event-title').append("<br/>" + info.event.extendedProps.department);
                //   },
                  // eventRender: function(event, element) {
                  //     console.log("event---------------------",event)
                  //     element.qtip({
                  //         content: event.description + '<br />' + event.start,
                  //         style: {
                  //             background: 'black',
                  //             color: '#FFFFFF'
                  //         },
                  //         position: {
                  //             corner: {
                  //                 target: 'center',
                  //                 tooltip: 'bottomMiddle'
                  //             }
                  //         }
                  //     });
                  // }
              });
          calendar.render();
        });
  
      </script>

  @endpush

	     
@endsection