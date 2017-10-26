   <div class="modal fade shared-modal" role="dialog" >
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header bg-blue">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title" id="datatitle"></h4>
            </div>   
               <div class="modal-body">
                  <div class="alert bg-green lead" style='display:none;'><i class="icon fa fa-check"></i> <span id="modalmessage"></span></div>
                  <form id='myForm' role='form' >         
                     @include('admin.achievement.fields') 
                  </form> 
               </div>   
               <div class="modal-footer bg-blue">
               </div>            
         </div>
      </div>
   </div>