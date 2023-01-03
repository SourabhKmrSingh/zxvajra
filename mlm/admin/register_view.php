<?php
include_once("inc_config.php");
include_once("login_user_check.php");

$_SESSION['active_menu'] = "register";

echo $validation->read_permission();

@$orderby = $validation->input_validate($_GET['orderby']);
@$order = $validation->input_validate($_GET['order']);

@$userid = $validation->input_validate($_GET['userid']);
@$name = strtolower($validation->input_validate($_GET['name']));
@$email = strtolower($validation->input_validate($_GET['email']));
@$mobile = strtolower($validation->input_validate($_GET['mobile']));
@$status = strtolower($validation->input_validate($_GET['status']));
@$datefrom = $validation->input_validate($_GET['datefrom']);
@$dateto = $validation->input_validate($_GET['dateto']);

$where_query = "";
if($userid != "")
{
	$where_query .= " and userid = '$userid'";
}
if($name != "")
{
	$where_query .= " and LOWER(first_name) LIKE '%$name%' OR LOWER(last_name) LIKE '%$name%'";
}
if($email != "")
{
	$where_query .= " and email = '$email'";
}
if($mobile != "")
{
	$where_query .= " and mobile = '$mobile'";
}
if($status != "")
{
	$where_query .= " and status = '$status'";
}
if($datefrom != "" and $dateto != "")
{
	$where_query .= " and createdate between '$datefrom' and '$dateto'";
}

if($orderby != "" and $order != "")
{
	$orderby_final = "{$orderby} {$order}";
	if($orderby == "createdate")
	{
		$orderby_final .= ", createtime {$order}";
	}
}
else
{
	$orderby_final = "regid desc";
}

$param1 = "first_name";
$param2 = "order_custom";
$param3 = "createdate";
include_once("inc_sorting.php");

$table = "mlm_registrations";
$id = "regid";
$url_parameters = "&userid=$userid&name=$name&email=$email&mobile=$mobile&status=$status&datefrom=$datefrom&dateto=$dateto";

$data = $pagination->main($table, $url_parameters, $where_query, $id, $orderby_final);

echo $validation->search_filter_enable();
?>
<!DOCTYPE html>
<html LANG="en">
<head>
<?php include_once("inc_title.php"); ?>
<?php include_once("inc_files.php"); ?>
</head>
<body>
<div ID="wrapper">
<?php include_once("inc_header.php"); ?>
<div ID="page-wrapper">
<div CLASS="container-fluid">
<div CLASS="row">
	<div CLASS="col-lg-12">
		<h1 CLASS="page-header">Members <!--<?php if($_SESSION['per_write'] == "1") { ?><a href="register_form.php?mode=insert" class="btn btn-default btn-sm button">Add New</a><?php } ?>--></h1>
	</div>
</div>

<form name="form_actions" method="POST" action="register_actions.php" ENCTYPE="MULTIPART/FORM-DATA">
<div class="row">
	<div class="col-sm-12 mb-0">
		<div class="form-inline">
			<select NAME="bulk_actions" CLASS="form-control mb_inline mb-2" >
				<option VALUE="">Bulk Actions</option>
				<option VALUE="delete">Delete</option>
				<!--<option VALUE="active">Status to Active</option>
				<option VALUE="inactive">Status to Inactive</option>-->
			</select>
			<button type="submit" class="btn btn-default mb_inline btn-sm btn_submit mb-2 mr-4">Apply</button>
			
			<input type="text" name="name" class="form-control mb_inline mb-2" placeholder="Name" value="<?php echo $name; ?>" />
			<input type="text" name="email" class="form-control mb_inline mb-2" placeholder="Email ID" value="<?php echo $email; ?>" />
			<input type="text" name="mobile" class="form-control mb_inline mb-2" placeholder="Mobile No." value="<?php echo $mobile; ?>" />
			<select NAME="status" CLASS="form-control mb_inline mb-2">
				<option VALUE="" <?php if($status=='') echo "selected"; ?>>Status</option>
				<option VALUE="active" <?php if($status=="active") echo "selected"; ?>>Active</option>
				<option VALUE="inactive" <?php if($status=="inactive") echo "selected"; ?>>Inactive</option>
			</select>
			<p class="pt-2">From&nbsp;</p> <input type="date" name="datefrom" class="form-control mb_inline mb-2" placeholder="From" value="<?php echo $datefrom; ?>" />
			<p class="pt-2">To&nbsp;</p> <input type="date" name="dateto" class="form-control mb_inline mb-2" placeholder="To" value="<?php echo $dateto; ?>" />
			<input type="submit" value="Filter" class="btn btn-default mb_inline btn-sm btn_submit ml-sm-2 ml-md-0 mb-2 mr-1" />
			<a href="register_view.php" class="btn btn-default mb_inline btn-sm btn_delete ml-sm-2 ml-md-0 mb-2">Clear</a>
		</div>
	</div>
