<?php ?>

<!--footer section start-->

<div role="dialog" id="delete_modal" class="modal fade">
    <div class="modal-dialog" style="width: 600px;">
        <div class="modal-content">
            <div class="modal-header panel-heading dark" >                
                <h4 class="modal-title" style="text-align:center">Delete Dialog</h4>
            </div>
            <div class="modal-body">

                <?php
                $attributes = array('class' => 'cmxform form-horizontal adminex-form', 'id' => 'delete_form');
                echo form_open_multipart('app/processDelete', $attributes);
                ?>
                <div class="panel-body">
                    <div class="row">
                        <div class="form">
                            <div class="col-md-12">
                                <div class="form-group ">
                                    <h4>Are You Sure You Want To Delete This Item?</h4>
                                    <input type="hidden" value="" name="delete_id" id="delete_id">
                                    <input type="hidden" value="" name="delete_type" id="delete_type">
                                    <input type="hidden" value="" name="delete_page" id="delete_page">
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <input class="btn btn-success btn-sm" type="submit" name="submit" value="YES" />
                <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                </form> 
            </div>
        </div>
    </div>
</div>

<div role="dialog" id="access_modal" class="modal fade">
    <div class="modal-dialog" style="width: 600px;">
        <div class="modal-content">
            <div class="modal-header panel-heading dark" >                
                <h4 class="modal-title" style="text-align:center">Access Denied</h4>
            </div>
            <div class="modal-body">                
                <div class="panel-body">
                    <div class="row">
                        <div class="form">
                            <div class="col-md-12">
                                <div class="form-group ">
                                    <h4>Sorry, You Do Not Have Permission For This Action!</h4>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>                
            </div>
        </div>
    </div>
</div>



<footer>
    &copy; <?php echo date('Y'); ?>  Powered by <a href="http://webmobiles.com.ng/" target="_blank" >Webmobiles IT Services Ltd</a>
</footer>
<!--footer section end-->


</div>
<!-- main content end-->
</section>

<?php include_once 'js_scripts.php'; ?>


