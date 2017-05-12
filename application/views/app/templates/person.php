<?php
$current = $received[0];
extract($current);
$countries_list=displayOptions($countries,$country);

if ($form_error) {
    $danger_style = "alert alert-danger error";
    $display_modal="block";
    $modal_mode="in";
} else {
    $danger_style = $display_modal=$modal_mode="";
}
?>

<!--body wrapper start-->
<div class="wrapper">

    <div class="row">
        <div class="col-sm-10">
            <section class="panel">
                <header class="panel-heading">
                    <!--Person-->
                    <div>
                        <div id="person_loader"></div>
                        <div>Clients</div>
                        <div class="pull-right">

                            <div class="form-group ">
                                <div class="col-sm-12">
                                    <?php
                                    $buttons = "<a onclick=\"modalLoader('person','#person_modal','new',0);\" class=\"btn btn-default  \" type=\"button\"><i class=\"fa fa-plus\"></i>&nbsp;New</a>&nbsp;"; //                    
                                    if ($count >= 1) {                                        
                                        $buttons.="<a id=\"person_edit\" onclick=\"\" type=\"button\" class=\"btn btn-primary \"><i class=\"fa fa-edit\"></i>&nbsp;Edit</a>&nbsp;";
                                        if(isset($_SESSION["delete_group"]) && $_SESSION["delete_group"] === '1'){
                                            $buttons.="<a id=\"person_delete\"onclick=\"\" type=\"button\" class=\"btn btn-primary \"><i class=\"fa fa-trash-o\"></i>&nbsp;Delete</a>&nbsp;";
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
                    <div class="" id="person_data">

                    </div>

                </div>
            </section>
        </div>

    </div>
</div>

<!--body wrapper end-->

<!-- person_modal Modal -->
<div id="person_modal" class="modal fade <?php echo $modal_mode; ?>"  role="dialog" style="display:<?php echo $display_modal; ?>;">
    <div class="modal-dialog" style="width:1000px;"> 

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header panel-heading dark">
                <h4 class="modal-title" style="text-align:center">Guest (NEW)</h4>
            </div>

            <div class="modal-body" > 
                <?php
                $attributes = array('class' => 'cmxform form-horizontal adminex-form', 'id' => 'person_form');
                echo '<div id="error_div" class="' . $danger_style . '">' . $form_error . '</div>';
                echo form_open('resv/processPerson', $attributes);
                ?>

                <div class="panel-body">
                    <div class="form">
                        <input type="hidden" name="person_ID"  id="person_ID" value="<?php echo $ID; ?>">
                        <input type="hidden" name="person_type" id="person_type" value="<?php echo $type; ?>">
                        <input type="hidden" name="person_action" id="person_action" value="<?php echo $action; ?>">
                        <input type="hidden" name="person_page_number" id="person_page_number" value="<?php echo $page_number; ?>">

                        <div class="form-group ">
                            <label for="person_title" class="col-sm-1 control-label">Name</label>
                            <div class="col-sm-2">
                                <input  class=" form-control" id="person_title" value="<?php echo $title; ?>" name="person_title" type="text" />
                            </div>
                            
                            <label for="person_title_ref" class="col-sm-1 control-label">Title</label>
                            <div class="col-lg-2 col-sm-2">
                                <select  class="form-control " name="person_title_ref" id="person_title_ref">
                                    <option value="mr." <?php
                                    if ($title_ref === "mr.") {
                                        echo 'selected';
                                    }
                                    ?>>Mr.</option>
                                    <option value="mrs." <?php
                                    if ($title_ref === "mrs.") {
                                        echo 'selected';
                                    }
                                    ?>>Mrs.</option>
                                    <option value="miss." <?php
                                    if ($title_ref === "miss.") {
                                        echo 'selected';
                                    }
                                    ?>>Miss.</option>
                                    <option value="chief" <?php
                                    if ($title_ref === "chief") {
                                        echo 'selected';
                                    }
                                    ?>>Chief</option>

                                </select>                                                                 
                            </div> 

                            <label for="person_email" class="col-sm-1 control-label">Email</label>
                            <div class="col-sm-2">
                                <input  class=" form-control" id="person_email" name="person_email" value="<?php echo $email;?>" type="text" />                                
                            </div> 

                            <label for="person_phone" class="col-sm-1 control-label">Phone</label>
                            <div class="col-sm-2">
                                <input  class=" form-control" id="person_phone" name="person_phone" value="<?php echo $phone;?>" type="text" />                                
                            </div> 
                        </div>

                        <div class="form-group ">
                            <label for="person_street" class="col-sm-1 control-label">Street</label>
                            <div class="col-sm-2">
                                <input  class=" form-control" id="person_street" value="<?php echo $street; ?>" name="person_street" type="text" />
                            </div>
                            
                            <label for="person_city" class="col-sm-1 control-label">City</label>
                            <div class="col-sm-2">
                                <input  class=" form-control" id="person_city" value="<?php echo $city; ?>" name="person_city" type="text" />
                            </div>

                            <label for="person_state" class="col-sm-1 control-label">State</label>
                            <div class="col-sm-2">
                                <input  class=" form-control" id="person_state" name="person_state" value="<?php echo $state;?>" type="text" />                                
                            </div> 

                            <label for="person_country" class="col-sm-1 control-label">Country</label>
                            <div class="col-lg-2 col-sm-2">
                                <select  class="form-control " name="person_country" id="person_country">
                                    <?php echo $countries_list; ?>
                                </select>                                                                 
                            </div>
                        </div>
                        
                        <div class="form-group ">
                            <label for="person_sex" class="col-sm-1 control-label">Gender</label>
                            <div class="col-lg-2 col-sm-2">
                                <select  class="form-control " name="person_sex" id="person_sex">
                                    <option value="m" <?php
                                    if ($sex === "m") {
                                        echo 'selected';
                                    }
                                    ?>>Male</option>
                                    <option value="f" <?php
                                    if ($sex === "f") {
                                        echo 'selected';
                                    }
                                    ?>>Female</option>
                                </select>                                                                 
                            </div> 
                            
                            <label for="person_occupation" class="col-sm-1 control-label">Occupation</label>
                            <div class="col-sm-2">
                                <input  class=" form-control" id="person_occupation" value="<?php echo $occupation; ?>" name="person_occupation" type="text" />
                            </div>

                            <label for="person_birthday" class="col-sm-1 control-label">Birthday</label>
                            <div class="col-sm-1 col-lg-1" name="person_birthday" id="person_birthday"></div>
                            
                            <label for="person_birth_location" class="col-sm-1 control-label">Birth Location</label>
                            <div class="col-sm-2">
                                <input  class=" form-control" id="person_birth_location" name="person_birth_location" value="<?php echo $birth_location;?>" type="text" />                                
                            </div> 
                        </div>
                        
                        <div class="form-group ">
                            <label for="person_passport_no" class="col-sm-1 control-label">Passport No</label>
                            <div class="col-lg-2 col-sm-2">
                                <input  class=" form-control" id="person_passport_no" value="<?php echo $passport_no; ?>" name="person_passport_no" type="text" />
                            </div>
                            
                            <label for="person_pp_issued_at" class="col-sm-1 control-label">Issued At</label>
                            <div class="col-sm-2">
                                <input  class=" form-control" id="person_pp_issued_at" value="<?php echo $pp_issued_at ?>" name="person_pp_issued_at" type="text" />
                            </div>

                            <label for="person_pp_issued_date" class="col-sm-1 control-label">Issue Date</label>
                            <div class="col-sm-1 col-lg-1" name="person_pp_issued_date" id="person_pp_issued_date"></div>
                            
                            <label for="person_pp_expiry_date" class="col-sm-1 control-label">Expiry Date</label>
                            <div class="col-sm-1 col-lg-1" name="person_pp_expiry_date" id="person_pp_expiry_date"></div>                          
                             
                        </div>
                        
                        <div class="form-group ">
                            <label for="person_visa" class="col-sm-1 control-label">Visa</label>
                            <div class="col-lg-2 col-sm-2">
                                <input  class=" form-control" id="person_visa" value="<?php echo $visa; ?>" name="person_visa" type="text" />
                            </div>
                            
                            <label for="person_resident_permit_no" class="col-sm-1 control-label">Resident Permit No.</label>
                            <div class="col-sm-2">
                                <input  class=" form-control" id="person_resident_permit_no" value="<?php echo $resident_permit_no ?>" name="person_resident_permit_no" type="text" />
                            </div>
                            
                            <label for="person_spg_no" class="col-sm-1 control-label">SPG No.</label>
                            <div class="col-sm-2">
                                <input  class=" form-control" id="person_spg_no" value="<?php echo $spg_no ?>" name="person_spg_no" type="text" />
                            </div>
                             
                            <label for="person_destination" class="col-sm-1 control-label">Destination</label>
                            <div class="col-sm-2">
                                <input  class=" form-control" id="person_destination" value="<?php echo $destination ?>" name="person_destination" type="text" />
                            </div>
                        </div>
                        
                        <div class="form-group ">
                            <label for="person_payment_method" class="col-sm-1 control-label">Payment Method</label>
                            <div class="col-lg-2 col-sm-2">
                                <select  class="form-control " name="person_payment_method" id="person_payment_method">
                                    <option value="cash" <?php
                                    if ($payment_method === "cash") {
                                        echo 'selected';
                                    }
                                    ?>>Cash</option>
                                    <option value="pos" <?php
                                    if ($payment_method === "pos") {
                                        echo 'selected';
                                    }
                                    ?>>POS</option>
                                    <option value="coy" <?php
                                    if ($payment_method === "coy") {
                                        echo 'selected';
                                    }
                                    ?>>Charge to Company</option>
                                    <option value="cheque" <?php
                                    if ($payment_method === "cheque") {
                                        echo 'selected';
                                    }
                                    ?>>Cheque</option>
                                </select>                                                                 
                            </div>
                            
                            <label for="person_group_name" class="col-sm-1 control-label">Group Name</label>
                            <div class="col-sm-2">
                                <input  class=" form-control" id="person_group_name" value="<?php echo $group_name ?>" name="person_group_name" type="text" />
                            </div>
                            
                            <label for="person_plate_number" class="col-sm-1 control-label">Plate Number</label>
                            <div class="col-sm-2">
                                <input  class=" form-control" id="person_plate_number" value="<?php echo $plate_number ?>" name="person_plate_number" type="text" />
                            </div>
                             
                            <label for="person_remarks" class="col-sm-1 control-label">Remarks</label>
                            <div class="col-sm-2">
                                <input  class=" form-control" id="person_remarks" value="<?php echo $remarks ?>" name="person_remarks" type="text" />
                            </div>
                        </div>
                    </div>   
                </div>
                <div class="pull-right">
                    <input class="btn btn-success btn-sm" type="submit" name="submit" value="Save" />
                    <button type="button" class="btn btn-default" onclick="closeModal('#person_modal');">Close</button>
                </div>
                <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--person_modal -->
