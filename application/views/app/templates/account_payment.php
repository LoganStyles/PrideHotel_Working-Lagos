<?php
$current = $received[0];
extract($current);
$account_payment_accounttype_list=displayOptions($accounttypes,0);
$account_payment_accountclass_list=displayOptions($accountclasses,0);

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
           Payment Accounts
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
                    <!--Account: Payments-->
                    <div>
                        <div id="account_payment_loader"></div>
                        <div class="pull-right">

                            <div class="form-group ">
                                <div class="col-sm-12">
                                    <?php
                                    $buttons = "<a onclick=\"modalLoader('account_payment','#account_payment_modal','new',0);\" class=\"btn btn-default  \" type=\"button\"><i class=\"fa fa-plus\"></i>&nbsp;New</a>&nbsp;"; //                    
                                    if ($count >= 1) {                                        
                                        $buttons.="<a id=\"account_payment_edit\" onclick=\"\" type=\"button\" class=\"btn btn-success \"><i class=\"fa fa-edit\"></i>&nbsp;Edit</a>&nbsp;";
                                        if(isset($_SESSION["delete_group"]) && $_SESSION["delete_group"] === '1'){
                                            $buttons.="<a id=\"account_payment_delete\"onclick=\"\" type=\"button\" class=\"btn btn-primary \"><i class=\"fa fa-trash-o\"></i>&nbsp;Delete</a>&nbsp;";
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
                    <div class="" id="account_payment_data">

                    </div>

                </div>
            </section>
        </div>

    </div>
</div>

<!--body wrapper end-->

<!-- account_payment_modal Modal -->
<div id="account_payment_modal" class="modal fade <?php echo $modal_mode; ?>"  role="dialog" style="display:<?php echo $display_modal; ?>;">
    <div class="modal-dialog"> 

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header panel-heading dark">
                <h4 class="modal-title" style="text-align:center">Account: Payment</h4>
            </div>

            <div class="modal-body" > 
                <?php
                $attributes = array('class' => 'cmxform form-horizontal adminex-form', 'id' => 'account_payment_form');
                echo '<div id="error_div" class="' . $danger_style . '">' . $form_error . '</div>';
                echo form_open('app/processAccountPayment', $attributes);
                ?>

                <div class="panel-body">
                    <div class="form">
                        <input type="hidden" name="account_payment_ID"  id="account_payment_ID" value="<?php echo $ID;?>">
                        <input type="hidden" name="account_payment_type" id="account_payment_type" value="<?php echo $type;?>">
                        <input type="hidden" name="account_payment_action" id="account_payment_action" value="<?php echo $action;?>">
                        <input type="hidden" name="account_payment_page_number" id="account_payment_page_number" value="<?php echo $page_number;?>">
                        <div class="form-group ">
                            <label for="account_payment_code" class="col-sm-3 control-label">Account Code</label>
                            <div class="col-sm-3">
                                <input class=" form-control" id="account_payment_code" value="<?php echo $code; ?>" name="account_payment_code" type="text" />
                            </div>
                            
                            <label for="account_payment_title" class="col-sm-3 control-label">Account Name</label>
                            <div class="col-lg-3 col-sm-3">
                                <input class=" form-control" id="account_payment_title" value="<?php echo $title; ?>" name="account_payment_title" type="text" />                                
                            </div>
                        </div> 
                        
                        <div class="form-group ">
                            <label for="account_payment_description" class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10">
                                <input class=" form-control" id="account_payment_description" value="<?php echo $description; ?>" name="account_payment_description" type="text" />
                            </div>
                        </div>
                        
                        <div class="form-group ">
                            <label for="account_payment_alias" class="col-sm-2 control-label">Alias</label>
                            <div class="col-sm-10">
                                <input class=" form-control" id="account_payment_alias" value="<?php echo $alias; ?>" name="account_payment_alias" type="text" />
                            </div>
                        </div>
                        
                        <div class="form-group ">
                            <label for="account_payment_accounttype" class="col-sm-3 control-label">Account Type</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="account_payment_accounttype" id="account_payment_accounttype">
                                    <?php echo $account_payment_accounttype_list; ?>
                                </select>                                
                            </div>
                            
                            <label class="col-sm-3 control-label col-lg-3" for="account_payment_debit_credit">Debit/Credit</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="account_payment_debit_credit" id="account_payment_debit_credit">
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
                        </div>
                        
                        
                        <div class="form-group ">
                            <label class="col-sm-3 control-label col-lg-3" for="account_payment_cash_declaration">Cash Declaration</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="account_payment_cash_declaration" id="account_payment_cash_declaration">
                                    <option value="no" <?php
                                    if ($cash_declaration === "no") {
                                        echo 'selected';
                                    }
                                    ?>>NO</option>
                                    <option value="yes" <?php
                                    if ($cash_declaration === "yes") {
                                        echo 'selected';
                                    }
                                    ?>>YES</option>                                    
                                </select>
                            </div>
                            
                            <label class="col-sm-3 control-label col-lg-3" for="account_payment_enable">Show</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="account_payment_enable" id="account_payment_enable">
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
                        
                        <div class="form-group ">
                            <label for="account_payment_accountclass" class="col-sm-3 control-label">Account Class</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="account_payment_accountclass" id="account_payment_accountclass">
                                    <?php echo $account_payment_accountclass_list; ?>
                                </select>                                
                            </div>
                        
                        </div>
                        
                    </div>   
                </div>
                <div class="pull-right">
                    <input class="btn btn-success btn-sm" type="submit" name="submit" value="Save" />
                    <button type="button" class="btn btn-default" onclick="closeModal('#account_payment_modal');">Close</button>
                </div>
                <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--role_modal modal-->
