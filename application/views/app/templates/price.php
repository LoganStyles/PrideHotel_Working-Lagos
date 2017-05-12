<?php
$current = $received[0];
extract($current);
$price_title_list = displayOptions($roomtypes, 0);
$price_acctsale_list = displayOptions($accountsale, 0);

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
            Prices
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
                    <!--Prices-->
                    <div>
                        <div id="price_loader"></div>
                        <div class="pull-right">

                            <div class="form-group ">
                                <div class="col-sm-12">
                                    <?php
                                    $buttons = "<a onclick=\"modalLoader('price','#price_modal','new',0);\" class=\"btn btn-default  \" type=\"button\"><i class=\"fa fa-plus\"></i>&nbsp;New</a>&nbsp;"; //                    
                                    if ($count >= 1) {
                                        $buttons.="<a id=\"price_edit\" onclick=\"\" type=\"button\" class=\"btn btn-success \"><i class=\"fa fa-edit\"></i>&nbsp;Edit</a>&nbsp;";
                                        if (isset($_SESSION["delete_group"]) && $_SESSION["delete_group"] === '1') {
                                            $buttons.="<a id=\"price_delete\"onclick=\"\" type=\"button\" class=\"btn btn-primary \"><i class=\"fa fa-trash-o\"></i>&nbsp;Delete</a>&nbsp;";
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
                    <div class="" id="price_data">

                    </div>

                </div>
            </section>
        </div>

    </div>
</div>

<!--body wrapper end-->

<!-- price_modal Modal -->
<div id="price_modal" class="modal fade <?php echo $modal_mode; ?>"  role="dialog" style="display:<?php echo $display_modal; ?>;">
    <div class="modal-dialog"> 

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header panel-heading dark">
                <h4 class="modal-title" style="text-align:center">Price Rate</h4>
            </div>

            <div class="modal-body" > 
                <?php
                $attributes = array('class' => 'cmxform form-horizontal adminex-form', 'id' => 'price_form');
                echo '<div id="error_div" class="' . $danger_style . '">' . $form_error . '</div>';
                echo form_open('app/processPrice', $attributes);
                ?>

                <div class="panel-body">
                    <div class="form">
                        <input type="hidden" name="price_ID"  id="price_ID" value="<?php echo $ID; ?>">
                        <input type="hidden" name="price_type" id="price_type" value="<?php echo $type; ?>">
                        <input type="hidden" name="price_action" id="price_action" value="<?php echo $action; ?>">
                        <input type="hidden" name="price_page_number" id="price_page_number" value="<?php echo $page_number; ?>">
                        <div class="form-group ">
                            <label for="price_title" class="col-sm-3 control-label">Room Type</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="price_title" id="price_title">
                                    <?php echo $price_title_list; ?>
                                </select>                                
                            </div>

                            <label for="price_acctsale" class="col-sm-3 control-label">Account Name</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="price_acctsale" id="price_acctsale">
                                    <?php echo $price_acctsale_list; ?>
                                </select>
                            </div>
                        </div> 

                        <div class="form-group ">
                            <label for="price_description" class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10">
                                <input class=" form-control" id="price_description" value="<?php echo $description; ?>" name="price_description" type="text" />
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="price_comp_nights" class="col-sm-3 control-label">Comp. Nights</label>
                            <div class="col-sm-3">
                                <input class=" form-control" id="price_comp_nights" value="<?php echo $comp_nights; ?>" name="price_comp_nights" type="number" />
                            </div>

                            <label class="col-sm-3 control-label col-lg-3" for="price_comp_visits">Comp. Visits</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="price_comp_visits" id="price_comp_visits">
                                    <option value="no" <?php
                                    if ($comp_visits === "no") {
                                        echo 'selected';
                                    }
                                    ?>>NO</option>
                                    <option value="yes" <?php
                                    if ($comp_visits === "yes") {
                                        echo 'selected';
                                    }
                                    ?>>YES</option>                                    
                                </select>
                            </div> 
                        </div>

                        <div class="form-group ">
                            <label for="price_adults" class="col-sm-3 control-label">Adults</label>
                            <div class="col-sm-3">
                                <input class=" form-control" id="price_adults" value="<?php echo $adults; ?>" name="price_adults" type="number" />
                            </div>

                            <label for="price_children" class="col-sm-3 control-label">Children</label>
                            <div class="col-sm-3">
                                <input class=" form-control" id="price_children" value="<?php echo $children; ?>" name="price_children" type="number" />
                            </div>
                        </div>
                        
                        <div class="form-group ">
                            <label for="price_special" class="col-sm-3 control-label">Special</label>
                            <div class="col-sm-3">
                                <input class=" form-control" id="price_special" value="<?php echo $adults; ?>" name="price_special" type="number" />
                            </div>

                            <label for="price_weekday" class="col-sm-3 control-label">Weekday</label>
                            <div class="col-sm-3">
                                <input class=" form-control" id="price_weekday" value="<?php echo $weekday; ?>" name="price_weekday" type="number" />
                            </div>
                        </div>
                        
                        <div class="form-group ">
                            <label for="price_weekend" class="col-sm-3 control-label">Weekend</label>
                            <div class="col-sm-3">
                                <input class=" form-control" id="price_weekend" value="<?php echo $weekend; ?>" name="price_weekend" type="number" />
                            </div>

                            <label for="price_holiday" class="col-sm-3 control-label">Holiday</label>
                            <div class="col-sm-3">
                                <input class=" form-control" id="price_holiday" value="<?php echo $holiday; ?>" name="price_holiday" type="number" />
                            </div>
                        </div>
                        
                        <div class="form-group ">
                            <label class="col-sm-3 control-label col-lg-3" for="price_enable">Show</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="price_enable" id="price_enable">
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
                    <button type="button" class="btn btn-default" onclick="closeModal('#price_modal');">Close</button>
                </div>
                <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--role_modal modal-->
