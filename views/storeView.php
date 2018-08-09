<div class="header"><h1>Stores</h1></div>

<div id="modalDiv" class="modal fade">
		<form onsubmit="saveStore();return false;">
			<div class="modal-dialog">

				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h2 class="modal-title">Store</h2>
					</div>

					<div class="modal-body">
						<input type="text" class="form-control"  name="store_id" >
						<label for="">Name</label>
						<input type="text" required class="form-control" placeholder="entry name ..." name="name" >
						<label for="">Address</label>
						<textarea name="address"  placeholder="entry address ..." class="form-control"></textarea>
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

	<table id="store-grid"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
			<thead>
				<tr>
					<th>Branch Store</th>
					<th>Address</th>
				</tr>
			</thead>
	</table>
</div>


<script type="text/javascript">
	$(document).ready(function () {
		$('#addNew').on('click',function () {
			$('#modalDiv').modal('show');
		});

		// var table = $('#example').DataTable();
		//
		// dataTable.ajax.reload( function ( json ) {
		//     $('#myInput').val( json.lastInput );
		// } );

		var dataTable = $('#store-grid').DataTable( {
			"dataSrc": "Data",
			"processing": true,
			"serverSide": true,
			"ajax":{
				url:'controllers/storeController.php',
				data:{action:'view'},
				// url :"store-grid-data.php", // json datasource
				type: "post",  // method  , by default get
				error: function(){  // error handling
					$(".store-grid-error").html("");
					$("#store-grid").append('<tbody class="store-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
					$("#store-grid_processing").css("display","none");
				}
			}
		});

	})


	function saveStore() {
		$.ajax({
			url:'controllers/storeController.php',
			data:$('form').serialize()+'&action=save',
			method:'post',
			dataType:'json',
			success:function(res){
				if(res.status!='success') alert(res.status);
				else {
					$('#modalDiv').modal('hide');
					var tablex = $('#store-grid').DataTable();

					tablex.ajax.reload();

				}
			}
		});
	}
</script>
