$(document).on('click', '.delete-datatable-record', function(e){
    let url  = site_url + "/jobs/" + $(this).attr('data-id');
    let tableId = 'usersTable';
    deleteDataTableRecord(url, tableId);
});

$(document).ready(function() {
    console.log(site_url, '======site_url');
    var table = $('#usersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: site_url + "/jobs/",
          data: function (d) {
                d.status = $('#job_status').val()
            }
        },
        //ajax: site_url + "/jobs/",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            { data: 'customer_name', name: 'customer_name' },
            { data: 'service_titan_number', name: 'service_titan_number' },
            { data: 'total_amount', name: 'total_amount' },
            { data: 'dispatch_time', name: 'dispatch_time' },
            { data: 'checkout_time', name: 'checkout_time' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false},
            
        ]
    });

    $('#job_status').change(function(){
        table.draw();
    });
    var selectedRow;
    var eventModal;
    $(document).on('click', '.edit-button', function () {
        selectedRow = table.row($(this).closest('tr'));
        var row = selectedRow.data(); 
        console.log("row--------------",row);
        //$('#editNumberOfSlots').val(row.status_val);
        $('#editStatus').val(row.status_val);
       
        eventModal = new bootstrap.Modal(document.getElementById('editRecordModal'));
        eventModal.show();
    });
    $('#saveChanges').on('click', function () {
        var text = $( "#editStatus option:selected" ).text();
        var selected_id = $('#editStatus').val();
        var rowData = selectedRow.data();
        $.ajax({
            url: site_url + '/update-job-status',
            method: 'POST', // or 'PUT' if updating data
            data: {
                id: selectedRow.data().id, // Include the row ID for server-side identification
                job_status: selected_id,
                // Include other fields as needed
            },
            success: function (response) {
                if (response.status == "success") {
                    // Update the DataTable row with the server's response, if needed
                    rowData.status = text;
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

