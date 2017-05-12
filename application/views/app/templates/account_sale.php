<?php
$current = $received[0];
extract($current);
$account_sale_salescategory_list=displayOptions($salescats,0);
$account_sale_accountclass_list=displayOptions($accountclasses,0);
$account_sale_accounttype_list=displayOptions($accounttypes,0);
$account_sale_discountcategory_list=displayOptions($discountcats,0);

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
           Sale Accounts
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
                    <!--Account: Sale-->
                    <div>
                        <div id="account_sale_loader"></div>
                        <div class="pull-right">

                            <div class="form-group ">
                                <div class="col-sm-12">
                                    <?php
                                    $buttons = "<a onclick=\"modalLoader('account_sale','#account_sale_modal','new',0);\" class=\"btn btn-default  \" type=\"button\"><i class=\"fa fa-plus\"></i>&nbsp;New</a>&nbsp;"; //                    
                                    if ($count >= 1) {                                        
                                        $buttons.="<a id=\"account_sale_edit\" onclick=\"\" type=\"button\" class=\"btn btn-success \"><i class=\"fa fa-edit\"></i>&nbsp;Edit</a>&nbsp;";
                                        if(isset($_SESSION["delete_group"]) && $_SESSION["delete_group"] === '1'){
                                            $buttons.="<a id=\"account_sale_delete\"onclick=\"\" type=\"button\" class=\"btn btn-primary \"><i class=\"fa fa-trash-o\"></i>&nbsp;Delete</a>&nbsp;";
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
                    <div class="" id="account_sale_data">

                    </div>

                </div>
            </section>
        </div>

    </div>
</div>

<!--body wrapper end-->

<!-- account_sale_modal Modal -->
<div id="account_sale_modal" class="modal fade <?php echo $modal_mode; ?>"  role="dialog" style="display:<?php echo $display_modal; ?>;">
    <div class="modal-dialog"> 

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header panel-heading dark">
                <h4 class="modal-title" style="text-align:center">Account: Sale</h4>
            </div>

            <div class="modal-body" > 
                <?php
                $attributes = array('class' => 'cmxform form-horizontal adminex-form', 'id' => 'account_sale_form');
                echo '<div id="error_div" class="' . $danger_style . '">' . $form_error . '</div>';
                echo form_open('app/processAccountSale', $attributes);
                ?>

                <div class="panel-body">
                    <div class="form">
                        <input type="hidden" name="account_sale_ID"  id="account_sale_ID" value="<?php echo $ID;?>">
                        <input type="hidden" name="account_sale_type" id="account_sale_type" value="<?php echo $type;?>">
                        <input type="hidden" name="account_sale_action" id="account_sale_action" value="<?php echo $action;?>">
                        <input type="hidden" name="account_sale_page_number" id="account_sale_page_number" value="<?php echo $page_number;?>">
                        <div class="form-group ">
                            <label for="account_sale_code" class="col-sm-3 control-label">Account Code</label>
                            <div class="col-sm-3">
                                <input class=" form-control" id="account_sale_code" value="<?php echo $code; ?>" name="account_sale_code" type="text" />
                            </div>
                            
                            <label for="account_sale_title" class="col-sm-3 control-label">Account Name</label>
                            <div class="col-lg-3 col-sm-3">
                                <input class=" form-control" id="account_sale_title" value="<?php echo $title; ?>" name="account_sale_title" type="text" />                                
                            </div>
                        </div> 
                        
                        <div class="form-group ">
                            <label for="account_sale_description" class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10">
                                <input class=" form-control" id="account_sale_description" value="<?php echo $description; ?>" name="account_sale_description" type="text" />
                            </div>
                        </div>
                        
                        <div class="form-group ">
                            <label for="account_sale_alias" class="col-sm-2 control-label">Alias</label>
                            <div class="col-sm-10">
                                <input class=" form-control" id="account_sale_alias" value="<?php echo $alias; ?>" name="account_sale_alias" type="text" />
                            </div>
                        </div>
                        
                        <div class="form-group ">
                            <label for="account_sale_accounttype" class="col-sm-3 control-label">Account Type</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="account_sale_accounttype" id="account_sale_accounttype">
                                    <?php echo $account_sale_accounttype_list; ?>
                                </select>                                
                            </div>
                            
                            <label for="account_sale_accountclass" class="col-sm-3 control-label">Account Class</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="account_sale_accountclass" id="account_sale_accountclass">
                                    <?php echo $account_sale_accountclass_list; ?>
                                </select>                                
                            </div>                
                        </div>
                        
                        
                        <div class="form-group ">
                            <label class="col-sm-3 control-label col-lg-3" for="account_sale_vattype">VAT</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="account_sale_vattype" id="account_sale_vattype">
                                    <option value="excl" <?php
                                    if ($vattype === "excl") {
                                        echo 'selected';
                                    }
                                    ?>>EXCL</option>
                                    <option value="incl" <?php
                                    if ($vattype === "incl") {
                                        echo 'selected';
                                    }
                                    ?>>INCL</option>                                    
                                </select>
                            </div>
                            
                            <label class="col-sm-3 control-label col-lg-3" for="account_sale_vatpercent">VAT (%)</label>
                            <div class="col-lg-3 col-sm-3">
                                <input class=" form-control" id="account_sale_vatpercent" value="<?php echo $vatpercent; ?>" name="account_sale_vatpercent" type="text" />                            
                            </div> 
                        </div>
                        
                        <div class="form-group ">
                            <label class="col-sm-3 control-label col-lg-3" for="account_sale_debit_credit">Debit/Credit</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="account_sale_debit_credit" id="account_sale_debit_credit">
                                    <option value="debit" <?php
                                    if ($debit_credit === "debit") {
                                        echo 'selected';
                                    }
                                    ?>>DEBIT</option>
                                    <option value="credit" <?php
                                    if ($debit_credit === "credit") {
                                        echo 'selected';
                                    }
                                    ?>>CREDIT</option>                                    
                                </select>
                            </div> 
                            
                            <label for="account_sale_salescategory" class="col-sm-3 control-label">Sales Category</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="account_sale_salescategory" id="account_sale_salescategory">
                                    <?php echo $account_sale_salescategory_list; ?>
                                </select>                                
                            </div>  
                        </div>
                        
                        <div class="form-group ">
                            <label for="account_sale_discountcategory" class="col-sm-3 control-label">Discount Category</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="account_sale_discountcategory" id="account_sale_discountcategory">
                                    <?php echo $account_sale_discountcategory_list; ?>
                                </select>                                
                            </div>
                            
                            <label class="col-sm-3 control-label col-lg-3" for="account_sale_default_price">Default Price</label>
                            <div class="col-lg-3 col-sm-3">
                                <input class=" form-control" id="account_sale_default_price" value="<?php echo $default_price; ?>" name="account_sale_default_price" type="text" />                            
                            </div>                        
                        </div>
                        
                        <div class="form-group ">
                            <label for="account_sale_service_charge" class="col-sm-3 control-label">Service Charge</label>                            
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="account_sale_service_charge" id="account_sale_service_charge">
                                    <option value="no" <?php
                                    if ($service_charge === "no") {
                                        echo 'selected';
                                    }
                                    ?>>NO</option>
                                    <option value="yes" <?php
                                    if ($service_charge === "yes") {
                                        echo 'selected';
                                    }
                                    ?>>YES</option>                                    
                                </select>
                            </div>
                            
                            <label for="account_sale_enable" class="col-sm-3 control-label">Show</label>                            
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="account_sale_enable" id="account_sale_enable">
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
                    <button type="button" class="btn btn-default" onclick="closeModal('#account_sale_modal');">Close</button>
                </div>
                <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--role_modal modal-->
