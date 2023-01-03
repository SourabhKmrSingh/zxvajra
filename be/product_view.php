<?php
include_once("inc_config.php");
include_once("login_user_check.php");

$_SESSION['active_menu'] = "product";

echo $validation->read_permission();

@$orderby = $validation->input_validate($_GET['orderby']);
@$order = $validation->input_validate($_GET['order']);

@$userid = $validation->input_validate($_GET['userid']);
@$categoryid = $validation->input_validate($_GET['categoryid']);
@$subcategoryid = $validation->input_validate($_GET['subcategoryid']);
@$title = strtolower($validation->input_validate($_GET['title']));
@$title_id = strtolower($validation->input_validate($_GET['title_id']));
@$status = strtolower($validation->input_validate($_GET['status']));
@$datefrom = $validation->input_validate($_GET['datefrom']);
@$dateto = $validation->input_validate($_GET['dateto']);

$where_query = "";
if($userid != "")
{
	$where_query .= " and userid = '$userid'";
}
if($categoryid != "")
{
	$where_query .= " and categoryid = '$categoryid'";
}
if($subcategoryid != "")
{
	$where_query .= " and subcategoryid = '$subcategoryid'";
}
if($title != "")
{
	$where_query .= " and LOWER(title) LIKE '%$title%'";
}
if($title_id != "")
{
	$where_query .= " and title_id = '$title_id'";
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
	$orderby_final = "productid desc";
}

$param1 = "title";
$param2 = "order_custom";
$param3 = "createdate";
$param4 = "stock_quantity";
include_once("inc_sorting.php");

$table = "rb_products";
$id = "productid";
$url_parameters = "&userid=$userid&categoryid=$categoryid&subcategoryid=$subcategoryid&title=$title&title_id=$title_id&status=$status&datefrom=$datefrom&dateto=$dateto";

$data = $pagination->main($table, $url_parameters, $where_query, $id, $orderby_final);

echo $validation->search_filter_enable();

$variantResult = $db->view('variantid', 'rb_products_variants', 'variantid', "and stock_quantity <= 5 and productid IN (select productid from rb_products)");
$variantCount = $variantResult['num_rows'];
?>
<!DOCTYPE html>
<html LANG="en">
<head>
<?php include_once("inc_title.php"); ?>
<?php include_once("inc_files.php"); ?>
<style>
.stock_count
{
	font-size:9px;
	vertical-align:text-top;
}
</style>
</head>
<body>
<div ID="wrapper">
<?php include_once("inc_header.php"); ?>
<div ID="page-wrapper">
<div CLASS="container-fluid">
<div CLASS="row">
	<div CLASS="col-lg-12">
		<h1 CLASS="page-header">Products <?php if($_SESSION['per_write'] == "1") { ?><a href="product_form.php?mode=insert" class="btn btn-default btn-sm button">Add New</a><?php } ?></h1>
	</div>
</div>

<form name="form_actions" method="POST" action="product_actions.php" ENCTYPE="MULTIPART/FORM-DATA">
<div class="row">
	<div class="col-sm-10 mb-0">
		<div class="form-inline">
			<select NAME="bulk_actions" CLASS="form-control mb_inline mb-2" >
				<option VALUE="">Bulk Actions</option>
				<option VALUE="delete">Delete</option>
				<option VALUE="active">Status to Active</option>
				<option VALUE="inactive">Status to Inactive</option>
			</select>
			<button type="submit" class="btn btn-default mb_inline btn-sm btn_submit mb-2 mr-4">Apply</button>
			
			<input type="text" name="title" class="form-control mb_inline mb-2" placeholder="Title" value="<?php echo $title; ?>" />
			<input type="text" name="title_id" class="form-control mb_inline mb-2" placeholder="Title ID" value="<?php echo $title_id; ?>" />
			<select NAME="status" CLASS="form-control mb_inline mb-2">
				<option VALUE="" <?php if($status=='') echo "selected"; ?>>Status</option>
				<option VALUE="active" <?php if($status=="active") echo "selected"; ?>>Active</option>
				<option VALUE="inactive" <?php if($status=="inactive") echo "selected"; ?>>Inactive</option>
			</select>
			<p class="pt-2">From&nbsp;</p> <input type="date" name="datefrom" class="form-control mb_inline mb-2" placeholder="From" value="<?php echo $datefrom; ?>" />
			<p class="pt-2">To&nbsp;</p> <input type="date" name="dateto" class="form-control mb_inline mb-2" placeholder="To" value="<?php echo $dateto; ?>" />
			<input type="submit" value="Filter" class="btn btn-default mb_inline btn-sm btn_submit ml-sm-2 ml-md-0 mb-2 mr-1" />
			<a href="product_view.php" class="btn btn-default mb_inline btn-sm btn_delete ml-sm-2 ml-md-0 mb-2">Clear</a>
		</div>
	</div>
	<div class="col-sm-2 mb-0 text-right">
		<a href="product_stock_view.php" class="btn btn-default mb_inline btn-sm btn_delete ml-sm-2 ml-md-0 mb-2">Stock Alerts <span class="stock_count">(<?php echo $variantCount; ?>)</span></a>
	</div>
</div>

