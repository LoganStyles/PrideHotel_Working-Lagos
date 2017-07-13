<?php
//site info
if (empty($site[0]["ID"])) {
    $site_id = 0;
    $site_street1 = "";
    $site_street2 = "";
    $site_state = "";
    $site_country = "";
    $site_tel1 = "";
    $site_tel2 = "";
    $site_logo = "";
    $site_title = "";
    $site_email = "";
    $site_url = "";
} else {
    $site_id = $site[0]["ID"];
    $site_street1 = $site[0]["street1"];
    $site_street2 = $site[0]["street2"];
    $site_state = $site[0]["state"];
    $site_country = $site[0]["country"];
    $site_tel1 = $site[0]["tel1"];
    $site_tel2 = $site[0]["tel2"];
    $site_logo = $site[0]["logo"];
    $site_title = $site[0]["title"];
    $site_email = $site[0]["email"];
    $site_url = $site[0]["url"];
}
$received_image = "";
if (!empty($site_logo)) {
    $received_image = base_url() . 'images/UPLOADS/' . $site[0]["logo"];
    $site_logo = "<img style=\"height:80px;max-width:100%;\" src=\"$received_image\" alt=\"Hotel Software logo\" >";
}

$curr_name = ($this->session->us_name) ? ($this->session->us_name) : ("");

function displayOptions($list, $id) {
    $options = "<option value=\"0\">None</option>";
    if (count($list) > 0) {
        $content = "";
        foreach ($list as $row) {
            $curr_ID = $row["ID"];
            $curr_title = ucwords($row["title"]);
            if ($id === $curr_ID) {
                $selected = "selected";
            } else {
                $selected = "";
            }
            $content.="<option value=\"$curr_ID\" $selected>$curr_title</option>";
        }
        $options = $content;
    }
    return $options;
}

function getTitle($titles, $id) {
    if (count($titles) > 0) {
        foreach ($titles as $row) {
            $curr_ID = $row["ID"];
            $curr_title = ucwords($row["title"]);
            if ($curr_ID == $id) {
                return $curr_title;
            }
        }
        return "";
    }
}


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="keywords" content="app, dashboard">
        <meta name="description" content="">
        <meta name="author" content="">

        <title><?php echo $site_title; ?></title>

        <!--dashboard calendar-->
        <link href="<?php echo base_url(); ?>css_admin/clndr.css" rel="stylesheet" type="text/css">

        <!--file upload-->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css_admin/bootstrap-fileupload.min.css" />

        <!--tags input-->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js_admin/jquery-tags-input/jquery.tagsinput.css" />

        <!--common-->
        <link href="<?php echo base_url(); ?>css_admin/style.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>css_admin/style-responsive.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>fonts/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>js_admin/jqwidgets/styles/jqx.base.css" rel="stylesheet">
        <link rel="shortcut icon" href="<?php echo $received_image; ?>" type="image/png"/>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="" style="background: #fff;">

        <!--body wrapper start-->
        <?php
        if (($paper_type=="letter")) {?>
        
        <div class="wrapper" style="margin-top: 220px;">
                    
        <?php }else{        ?>
        <div class="wrapper">
            <div class="row">
                <div class="col-sm-5"></div>
                <div class="col-sm-7">
                    <div class="logo">
                        <?php echo $site_logo; ?>                   
                    </div>
                </div>
            </div>

            <div class="row" style="font-size: 0.9em;margin-top: 40px;color: #000;">
                <div class="col-sm-9">
                    <div><?php echo $site_title; ?></div>
                    <div><?php echo $site_street1; ?></div>
                    <div><?php echo $site_street2; ?></div>
                    <div><?php echo $site_tel1 . ", " . $site_tel2; ?></div>
                    <div><?php echo $site_email . ", " . $site_url; ?></div>
                </div>
                <div class="col-sm-3">
                    <div>
                        <span><?php echo "(".ucwords($this->session->us_name).")"; ?></span>
                        <span><?php echo date("H:i");?></span>&nbsp;&nbsp;
                        <span><?php echo date("d/m/Y");?></span>
                    </div>

                </div>
            </div>
            <div class="row" style="font-size: 0.9em;color: #000;">
                <div class="col-sm-5"></div>
                <div class="col-sm-7"><?php echo $header_title;?></div>
            </div>
        <?php } ?>