<style media="screen">
.bootstrap-select.btn-group .dropdown-menu {
  z-index: 2000;
}
.bootstrap-select.btn-group .dropdown-menu.inner {
  position: static;
}
.modal { overflow: visible; }
.modal-body { overflow-y: visible !important; }
</style>


<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">

      <!-- header -->
      <div class="header">
        <h2>Users</h2>
      </div>

      <!-- body -->
      <div class="body">

        <!-- confirmation Dialog -->
        <div class="modal fade" id="confirmModal" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Delete Parmanently</h4>
              </div>
              <div class="modal-body">
                <p>Are you sure about this ?</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirm">Delete</button>
              </div>
            </div>
          </div>
        </div>


        <!-- form modal -->
        <div id="formModal"  data-keyboard="false" data-backdrop="true" class="modal fade">
        		<form onsubmit="saveRow();return false;">
        			<div class="modal-dialog">

        				<div class="modal-content">
        					<div class="modal-header">
        						<button type="button" class="close" aria-hidden="true" data-dismiss="modal">&times;</button>
        						<h2 class="modal-title">User</h2>
        					</div>

        					<div class="modal-body">
        						<input type="hidden"  name="wardrobe_id" id="wardrobe_id" >

                     <div class="form-group xform-float">
                       <div class="xform-line">
                        <label for="">Level</label>
                        <?php
                          include 'lib/dbcon.php';
                          $s='SELECT * FROM levels order by name ASC';
                          $e=mysqli_query($conn,$s);
                        ?>
                        <select name="level_id" id="level_id" class="form-control js-example-basic-single col-md-12" >
                          <option value="">--choose store--</option>
                          <?php
                            while ($r=mysqli_fetch_assoc($e)) {
                              echo '<option value="'.$r['level_id'].'">'.$r['name'].' </option>';
                            }
                          ?>
                        </select>
                      </div><br>

                      <div class="xform-line">
                       <label for="">Store</label>
                       <?php
                         $s='SELECT * FROM stores order by name ASC';
                         $e=mysqli_query($conn,$s);
                       ?>
                       <select name="store_id" id="store_id" class="form-control js-example-basic-single col-md-12" >
                         <option value="">--choose store--</option>
                         <?php
                           while ($r=mysqli_fetch_assoc($e)) {
                             echo '<option value="'.$r['store_id'].'">'.$r['name'].' </option>';
                           }
                         ?>
                       </select>
                     </div><br>

                     <div class="form-group xform-float">
                        <div class="form-line">
                          <input type="text" id="name" name="name" class="form-control">
                          <label class="form-label">Name</label>
                        </div>
                      </div>

                     <div class="form-group xform-float">
                        <div class="form-line">
                          <input type="text" id="email" name="email" class="form-control">
                          <label class="form-label">Email</label>
                        </div>
                      </div>

                     <div class="form-group xform-float">
                        <div class="form-line">
                          <input type="text" id="username" name="username" class="form-control">
                          <label class="form-label">Username</label>
                        </div>
                      </div>

                     <div class="form-group xform-float">
                        <div class="form-line">
                          <input type="password" id="password" name="password" class="form-control">
                          <label class="form-label">Password</label>
                        </div>
                      </div>

                     <div class="form-group xform-float">
                        <div class="form-line">
                          <input type="phone" id="phone" name="phone" class="form-control">
                          <label class="form-label">Phone</label>
                        </div>
                      </div>

                      <div class="form-group xform-float">
                        <div class="form-line">
                          <div class="switch">
                            <label>
                              Status
                              <input name="status" id="status" type="checkbox">
                              <span class="lever switch-col-red"></span>
                            </label>
                          </div>

                          <!-- <input type="checkbox" id="remember_me" class="filled-in">
                          <label for="remember_me">Remember Me</label> -->
                        </div>
                      </div>

                    </div>

        					</div>

        					<div class="modal-footer">
        						<input type="submit" class="btn btn-success" value="save" >
        					</div>

        				</div>
        			</div>
        		</form>
        </div>

        <!-- button add -->
        <div class="js-modal-buttons">
          <button data-color="blue" class="btn bg-blue waves-effect" id="addNew" value="add">Add</button>
        </div>
        <br>

        <div class="row">
        	<table id="table-grid"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
        			<thead>
        				<tr>
        					<th>Name</th>
        					<th>Username</th>
        					<th>Email</th>
        					<th>phone</th>
                  <th>Status</th>
                  <th>Level</th>
        					<th>Store</th>
        					<th>Action</th>
        				</tr>
        			</thead>
        			<tfoot>
        				<tr>
        					<th>Name</th>
        					<th>Username</th>
        					<th>Email</th>
        					<th>phone</th>
                  <th>Status</th>
                  <th>Level</th>
        					<th>Store</th>
        					<th>Action</th>
        				</tr>
        			</tfoot>
        	</table>
        </div>

        <script type="text/javascript">
          var title='user';
        	$(document).ready(function () {
        		$('#addNew').on('click',function () {
        			resetForm();
        			$('#name').focus();
        			$('.modal-title').html('Add Store');
        			$('#formModal').modal('show');
            });

            // $('.js-example-basic-single').select2();
            $('#level_id').select2();
            $('#store_id').select2();

        		$('#confirmModal').on('show.bs.modal', function (e) {
        			 $message = $(e.relatedTarget).attr('data-message');
        			 $(this).find('.modal-body p').text($message);
        			 $title = $(e.relatedTarget).attr('data-title');
        			 $(this).find('.modal-title').text($title);

        	 });

        		var dataTable = $('#table-grid').DataTable( {
              "dataSrc": "Data",
              "processing": true,
              "serverSide": true,
              "ajax":{
                url:'controllers/'+title+'Controller.php',
                data:{action:'view'},
                type: "post",  // method  , by default get
                error: function(){  // error handling
                  $(".table-grid-error").html("");
                  $("#table-grid").append('<tbody class="table-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                  $("#table-grid_processing").css("display","none");
                }
              },
              initComplete: function () {
                this.api().columns().every( function () {
                  var column = this;
                  var select = $('<select><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                      var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val()
                      );
                      column
                        .search( val ? '^'+val+'$' : '', true, false )
                        .draw();
                    });
                    column.data().unique().sort().each( function ( d, j ) {
                      select.append( '<option value="'+d+'">'+d+'</option>' )
                    });
                  });
                }

        		});
        		// var dataTable = $('#table-grid').DataTable( {
        		// 	"dataSrc": "Data",
        		// 	"processing": true,
        		// 	"serverSide": true,
        		// 	"ajax":{
        		// 		url:'controllers/'+title+'Controller.php',
        		// 		data:{action:'view'},
        		// 		type: "post",  // method  , by default get
        		// 		error: function(){  // error handling
        		// 			$(".table-grid-error").html("");
        		// 			$("#table-grid").append('<tbody class="table-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
        		// 			$("#table-grid_processing").css("display","none");
        		// 		}
        		// 	}
        		// });

        	})

        	function deleteRow(id) {
        		$('#confirm').on('click',function(){
        			$.ajax({
        				url:'controllers/'+title+'Controller.php',
        				data:{'action':'delete','wardrobe_id':id},
        				method:'post',
        				dataType:'json',
        				success:function(res){
        					if(res.status!='success') alert(res.status);
        					else {
        						$('#confirmModal').modal('hide');
        						var tablex = $('#table-grid').DataTable();
        						tablex.ajax.reload();
        					}
        				}
        			});
        		})
        	}

        	function editRow(id) {
        		resetForm();
        		$('.modal-title').html('Edit '+title);
        		$.ajax({
        			url:'controllers/'+title+'Controller.php',
        			data:{'action':'edit','wardrobe_id':id},
        			method:'post',
        			dataType:'json',
        			success:function(res){
        				if(res.status!='success') alert(res.status);
        				else {
        					$('#wardrobe_id').val(id);
        					$('#code').val(res.data.code);
                  $('#store_id').val(res.data.store_id);
                  if(res.data.is_locked=='1'){
					           $('#is_locked').attr('checked',true);
                  }else {
                    $('#is_locked').removeAttr('checked');
                  }
        					$('#formModal').modal('show');
        				}
        			}
        		});
        	}

        	function resetForm(){
        		$('#wardrobe_id').val('');
        		$('#code').val('');
        		$('#is_locked').val('');
        	}

        	function saveRow() {
        		$.ajax({
        			url:'controllers/'+title+'Controller.php',
        			data:$('form').serialize()+'&action=save',
        			method:'post',
        			dataType:'json',
        			success:function(res){
        				if(res.status!='success') alert(res.status);
        				else {
        					$('#formModal').modal('hide');
        					var tablex = $('#table-grid').DataTable();
        					tablex.ajax.reload();
        				}
        			}
        		});
        	}
        </script>

      </div>

    </div>
  </div>
