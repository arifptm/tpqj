<script>
  $datatable = $('#achievements-data').DataTable({    
    dom: 'Bfrtip',
    buttons: ['pdf','excel'],  
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth   : false,
    pageLength: 20,
    order: [ 0, "desc" ],
    //ins =def ; all = stage ; group = tpqa/d
    ajax: '/data/achievements/default/all/group',  
    columns: [
      { data: 'id', name: 'id', searchable: false, "visible": false },
      
      { data: 'fdate', name: 'achievement_date'},          
      
      { data: 'fname', name: 'student.fullname'}, 
      { data: 'stage.name', name: 'achievement.stage.name', searchable: false},       
      // { data: 'famount', name: 'amount', orderable: false, searchable: false},       
      // { data: 'notes', name: 'notes',  defaultContent: '...'},       
      { data: 'actions', name: 'actions', orderable: false, searchable: false}
    ],
    createdRow: function(row, data, index) {
      $(row).attr('id', 'row-'+data.id)
    },
    language: {        
      'url': '/assets/dt.indonesian.json'
    }    
  }); 

</script>