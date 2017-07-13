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
                                $personid = $row["ID"];
                                $occupation = $row["occupation"];
                                $street = $row["street"];
                                $email = $row["email"];                                
                                $client_name = $row["title"];
                                $gender = $row["gender"];
                                $nationality = $row["nationality"];

                                $content.="<tr class=\"booking_radio\">";
                                $content.="<td><input class=\"booking_hidden_id\" type=\"hidden\" value=\"$personid\">"
                                        . "$client_name</td>";
                                $content.="<td>$gender</td>";
                                $content.="<td>$nationality</td>";
                                $content.="<td>$occupation</td>";
                                $content.="<td>$street</td>";
                                $content.="<td>$email</td>";
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
                            <th>Client Name</th>
                            <th>Gender</th>
                            <th>Nationality</th>
                            <th>Occupation</th>
                            <th>Street</th>
                            <th>Email</th>
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


