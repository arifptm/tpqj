   <div class="modal fade shared-modal" role="dialog">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <div class="modal-body">
               <section class="content-header">
                  <h1 id="datatitle"></h1>
               </section>

               <div class="content">
                  <div class="box box-primary">
                     <div class="box-body">
                        <form id='myForm' role='form' >
                        @include('admin.person.fields') 
                     </form>
                     </div>
                  </div>
               </div>

            </div>
            <div class="modal-footer">
            </div>
         </div>
      </div>
   </div>