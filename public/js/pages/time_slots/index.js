$(document).on('click', '.delete-datatable-record', function(e){
    let url  = site_url + "/time_slot/" + $(this).attr('data-id');
    let tableId = 'usersTable';
    deleteDataTableRecord(url, tableId);
});

$(document).ready(function() {
    console.log(site_url, '======site_url');
    $('#usersTable').DataTable({
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
});