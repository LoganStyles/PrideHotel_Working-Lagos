<?php
$current = $received[0];
extract($current);

?>

<!--body wrapper start-->
<div class="wrapper">    
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading" style="text-align:center">
                    <span>Reports</span>
                </header>

                <?php
                $attributes = array('class' => 'cmxform form-horizontal adminex-form', 'id' => 'report_form');
                echo form_open('report/getReports', $attributes);
                ?>

                <div class="panel-body">
                    <div class="form">
                        <div class="form-group ">
                            <label for="report_type" class="col-sm-2 control-label">Report Type</label>
                            <div class="col-lg-2 col-sm-2">
                                <select class="form-control " name="report_type" id="report_type">
                                    <option value="arrivals">ARRIVALS</option>
                                    <option value="departures">DEPARTURES</option>
                                    <option value="staying guests">STAYING GUESTS</option>
                                    <option value="sales summary">SALES SUMMARY</option>
                                    <option value="sales_fnb_summary">SALES FROM RESTAURANT</option>
                                    <option value="cashier summary">CASHIER SUMMARY</option>
                                    <option value="audit trail">AUDIT TRAIL</option>
                                    <option value="ledger_guest">LEDGER GUEST</option>
                                    <option value="ledger_group">LEDGER GROUP</option>
                                    <option value="police">POLICE REPORT</option>
                                    <option value="client history">CLIENT HISTORY</option>
                                    
                                </select>                                
                            </div>  
                            
                            <label for="report_user" class="col-sm-1 control-label">Users</label>
                            <div class="col-lg-2 col-sm-2">                                
                                <select class="form-control " name="report_user" id="report_user">
                                    
                                    <?php if (count($collection) > 0) { $content="";?>
                                    <?php 
                                    $content.="<option value='all'>All</option>";
                                    foreach ($collection as $row):
                                         $content.="<option value='".$row['signature']."'>".$row['title']."</option>";
                                    endforeach;
                                    echo $content;
                                    ?>
                                   
                                    <?php }else{                                        
                                        echo"<option value='None'>None</option>";
                                    } ?>
                                </select>                                
                            </div> 
                        </div>
                        
                        <div class="form-group ">  
                            <label  for="report_from" class="col-sm-2 col-lg-2 control-label">From Date</label>
                            <div class="col-sm-1 col-lg-1" name="report_from" id="report_from"></div>
                            
                            <label  for="report_to" class="col-sm-1 col-lg-1 control-label">To Date</label>
                            <div class="col-sm-1 col-lg-1" name="report_to" id="report_to"></div> 
                        </div>
                                               
                    </div>
                </div>
                <div class="pull-right">
                    <input class="btn btn-success btn-sm" type="submit" name="submit" value="Submit" />
                </div>
                <div class="clearfix"></div>
                </form>
            </section>
        </div>
    </div>
</div>
<!--body wrapper end-->






