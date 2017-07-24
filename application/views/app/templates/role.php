<?php
$current = $received[0];
extract($current);

if ($form_error) {
    $danger_style = "alert alert-danger error";
    $display_modal="block";
    $modal_mode="in";
} else {
    $danger_style = $display_modal=$modal_mode="";
}
?>

<!-- page heading start-->
<div class="page-heading">
    <h3> <?php echo $header_title; ?></h3>
    <ul class="breadcrumb">
        <li class="active">
            User Groups
        </li>
    </ul>
</div>
<!-- page heading end-->

<!--body wrapper start-->
<div class="wrapper">

    <div class="row">
        <div class="col-sm-10">
            <section class="panel">
                <header class="panel-heading">
                    <!--User Groups-->
                    <div>
                        <div id="role_loader"></div>
                        <div class="pull-right">

                            <div class="form-group ">
                                <div class="col-sm-12">
                                    <?php
                                    $buttons = "<a onclick=\"modalLoader('role','#role_modal','new',0);\" class=\"btn btn-default  \" type=\"button\"><i class=\"fa fa-plus\"></i>&nbsp;New</a>&nbsp;"; //                    
                                    if ($count >= 1) {                                        
                                        $buttons.="<a id=\"role_edit\" onclick=\"\" type=\"button\" class=\"btn btn-success \"><i class=\"fa fa-edit\"></i>&nbsp;Edit</a>&nbsp;";
                                        if(isset($_SESSION["delete_group"]) && $_SESSION["delete_group"] === '1'){
                                            $buttons.="<a id=\"role_delete\"onclick=\"\" type=\"button\" class=\"btn btn-primary \"><i class=\"fa fa-trash-o\"></i>&nbsp;Delete</a>&nbsp;";
                                        }                                        
                                    }
                                    echo $buttons;
                                    ?>
                                </div>
                            </div>


                        </div>
                        <div class="clearfix"></div>

                    </div>
                </header>

                <div class="panel-body">
                    <div class="" id="role_data">

                    </div>

                </div>
            </section>
        </div>

    </div>
</div>

<!--body wrapper end-->