<div class="table-responsive">
<table class="table table-striped table-view" cellspacing="0" width="100%">
	<thead>
	<tr>
		<th class="check-row text-center"><input type="checkbox" name="select_all" onClick="selectall(this);" /></th>
		<th class="<?php echo $th_sort1." ".$th_order_cls1; ?>"><a href="product_view.php?orderby=title&order=<?php echo $th_order1; echo $url_parameters; ?>"><span>Title</span> <span class="sorting-indicator"></span></a></th>
		<th>Author</th>
		<th class="<?php echo $th_sort2." ".$th_order_cls2; ?>"><a href="product_view.php?orderby=order_custom&order=<?php echo $th_order2; echo $url_parameters; ?>"><span>Order</span> <span class="sorting-indicator"></span></a></th>
		<th>Title ID</th>
		<th>Price</th>
		<th>Category</th>
		<th>Sub-Category</th>
		<th class="<?php echo $th_sort4." ".$th_order_cls4; ?>"><a href="product_view.php?orderby=stock_quantity&order=<?php echo $th_order4.''.$url_parameters; ?>"><span>Stock</span> <span class="sorting-indicator"></span></a></th>
		<th>Status</th>
		<th class="<?php echo $th_sort3." ".$th_order_cls3; ?>"><a href="product_view.php?orderby=createdate&order=<?php echo $th_order3.''.$url_parameters; ?>"><span>Date</span> <span class="sorting-indicator"></span></a></th>
	</tr>
	</thead>
	<tbody>
	<?php
	if($data['num_rows'] >= 1)
	{
		foreach($data['result'] as $productRow)
		{
			$userid = $productRow['userid'];
			$userQueryResult = $db->view("display_name", "rb_users", "userid", "and userid='{$userid}'");
			$userRow = $userQueryResult['result'][0];
			
			$categoryid = $productRow['categoryid'];
			$categoryQueryResult = $db->view("title", "rb_categories", "categoryid", "and categoryid='{$categoryid}'");
			$categoryRow = $categoryQueryResult['result'][0];
			
			$subcategoryid = $productRow['subcategoryid'];
			$subcategoryQueryResult = $db->view("title", "rb_subcategories", "subcategoryid", "and subcategoryid='{$subcategoryid}'");
			$subcategoryRow = $subcategoryQueryResult['result'][0];
		?>
		<tr class="text-center has-row-actions">
			<td class="text-center" data-label=""><input type="checkbox" name="del_items[]" value="<?php echo $validation->db_field_validate($productRow['productid']); ?>"/></td>
			<td data-label="Title - ">
				<a href="product_form.php?mode=edit&productid=<?php echo $validation->db_field_validate($productRow['productid']); ?>" class="fw-500"><?php echo $validation->db_field_validate($productRow['title']); ?></a>
				
				<div class="row row-actions">
					<div class="col-sm-12">
						<?php if($_SESSION['per_update'] == "1") { ?>
							<a href="product_form.php?mode=edit&productid=<?php echo $validation->db_field_validate($productRow['productid']); ?>">Edit</a>
							 | 
						<?php } ?>
						<?php if($_SESSION['per_delete'] == "1") { ?>
							<a href="product_actions.php?q=del&productid=<?php echo $validation->db_field_validate($productRow['productid']); ?>" onClick="return del();" class="delete">Delete</a>
							 | 
						<?php } ?>
						<a href="product_review_view.php?productid=<?php echo $validation->db_field_validate($productRow['productid']); ?>">Reviews</a>
					</div>
				</div>
			</td>
			<td data-label="Author - "><a href="product_view.php?userid=<?php echo $userid; ?>"><?php echo $validation->db_field_validate($userRow['display_name']); ?></a></td>
			<td data-label="Order - "><?php echo $validation->db_field_validate($productRow['order_custom']); ?></td>
			<td data-label="Title ID - "><?php echo $validation->db_field_validate($productRow['title_id']); ?></td>
			<td data-label="Price - "><?php if($productRow['currency_code'] == 'INR') echo '&#8377;'; else $validation->db_field_validate($productRow['currency_code']); ?><?php echo $validation->price_format($productRow['price']); ?></td>
			<td data-label="Category - "><a href="product_view.php?categoryid=<?php echo $categoryid; ?>"><?php echo $validation->db_field_validate($categoryRow['title']); ?></a></td>
			<td data-label="Sub-Category - "><a href="product_view.php?subcategoryid=<?php echo $subcategoryid; ?>"><?php echo $validation->db_field_validate($subcategoryRow['title']); ?></a></td>
			<td data-label="Stock - "><?php echo $validation->db_field_validate($productRow['stock_quantity']); ?></td>
			<td data-label="Status - "><font color="<?php if($productRow['status'] == "active") { echo "green"; } else { echo "red"; } ?>"><?php echo $validation->db_field_validate(ucfirst($productRow['status'])); ?></font></td>
			<td class="date" data-label="Date - "><?php echo $validation->date_format_custom($productRow['createdate']); ?> <br class="mb-hidden" />(<?php echo $validation->timecount("{$productRow['createdate']} {$productRow['createtime']}"); ?>)</td>
		</tr>
		<?php
		}
	}
	else
	{
	?>
		<tr class="text-center">
			<td class="text-center" colspan="10">No Record is Available!</td>
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