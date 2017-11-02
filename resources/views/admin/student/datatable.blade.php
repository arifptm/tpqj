<script>
$datatable = $('#students-data').DataTable({
  dom: 'Bfrtip',
  buttons: ['pdf','excel'],    
  processing: true,
  serverSide: true,
  responsive: true,
  autoWidth : false,
  pageLength : 15,
  order: [ 0, "desc" ],
  ajax: '/data/students/all',  
  columns: [
    { data: 'id', name: 'id' },
    { data: 'formatted_registered_date', name: 'formatted_registered_date', orderable: false, searchable: false},         
    { data: 'institution.name', name: 'institution.name', orderable: false}, 
    { data: 'name_href', name: 'fullname'}, 
    // { data: 'gender_x', name: 'gender'},
    { data: 'status', name: 'status', orderable: false},
    { data: 'actions', name: 'actions', orderable: false, searchable: false}
  ],
  createdRow: function(row, data, index) {
      $(row).addClass('row'+data.id)
    }  
});
</script> 