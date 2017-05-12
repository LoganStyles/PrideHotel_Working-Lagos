<?php
$current = $received[0];
extract($current);
$role_list=displayOptions($roles,0);

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
            Users
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
                        <div class="pull-right">

                            <div class="form-group ">
                                <div class="col-sm-12">
                                    <?php
                                    $buttons = "<a onclick=\"modalLoader('user','#user_modal','new',0);\" class=\"btn btn-default  \" type=\"button\"><i class=\"fa fa-plus\"></i>&nbsp;New</a>&nbsp;"; //                    
                                    if ($count >= 1) {                                        
                                        $buttons.="<a id=\"user_edit\" onclick=\"\" type=\"button\" class=\"btn btn-success \"><i class=\"fa fa-edit\"></i>&nbsp;Edit</a>&nbsp;";
                                        if(isset($_SESSION["delete_group"]) && $_SESSION["delete_group"] === '1'){
                                        $buttons.="<a id=\"user_delete\"onclick=\"\" type=\"button\" class=\"btn btn-primary \"><i class=\"fa fa-trash-o\"></i>&nbsp;Delete</a>&nbsp;";
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
                    <div class="" id="user_data">

                    </div>

                </div>
            </section>
        </div>

    </div>
</div>

<!--body wrapper end-->

<!-- user_modal Modal -->
<div id="user_modal" class="modal fade <?php echo $modal_mode; ?>"  role="dialog" style="display:<?php echo $display_modal; ?>;">
    <div class="modal-dialog"> 

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header panel-heading dark">
                <h4 class="modal-title" style="text-align:center">User</h4>
            </div>

            <div class="modal-body" > 
                <?php
                $attributes = array('class' => 'cmxform form-horizontal adminex-form', 'id' => 'user_form');
                echo '<div id="error_div" class="' . $danger_style . '">' . $form_error . '</div>';
                echo form_open('app/processUser', $attributes);
                ?>

                <div class="panel-body">
                    <div class="form">
                        <input type="hidden" name="user_ID"  id="user_ID" value="<?php echo $ID;?>">
                        <input type="hidden" name="user_type" id="user_type" value="<?php echo $type;?>">
                        <input type="hidden" name="user_action" id="user_action" value="<?php echo $action;?>">
                        <input type="hidden" name="user_page_number" id="user_page_number" value="<?php echo $page_number;?>">
                        <div class="form-group ">
                            <label for="user_title" class="col-sm-2 control-label">User Name</label>
                            <div class="col-sm-10">
                                <input class=" form-control" id="user_title" value="<?php echo $title; ?>" name="user_title" type="text" />
                            </div>
                        </div> 

                        <div class="form-group ">
                            <label for="user_signature" class="col-sm-2 control-label">Signature </label>
                            <div class="col-sm-10">
                                <input class=" form-control" id="user_signature" value="<?php echo $signature; ?>" name="user_signature" type="text" />
                            </div>
                        </div>
                        
                        <div class="form-group ">
                            <label for="user_keyword" class="col-sm-2 control-label">Keyword</label>
                            <div class="col-sm-10">
                                <input class=" form-control" id="user_keyword" value="<?php echo $keyword; ?>" name="user_keyword" type="password" />
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="col-sm-3 control-label col-lg-3" for="user_role">Role</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="user_role" id="user_role">
                                    <?php echo $role_list; ?>
                                </select>
                            </div>
                        
                        </div>
                        
                    </div>   
                </div>
                <div class="pull-right">
                    <input class="btn btn-success btn-sm" type="submit" name="submit" value="Save" />
                    <button type="button" class="btn btn-default" onclick="closeModal('#user_modal');">Close</button>
                </div>
                <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--role_modal modal-->
