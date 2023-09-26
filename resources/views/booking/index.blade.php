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
      <!-- Modal to display event details -->
    <div class="modal" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Event Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Slot:</strong> <span id="eventTitle"></span></p>
                    <p><strong>Date:</strong> <span id="eventDate"></span></p>
                    <p><strong>CSR Name:</strong> <span id="csr_name"></span></p>
                    <p><strong>Service Titan Job Number:</strong> <span id="job_number"></span></p>
                    <p><strong>Customer Name:</strong> <span id="customer_name"></span></p>
                    <!-- Add more event details here as needed -->
                </div>
                <div id="eventModalFooter" class="modal-footer">
                  <button type="button" class="btn btn-danger" id="cancelEventBtn">Cancel Event</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="editButton" class="btn btn-primary">Edit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Event Modal -->
    <!-- Edit Event Modal -->
<div class="modal" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEventModalLabel">Edit Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form for editing event details -->
                <form id="editEventForm">
                    <inpput type="text" value="" id="event_id" />
                    <div class="mb-2">
                        <label for="editEventTitle" class="form-label">Date</label>
                        <input type="date" readonly class="form-control" value="" id="edit_date" />
                    </div>
                    <div class="mb-2">
                        <label for="editEventTitle" class="form-label">Slot</label>
                        <select class="form-select" disabled id="editSlot" required name="slot[]">
                            <option  value="8AM - 9AM">8AM - 9AM</option>
                            <option  value="10AM - 1PM">10AM - 1PM</option>
                            <option  value="12PM - 3PM">12PM - 3PM</option>
                            <option  value="2PM - 5PM">2PM - 5PM</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="editCSRName" class="form-label">CSR Name</label>
                        <input type="text" class="form-control" id="editCSRName">
                    </div>
                    <div class="mb-2">
                        <label for="editJobNumber" class="form-label">Service Titan Job Number</label>
                        <input type="text" class="form-control" id="editJobNumber">
                    </div>
                    <div class="mb-2">
                        <label for="editCustomerName" class="form-label">Customer Name</label>
                        <input type="text" class="form-control" id="editCustomerName">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveEventChanges">Save Changes</button>
            </div>
        </div>
    </div>
</div>


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
           <h3>{{$company->name}}</h3> 
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
          var editButtonAdded = false;
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
                   eventDidMount: function(info) {
                       //console.log("info--------------------",info.event.extendedProps.department)
                       //var statusText = info.event.extendedProps.status;
                       // info.el.setAttribute("data-id", 123);
                       $(info.el).find('.fc-event-title').append("<br/>" + info.event.extendedProps.csr_name);
                   },
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
                  
                  eventClick: function(info) {
                      // Update modal content with event details
                      
                      document.getElementById('eventTitle').textContent = info.event.title;
                      var eventDate = info.event.start;
                      var formattedDate = eventDate.getFullYear() + '-' + 
                               ('0' + (eventDate.getMonth() + 1)).slice(-2) + '-' + 
                               ('0' + eventDate.getDate()).slice(-2);
                      document.getElementById('eventDate').textContent = formattedDate;
                      document.getElementById('customer_name').textContent = info.event.extendedProps.customer_name;
                      document.getElementById('csr_name').textContent = info.event.extendedProps.csr_name;
                      document.getElementById('job_number').textContent = info.event.extendedProps.job_number;
                      
                      
                      // Show the modal
                      var eventModal = new bootstrap.Modal(document.getElementById('eventModal'));
                      eventModal.show();
                    
                        var editButton = document.getElementById('editButton');
                        editButton.addEventListener('click', function() {
                            // Open edit popup and prepopulate with current event details

                            var slotDropdown = document.getElementById('editSlot');
                            var eventSlot = info.event.title; // Assuming the event title contains the slot value
                            for (var i = 0; i < slotDropdown.options.length; i++) {
                                if (slotDropdown.options[i].value === eventSlot) {
                                    slotDropdown.selectedIndex = i;
                                    break;
                                }
                            }
                            //console.log("-----------------",info.event.start)
                            document.getElementById('editCSRName').value = info.event.extendedProps.csr_name;
                            document.getElementById('editJobNumber').value = info.event.extendedProps.job_number;
                            document.getElementById('editCustomerName').value = info.event.extendedProps.customer_name;
                            document.getElementById('event_id').value = info.event.id;
                            document.getElementById('edit_date').value = formattedDate;
                            
                            // Similar for other fields...

                            // Show the edit popup
                            var editEventModal = new bootstrap.Modal(document.getElementById('editEventModal'));
                            editEventModal.show();
                            
                        });
                        // if (!editButtonAdded) {
                        //     document.getElementById('eventModalFooter').appendChild(editButton);
                        //     editButtonAdded = true;
                        // }

                        
                         

                      var cancelEventBtn = document.getElementById('cancelEventBtn');
                      cancelEventBtn.addEventListener('click', function() {
                        var confirmation = confirm('Are you sure you want to cancel this event?');

                            if (confirmation) {
                                // User confirmed, proceed with AJAX request
                                // Replace this with your actual AJAX logic
                                // Here's a simple example with jQuery AJAX:
                                $.ajax({
                                    url: '/booking/cancel', // Replace with your API endpoint
                                    method: 'POST',
                                    data: { eventId: info.event.id }, // Pass the event ID or other data
                                    success: function(response) {
                                        // If the cancellation was successful, remove the event from the calendar
                                        info.event.remove();
                                        // Close the modal
                                        eventModal.hide();
                                    },
                                    error: function(error) {
                                        // Handle AJAX error here
                                        alert('An error occurred while canceling the event.');
                                    }
                                });
                            }
                      });

                      
                  }
              });
          calendar.render();
        });

        $('.modal').on('hidden.bs.modal', function(){
            //remove the backdrop
            $('.modal-backdrop').remove();
        })

        document.addEventListener('DOMContentLoaded', function() {
            var saveEventChangesButton = document.getElementById('saveEventChanges');

                saveEventChangesButton.addEventListener('click', function() {
                    // Get updated values from the edit form
                    var updatedCSRName = document.getElementById('editCSRName').value;
                    var updatedJobNumber = document.getElementById('editJobNumber').value;
                    var updatedCustomerName = document.getElementById('editCustomerName').value;
                    var eventId = document.getElementById('event_id').value;
                    // Similar for other fields...

                    // Prepare the data to send to the server
                    var eventData = {
                        eventId: eventId,
                        csrName: updatedCSRName,
                        jobNumber: updatedJobNumber,
                        customerName: updatedCustomerName,
                        // Add other fields as needed
                    };

                    // Send an AJAX request to update the data in the database
                    $.ajax({
                        url: '/booking/update', // Replace with your API endpoint for updating events
                        method: 'POST',
                        data: eventData,
                        success: function(response) {
                            // Handle success response here, if needed
                            alert('Event data updated successfully.');
                            //console.log('Event data updated successfully.');
                            // You can optionally close the edit modal after a successful update
                            $("#editEventModal").hide();
                            location.reload(true)
                        },
                        error: function(error) {
                            // Handle AJAX error here
                            console.error('Error updating event data:', error);
                            alert('An error occurred while updating event data.');
                        }
                    });
                });
            });
        
  
      </script>

  @endpush

	     
@endsection