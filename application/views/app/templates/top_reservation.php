<?php
$current = $received[0];
extract($current);

$topbuttons = "";
$button_type_client=$button_type_confirmed=$button_type_new="btn-primary";
if ($type=="person") {
    $button_type_client="btn-success";
}
if ($header_title=="Confirmed") {
    $button_type_confirmed="btn-success";
}

if ($header_title=="Guest") {
    $button_type_new="btn-success";
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
                                    <?php
                                    $topbuttons .= "<a href=\" " . base_url() . 'resv/guest' . " \" type=\"button\" class=\"btn ".$button_type_new." \"><i class=\"fa fa-user\"></i>&nbsp;New</a>&nbsp;";
                                    $topbuttons.="<a href=\" " . base_url() . 'resv/confirmed' . "\" type=\"button\" class=\"btn ".$button_type_confirmed." \"><i class=\"fa fa-thumbs-up\"></i>&nbsp;Confirmed</a>&nbsp;";
                                    $topbuttons.="<a href=\" " . base_url() . 'resv/arriving' . "\" type=\"button\" class=\"btn btn-primary \"><i class=\"fa fa-sign-in\"></i>&nbsp;Arriving Today</a>&nbsp;";
                                    $topbuttons.="<a id=\"housekeeping_print\" onclick=\"printAll('room');\" type=\"button\" class=\"btn btn-primary \"><i class=\"fa fa-home\"></i>&nbsp;Staying Guest</a>&nbsp;";
                                    $topbuttons.="<a href=\" " . base_url() . 'resv/departing' . "\" type=\"button\" class=\"btn btn-primary \"><i class=\"fa fa-sign-out\"></i>&nbsp;Departing Today</a>&nbsp;";
                                    $topbuttons.="<a id=\"housekeeping_block\" onclick=\"\" type=\"button\" class=\"btn btn-primary \"><i class=\"fa fa-star-half-full\"></i>&nbsp;Provisional</a>&nbsp;";
                                    $topbuttons.="<a id=\"housekeeping_block\" onclick=\"\" type=\"button\" class=\"btn btn-primary \"><i class=\"fa fa-times-circle\"></i>&nbsp;Cancelled</a>&nbsp;"; #
                                    $topbuttons.="<a id=\"housekeeping_block\" onclick=\"\" type=\"button\" class=\"btn btn-primary \"><i class=\"fa fa-users\"></i>&nbsp;All</a>&nbsp;";
                                    echo $topbuttons;
                                    ?>
                                </div>
                            </div> 
                        </div>

                        <div class="row">
                            <div class="form-group " style="margin-top: 5px;">
                                <div class="col-sm-12">
                                    <?php
                                    $topbuttons = "<a href=\" " . base_url() . 'resv/client' . " \" type=\"button\" class=\"btn ".$button_type_client." \"><i class=\"fa fa-sign-out\"></i>&nbspClients</a>&nbsp;";

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


