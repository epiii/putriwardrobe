<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">

      <!-- header -->
      <div class="header">
        <h2>Product Categories</h2>
      </div>

      <!-- body -->
      <div class="body">
        <!-- <div class="header"><h1>Stores</h1></div> -->

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
        						<h2 class="modal-title">Product Category</h2>
        					</div>

        					<div class="modal-body">
        						<input type="hidden" class="form-control"  name="product_category_id" id="product_category_id" >

        						<label for="">Name</label>
        						<input type="text" required class="form-control" placeholder="entry name ..." name="name" id="name" >
        					</div>

        					<div class="modal-footer">
        						<input type="submit" class="btn btn-success" value="save" >
        					</div>

        				</div>
        			</div>
        		</form>
        </div>

        <div class="row">
        	<div class="col-md-8 col-md-offset-2">
        		<input type="button" style="float:right"class="btn btn-success" id="addNew" value="add">
        	</div>

        	<table id="table-grid"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
        			<thead>
        				<tr>
        					<th>Category</th>
        					<th>Action</th>
        				</tr>
        			</thead>
        			<tfoot>
        				<tr>
        					<th>Category</th>
        					<th>Action</th>
        				</tr>
        			</tfoot>
        	</table>
        </div>


        <script type="text/javascript">
          var title = 'productCategories';
        	$(document).ready(function () {
        		$('#addNew').on('click',function () {
        			resetForm();
        			$('#name').focus();
        			$('.modal-title').html('Add Prduct Category');
        			$('#formModal').modal('show');
        		});

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
        			}
        		});

        	})

        	function deleteRow(id) {
        		$('#confirm').on('click',function(){
        			$.ajax({
        				url:'controllers/'+title+'Controller.php',
        				data:{'action':'delete','product_category_id':id},
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
        		$('.modal-title').html('Edit '+title+'');
        		$.ajax({
        			url:'controllers/'+title+'Controller.php',
        			data:{'action':'edit','product_category_id':id},
        			method:'post',
        			dataType:'json',
        			success:function(res){
        				if(res.status!='success') alert(res.status);
        				else {
        					$('#product_category_id').val(id);
        					$('#name').val(res.data.name);
        					$('#address').val(res.data.address);
        					$('#formModal').modal('show');
        				}
        			}
        		});
        	}

        	function resetForm(){
        		$('#product_category_id').val('');
        		$('#name').val('');
        		$('#address').val('');
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
