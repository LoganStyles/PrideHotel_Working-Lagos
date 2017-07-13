<?php
$current = $received[0];
extract($current);
$topbuttons="";

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
                                    $topbuttons .= "<a onclick=\"showSingleDialog('confirm','backup');\" type=\"button\" class=\"btn btn-primary\"><i class=\"fa fa-upload\"></i>&nbsp;File Backup</a>&nbsp;";
                                    $topbuttons.="<a onclick=\"showSingleDialog('confirm','charge');\" type=\"button\" class=\"btn btn-primary\"><i class=\"fa fa-check\"></i>&nbsp;Automatic Charges</a>&nbsp;";
                                    $topbuttons.="<a onclick=\"showSingleDialog('confirm','close');\" type=\"button\" class=\"btn btn-primary\"><i class=\"fa fa-folder-open\"></i>&nbsp;Close Account</a>&nbsp;";
                                    echo $topbuttons;
                                    
                                        if (isset($_SESSION["form_success"])) {
                                        echo "<br><br><div class=\"alert alert-success\">" . $this->session->form_success . "</div>";
                                    }
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


