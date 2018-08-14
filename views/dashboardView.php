<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">

      <!-- header -->
      <div class="header">
        <h2>Dashboard</h2>
      </div>

      <!-- body -->
      <div class="body">
		this is dashboard
	  </div>
      

        <script type="text/javascript">
        	$(document).ready(function () {
        		$('#addNew').on('click',function () {
        			resetForm();
        			$('#name').focus();
        			$('.modal-title').html('Add Store');
        			$('#formModal').modal('show');
        		});

        		$('#confirmModal').on('show.bs.modal', function (e) {
        			 $message = $(e.relatedTarget).attr('data-message');
        			 $(this).find('.modal-body p').text($message);
        			 $title = $(e.relatedTarget).attr('data-title');
        			 $(this).find('.modal-title').text($title);

        	 });


        		var dataTable = $('#store-grid').DataTable( {
        			"dataSrc": "Data",
        			"processing": true,
        			"serverSide": true,
        			"ajax":{
        				url:'controllers/storeController.php',
        				data:{action:'view'},
        				type: "post",  // method  , by default get
        				error: function(){  // error handling
        					$(".store-grid-error").html("");
        					$("#store-grid").append('<tbody class="store-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
        					$("#store-grid_processing").css("display","none");
        				}
        			}
        		});

        	})

        	function deleteRow(id) {
        		$('#confirm').on('click',function(){
        			$.ajax({
        				url:'controllers/storeController.php',
        				data:{'action':'delete','store_id':id},
        				method:'post',
        				dataType:'json',
        				success:function(res){
        					if(res.status!='success') alert(res.status);
        					else {
        						$('#confirmModal').modal('hide');
        						var tablex = $('#store-grid').DataTable();
        						tablex.ajax.reload();
        					}
        				}
        			});
        		})
        	}

        	function editRow(id) {
        		resetForm();
        		$('.modal-title').html('Edit Store');
        		$.ajax({
        			url:'controllers/storeController.php',
        			data:{'action':'edit','store_id':id},
        			method:'post',
        			dataType:'json',
        			success:function(res){
        				if(res.status!='success') alert(res.status);
        				else {
        					$('#store_id').val(id);
        					$('#name').val(res.data.name);
        					$('#address').val(res.data.address);
        					$('#formModal').modal('show');
        				}
        			}
        		});
        	}

        	function resetForm(){
        		$('#store_id').val('');
        		$('#name').val('');
        		$('#address').val('');
        	}



        	function saveRow() {
        		$.ajax({
        			url:'controllers/storeController.php',
        			data:$('form').serialize()+'&action=save',
        			method:'post',
        			dataType:'json',
        			success:function(res){
        				if(res.status!='success') alert(res.status);
        				else {
        					$('#formModal').modal('hide');
        					var tablex = $('#store-grid').DataTable();
        					tablex.ajax.reload();
        				}
        			}
        		});
        	}
        </script>

      </div>

    </div>
  </div>
