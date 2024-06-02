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
            { 
                data: 'dispatch_time', 
                name: 'dispatch_time',
                render: function(data, type, full, meta) {
                    var dispacheAddress = full.dispatch_address;
                    if(dispacheAddress == null){
                        dispacheAddress = "Not added";
                    }
                    if(data != null && data.length != 0){
                        return '<span title="'+dispacheAddress +'" data-id="' + full.id + '">' + data + '</span>';
                    }else{
                        return "--";
                    }
                }
            },
            { 
                data: 'checkout_time', 
                name: 'checkout_time',
                render: function(data, type, full, meta) {
                    var checkoutAddress = full.checkout_address;
                    if(checkoutAddress == null){
                        checkoutAddress = "Not added";
                    }
                    if(data != null &&  data.length != 0){
                        return '<span title="'+checkoutAddress +'" data-id="' + full.id + '">' + data + '</span>';
                    }else{
                        return "--";
                    }
                }
            },
            { data: 'status', name: 'status' },
            {data : 'is_lead' , name :'is_lead'},
            { data: 'action', name: 'action', orderable: false, searchable: false},
            
        ],
       
    });
    $('#filterBtn').click(function() {
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();
        var selected_users = $("#selected_users").val();

        // Reload DataTable with new date range
        table.ajax.url(site_url + "/jobs/?start_date=" + startDate + "&end_date=" + endDate+ "&selected_id=" + selected_users).load();
        // $('#exportBtn').show();
    });
    $("#exportBtn").on('click', function() {
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();
        var selectedUsers = $("#selected_users").val();
        window.location = '/exportToExcel?startDate=' + startDate + '&endDate=' + endDate + '&selectedUsers=' + selectedUsers;
    });
    

    $('#job_status').change(function(){
        table.draw();
    });
    var selectedRow;
    var eventModal;
    $(document).on('click', '.edit-button', function () {
        selectedRow = table.row($(this).closest('tr'));
        var row = selectedRow.data(); 
        console.log("row--------------",row.status_val);
        //$('#editNumberOfSlots').val(row.status_val);
        $('#editStatus').val(row.status_val);
       
        eventModal = new bootstrap.Modal(document.getElementById('editRecordModal'));
        eventModal.show();
    });
    $(document).on('change',"#editStatus",function () {
        var status = $(this).val();
        console.log(status);
        if(status == 6){
            $("#extrafeilds").removeClass("d-none");
            // $("#admin_comission_per").removeClass("d-none");
        }
    })
    $('#saveChanges').on('click', function () {
        var text = $( "#editStatus option:selected" ).text();
        var selected_id = $('#editStatus').val();
        var admin_comission_per = $("#admin_comission_per").val();
        var admin_comission_amount_per = $("#admin_comission_amount_per").val();
        var rowData = selectedRow.data();
        $.ajax({
            url: site_url + '/update-job-status',
            method: 'POST', // or 'PUT' if updating data
            data: {
                id: selectedRow.data().id, // Include the row ID for server-side identification
                job_status: selected_id,
                admin_comission_per : admin_comission_per,
                admin_comission_amount_per : admin_comission_amount_per
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
            error: function (xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                console.log(response.errors.admin_comission_per[0]);

                if(response.errors && response.errors.admin_comission_per) {
                    swal("Error!", response.errors.admin_comission_per[0], "error");
                    // swal("Error!", "The admin comission Percentage field is required!", "error");
                    
                } else if(response.errors && response.errors.admin_comission_amount_per) {
                        swal("Error!", "The admin comission amount field is required!", "error");
                } else {
                    swal("Error!", "Changes are not saved!", "error");
                }
                // Handle errors
                
            }
        });
    });

});

