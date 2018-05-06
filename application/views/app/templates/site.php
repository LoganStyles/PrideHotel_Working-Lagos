<?php
$current = $received[0];
extract($current);

$country_list=displayOptions($countries,$country);


if (!empty($ID)) {
//if page reload,get current data
    $header_title = ucfirst($title);
} else {
    $header_title = "New Item";
}
?>
<!-- page heading start-->
<div class="page-heading">
    <h3>Configuration</h3>
    <ul class="breadcrumb">
        <li class="active"> Hotel Info </li>
    </ul>
</div>
<!-- page heading end-->


<!--body wrapper start-->
<div class="wrapper">    
    <div class="row">
        <div class="col-lg-10">
            <section class="panel">
                <header class="panel-heading">

                </header>

                <?php
                if ($form_error) {
                    $danger_style = "alert alert-danger error";
                } else {
                    $danger_style = "";
                }                
                
                $attributes = array('class' => 'cmxform form-horizontal adminex-form', 'id' => 'site_form');
                $hidden = array('site_ID' => $ID, 'site_type' => $type);
                echo '<div class="' . $danger_style . '">' . $form_error . '</div>';
                if (isset($_SESSION["form_success"])) {
                    echo "<div class=\"alert alert-success\">".$this->session->form_success."</div>";
                     
                }
                echo form_open_multipart('app/saveSite/' . $type, $attributes, $hidden);
                ?>

                <div class="panel-body">
                    <div class="form">                        
                        <div class="form-group ">
                            <label for="site_title" class="col-sm-2 control-label">Hotel Name</label>
                            <div class="col-sm-6">
                                <input class=" form-control" id="site_title" value="<?php echo $title; ?>" name="site_title" type="text" />
                            </div>
                            
                            <label for="site_show_passwords" class="col-sm-2 control-label">Show Staff Passwords</label>
                            <div class="col-lg-2 col-sm-2">
                                <select class="form-control " name="site_show_passwords" id="site_show_passwords">
                                    <option value="0" <?php
                                    if ($show_passwords === "0") {
                                        echo 'selected';
                                    }
                                    ?>>NO</option>
                                    <option value="1" <?php
                                    if ($show_passwords === "1") {
                                        echo 'selected';
                                    }
                                    ?>>YES</option>
                                    
                                </select>                                                                 
                            </div>

                        </div>
                        <div class="form-group ">
                            <label for="site_street1" class="col-sm-2 control-label">Street1</label>
                            <div class="col-sm-4">
                                <input class=" form-control" id="site_street1" value="<?php echo $street1; ?>" name="site_street1" type="text" />
                            </div>

                            <label for="site_street2" class="col-sm-2 control-label">street2</label>
                            <div class="col-sm-4">
                                <input class=" form-control" id="site_street2" value="<?php echo $street2; ?>" name="site_street2" type="text" />
                            </div>

                        </div>
                        <div class="form-group ">
                            <label for="site_state" class="col-sm-2 control-label">State</label>
                            <div class="col-sm-4">
                                <input class=" form-control" id="site_state" value="<?php echo $state; ?>" name="site_state" type="text" />
                            </div>

                            <label for="site_country" class="col-sm-2 control-label">Country</label>
                            <div class="col-sm-4">
                                <select class="form-control " name="site_country">
                                    <?php echo $country_list; ?>
                                </select>
                            </div>

                        </div>
                        <div class="form-group ">
                            <label for="site_tel1" class="col-sm-2 control-label">Tel1</label>
                            <div class="col-sm-4">
                                <input class=" form-control" id="site_tel1" value="<?php echo $tel1; ?>" name="site_tel1" type="text" />
                            </div>

                            <label for="site_tel2" class="col-sm-2 control-label">Tel2</label>
                            <div class="col-sm-4">
                                <input class=" form-control" id="site_tel2" value="<?php echo $tel2; ?>" name="site_tel2" type="text" />
                            </div>

                        </div>
                        <div class="form-group ">
                            <label for="site_email" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-4">
                                <input class=" form-control" id="site_email" value="<?php echo $email; ?>" name="site_email" type="text" />
                            </div>

                            <label for="site_facebook" class="col-sm-2 control-label">Facebook</label>
                            <div class="col-sm-4">
                                <input class=" form-control" id="site_facebook" value="<?php echo $facebook; ?>" name="site_facebook" type="text" />
                            </div>

                        </div>
                        <div class="form-group ">
                            <label for="site_twitter" class="col-sm-2 control-label">Twitter</label>
                            <div class="col-sm-2">
                                <input class=" form-control" id="site_twitter" value="<?php echo $twitter; ?>" name="site_twitter" type="text" />
                            </div>

                            <label for="site_url" class="col-sm-2 control-label">Url</label>
                            <div class="col-sm-2">
                                <input class=" form-control" id="site_url" value="<?php echo $url; ?>" name="site_url" type="text" />
                            </div>


                            <label for="site_bank_account" class="col-sm-2 control-label">Bank Account</label>
                            <div class="col-sm-2">
                                <input class=" form-control" id="site_bank_account" value="<?php echo $bank_account; ?>" name="site_bank_account" type="text" />
                            </div>                           

                        </div>
                        <div class="form-group">
                            <input type="hidden" value="<?php echo $logo; ?>" name="site_prev_filename" >
                            <?php foreach ($received as $received_items): ?>

                                <?php
                                $filename = $logo;
                                $image_content = "";
                                if (!empty($filename)) {
                                    $received_image = base_url() . 'images/UPLOADS/' . $filename;
                                    $image_content.="<div class=\"col-md-4\">";
                                    $image_content.="<div class=\"fileupload fileupload-new\" data-provides=\"fileupload\">";
                                    $image_content.="<div class=\"fileupload-new thumbnail\" style=\"width: 200px; height: 150px;\">";
                                    $image_content.="<img src=\"$received_image\" alt=\"\" >";
                                    $image_content.="</div></div><br/></div>";
                                    echo $image_content;
                                }
                                ?>
                            <?php endforeach; ?>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Image Upload( MAX 2MB, [1024 x 1024])</label>

                            <div class="col-md-6">
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    <div>
                                        <span class="btn btn-default btn-file">
                                            <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Add an image</span>
                                            <span class="fileupload-new"><i class="fa fa-paper-clip"></i> </span>
                                            <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                            <input type="file" class="default" name="site_filename" />
                                        </span>
                                        <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</a>
                                    </div>
                                </div>
                                <br/>
                            </div> 

                        </div>


                    </div>
                </div>
                <div class="pull-right">
                    <input class="btn btn-success btn-sm" type="submit" name="submit" value="Save" />
                </div>
                <div class="clearfix"></div>
                </form>
            </section>
        </div>
    </div>
</div>
<!--body wrapper end-->



