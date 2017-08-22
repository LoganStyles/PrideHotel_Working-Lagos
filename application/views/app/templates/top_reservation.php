<?php
$current = $received[0];
extract($current);

$topbuttons = "";
$button_type_client = $button_type_confirmed = $button_type_new = $button_type_departing = "btn-primary";
$button_type_provisional = $button_type_Cancelled = $button_type_arriving = $button_type_all = $button_type_staying = "btn-primary";
if ($type == "person") {
    $button_type_client = "btn-success";
}
if ($header_title == "Confirmed") {
    $button_type_confirmed = "btn-success";
}

if ($header_title == "Departing") {
    $button_type_departing = "btn-success";
}

if ($header_title == "Provisional") {
    $button_type_provisional = "btn-success";
}

if ($header_title == "Cancelled") {
    $button_type_Cancelled = "btn-success";
}

if ($header_title == "Arriving") {
    $button_type_arriving = "btn-success";
}

if ($header_title == "All") {
    $button_type_all = "btn-success";
}

if ($header_title == "Staying") {
    $button_type_staying = "btn-success";
}

if ($header_title == "Guest" && $action == "insert") {
    $button_type_new = "btn-success";
}
?>
<!--top body wrapper start-->
<div class="wrapper" style="padding-top: 0px;">
    <div class="row">
        <div class="col-sm-12">
            <section class="panel" style="margin-bottom: 0px;border-bottom: 0px;background-color: #eff0f4;">
                <header class="panel-heading" style="padding: 0px;border-bottom: 0px;">  

                    <div>
                        <div class="row">
                            <div class="form-group ">
                                <div class="col-sm-12">
                                    <div>
                                        <span class="label label-default">Staying</span><span class="label label-success"><?php echo $room_stats['staying'];?></span>
                                        <span class="label label-default">Arr.Left</span><span class="label label-warning"><?php echo $room_stats['arrival'];?></span>
                                        <span class="label label-default">Dep.Left</span><span class="label label-warning"><?php echo $room_stats['departure'];?></span>
                                        <span class="label label-default">Vacant</span><span class="label label-success"><?php echo $room_stats['vacant'];?></span>
                                        <span class="label label-default">Occupancy</span><span class="label label-success"><?php echo $room_stats['occupancy'];?>%</span>
                                    </div>
                                </div><br><br>
                                <div class="col-sm-12">
                                    <?php
                                    $topbuttons .= "<a href=\" " . base_url() . 'resv/guest/new' . " \" type=\"button\" class=\"btn " . $button_type_new . " \"><i class=\"fa fa-user\"></i>&nbsp;New</a>&nbsp;";
                                    $topbuttons.="<a href=\" " . base_url() . 'resv/confirmed' . "\" type=\"button\" class=\"btn " . $button_type_confirmed . " \"><i class=\"fa fa-thumbs-up\"></i>&nbsp;Confirmed</a>&nbsp;";
                                    $topbuttons.="<a href=\" " . base_url() . 'resv/staying' . "\" type=\"button\" class=\"btn " . $button_type_staying . " \"><i class=\"fa fa-home\"></i>&nbsp;Staying Guest</a>&nbsp;";
                                    $topbuttons.="<a href=\" " . base_url() . 'resv/arriving' . "\" type=\"button\" class=\"btn " . $button_type_arriving . " \"><i class=\"fa fa-sign-in\"></i>&nbsp;Arriving Today</a>&nbsp;";
                                    $topbuttons.="<a href=\" " . base_url() . 'resv/departing' . "\" type=\"button\" class=\"btn " . $button_type_departing . " \"><i class=\"fa fa-sign-out\"></i>&nbsp;Departing Today</a>&nbsp;";
                                    $topbuttons.="<a href=\" " . base_url() . 'resv/cancelled' . "\" type=\"button\" class=\"btn " . $button_type_Cancelled . " \"><i class=\"fa fa-times-circle\"></i>&nbsp;Cancelled</a>&nbsp;";
                                    $topbuttons.="<a href=\" " . base_url() . 'resv/all' . "\" type=\"button\" class=\"btn " . $button_type_all . " \"><i class=\"fa fa-users\"></i>&nbsp;All</a>&nbsp;";
                                    echo $topbuttons;
                                    ?>
                                </div>
                            </div> 
                        </div>

                        <div class="row">
                            <div class="form-group " style="margin-top: 5px;">
                                <div class="col-sm-12">
                                    <?php
                                    $topbuttons = "<a href=\" " . base_url() . 'resv/person' . " \" type=\"button\" class=\"btn " . $button_type_client . " \"><i class=\"fa fa-sign-out\"></i>&nbspClients</a>&nbsp;";
                                    echo $topbuttons;
                                    ?>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </header>
            </section>
        </div>
    </div>
</div>
<!--top body wrapper end-->


