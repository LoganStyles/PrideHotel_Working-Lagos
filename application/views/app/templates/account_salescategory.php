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
            Account Sales Category
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
                    <!--Account Discounts-->
                    <div>
                        <div id="account_salescategory_loader"></div>
                        <div class="pull-right">

                            <div class="form-group ">
                                <div class="col-sm-12">
                                    <?php
                                    $buttons = "<a onclick=\"modalLoader('account_salescategory','#account_salescategory_modal','new',0);\" class=\"btn btn-default  \" type=\"button\"><i class=\"fa fa-plus\"></i>&nbsp;New</a>&nbsp;"; //                    
                                    if ($count >= 1) {                                        
                                        $buttons.="<a id=\"account_salescategory_edit\" onclick=\"\" type=\"button\" class=\"btn btn-success \"><i class=\"fa fa-edit\"></i>&nbsp;Edit</a>&nbsp;";
                                        if(isset($_SESSION["delete_group"]) && $_SESSION["delete_group"] === '1'){
                                            $buttons.="<a id=\"account_salescategory_delete\"onclick=\"\" type=\"button\" class=\"btn btn-primary \"><i class=\"fa fa-trash-o\"></i>&nbsp;Delete</a>&nbsp;";
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
                    <div class="" id="account_salescategory_data">

                    </div>

                </div>
            </section>
        </div>

    </div>
</div>

<!--body wrapper end-->

<!-- account_salescategory_modal Modal -->
<div id="account_salescategory_modal" class="modal fade <?php echo $modal_mode; ?>"  account_salescategory="dialog" style="display:<?php echo $display_modal; ?>;">
    <div class="modal-dialog"> 

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header panel-heading dark">
                <h4 class="modal-title" style="text-align:center">Sales Category</h4>
            </div>

            <div class="modal-body" > 
                <?php
                $attributes = array('class' => 'cmxform form-horizontal adminex-form', 'id' => 'account_salescategory_form');
                echo '<div id="error_div" class="' . $danger_style . '">' . $form_error . '</div>';
                echo form_open('app/process/account_salescategory', $attributes);
                ?>

                <div class="panel-body">
                    <div class="form">
                        <input type="hidden" name="account_salescategory_ID"  id="account_salescategory_ID" value="<?php echo $ID;?>">
                        <input type="hidden" name="account_salescategory_type" id="account_salescategory_type" value="<?php echo $type;?>">
                        <input type="hidden" name="account_salescategory_action" id="account_salescategory_action" value="<?php echo $action;?>">
                        <input type="hidden" name="account_salescategory_page_number" id="account_salescategory_page_number" value="<?php echo $page_number;?>">
                        <div class="form-group">
                            <label for="account_salescategory_title" class="col-sm-2 control-label">Account Discount</label>
                            <div class="col-sm-10">
                                <input class=" form-control" id="account_salescategory_title" value="<?php echo $title; ?>" name="account_salescategory_title" type="text" />
                            </div>
                        </div> 

                        <div class="form-group">
                            <label for="account_salescategory_description" class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10">
                                <input class=" form-control" id="account_salescategory_description" value="<?php echo $description; ?>" name="account_salescategory_description" type="text" />
                            </div>
                        </div>
                    </div>   
                </div>
                <div class="pull-right">
                    <input class="btn btn-success btn-sm" type="submit" name="submit" value="Save" />
                    <button type="button" class="btn btn-default" onclick="closeModal('#account_salescategory_modal');">Close</button>
                </div>
                <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--account_salescategory_modal modal-->
