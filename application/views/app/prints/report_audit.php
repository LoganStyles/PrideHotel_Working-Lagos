<?php ?>

<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="">
                <div>
                    <div class="pull-right">
                        <?php if (count($collection) > 0) { ?>
                            <?php
                            $content = "";
                            $count = 1;
                            foreach ($collection as $row):
                                $logid = $row["ID"];
                                $date = date('d/m/Y H:i:s', strtotime($row["date_created"]));
                                $signature_created = $row["signature_created"];
                                $user_title = $row["user_title"];
                                $action = $row["action"];
                                $section = $row["section"];
                                $description = $row["description"];

                                $content.="<tr class=\"booking_radio\">";
                                $content.="<td><input class=\"booking_hidden_id\" type=\"hidden\" value=\"$logid\">"
                                        . "$date</td>";
                                $content.="<td>$signature_created</td>";
                                $content.="<td>$user_title</td>";
                                $content.="<td>$action</td>";
                                $content.="<td>$section</td>";
                                $content.="<td>$description</td>";
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
                            <th>Date</th>
                            <th>Signature</th>
                            <th>Staff</th>
                            <th>Action</th>
                            <th>Module</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($collection) > 0) { ?>
                            <?php echo $content; ?>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
        </section>
    </div>

</div>

<div class="row">
    <div class="pull-right" id="print_box">
        <div class="col-sm-12">
            <?php
            $buttons = "<a onclick=\"printAction('print','" . base_url() . "resv/reports');\" type=\"button\" class=\"btn btn-primary \"><i class=\"fa fa-print\"></i>&nbsp;Print</a>&nbsp;";
            $buttons.="<a href=\"" . base_url() . "resv/reports\" type=\"button\" class=\"btn btn-danger \"><i class=\"fa fa-times\"></i>&nbsp;Close</a>&nbsp;";

            echo $buttons;
            ?>
        </div>
    </div>
</div>
</div>

<!--body wrapper end-->


