<?php
$current = $received[0];
extract($current);
$account_plu_number_account_sale_list = displayOptions($accountsale, 0);
$account_plu_number_account_plu_group_list = displayOptions($accountplugroups, 0);

if ($form_error) {
    $danger_style = "alert alert-danger error";
    $display_modal = "block";
    $modal_mode = "in";
} else {
    $danger_style = $display_modal = $modal_mode = "";
}
?>

<!-- page heading start-->
<div class="page-heading">
    <h3> <?php echo $header_title; ?></h3>
    <ul class="breadcrumb">
        <li class="active">
            Accounts PLU Number
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
                    <!--Account: PLU Number-->
                    <div>
                        <div id="account_plu_number_loader"></div>
                        <div class="pull-right">

                            <div class="form-group ">
                                <div class="col-sm-12">
                                    <?php
                                    $buttons = "<a onclick=\"modalLoader('account_plu_number','#account_plu_number_modal','new',0);\" class=\"btn btn-default  \" type=\"button\"><i class=\"fa fa-plus\"></i>&nbsp;New</a>&nbsp;"; //                    
                                    if ($count >= 1) {
                                        $buttons.="<a id=\"account_plu_number_edit\" onclick=\"\" type=\"button\" class=\"btn btn-success \"><i class=\"fa fa-edit\"></i>&nbsp;Edit</a>&nbsp;";
                                        if (isset($_SESSION["delete_group"]) && $_SESSION["delete_group"] === '1') {
                                            $buttons.="<a id=\"account_plu_number_delete\"onclick=\"\" type=\"button\" class=\"btn btn-primary \"><i class=\"fa fa-trash-o\"></i>&nbsp;Delete</a>&nbsp;";
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
                    <div class="" id="account_plu_number_data">

                    </div>

                </div>
            </section>
        </div>

    </div>
</div>

<!--body wrapper end-->

<!-- account_plu_number_modal Modal -->
<div id="account_plu_number_modal" class="modal fade <?php echo $modal_mode; ?>"  role="dialog" style="display:<?php echo $display_modal; ?>;">
    <div class="modal-dialog"> 

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header panel-heading dark">
                <h4 class="modal-title" style="text-align:center">PLU Number</h4>
            </div>

            <div class="modal-body" > 
                <?php
                $attributes = array('class' => 'cmxform form-horizontal adminex-form', 'id' => 'account_plu_number_form');
                echo '<div id="error_div" class="' . $danger_style . '">' . $form_error . '</div>';
                echo form_open('app/processAccountPlu', $attributes);
                ?>

                <div class="panel-body">
                    <div class="form">
                        <input type="hidden" name="account_plu_number_ID"  id="account_plu_number_ID" value="<?php echo $ID; ?>">
                        <input type="hidden" name="account_plu_number_type" id="account_plu_number_type" value="<?php echo $type; ?>">
                        <input type="hidden" name="account_plu_number_action" id="account_plu_number_action" value="<?php echo $action; ?>">
                        <input type="hidden" name="account_plu_number_page_number" id="account_plu_number_page_number" value="<?php echo $page_number; ?>">

                        <div class="form-group ">
                            <label for="account_plu_number_title" class="col-sm-3 control-label">PLU No.</label>
                            <div class="col-sm-3">
                                <input class=" form-control" id="account_plu_number_title" value="<?php echo $title; ?>" name="account_plu_number_title" type="text" />
                            </div>

                            <label for="account_plu_number_account_plu_group" class="col-sm-3 control-label">PLU Group</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="account_plu_number_account_plu_group" id="account_plu_number_account_plu_group">
                                    <?php echo $account_plu_number_account_plu_group_list; ?>
                                </select>                                
                            </div> 
                        </div> 

                        <div class="form-group ">                         

                            <label for="account_plu_number_description" class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-9">
                                <input class=" form-control" id="account_plu_number_description" value="<?php echo $description; ?>" name="account_plu_number_description" type="text" />
                            </div>
                        </div> 

                        <div class="form-group ">
                            <label for="account_plu_number_price" class="col-lg-3 col-sm-3 control-label">Price</label>
                            <div class="col-lg-3 col-sm-3">
                                <input class=" form-control" id="account_plu_number_price" value="<?php echo $price; ?>" name="account_plu_number_price" type="text" />
                            </div>

                            <label for="account_plu_number_cost" class="col-lg-3 col-sm-3 control-label">Cost</label>
                            <div class="col-lg-3 col-sm-3">
                                <input class=" form-control" id="account_plu_number_cost" value="<?php echo $cost; ?>" name="account_plu_number_cost" type="text" />
                            </div>
                        </div> 

                        <div class="form-group "> 
                            <label for="account_plu_number_acctsale" class="col-sm-3 control-label">Account Name</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="account_plu_number_acctsale" id="account_plu_number_acctsale">
                                    <?php echo $account_plu_number_account_sale_list; ?>
                                </select>                                
                            </div>
                            
                            <label class="col-sm-3 control-label col-lg-3" for="account_plu_number_enable">Show</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="account_plu_number_enable" id="account_plu_number_enable">
                                    <option value="no" <?php
                                    if ($enable === "no") {
                                        echo 'selected';
                                    }
                                    ?>>NO</option>
                                    <option value="yes" <?php
                                    if ($enable === "yes") {
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
                    <button type="button" class="btn btn-default" onclick="closeModal('#account_plu_number_modal');">Close</button>
                </div>
                <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--role_modal modal-->
