<?php
	include '../lib/dbcon.php';
	include '../lib/function.php';

	$requestData= $_REQUEST;

	if (!isset($_POST['action'])) {
			$outArr=['status'=>'invalid_request'];
	}else{
		$outArr=['status'=>'valid_request'];
		$title = 'product_category';
		$table = 'product_categories';
		if ($_POST['action']=='view') {
			// datatable column index  => database column name
			$columns = array(
				0 =>'name',
			);

			// getting total number records without any search
			$sql = "SELECT * ";
			$sql.=" FROM {$table}";
			$query=mysqli_query($conn, $sql) or die(mysqli_error($conn));
			$totalData = mysqli_num_rows($query);
			$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

			if( !empty($requestData['search']['value']) ) {
				// if there is a search parameter
				$sql = "SELECT * ";
				$sql.=" FROM {$table}";
				$sql.=" WHERE name LIKE '%".$requestData['search']['value']."%' ";    // $requestData['search']['value'] contains search parameter
				$sql.=" OR address LIKE '%".$requestData['search']['value']."%' ";
		// pr($sql);
				$query=mysqli_query($conn, $sql) or die(mysqli_error($conn));
				$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result without limit in the query

				$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   "; // $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc , $requestData['start'] contains start row number ,$requestData['length'] contains limit length.
				$query=mysqli_query($conn, $sql) or die(mysqli_error($conn));
			} else {
				$sql = "SELECT *  ";
				$sql.=" FROM {$table}";
				$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
				$query=mysqli_query($conn, $sql) or die(mysqli_error($conn));
			}

			$data = array();
			while( $row=mysqli_fetch_array($query) ) {  // preparing an array
				$nestedData=array();
				$nestedData[] = $row["name"];
				$nestedData[] = '
					<button onclick="editRow('.$row[$title.'_id'].')" data-toggle="modal" data-target="modalDiv" data-id="'.$row[$title.'_id'].'" class="btn btn-info btn-xs">
						<i class="glyphicon glyphicon-pencil"></i> Edit
					</button>

					<form method="POST" xaction="alert()" accept-charset="UTF-8" style="display:inline">
					    <button
								type="button"
								data-title="Delete '.$title.'"
								data-toggle="modal"
								data-target="#confirmModal"
								class="btn btn-xs btn-danger"
								onclick="deleteRow('.$row[$title.'_id'].')"
								data-message="Are you sure you want to delete \''.$row['name'].' \' ?"
							>
					        <i class="glyphicon glyphicon-cross"></i> Delete
					    </button>
					</form>
					';
				$data[] = $nestedData;
			}

			$outArr = array(
				"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
				"recordsTotal"    => intval( $totalData ),  // total number of records
				"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
				"data"            => $data,   // total data array
				"status" => 'success view',
			);
		} elseif ($_POST['action']=='save') {
			$sql= $table.' SET
						name="'.$_POST['name'].'"
						';
			if(is_numeric($_POST[$title.'_id'])){
				$s='UPDATE '.$sql.' WHERE '.$title.'_id='.$_POST[$title.'_id'];
			}else{
				$s='INSERT INTO '.$sql;
			}
			// pr($s);
			$e=mysqli_query($conn,$s);
			$outArr=['status'=>!$e?'failed save db':'success'];
		} elseif ($_POST['action']=='edit') {
			$s= 'SELECT * FROM '.$table.' WHERE '.$title.'_id ='.$_POST[$title.'_id'];
			// pr($);
			$e=mysqli_query($conn,$s);
			$r=mysqli_fetch_assoc($e);
			$outArr=[
				'status'=>!$e?'failed load data':'success',
				'data'=>$r
			];
		} elseif ($_POST['action']=='delete') {
			$s= 'DELETE FROM '.$table.' WHERE '.$title.'_id ='.$_POST[$title.'_id'];
			$e=mysqli_query($conn,$s);
			$outArr=['status'=>!$e?'failed delete data':'success'];
		}
	}
	echo json_encode($outArr);  // send data as json format
?>
