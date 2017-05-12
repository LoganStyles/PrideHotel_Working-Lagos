<?php ?>

<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="">
                <div>
                    <div class="pull-right">
                        <?php if (count($room) > 0) { ?>
                            <?php
                            $content = $status_span = $active_span = "";
                            $count = 1;
                            foreach ($room as $row):
                                $id = $row["ID"];
                                $title = $row["title"];
                                $description = $row["description"];
                                $remark = $row["remark"];
                                $roomtype = getTitle($roomtypes, $row["roomtype"]);
                                $status = getTitle($room_status, $row["status"]);

                                $content.="<tr class=\"booking_radio \">";
                                $content.="<td><input class=\"booking_hidden_id\" type=\"hidden\" value=\"$id\">"
                                        . "$count</td>"; //   
                                $content.="<td>$title</td>";
                                $content.="<td>$roomtype</td>";
                                $content.="<td>$description</td>";
                                $content.="<td>$status</td>";
                                $content.="<td>$remark</td>";
                                $content.="</tr>";

                                $count++;
                            endforeach;
                            ?>
                        <?php } ?>

                    </div>
                    <div class="clearfix"></div>

                </div>
            </header>


            <div class="panel-body"><p style="font-weight: 700;color: #f00;"> </p>
                <table class="table  table-hover general-table table-bordered table-condensed">
                    <thead>
                        <tr>                                
                            <th>S/N</th>
                            <th>Title</th>
                            <th>Room Type</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Remark</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($room) > 0) { ?>
                            <?php echo $content; ?>
                        <?php } ?>
                    </tbody>
                </table>

                <?php
                if (strlen($pagination)) {
                    echo $pagination;
                }
                ?>

            </div>
        </section>
    </div>

</div>
<div class="row">
    <div class="pull-right">
        <div class="form-group ">
            <div class="col-sm-12">
                <?php
                $buttons = "<a id=\"room_print\" onclick=\"\" type=\"button\" class=\"btn btn-primary \"><i class=\"fa fa-print\"></i>&nbsp;Print</a>&nbsp;";
                $buttons.="<a id=\"room_close_print\" onclick=\"\" type=\"button\" class=\"btn btn-danger \"><i class=\"fa fa-times\"></i>&nbsp;Close</a>&nbsp;";

                echo $buttons;
                ?>
            </div>
        </div>

    </div>
</div>
</div>

<!--body wrapper end-->