</div>

<div class="table-responsive">
<table class="table table-striped table-view" cellspacing="0" width="100%">
	<thead>
	<tr>
		<th class="check-row text-center"><input type="checkbox" name="select_all" onClick="selectall(this);" /></th>
		<th class="<?php echo $th_sort1." ".$th_order_cls1; ?>"><a href="register_view.php?orderby=first_name&order=<?php echo $th_order1; echo $url_parameters; ?>"><span>Name</span> <span class="sorting-indicator"></span></a></th>
		<th>Membership ID</th>
		<th>Sponsor ID</th>
		<th>Email</th>
		<th>Mobile No.</th>
		<th>Downline Members</th>
		<th>E-Wallet</th>
		<th>Status</th>
		<th class="<?php echo $th_sort3." ".$th_order_cls3; ?>"><a href="register_view.php?orderby=createdate&order=<?php echo $th_order3.''.$url_parameters; ?>"><span>Date</span> <span class="sorting-indicator"></span></a></th>
	</tr>
	</thead>
	<tbody>
	<?php
	if($data['num_rows'] >= 1)
	{
		foreach($data['result'] as $registerRow)
		{
			$regid = $registerRow['regid'];
			
			// $creditResult = $db->view("SUM(amount) as total_credit_amount", "mlm_ewallet", "regid", "and type='credit' and regid='{$regid}'");
			// $creditRow = $creditResult['result'][0];
			
			// $debitResult = $db->view("SUM(amount) as total_debit_amount", "mlm_ewallet", "regid", "and type='debit' and regid='{$regid}'");
			// $debitRow = $debitResult['result'][0];
		?>
		<tr class="text-center has-row-actions">
			<td class="text-center" data-label=""><input type="checkbox" name="del_items[]" value="<?php echo $validation->db_field_validate($registerRow['regid']); ?>"/></td>
			<td data-label="Name - ">
				<a href="register_form.php?mode=edit&regid=<?php echo $validation->db_field_validate($registerRow['regid']); ?>" class="fw-500"><?php echo $validation->db_field_validate($registerRow['first_name'].' '.$registerRow['last_name']); ?></a>
				
				<div class="row row-actions">
					<div class="col-sm-12">
						<?php if($_SESSION['per_update'] == "1") { ?>
							<a href="register_form.php?mode=edit&regid=<?php echo $validation->db_field_validate($registerRow['regid']); ?>">Edit</a>
							 | 
						<?php } ?>
						<?php if($_SESSION['per_delete'] == "1") { ?>
							<a href="register_actions.php?q=del&regid=<?php echo $validation->db_field_validate($registerRow['regid']); ?>" onClick="return del();" class="delete">Delete</a>
							 | 
						<?php } ?>
						<a href="genealogy.php?regid=<?php echo $validation->db_field_validate($registerRow['regid']); ?>">Genealogy</a>
					</div>
				</div>
			</td>
			<td data-label="Membership ID - "><?php echo $validation->db_field_validate($registerRow['membership_id']); ?></td>
			<td data-label="Sponsor ID - "><?php echo $validation->db_field_validate($registerRow['sponsor_id']); ?></td>
			<td data-label="Email - "><?php echo $validation->db_field_validate($registerRow['email']); ?></td>
			<td data-label="Mobile No. - "><?php echo $validation->db_field_validate($registerRow['mobile']); ?></td>
			<td data-label="Downline Members - "><?php echo $validation->db_field_validate($registerRow['members']); ?></td>
			<td data-label="E-Wallet - ">
				Wallet Balance: &#8377;<?php echo $validation->price_format($registerRow['wallet_money']); ?>
				<br />
				Total Credit: &#8377;<?php echo $validation->price_format($registerRow['wallet_total']); ?>
				<br />
				Total Debit:&nbsp; &#8377;<?php echo $validation->price_format($registerRow['total_debit']); ?>
			</td>
			<td data-label="Status - "><font color="<?php if($registerRow['status'] == "active") { echo "green"; } else { echo "red"; } ?>"><?php echo $validation->db_field_validate(ucfirst($registerRow['status'])); ?></font></td>
			<td class="date" data-label="Date - "><?php echo $validation->date_format_custom($registerRow['createdate']); ?> <br class="mb-hidden" />(<?php echo $validation->timecount("{$registerRow['createdate']} {$registerRow['createtime']}"); ?>)</td>
		</tr>
		<?php
		}
	}
	else
	{
	?>
		<tr class="text-center">
			<td class="text-center" colspan="9">No Record is Available!</td>
		</tr>
	<?php
	}
	?>
	</tbody>
</table>
</div>
</form>

<hr />
<?php echo $data['content']; ?>
<hr />
</div>
</div>
</div>
</body>
</html>