$(document).on('click', '.delete-datatable-record', function(e){
    let url  = site_url + "/company/" + $(this).attr('data-id');
    let tableId = 'usersTable';
    deleteDataTableRecord(url, tableId);
});

$(document).ready(function() {
    console.log(site_url, '======site_url');
    $('#usersTable').DataTable({
        ...defaultDatatableSettings,
        ajax: site_url + "/company/",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            { data: 'name', name: 'name' },
            { data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
});