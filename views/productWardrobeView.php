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
        <h2>Sharing Stock(Owner)</h2>
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
        						<h2 class="modal-title">Wardrobe</h2>
        					</div>

        					<div class="modal-body">
        						<input type="hidden"  name="product_wardrobe_id" id="product_wardrobe_id" >

                    <!-- store -->
                     <div class="form-group form-float">
                       <div class="xform-line">
                        <label for="">Store</label>
                        <?php
                          include 'lib/dbcon.php';
                          include 'lib/function.php';
                          $storeList=getListByParam('stores','name','');
                        ?>
                        <select onchange="comboWardrobe(this.value);" name="store_id" id="store_id" class="form-control js-example-basic-single col-md-12" >
                          <option value="">--choose--</option>
                          <?php
                            foreach ($storeList['data'] as $k => $v) {
                              echo '<option value="'.$v['store_id'].'">'.$v['name'].' | '.$v['address'].'</option>';
                            }
                          ?>
                        </select>
                      </div>
                    </div>

                    <!-- Wardrobe -->
                     <div class="form-group form-float" >
                       <div class="xform-line "style="width:100%;">
                        <label for="">Wardrobe</label>
                        <select required name="wardrobe_id" id="wardrobe_id" class="form-control js-example-basic-single col-md-12" >
                          <option value="">--choose_store_first--</option>
                        </select>
                      </div>
                      <br>
                    <!-- </div> -->

                    <!-- category -->
                    <div class="form-group form-float" >
                      <div class="xform-line "style="width:100%;">
                        <label for="">Product category</label>
                        <?php
                          $productCategoryList=getListByParam('product_categories','name','');
                        ?>
                        <select onchange="comboProduct(this.value);" name="product_category_id" id="product_category_id" class="form-control js-example-basic-single col-md-12" >
                          <option value="">--choose--</option>
                          <?php
                            foreach ($productCategoryList['data'] as $k => $v) {
                              echo '<option value="'.$v['product_category_id'].'">'.$v['name'].'</option>';
                            }
                          ?>
                        </select>
                      </div>
                      </div>

                      <!-- product -->
                       <div class="form-group form-float" >
                         <div class="xform-line "style="width:100%;">
                          <label for="">Product</label>
                          <select onchange="detailProduct(this.value);" required name="product_id" id="product_id" class="form-control js-example-basic-single col-md-12" >
                            <option value="">--choose_category_first--</option>
                          </select>
                        </div>
                        <br>
                      </div>

                      <div id="detailProductDiv"></div>
                      <div class="form-group form-float" >
                        <div class="xform-line "style="width:100%;">
                         <label for="">Product</label>
                         <input type="text" name="stock" id="stock" >
                       </div>
                       <br>
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

        <!-- <button class="btn btn-primary" data-toggle="modal" data-target="#largePopup">Open</button> -->

        <div class="modal fade" id="largePopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Popup</h4>
              </div>

              <div class="modal-body">
                <?php
                  include 'lib/dbcon.php';
                  $s='SELECT * FROM stores order by name ASC';
                  $e=mysqli_query($conn,$s);
                ?>
                <select class="js-example-basic-single" name="state">
                  <option value="">--choose store--</option>
                  <?php
                    while ($r=mysqli_fetch_assoc($e)) {
                      echo '<option value="'.$r['store_id'].'">'.$r['name'].'</option>';
                    }
                  ?>
                </select>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-tertiary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

        <!-- button add -->
        <div class="js-modal-buttons">
          <button data-color="blue" class="btn bg-blue waves-effect" id="addNew" value="add">Add</button>
        </div>
        <br>
        <!-- <select class="" id="store_ids">
          <option value="">Branch Store</option>
          <option value="40">S01</option>
          <option value="34">S02</option>
          <option value="39">S03</option>
        </select> -->

        <div class="row">
          <!-- grid -->
        	<table id="table-grid"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
        			<thead>
        				<tr>
        					<th>Branch Store</th>
        					<th>Code</th>
        					<th>status</th>
        					<th>Action</th>
        				</tr>
        			</thead>
        			<tfoot>
        				<tr>
        					<th>Branch Store</th>
        					<th>Code</th>
        					<th>status</th>
        					<th>Action</th>
        				</tr>
        			</tfoot>
        	</table>
        </div>

        <script type="text/javascript">
          var title='productWardrobe';
        	$(document).ready(function () {
        		$('#addNew').on('click',function () {
        			resetForm();
        			$('#name').focus();
        			$('.modal-title').html('Add Sharing Stock');
        			$('#formModal').modal('show');
            });

            $('.js-example-basic-single').select2();

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
        				data:{'action':'delete','product_wardrobe_id':id},
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
        			data:{'action':'edit','product_wardrobe_id':id},
        			method:'post',
        			dataType:'json',
        			success:function(res){
        				if(res.status!='success') alert(res.status);
        				else {
        					$('#product_wardrobe_id').val(id);
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
        		$('#product_wardrobe_id').val('');
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

          function comboWardrobe(store_id) {
            $.ajax({
        			url:'controllers/wardrobeController.php',
        			data:{
                'action':'comboWardrobe',
                'store_id':store_id,
              },
        			method:'post',
        			dataType:'json',
        			success:function(res){
        				if(res.status!='success') alert(res.status);
        				else {
                  var opt='';
                  if (res.num=='0') {
                    opt+='<option value="">empty</option>'
                  } else{
                    opt+='<option value="">--choose--</option>'
                    $.each(res.data,function (id,val) {
                      opt+='<option value="'+val.product_wardrobe_id+'">'+val.code+'</option>';
                    });
                  }
                  $('#wardrobe_id').html(opt);
        				}
        			}
        		});
          }

          function comboProduct(par) {
            $.ajax({
        			url:'controllers/productController.php',
        			data:{
                'action':'comboProduct',
                'product_category_id':par,
              },
        			method:'post',
        			dataType:'json',
        			success:function(res){
        				if(res.status!='success') alert(res.status);
        				else {
                  var opt='';
                  if (res.num=='0') {
                    opt+='<option value="">empty</option>'
                  } else{
                    opt+='<option value="">--choose--</option>'
                    $.each(res.data,function (id,val) {
                      opt+='<option value="'+val.product_id+'">'+val.code+'</option>';
                    });
                  }
                  $('#product_id').html(opt);
        				}
        			}
        		});
          }

          function detailProduct(par) {
            $.ajax({
        			url:'controllers/productController.php',
        			data:{
                'action':'detailProduct',
                'product_id':par,
              },
        			method:'post',
        			dataType:'json',
        			success:function(res){
        				if(res.status!='success') alert(res.status);
        				else {
                  var tb = '<table class="table table-striped">'
                    +'<tr>'
                      +'<td>Code</td>'
                      +'<td>: '+res.data.code+'</td>'
                    +'</tr>'
                    +'<tr>'
                      +'<td>size</td>'
                      +'<td>: '+res.data.size+'</td>'
                    +'</tr>'
                    +'<tr>'
                      +'<td>Merk</td>'
                      +'<td>: '+res.data.merk+'</td>'
                    +'</tr>'
                    +'<tr>'
                      +'<td>purchase Price</td>'
                      +'<td>: '+res.data.purchase_price+'</td>'
                    +'</tr>'
                    +'<tr>'
                      +'<td>selling Price</td>'
                      +'<td>: '+res.data.selling_price+'</td>'
                    +'</tr>'
                  +'</table>';
                  $('#detailProductDiv').html(tb);
                  // $('#code').val(res.data.code);
                  // $('#size').val(res.data.size);
                  // $('#purchase_price').val(res.data.purchase_price);
                  // $('#selling_price').val(res.data.selling_price);
                  // $('#merk').val(res.data.merk);
        				}
        			}
        		});
          }
        </script>

      </div>

    </div>
  </div>
