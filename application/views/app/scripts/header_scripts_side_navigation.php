<?php
$current = $received[0];
extract($current);
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
    $site_logo = "<img style=\"height:40px;max-width:100%;\" src=\"$received_image\" alt=\"Hotel Software logo\" >";
}

$curr_name = ($this->session->us_name) ? ($this->session->us_name) : ("");

function displayOptions($list, $id) {
    $options = "<option value=\"0\">None</option>";
    if (count($list) > 0) {
        $content = "";
        foreach ($list as $row) {
            $curr_ID = $row["ID"];
            $curr_title = ucwords($row["title"]);
            if ($id == $curr_ID) {
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

function getTitle($titles, $id, $result_type = NULL) {
    if (count($titles) > 0) {
        foreach ($titles as $row) {
            $curr_ID = $row["ID"];
            $curr_title = ucwords($row["title"]);
            if (!empty($result_type) && ($curr_ID == $id)) {
                $curr_type = strtoupper($row[$result_type]);
                return $curr_type;
            }
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

    <body class="sticky-header">
        <section>
            <!-- left side start-->
            <div class="left-side sticky-left-side">

                <!--logo and iconic logo start-->
                <div class="logo">
                    <a href="<?php
                    $url = base_url();
                    echo $url;
                    ?>">
<?php echo $site_logo . " " . date('d/m/Y', strtotime($app_date)); ?>
                    </a>                    
                </div>

                <div class="left-side-inner">

                    <!-- visible to small devices only -->
                    <div class="visible-xs hidden-sm hidden-md hidden-lg">
                        <div class="media logged-user">
                            <!--<img alt="" src="images/photos/user-avatar.png" class="media-object">-->
                            <div class="media-body">
                                <h4><a href="#"><?php echo $curr_name; ?></a></h4>
                            </div>
                        </div>
                    </div>

                    <!--sidebar nav start-->
                    <ul class="nav nav-pills nav-stacked custom-nav">
                        <li class="menu-list <?php
                        if ($module == 'reservation') {
                            echo 'nav-active';
                        }
                        ?>"><a href="#"><i class="fa fa-book"></i><span>Reservations</span></a>

                            <ul class="sub-menu-list">                                
                                <li class="<?php
                                if ($header_title == "Guest") {
                                    echo "active";
                                }
                                ?>"><a href="<?php echo base_url() . 'app'; ?>"> Guest Rooms</a></li>
                                <li class="<?php
                                if ($bar_title == "Group") {
                                    echo "active";
                                }
                                ?>"><a href="<?php echo base_url() . 'group'; ?>"> Groups</a></li>
                                <!--<li class="<?php
                                if ($type == "house_accounts") {
                                    echo "active";
                                }
                                ?>"><a href="#"> House Accounts</a></li>-->
                            </ul>
                        </li>

                        <li class="menu-list-altered <?php
                                if ($type == 'nightaudit') {
                                    echo 'nav-active';
                                }
                                ?>"><a href="<?php echo base_url() . 'app/night'; ?>"><i class="fa fa-moon-o"></i><span>Night Audit</span></a>                            
                        </li>

                        <?php if (isset($_SESSION["utilities"]) && $_SESSION["utilities"] > 1) { ?>

                            <li class="menu-list <?php
                            if ($header_title == 'Utilities') {
                                echo 'nav-active';
                            }
                            ?>"><a href="#"><i class="fa fa-home"></i><span>Utilities</span></a>

                                <ul class="sub-menu-list">                                
                                    <li class="<?php
                        if ($type == "housekeeping") {
                            echo "active";
                        }
                            ?>"><a href="<?php echo base_url() . 'app/housekeeping'; ?>"> Housekeeping</a></li>                                    

                                </ul>
                            </li>                        
                        <?php } ?>

                        <?php if (isset($_SESSION["monitors"]) && $_SESSION["monitors"] > 1) { ?>

                            <li class="menu-list-altered <?php
                            if ($header_title == 'Terminals') {
                                echo 'nav-active';
                            }
                            ?>"><a href="<?php echo base_url() . 'app/terminals'; ?>"><i class="fa fa-desktop"></i><span>Terminals</span></a>                            
                            </li>
                        <?php } ?>
                            
                            <li class="menu-list <?php
                        if ($module == 'ledger') {
                            echo 'nav-active';
                        }
                        ?>"><a href="#"><i class="fa fa-folder-open"></i><span>Ledger</span></a>

                            <ul class="sub-menu-list">                                
                                <li class="<?php
                                if ($header_title == 'Ledger Guest') {
                                    echo "active";
                                }
                                ?>"><a href="<?php echo base_url() . 'resv/ledger/guest'; ?>"> Guest Ledgers</a></li>
                                <li class="<?php
                                if ($header_title == 'Ledger Group') {
                                    echo "active";
                                }
                                ?>"><a href="<?php echo base_url() . 'resv/ledger/group'; ?>"> Group Ledgers</a></li>
                                
                            </ul>
                        </li>

<!--                        <li class="menu-list-altered <?php
                        if ($header_title == 'Ledger') {
                            echo 'nav-active';
                        }
                        ?>"><a href="<?php echo base_url() . 'resv/ledger'; ?>"><i class="fa fa-folder-open"></i><span>Ledger</span></a>                            
                        </li>-->

                        <?php if (isset($_SESSION["prices"]) && $_SESSION["prices"] > 1) { ?>

                            <li class="menu-list-altered <?php
                            if ($header_title == 'Price') {
                                echo 'nav-active';
                            }
                            ?>"><a href="<?php echo base_url() . 'app/prices'; ?>"><i class="fa fa-money"></i><span>Prices</span></a>                            
                            </li>
                        <?php } ?>

                        <?php if (isset($_SESSION["configuration"]) && $_SESSION["configuration"] > 1) { ?>
                            <li class="menu-list <?php
                            if ($header_title == 'Configuration') {
                                echo 'nav-active';
                            }
                            ?>"><a href="#"><i class="fa fa-cogs"></i><span>Configuration</span></a>

                                <ul class="sub-menu-list"> 
                                    <li class="<?php
                        if ($type == "account_class") {
                            echo "active";
                        }
                            ?>"><a href="<?php echo base_url() . 'app/account_class'; ?>"> Account Class</a></li>
                                    <li class="<?php
                                if ($type == "account_type") {
                                    echo "active";
                                }
                            ?>"><a href="<?php echo base_url() . 'app/account_type'; ?>"> Account Types</a></li>
                                    <li class="<?php
                                if ($type == "account_salescategory") {
                                    echo "active";
                                }
                            ?>"><a href="<?php echo base_url() . 'app/account_salescategory'; ?>"> Account Sales Categories</a></li>
                                    <li class="<?php
                                if ($type == "account_discount") {
                                    echo "active";
                                }
                            ?>"><a href="<?php echo base_url() . 'app/account_discount'; ?>"> Discount Categories</a></li>

                                    <li class="<?php
                                if ($type == "account_sale") {
                                    echo "active";
                                }
                            ?>"><a href="<?php echo base_url() . 'app/showAccountsale/account_sale'; ?>"> Sale Accounts</a></li>

                                    <li class="<?php
                                if ($type == "account_payment") {
                                    echo "active";
                                }
                            ?>"><a href="<?php echo base_url() . 'app/showAccountpayment/account_payment'; ?>"> Payment Accounts</a></li> 

                                    <li class="<?php
                                if ($type == "account_plu_group") {
                                    echo "active";
                                }
                            ?>"><a href="<?php echo base_url() . 'app/account_plu_group'; ?>"> PLU Groups</a></li>

                                    <li class="<?php
                                if ($type == "account_plu_number") {
                                    echo "active";
                                }
                            ?>"><a href="<?php echo base_url() . 'app/showAccountplu/account_plu_number'; ?>"> PLU Numbers</a></li>

                                    <li class="<?php
                                if ($type == "site") {
                                    echo "active";
                                }
                            ?>"><a href="<?php echo base_url() . 'app/showSite/1/site'; ?>"> Hotel Info</a></li>
                                    <li class="<?php
                                if ($type == "role") {
                                    echo "active";
                                }
                            ?>"><a href="<?php echo base_url() . 'app/showRole/role'; ?>"> User Groups</a></li>
                                    <li class="<?php
                                if ($type == "user") {
                                    echo "active";
                                }
                            ?>"><a href="<?php echo base_url() . 'app/showUser/user'; ?>"> Users</a></li>

                                    <li class="<?php
                                if ($type == "roomclass") {
                                    echo "active";
                                }
                            ?>"><a href="<?php echo base_url() . 'app/roomclass'; ?>"> Room Class</a></li>

                                    <li class="<?php
                                if ($type == "roomtype") {
                                    echo "active";
                                }
                            ?>"><a href="<?php echo base_url() . 'app/showRoomtype/roomtype'; ?>"> Room Types</a></li>
                                    <li class="<?php
                                if ($type == "room") {
                                    echo "active";
                                }
                            ?>"><a href="<?php echo base_url() . 'app/showRoom/room'; ?>"> Rooms</a></li>  

                                </ul>
                            </li>
                        <?php } ?>


                        <li class="menu-list-altered <?php
                        if ($header_title == 'Reports') {
                            echo 'nav-active';
                        }
                        ?>"><a href="<?php echo base_url() . 'resv/reports'; ?>"><i class="fa fa-files-o"></i><span>Reports</span></a>                            
                        </li>
                    </ul>
                    <!--sidebar nav end-->

                </div>
            </div>
            <!-- left side end-->

            <!-- main content start-->
            <div class="main-content" >

                <!-- header section start-->
                <div class="header-section">

                    <!--toggle button start-->
                    <a class="toggle-btn"><i class="fa fa-bars"></i></a>
                    <!--toggle button end-->
                    <!--notification menu start allow this line for forward compatibility-->

                    <div class="menu-right">
                        <ul class="notification-menu">

                            <li>
                                <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?php echo base_url(); ?>images/avatars/avatar.png" alt="" />
                                    <?php echo $curr_name; ?>
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                                    <li><a href="<?php echo base_url() . 'app'; ?>"> Change Password</a></li>
                                    <li><a href="<?php echo base_url() . 'app/logout'; ?>"><i class="fa fa-sign-out"></i> Log Out</a></li>
                                </ul>
                            </li>

                        </ul>
                    </div>
                    <div class="clearfix"></div>

                    <!--notification menu end -->

                </div>
                <!-- header section end-->