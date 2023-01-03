<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<?php if($configRow['favicon'] != "") { ?>
<link rel="icon" href="<?php echo BASE_URL.IMG_MAIN_LOC.$validation->db_field_validate($configRow['favicon']); ?>" type="image/x-icon" />
<?php } ?>
<?php if($configRow['google_indexing'] == "1") { ?>
<meta name="robots" content="noindex" />
<?php } ?>
<link rel="canonical" href="<?php echo $full_url; ?>" />

<link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/font-awesome.min.css" type="text/css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/themify-icons.css" type="text/css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/elegant-icons.css" type="text/css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/owl.carousel.min.css" type="text/css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/nice-select.css" type="text/css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/jquery-ui.min.css" type="text/css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/slicknav.min.css" type="text/css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css" type="text/css">

<?php echo $configRow['style']; ?>
