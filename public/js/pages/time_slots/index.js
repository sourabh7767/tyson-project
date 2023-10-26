$(document).on('click', '.delete-datatable-record', function(e){
    let url  = site_url + "/time_slot/" + $(this).attr('data-id');
    let tableId = 'usersTable';
    deleteDataTableRecord(url, tableId);
});

$(document).ready(function() {
    console.log(site_url, '======site_url');
    var table = $('#usersTable').DataTable({
        ...defaultDatatableSettings,
        ajax: site_url + "/time_slot/",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            { data: 'name', name: 'name' },
            { data: 'slot', name: 'slot' },
            { data: 'start_date_time', name: 'start_date_time' },
            { data: 'no_of_slots', name: 'no_of_slots' },
            { data: 'remaining_slots', name: 'remaining_slots' },
            
             { data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    var selectedRow;
    var eventModal;
    $(document).on('click', '.edit-button', function () {
        selectedRow = table.row($(this).closest('tr'));
        var row = selectedRow.data(); 
        $('#editNumberOfSlots').val(row.no_of_slots);
    //     var row = $(this).closest('tr');
    //   var rowData = tanksEditor.row(row).data();
       
        eventModal = new bootstrap.Modal(document.getElementById('editRecordModal'));
                    eventModal.show();
        //$("#editRecordModal").show();
      });

      $('#saveChanges').on('click', function () {
        console.log("selectedRow----",selectedRow);
        // Get the edited data from the form fields
        var editSlot = $('#editNumberOfSlots').val();
        //var row = table.row($(this).closest('tr'));
        var rowData = selectedRow.data();
        //console.log("rowData----",row);
        //rowData.no_of_slots = editSlot;
        //row.data().email = editedEmail;
        //selectedRow.invalidate();
        
        


        $.ajax({
            url: site_url + '/update-slot',
            method: 'POST', // or 'PUT' if updating data
            data: {
                id: selectedRow.data().id, // Include the row ID for server-side identification
                no_of_slots: editSlot,
                // Include other fields as needed
            },
            success: function (response) {
                if (response.status == "success") {
                    // Update the DataTable row with the server's response, if needed
                    rowData.no_of_slots = editSlot;
                    rowData.remaining_slots = editSlot;
                    selectedRow.invalidate();
                    //Swal.fire('Saved!', '', 'success')
                    swal("Saved!", "Changes are Saved!", "success");
                    eventModal.hide(); // Hide the edit popup after saving
                }else{
                    eventModal.hide(); // Hide the edit popup after saving
                }
            },
            error: function (error) {
                console.log(error);
                // Handle errors
                swal("Error!", "Changes are not Saved!", "error");
                
            }
        });
    });
});