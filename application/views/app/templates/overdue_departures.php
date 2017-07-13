<?php
$current = $received[0];
extract($current);
$count = 1;
?>

<!--body wrapper start-->
<div class="wrapper">
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading" style="text-align: center;">
                    OVERDUE DEPARTURES 
                    <?php if (count($collection) > 0) { ?>
                        <?php
                        $content = "";
                        foreach ($collection as $row):
                            $active = $checked = "";
                            $resv_id = $row["reservation_id"];
                            $room_number = $row["room_desc"]." ".$row["room_number"];
                            $client_name = $row["client_name"];
                            $actual_arrival = $row["actual_arrival"];
                            $departure = $row["departure"];

                            if ($count === 1) {
                                $active = "active";
                                $checked = "checked";
                            }

                            $content.="<tr class=\"overdue_row $active\">"
                                    . "<td><input type=\"checkbox\" $checked >"
                                    . "<input class=\"overdue_hidden_id\" type=\"hidden\" value=\"$resv_id\"></td>";
                            $content.="<td>$client_name</td>";
                            $content.="<td>$room_number</td>";
                            $content.="<td>$resv_id</td>";
                            $content.="<td>$actual_arrival</td>";
                            $content.="<td>$departure</td>";
                            $content.="</tr>";

                            $count++;
                        endforeach;
                        ?>
                    <?php } ?>

                    <div>   
                        <div class="form-group ">
                            <label for="overdue_date" class="col-sm-3 col-lg-3 control-label">Update Departure Date</label>
                            <div class="col-lg-2 col-sm-2">
                                <select  class="form-control " name="overdue_date" id="overdue_date">
                                    <option value="YES">YES</option>
                                </select>                                                                 
                            </div> 
                        </div>

                        <div class="pull-right">                            
                            <div class="form-group ">
                                <div class="col-sm-12">
                                    <?php
                                    $buttons = "";
                                    $buttons.="<a onclick=\"processOverdueDates();\" type=\"button\" class=\"btn btn-default \"><i class=\"fa fa-plus-square\"></i>&nbsp;Update</a>&nbsp;";
                                    $buttons.="<a href=\" " . base_url() . 'app/night' . " \" type=\"button\" class=\"btn btn-danger\"><i class=\"fa fa-times\"></i>&nbsp;Cancel</a>";
                                    echo $buttons;
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </header>


                <div class="panel-body">
                    <table class="table  table-hover general-table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Client Name</th>
                                <th>Room </th>
                                <th>Reservation#</th>
                                <th>Arrival</th>
                                <th>Departure</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($collection) > 0) { ?>
                                <?php echo $content; ?>
                            <?php } ?>
                        </tbody>
                    </table>

                    <?php
                    if (strlen($pagination)) {
                        echo $pagination;
                    }
                    ?>
                    
                    <div class="row">
        <div class="col-sm-7">            
            <label for="check_all_overdue" class="col-sm-2 col-lg-2 control-label">Check All</label>
            <input class="col-sm-1 col-lg-1 control-label" type="checkbox" name="check_all_overdue" id="check_all_overdue" />
        </div>
    </div>

                </div>
        </div>
        </section>
    </div>

    
</div>
<!--body wrapper end-->











