<?php
include '../lib/dbcon.php';
include '../lib/function.php';
// storing  request (ie, get/post) global array to a variable
$requestData= $_REQUEST;
// pr($requestData);

// (!isset($_POST['action']));
if (!isset($_POST['action'])) {
		$outArr=['status'=>'invalid_request'];
}else{
	$outArr=['status'=>'valid_request'];
	$table = 'stores';
	if ($_POST['action']=='view') {
		// datatable column index  => database column name
		$columns = array(
			0 =>'name',
			1 =>'address',
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
			$nestedData[] = $row["address"];
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
					name="'.$_POST['name'].'",
					address="'.$_POST['address'].'"';
		// vd(is_numeric($_POST[$table.'_id']));
		// vd($_POST['store_id']!='');
		if(is_numeric($_POST['store_id'])){
			$s='UPDATE '.$sql.' WHERE '.$table.'_id='.$_POST[$table.'_id'];
		}else{
			$s='INSERT INTO '.$sql;
		}
		$e=mysqli_query($conn,$s);
		$outArr=['status'=>!$e?'failed save db':'success'];
	}
	// pr($outArr);
}
echo json_encode($outArr);  // send data as json format
?>
