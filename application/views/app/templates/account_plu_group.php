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
            Account PLU Group
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
                    <!--Account PLU Group-->
                    <div>
                        <div id="account_plu_group_loader"></div>
                        <div class="pull-right">

                            <div class="form-group ">
                                <div class="col-sm-12">
                                    <?php
                                    $buttons = "<a onclick=\"modalLoader('account_plu_group','#account_plu_group_modal','new',0);\" class=\"btn btn-default  \" type=\"button\"><i class=\"fa fa-plus\"></i>&nbsp;New</a>&nbsp;"; //                    
                                    if ($count >= 1) {                                        
                                        $buttons.="<a id=\"account_plu_group_edit\" onclick=\"\" type=\"button\" class=\"btn btn-success \"><i class=\"fa fa-edit\"></i>&nbsp;Edit</a>&nbsp;";
                                        if(isset($_SESSION["delete_group"]) && $_SESSION["delete_group"] === '1'){
                                            $buttons.="<a id=\"account_plu_group_delete\"onclick=\"\" type=\"button\" class=\"btn btn-primary \"><i class=\"fa fa-trash-o\"></i>&nbsp;Delete</a>&nbsp;";
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
                    <div class="" id="account_plu_group_data">

                    </div>

                </div>
            </section>
        </div>

    </div>
</div>

<!--body wrapper end-->

<!-- account_plu_group_modal Modal -->
<div id="account_plu_group_modal" class="modal fade <?php echo $modal_mode; ?>"  account_plu_group="dialog" style="display:<?php echo $display_modal; ?>;">
    <div class="modal-dialog"> 

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header panel-heading dark">
                <h4 class="modal-title" style="text-align:center">PLU Group</h4>
            </div>

            <div class="modal-body" > 
                <?php
                $attributes = array('class' => 'cmxform form-horizontal adminex-form', 'id' => 'account_plu_group_form');
                echo '<div id="error_div" class="' . $danger_style . '">' . $form_error . '</div>';
                echo form_open('app/process/account_plu_group', $attributes);
                ?>

                <div class="panel-body">
                    <div class="form">
                        <input type="hidden" name="account_plu_group_ID"  id="account_plu_group_ID" value="<?php echo $ID;?>">
                        <input type="hidden" name="account_plu_group_type" id="account_plu_group_type" value="<?php echo $type;?>">
                        <input type="hidden" name="account_plu_group_action" id="account_plu_group_action" value="<?php echo $action;?>">
                        <input type="hidden" name="account_plu_group_page_number" id="account_plu_group_page_number" value="<?php echo $page_number;?>">
                        <div class="form-group">
                            <label for="account_plu_group_title" class="col-sm-2 control-label">Account Discount</label>
                            <div class="col-sm-10">
                                <input class=" form-control" id="account_plu_group_title" value="<?php echo $title; ?>" name="account_plu_group_title" type="text" />
                            </div>
                        </div> 

                        <div class="form-group">
                            <label for="account_plu_group_description" class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10">
                                <input class=" form-control" id="account_plu_group_description" value="<?php echo $description; ?>" name="account_plu_group_description" type="text" />
                            </div>
                        </div>
                    </div>   
                </div>
                <div class="pull-right">
                    <input class="btn btn-success btn-sm" type="submit" name="submit" value="Save" />
                    <button type="button" class="btn btn-default" onclick="closeModal('#account_plu_group_modal');">Close</button>
                </div>
                <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--account_plu_group_modal modal-->
