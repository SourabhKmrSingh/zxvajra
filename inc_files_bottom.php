<script src="<?php echo BASE_URL; ?>assets/js/jquery-3.3.1.min.js"></script>
<script src="<?php echo BASE_URL; ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo BASE_URL; ?>assets/js/jquery-ui.min.js"></script>
<script src="<?php echo BASE_URL; ?>assets/js/jquery.countdown.min.js"></script>
<script src="<?php echo BASE_URL; ?>assets/js/jquery.nice-select.min.js"></script>
<!--<script src="<?php echo BASE_URL; ?>assets/js/jquery.zoom.min.js"></script>-->
<script src="<?php echo BASE_URL; ?>assets/js/jquery.dd.min.js"></script>
<script src="<?php echo BASE_URL; ?>assets/js/jquery.slicknav.js"></script>
<script src="<?php echo BASE_URL; ?>assets/js/owl.carousel.min.js"></script>
<script src="<?php echo BASE_URL; ?>assets/js/main.js"></script>
<script src="<?php echo BASE_URL; ?>assets/js/notify.min.js"></script>

<?php echo $configRow['script']; ?>

<script>
var visitors= $(".visitors").html();
$(".visitors").html('');
for(i=0;i<=visitors.length-1; i++)
{
	var html = visitors.substr(i,1);
	var sp="<span class='visitors_count'>" + html
	sp+=" </span> &nbsp;";
	$(".visitors").append(sp);
}

$(window).bind("load", function(){
	$.notify("<?php echo @$_SESSION['notify_success_msg_fe']; ?>", { className: 'success', autoHide: true, autoHideDelay: 8000 });
	$.notify("<?php echo @$_SESSION['notify_error_msg_fe']; ?>", { className: 'error', autoHide: true, autoHideDelay: 8000 });
});

function get_quantity(productid, variantid, slr)
{
	if($("#quantity"+slr).val() == "10+")
	{
		$("#quantity"+slr).hide();
		$("#quantity_custom"+slr).show();
		$("#quantity_custom_btn"+slr).show();
	}
	else if($("#quantity"+slr).val() > 0)
	{
		location.replace("<?php echo BASE_URL; ?>cart_inter.php?token=<?php echo $csrf_token; ?>&id="+productid+"&id2="+variantid+"&qty="+$("#quantity"+slr).val());
	}
}
function get_quantity_product()
{
	if($("#quantity").val() == "10+")
	{
		$("#quantity").hide();
		$("#quantity_custom").show();
		$("#quantity_custom_btn").show();
	}
}
function get_quantitycustom(productid, variantid, slr)
{
	location.replace("<?php echo BASE_URL; ?>cart_inter.php?token=<?php echo $csrf_token; ?>&id="+productid+"&id2="+variantid+"&qty="+$("#quantity_custom"+slr).val());
}
</script>
<?php
@$_SESSION['notify_success_msg_fe'] = "";
@$_SESSION['notify_error_msg_fe'] = "";
?>