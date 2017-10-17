<script>
  $datatable = $('#transactions-data').DataTable({    
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth   : false,
    pageLength: 20,
    order: [ 0, "desc" ],
    ajax: '/data/almaruf-transactions/all',  
    columns: [
      { data: 'id', name: 'id', searchable: false, "visible": false },
      { data: 'fdate', name: 'transaction_date', searchable: false},         
      { data: 'type', name: 'transactionType.name'}, 
      { data: 'fname', name: 'student.fullname'},       
      { data: 'famount', name: 'amount', orderable: false, searchable: false},       
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


  $('#123').click(function(e){
    $id = '2017-10-03';
    $datatable.ajax.url( '/data/almaruf-transactions/'+$id ).load();
  });

  
    $(document).on('click', '#show-tr', function() {  
      
      $dt = $(this).data('tdate').split('-');
      $dt = $dt[2]+'-'+$dt[1]+'-'+$dt[0];

      $datatable.ajax.url( '/data/almaruf-transactions/' + $dt ).load();
    });
    
  

</script>