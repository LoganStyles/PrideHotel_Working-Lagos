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
            Room Class
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
                    <!--Room Class-->
                    <div>
                        <div id="roomclass_loader"></div>
                        <div class="pull-right">

                            <div class="form-group ">
                                <div class="col-sm-12">
                                    <?php
                                    $buttons = "<a onclick=\"modalLoader('roomclass','#roomclass_modal','new',0);\" class=\"btn btn-default  \" type=\"button\"><i class=\"fa fa-plus\"></i>&nbsp;New</a>&nbsp;"; //                    
                                    if ($count >= 1) {                                        
                                        $buttons.="<a id=\"roomclass_edit\" onclick=\"\" type=\"button\" class=\"btn btn-success \"><i class=\"fa fa-edit\"></i>&nbsp;Edit</a>&nbsp;";
                                        if(isset($_SESSION["delete_group"]) && $_SESSION["delete_group"] === '1'){
                                            $buttons.="<a id=\"roomclass_delete\"onclick=\"\" type=\"button\" class=\"btn btn-primary \"><i class=\"fa fa-trash-o\"></i>&nbsp;Delete</a>&nbsp;";
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
                    <div class="" id="roomclass_data">

                    </div>

                </div>
            </section>
        </div>

    </div>
</div>

<!--body wrapper end-->

<!-- roomclass_modal Modal -->
<div id="roomclass_modal" class="modal fade <?php echo $modal_mode; ?>"  role="dialog" style="display:<?php echo $display_modal; ?>;">
    <div class="modal-dialog"> 

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header panel-heading dark">
                <h4 class="modal-title" style="text-align:center">Room Class</h4>
            </div>

            <div class="modal-body" > 
                <?php
                $attributes = array('class' => 'cmxform form-horizontal adminex-form', 'id' => 'roomclass_form');
                echo '<div id="error_div" class="' . $danger_style . '">' . $form_error . '</div>';
                echo form_open('app/process/roomclass', $attributes);
                ?>

                <div class="panel-body">
                    <div class="form">
                        <input type="hidden" name="roomclass_ID"  id="roomclass_ID" value="<?php echo $ID;?>">
                        <input type="hidden" name="roomclass_type" id="roomclass_type" value="<?php echo $type;?>">
                        <input type="hidden" name="roomclass_action" id="roomclass_action" value="<?php echo $action;?>">
                        <input type="hidden" name="roomclass_page_number" id="roomclass_page_number" value="<?php echo $page_number;?>">
                        <div class="form-group ">
                            <label for="roomclass_title" class="col-sm-3 control-label">Room Class</label>
                            <div class="col-sm-9">
                                <input class=" form-control" id="roomclass_title" value="<?php echo $title; ?>" name="roomclass_title" type="text" />
                            </div>
                        </div> 
                        

                        <div class="form-group ">
                            <label for="roomclass_description" class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10">
                                <input class=" form-control" id="roomclass_description" value="<?php echo $description; ?>" name="roomclass_description" type="text" />
                            </div>
                        </div>
                    </div>   
                </div>
                <div class="pull-right">
                    <input class="btn btn-success btn-sm" type="submit" name="submit" value="Save" />
                    <button type="button" class="btn btn-default" onclick="closeModal('#roomclass_modal');">Close</button>
                </div>
                <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--role_modal modal-->