<!-- role_modal Modal -->
<div id="role_modal" class="modal fade <?php echo $modal_mode; ?>"  role="dialog" style="display:<?php echo $display_modal; ?>;">
    <div class="modal-dialog"> 

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header panel-heading dark">
                <h4 class="modal-title" style="text-align:center">User Group</h4>
            </div>

            <div class="modal-body" > 
                <?php
                $attributes = array('class' => 'cmxform form-horizontal adminex-form', 'id' => 'role_form');
                echo '<div id="error_div" class="' . $danger_style . '">' . $form_error . '</div>';
                echo form_open('app/processRole', $attributes);
                ?>

                <div class="panel-body">
                    <div class="form">
                        <input type="hidden" name="role_ID"  id="role_ID" value="<?php echo $ID;?>">
                        <input type="hidden" name="role_type" id="role_type" value="<?php echo $type;?>">
                        <input type="hidden" name="role_action" id="role_action" value="<?php echo $action;?>">
                        <input type="hidden" name="role_page_number" id="role_page_number" value="<?php echo $page_number;?>">
                        <div class="form-group ">
                            <label for="role_title" class="col-sm-2 control-label">User Group</label>
                            <div class="col-sm-10">
                                <input class=" form-control" id="role_title" value="<?php echo $title; ?>" name="role_title" type="text" />
                            </div>
                        </div> 

                        <div class="form-group ">
                            <label for="role_description" class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10">
                                <input class=" form-control" id="role_description" value="<?php echo $description; ?>" name="role_description" type="text" />
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="col-sm-3 control-label col-lg-3" for="role_reserv_folio">Reservations & Folio</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="role_reserv_folio" id="role_reserv_folio">
                                    <option value="1" <?php
                                    if ($reserv_folio === "1") {
                                        echo 'selected';
                                    }
                                    ?>>NONE</option>
                                    <option value="2" <?php
                                    if ($reserv_folio === "2") {
                                        echo 'selected';
                                    }
                                    ?>>READ</option>
                                    <option value="3" <?php
                                    if ($reserv_folio === "3") {
                                        echo 'selected';
                                    }
                                    ?>>WRITE</option>
                                    <option value="4" <?php
                                    if ($reserv_folio === "4") {
                                        echo 'selected';
                                    }
                                    ?>>SPECIAL</option>
                                </select>
                            </div>
                        
                            <label class="col-sm-3 control-label col-lg-3" for="role_reports">Reports</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="role_reports" id="role_reports">
                                    <option value="1" <?php
                                    if ($reports === "1") {
                                        echo 'selected';
                                    }
                                    ?>>NONE</option>
                                    <option value="2" <?php
                                    if ($reports === "2") {
                                        echo 'selected';
                                    }
                                    ?>>READ</option>
                                    
                                </select>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="col-sm-3 control-label col-lg-3" for="role_utilities">Utilities</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="role_utilities" id="role_utilities">
                                    <option value="1" <?php
                                    if ($utilities === "1") {
                                        echo 'selected';
                                    }
                                    ?>>NONE</option>
                                    <option value="2" <?php
                                    if ($utilities === "2") {
                                        echo 'selected';
                                    }
                                    ?>>READ</option>
                                    <option value="3" <?php
                                    if ($utilities === "3") {
                                        echo 'selected';
                                    }
                                    ?>>WRITE</option>
                                    <option value="4" <?php
                                    if ($utilities === "4") {
                                        echo 'selected';
                                    }
                                    ?>>SPECIAL</option>
                                </select>
                            </div>
                        
                            <label class="col-sm-3 control-label col-lg-3" for="role_maintenance">Maintenance</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="role_maintenance" id="role_maintenance">
                                    <option value="1" <?php
                                    if ($maintenance === "1") {
                                        echo 'selected';
                                    }
                                    ?>>NONE</option>
                                    <option value="2" <?php
                                    if ($maintenance === "2") {
                                        echo 'selected';
                                    }
                                    ?>>READ</option>
                                    <option value="3" <?php
                                    if ($maintenance === "3") {
                                        echo 'selected';
                                    }
                                    ?>>WRITE</option>
                                    <option value="4" <?php
                                    if ($maintenance === "4") {
                                        echo 'selected';
                                    }
                                    ?>>SPECIAL</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="col-sm-3 control-label col-lg-3" for="role_monitors">Monitors</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="role_monitors" id="role_monitors">
                                    <option value="1" <?php
                                    if ($monitors === "1") {
                                        echo 'selected';
                                    }
                                    ?>>NONE</option>
                                    <option value="2" <?php
                                    if ($monitors === "2") {
                                        echo 'selected';
                                    }
                                    ?>>READ</option>
                                    <option value="3" <?php
                                    if ($monitors === "3") {
                                        echo 'selected';
                                    }
                                    ?>>WRITE</option>
                                    <option value="4" <?php
                                    if ($monitors === "4") {
                                        echo 'selected';
                                    }
                                    ?>>SPECIAL</option>
                                </select>
                            </div>
                        
                            <label class="col-sm-3 control-label col-lg-3" for="role_configuration">Configuration</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="role_configuration" id="role_configuration">
                                    <option value="1" <?php
                                    if ($configuration === "1") {
                                        echo 'selected';
                                    }
                                    ?>>NONE</option>
                                    <option value="2" <?php
                                    if ($configuration === "2") {
                                        echo 'selected';
                                    }
                                    ?>>READ</option>
                                    <option value="3" <?php
                                    if ($configuration === "3") {
                                        echo 'selected';
                                    }
                                    ?>>WRITE</option>
                                    <option value="4" <?php
                                    if ($configuration === "4") {
                                        echo 'selected';
                                    }
                                    ?>>SPECIAL</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="col-sm-3 control-label col-lg-3" for="role_prices">Prices</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="role_prices" id="role_prices">
                                    <option value="1" <?php
                                    if ($prices === "1") {
                                        echo 'selected';
                                    }
                                    ?>>NONE</option>
                                    <option value="2" <?php
                                    if ($prices === "2") {
                                        echo 'selected';
                                    }
                                    ?>>READ</option>
                                    <option value="3" <?php
                                    if ($prices === "3") {
                                        echo 'selected';
                                    }
                                    ?>>WRITE</option>
                                    <option value="4" <?php
                                    if ($prices === "4") {
                                        echo 'selected';
                                    }
                                    ?>>SPECIAL</option>
                                </select>
                            </div>
                        
                            <label class="col-sm-3 control-label col-lg-3" for="role_overview">Overview</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="role_overview" id="role_overview">
                                    <option value="1" <?php
                                    if ($prices === "1") {
                                        echo 'selected';
                                    }
                                    ?>>NONE</option>
                                    <option value="2" <?php
                                    if ($prices === "2") {
                                        echo 'selected';
                                    }
                                    ?>>READ</option>
                                    <option value="3" <?php
                                    if ($prices === "3") {
                                        echo 'selected';
                                    }
                                    ?>>WRITE</option>
                                    <option value="4" <?php
                                    if ($prices === "4") {
                                        echo 'selected';
                                    }
                                    ?>>SPECIAL</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="col-sm-3 control-label col-lg-3" for="role_delete_group">Delete</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="role_delete_group" id="role_delete_group">
                                    <option value="0" <?php
                                    if ($delete_group === "0") {
                                        echo 'selected';
                                    }
                                    ?>>NO</option>
                                    <option value="1" <?php
                                    if ($delete_group === "1") {
                                        echo 'selected';
                                    }
                                    ?>>YES</option>
                                    
                                </select>
                            </div>
                        </div>
                    </div>   
                </div>
                <div class="pull-right">
                    <input class="btn btn-success btn-sm" type="submit" name="submit" value="Save" />
                    <button type="button" class="btn btn-default" onclick="closeModal('#role_modal');">Close</button>
                </div>
                <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--role_modal modal-->
