@extends('template.layout')

@section('header-scripts')
  	<link rel="stylesheet" href="/bower_components/AdminLTE/plugins/iCheck/flat/purple.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">    
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css"> -->
    
@endsection

@section('footer-scripts')
	<script src="/bower_components/AdminLTE/plugins/iCheck/icheck.min.js"></script>
  	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  	<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
  	<!-- <script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js""></script>	
  	<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js""></script>	
  	<script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js""></script>	 -->

	<script src="/js/custom.js"></script>

	<script>
		$datatable = $('#datatable').DataTable({			
			// dom: 'Bfrtip',
			// buttons: ['pdf','excel'],			
		    processing: true,
		    serverSide: true,
		    responsive: true,
		    autoWidth   : false,
		    order: [ 1, "asc" ],
		    ajax: 'pub/data/persons',  
		    columns: [
		      { data: 'id', name: 'id', searchable: false },
		      { data: 'name_href', name: 'name'}, 
		      { data: 'institutions', name: 'mainInstitution.name'}, 
		      { data: 'phone', name: 'phone', defaultContent: '...', orderable: false},
		      
		    ],
		    createdRow: function(row, data, index) {
		      $(row).addClass('row'+data.id)
		    }
		}); 


	</script>

@endsection

@section('content-top')
  <h1>Daftar Ustadz/Ustadzah 
  </h1>
@endsection

@section('content-main')
  <div class="row">
<div class="col-md-8">
		  <div class="box">    
		    <div class="box-body">
		      <table class="table table-bordered table-striped" id="datatable">
		        <thead>
		        <tr>
		          <th style="width: 50px">No</th>
		          <th>Nama Ustadz/ah</th>
		          <th>Lembaga</th>
		          <th>Telepon</th>
		        </tr>	
		        </thead>	        
		      </table>
		    </div> 
		  </div>
		</div>
@endsection