<script type="text/javascript">
    var BASE_URL = "<?php echo base_url(); ?>";
    var PAGE_TYPE = "<?php echo $type; ?>";
    var ACTION = "<?php echo $action; ?>";
    var header_title = "<?php echo $header_title; ?>";

    function updateItem(type, ID, value) {
        var url = BASE_URL + "app/processUpdate/" + type + "/" + ID + "/" + value;
        console.log('update url: ' + url);
        window.location = url;
    }

    function closeWindow(type) {
        if (!type) {
            window.location = BASE_URL + "app";
        } else {
            window.location = BASE_URL + "resv/" + type;
        }
    }

    function printAll(type) {
        var url = BASE_URL + "report/printAllItems/" + type;
        console.log('update url: ' + url);
        window.location = url;
    }

    function fetchRowData(type, id) {
        var url = BASE_URL + "app/fetchJsonData/" + type + "/" + id;
        console.log(url);

        $.ajax({
            type: "POST",
            url: url,
            dataType: "json",
            success: function (data) {
                if ($.isEmptyObject(data) === false) {
                    $.each(data, function (key, value) {
                        $.each(value, function (key, value) {
                            var identifier = "#" + type + "_" + key;
                            if ($(identifier).length !== 0) {
                                console.log('identifier: ' + identifier);
                                console.log('value: ' + value);
                                $(identifier).val(value);
                            }
                        });
                    });
                }
            },
            error: function () {
                console.log('fetch data failed');
            }
        });
    }

    function fetchRowDataWithIdentifier(type, id, prefix) {
        var modal = "#" + prefix + "_modal";
        var url = BASE_URL + "app/fetchJsonData/" + type + "/" + id;
        console.log(url);

        $.ajax({
            type: "POST",
            url: url,
            dataType: "json",
            success: function (data) {
                $(modal).modal({backdrop: false, keyboard: false});
                if ($.isEmptyObject(data) === false) {
                    $.each(data, function (key, value) {
                        $.each(value, function (key, value) {
                            var identifier = "#" + prefix + "_" + key;
                            if ($(identifier).length !== 0) {
                                console.log('identifier: ' + identifier);
                                console.log('value: ' + value);

                                $(identifier).val(value);
                            }
                        });
                    });
                }
            },
            error: function () {
                console.log('fetch data failed');
            }
        });
    }

    function search(field, type, search) {
        var url = BASE_URL + "resv/searchClient/" + type + "/" + search;
        console.log(url);
        var content = "";
        var live_field = "#" + field + "_reservations_live";
        console.log('live_field ' + live_field);

        $.ajax({
            type: "POST",
            url: url,
            dataType: "json",
            success: function (data) {
                $(live_field).show();
                if ($.isEmptyObject(data) === false) {
                    $.each(data, function (key, value) {
                        console.log('value ' + value.title);
                        content += '<p id="' + value.ID + '" class="reservations_live_results">' + value.title + '</p>';
                    });
                } else {
                    content = '<p class="reservations_live_results" style="color:#f00;">No results found</p>';
                }
            },
            error: function () {
                console.log('search data failed');
            },
            complete: function () {
                $(live_field).html(content);
            }
        });
    }

    function modalLoader(type, modal, mode, id) {
        $('#error_div').html("").removeClass("alert alert-danger error");
        var form_action = "#" + type + "_action";
        var formid = "#" + type + "_form";
        var itemid = "#" + type + "_ID";
        console.log('form_action: ' + form_action);

        switch (mode) {
            case 'new':
                $(modal).addClass("in").css('display', 'block');
                $(formid).trigger('reset');
                $(form_action).val("insert");
                $(modal).modal({backdrop: false, keyboard: false});
                break;
            case 'edit':
                $(form_action).val("update");
                $(itemid).val(id);
                $(modal).addClass("in").css('display', 'block');
                console.log('case edit');
                if (type !== "housekeeping") {
                    fetchRowData(type, id);
                }
                break;
            case 'delete':
                console.log('case delete');
                $('#delete_id').val(id);
                $('#delete_type').val(type);
                $(form_action).val("delete");
                $("#delete_modal").modal({backdrop: false, keyboard: false});
                break;
            default:
                break;
        }
    }


    function closeModal(modal) {
        //close Modals     
        $(modal).removeClass("in").css('display', 'none');
        var type = modal.replace("_modal", "");
        type = type.replace("#", "");
        var form_page_number = modal.replace("modal", "page_number");
        var page_number = $(form_page_number).val();
        var show;

        if (type === "person") {
            show = "showClients";
            var url = BASE_URL + "resv/" + show + "/" + type + "/0/" + page_number;
            window.location = url;
        } else {
            switch (type) {
                case 'roomclass':
                case 'account_type':
                case 'account_discount':
                case 'account_salescategory':
                case 'account_class':
                case 'account_plu_group':
                    show = "showTypeclass";
                    break;
                case 'account_payment':
                    show = "showAccountpayment";
                case 'account_sale':
                    show = "showAccountsale";
                    break;
                case 'account_plu_number':
                    show = "showAccountplu";
                    break;
                default:
                    show = "show" + type.charAt(0).toUpperCase() + type.slice(1);
                    break;
            }

            var url = BASE_URL + "app/" + show + "/" + type + "/0/" + page_number;
            window.location = url;
        }
    }

    function processResv(type, page_number, mode) {/*handler for reservation actions
     * gets the resv id & type of operation, then calls controller*/
        var resv_id = $('.booking_radio.active .booking_hidden_id').val();
        console.log('resv_id is ' + resv_id);
        console.log('type is ' + type);
        var redirect = BASE_URL + "resv/guest/" + resv_id + "/" + page_number + "/" + type + "/" + mode;
        window.location = redirect;
    }


    $(document).ready(function () {
        setTimeout(function () {
            $('.alert-success').text("");
            $('.alert-success').css("display", "none");
        }, 3000);

        $('input:text').on('focus blur', function () {
            $(this).toggleClass('yellow');
        });

        //filter housekeeping
        $('#housekeeping_action').on('change', function () {
            var current_val = $(this).val();
            var grid_type = "housekeeping";
            var url = BASE_URL + "app/filters/" + grid_type + "/0/" + current_val;
            console.log('filter url: ' + url);

            var img = BASE_URL + "images/notif/ajax-loader.gif";
            var img_location = "#housekeeping_loader";
            console.log('img_loader ' + img);
            console.log('img_location ' + img_location);
            $(img_location).html("<img src='" + img + "' width='16' height='16' >");

            $.ajax({
                type: "POST",
                url: url,
                dataType: "json",
                success: function (data) {
                    var datafields_data;
                    var columndata;
                    var datafields_data = [
                        {name: 'ID', type: 'number'},
                        {name: 'title', type: 'string'},
                        {name: 'room_status', type: 'string'},
                        {name: 'rt_title', type: 'string'},
                        {name: 'remark', type: 'string'}
                    ];

                    var columndata = [
                        {text: 'Room No.', datafield: 'title', align: 'left', cellsalign: 'left'},
                        {text: 'Room Type', datafield: 'rt_title'},
                        {text: 'Status', datafield: 'room_status'},
                        {text: 'Remarks', datafield: 'remark'}
                    ];

                    $(img_location).html('');

                    configuration.grid(datafields_data, columndata, data, grid_type, "100%", 0, current_val);

                },
                error: function () {
                    console.log('fetch data failed');
                }
            });

        });

        //fetch grid
        switch (PAGE_TYPE) {
            case 'role':
            case 'user':
            case 'roomclass':
            case 'roomtype':
            case 'account_type':
            case 'account_discount':
            case 'account_salescategory':
            case 'account_class':
            case 'account_payment':
            case 'account_sale':
            case 'account_plu_group':
            case 'account_plu_number':
            case 'room':
            case 'price':
            case 'terminals':
            case 'housekeeping':
            case 'person':
                fetchGridData(PAGE_TYPE);
                break;
            default:
                break;
        }

        switch (ACTION) {
            case 'access_denied':
                $("#access_modal").modal({backdrop: false, keyboard: false});
        }
        //calenders
        if (header_title === "Guest") {
            var app_date = "<?php echo $app_date; ?>";
            var t = app_date.split(/[- :]/);
            var APP_DATE = new Date(Date.UTC(t[0], t[1] - 1, t[2]));
            var NEXT_DATE = new Date(Date.UTC(t[0], t[1] - 1, t[2]));
//            var NEXT_DATE = new Date(Date.UTC(t[0], t[1] - 1, t[2], t[3], t[4], t[5]));
            NEXT_DATE = new Date(NEXT_DATE.setTime(NEXT_DATE.getTime() + 1 * 86400000));

            $('#guest_arrival').jqxDateTimeInput({width: 100, height: 25});
            $('#guest_arrival').jqxDateTimeInput('setDate', APP_DATE);

            $('#guest_departure').jqxDateTimeInput({width: 100, height: 25, disabled: true});
            $('#guest_departure').jqxDateTimeInput('setDate', NEXT_DATE);

            var arrival = "<?php echo $arrival; ?>";
            var departuredate = "<?php echo $departuredate; ?>";
            var arrivaldate = "<?php echo $arrivaldate; ?>";
            if (arrival) {//data from db
                var arrival_date = "<?php echo date('d/m/Y', strtotime($arrival)); ?>";
                $('#guest_arrival').jqxDateTimeInput('setDate', arrival_date);

                var departure_date = "<?php echo date('d/m/Y', strtotime($departure)); ?>";
                $('#guest_departure').jqxDateTimeInput('setDate', departure_date);

            }
            if (arrivaldate) {//errors exist
                $('#guest_arrival').jqxDateTimeInput('setDate', arrivaldate);
                $('#guest_departure').jqxDateTimeInput('setDate', departuredate);
            }
        }

        if (header_title === "Checkin") {
            $('#checkin_arrival').jqxDateTimeInput({width: 100, height: 25});
            $('#checkin_departure').jqxDateTimeInput({width: 100, height: 25, disabled: true});

            var arrival = "<?php echo $arrival; ?>";
            var departuredate = "<?php echo $departuredate; ?>";
            var arrivaldate = "<?php echo $arrivaldate; ?>";
            if (arrival) {//data from db
                var arrival_date = "<?php echo date('d/m/Y', strtotime($arrival)); ?>";
                $('#checkin_arrival').jqxDateTimeInput('setDate', arrival_date);

                var departure_date = "<?php echo date('d/m/Y', strtotime($departure)); ?>";
                $('#checkin_departure').jqxDateTimeInput('setDate', departure_date);
            }
            if (arrivaldate) {//errors exist
                $('#checkin_arrival').jqxDateTimeInput('setDate', arrivaldate);
                $('#checkin_departure').jqxDateTimeInput('setDate', departuredate);
            }
        }

        if (header_title === "Clients") {
            $('#person_birthday').jqxDateTimeInput({width: 100, height: 25});
            $('#person_pp_issued_date').jqxDateTimeInput({width: 100, height: 25});
            $('#person_pp_expiry_date').jqxDateTimeInput({width: 100, height: 25});
        }

        //reservation functs
        $('#guest_arrival').on('valueChanged', function () {
            reservation.calcRoomPrice();
        });
        $('body').on('blur', '#guest_nights,#guest_weekday,#guest_weekend,#guest_holiday,#guest_price_extra,#guest_comp_nights', function () {
            reservation.calcRoomPrice();
        });

        $('#guest_client_name').keyup(function () {
            var searchterm = $(this).val();
            var trimedsearch = searchterm.trim();
            if (trimedsearch)
                search('client', 'person', trimedsearch);
        });

//        $('#guest_agency_name').keyup(function () {
//            var searchterm = $(this).val();
//            if (searchterm && searchterm != " ")
//                search('agency','person', searchterm);
//        });

        $('body').on('click', '.reservations_live_results', function () {
            var $this_id = $(this).attr('id');
            var $this_val = $(this).text();
            var parent_id = "#" + $(this).parent().attr('id');
            console.log('parent_id ' + parent_id);
            var prefix = parent_id.replace("_reservations_live", "");
            prefix = prefix.replace("#", "");
            var field = "#guest_" + prefix + "_name";
            $(field).val($this_val);
            $(parent_id).html("");
            $(parent_id).hide();
            if (prefix == "client") {
                $('#guest_guest1').val($this_val);
            }

        });

        $('#guest_client_name').on('blur', function () {
            if (!$("#client_reservations_live").is(":hover")) {
                console.log('live_results is not hovered');
                $('#client_reservations_live').html("");
                $('#client_reservations_live').hide();
                $('#guest_guest1').val($(this).val());
//                reservation.storeNewClient();
            }
        });

        $('#guest_agency_name').on('blur', function () {
            if (!$("#agency_reservations_live").is(":hover")) {
                console.log('live_results is not hovered');
                $('#agency_reservations_live').html("");
                $('#agency_reservations_live').hide();
//                reservation.storeNewClient();
            }
        });

        //reservatiion submission
        $('#guest_form').submit(function () {
            $('#guest_status').prop('disabled', false);
            $('#guest_comp_visits').prop('disabled', false);
        });

        $('#checkin_form').submit(function () {
            $('#checkin_reservation_id').prop('disabled', false);
        });

        $('body').on('click', '.booking_radio', function () {//select or deselect a row
            console.log('a radio was clicked');
            var $this = $(this);
            $('.booking_radio').removeClass('active');
            $this.addClass('active');
        });
    });


</script>


</body>
</html>

