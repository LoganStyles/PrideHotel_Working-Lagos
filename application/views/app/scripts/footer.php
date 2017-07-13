<!-- person_modal Modal -->
<div id="new_person_modal" class="modal fade"  role="dialog">
    <div class="modal-dialog" style="width:1000px;"> 

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header panel-heading dark">
                <h4 class="modal-title" style="text-align:center"></h4>
            </div>

            <div class="modal-body" > 
                <?php
                $attributes = array('class' => 'cmxform form-horizontal adminex-form', 'id' => 'new_person_form');
                echo form_open('resv/processPerson', $attributes);
                ?>

                <div class="panel-body">
                    <div class="form">
                        <input type="hidden" name="person_ID"  id="person_ID" value="0">
                        <input type="hidden" name="person_type" id="person_type" value="person">
                        <input type="hidden" name="person_action" id="person_action" value="insert">
                        <input type="hidden" name="person_page_number" id="person_page_number" value="0">

                        <div class="form-group ">
                            <label for="person_title" class="col-sm-1 control-label">Name</label>
                            <div class="col-sm-2">
                                <input  class=" form-control" id="person_title" value="" name="person_title" type="text" />
                            </div>

                            <label for="person_title_ref" class="col-sm-1 control-label">Title</label>
                            <div class="col-lg-2 col-sm-2">
                                <select  class="form-control " name="person_title_ref" id="person_title_ref">
                                    <option value="mr." >Mr.</option>
                                    <option value="mrs." >Mrs.</option>
                                    <option value="miss." >Miss.</option>
                                    <option value="chief" >Chief</option>
                                </select>                                                                 
                            </div> 

                            <label for="person_email" class="col-sm-1 control-label">Email</label>
                            <div class="col-sm-2">
                                <input  class=" form-control" id="person_email" name="person_email" value="" type="text" />                                
                            </div> 

                            <label for="person_phone" class="col-sm-1 control-label">Phone</label>
                            <div class="col-sm-2">
                                <input  class=" form-control" id="person_phone" name="person_phone" value="" type="text" />                                
                            </div> 
                        </div>

                        <div class="form-group ">
                            <label for="person_street" class="col-sm-1 control-label">Street</label>
                            <div class="col-sm-3">
                                <input  class=" form-control" id="person_street" value="" name="person_street" type="text" />
                            </div>

                            <label for="person_city" class="col-sm-1 control-label">City</label>
                            <div class="col-sm-3">
                                <input  class=" form-control" id="person_city" value="" name="person_city" type="text" />
                            </div>

                            <label for="person_state" class="col-sm-1 control-label">State</label>
                            <div class="col-sm-3">
                                <input  class=" form-control" id="person_state" name="person_state" value="" type="text" />                                
                            </div> 
                        </div>

                        <div class="form-group ">
                            <label for="person_sex" class="col-sm-1 control-label">Gender</label>
                            <div class="col-lg-3 col-sm-3">
                                <select  class="form-control " name="person_sex" id="person_sex">
                                    <option value="m" >Male</option>
                                    <option value="f" >Female</option>
                                </select>                                                                 
                            </div> 

                            <label for="person_occupation" class="col-sm-1 control-label">Occupation</label>
                            <div class="col-sm-3">
                                <input  class=" form-control" id="person_occupation" value="" name="person_occupation" type="text" />
                            </div>

                            <label for="person_birth_location" class="col-sm-1 control-label">Birth Location</label>
                            <div class="col-sm-3">
                                <input  class=" form-control" id="person_birth_location" name="person_birth_location" value="" type="text" />                                
                            </div> 
                        </div>

                        <div class="form-group ">
                            <label for="person_passport_no" class="col-sm-2 control-label">Passport No</label>
                            <div class="col-lg-2 col-sm-2">
                                <input  class=" form-control" id="person_passport_no" value="" name="person_passport_no" type="text" />
                            </div>

                            <label for="person_pp_issued_at" class="col-sm-2 control-label">Issued At</label>
                            <div class="col-sm-2">
                                <input  class=" form-control" id="person_pp_issued_at" value="" name="person_pp_issued_at" type="text" />
                            </div>

                        </div>

                        <div class="form-group ">
                            <label for="person_visa" class="col-sm-1 control-label">Visa</label>
                            <div class="col-lg-2 col-sm-2">
                                <input  class=" form-control" id="person_visa" value="" name="person_visa" type="text" />
                            </div>

                            <label for="person_resident_permit_no" class="col-sm-1 control-label">Resident Permit No.</label>
                            <div class="col-sm-2">
                                <input  class=" form-control" id="person_resident_permit_no" value="" name="person_resident_permit_no" type="text" />
                            </div>

                            <label for="person_spg_no" class="col-sm-1 control-label">SPG No.</label>
                            <div class="col-sm-2">
                                <input  class=" form-control" id="person_spg_no" value="" name="person_spg_no" type="text" />
                            </div>

                            <label for="person_destination" class="col-sm-1 control-label">Destination</label>
                            <div class="col-sm-2">
                                <input  class=" form-control" id="person_destination" value="" name="person_destination" type="text" />
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="person_payment_method" class="col-sm-1 control-label">Payment Method</label>
                            <div class="col-lg-2 col-sm-2">
                                <select  class="form-control " name="person_payment_method" id="person_payment_method">
                                    <option value="cash" >Cash</option>
                                    <option value="pos" >POS</option>
                                    <option value="coy" >Charge to Company</option>
                                    <option value="cheque" >Cheque</option>
                                </select>                                                                 
                            </div>

                            <label for="person_group_name" class="col-sm-1 control-label">Group Name</label>
                            <div class="col-sm-2">
                                <input  class=" form-control" id="person_group_name" value="" name="person_group_name" type="text" />
                            </div>

                            <label for="person_plate_number" class="col-sm-1 control-label">Plate Number</label>
                            <div class="col-sm-2">
                                <input  class=" form-control" id="person_plate_number" value="" name="person_plate_number" type="text" />
                            </div>

                            <label for="person_remarks" class="col-sm-1 control-label">Remarks</label>
                            <div class="col-sm-2">
                                <input  class=" form-control" id="person_remarks" value="" name="person_remarks" type="text" />
                            </div>
                        </div>
                    </div>   
                </div>
                <div class="pull-right">
                    <input class="btn btn-success btn-sm" type="submit" name="submit" value="Save" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--person_modal -->

<!--footer section start-->
<div role="dialog" id="delete_modal" class="modal fade">
    <div class="modal-dialog" style="width: 600px;">
        <div class="modal-content">
            <div class="modal-header panel-heading dark" >                
                <h4 class="modal-title" style="text-align:center">Delete Dialog</h4>
            </div>
            <div class="modal-body">

                <?php
                $attributes = array('class' => 'cmxform form-horizontal adminex-form', 'id' => 'client_form');
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

<div role="dialog" id="confirm_modal" class="modal fade">
    <div class="modal-dialog" style="width: 600px;">
        <div class="modal-content">
            <div class="modal-header panel-heading dark" >                
                <h4 class="modal-title" style="text-align:center">ACTION CONFIRMATION</h4>
            </div>
            <div class="modal-body">
                <h5><strong>Are You Sure You Want To Perform This Action</strong></h5>
                <form class="cmxform form-horizontal adminex-form" id="confirm_form" action="">
                    <input type="hidden" name="confirm_type"  id="confirm_type">
                    <div id="confirm_error"></div>
                    <div class="panel-body">
                        <div class="form">                            
                            <div class="form-group ">
                                <label for="confirm_reason" class="col-sm-3 control-label">Provide Reason</label>
                                <div class="col-sm-9">
                                    <input  class=" form-control" id="confirm_reason" name="confirm_reason" type="text" />                                
                                </div>                                                      
                            </div>
                        </div>
                    </div>                
            </div>
            <div class="modal-footer">
                <input class="btn btn-success btn-sm" type="submit" name="submit" value="SUBMIT" />
                <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
            </div>
            </form> 
        </div>
    </div>
</div>

<?php if ($print === "") { ?>

    <footer>
        &copy; <?php echo date('Y'); ?>  Powered by <a href="http://webmobiles.com.ng/" target="_blank" >Webmobiles IT Services Ltd</a>
        <span style="margin-left: 2%;color: #FF4545;"><?php echo $expiration;?></span>
    </footer>
    <!--footer section end-->
<?php } ?>

</div>
<!-- main content end-->
</section>

<?php include_once 'js_scripts.php'; ?>

<script type="text/javascript">
    var BASE_URL = "<?php echo base_url(); ?>";
    var PAGE_TYPE = "<?php echo $type; ?>";
    var ACTION = "<?php echo $action; ?>";
    var header_title = "<?php echo $header_title; ?>";
    var new_client = "<?php echo $new_client; ?>";

    function updateItem(type, ID, value) {
        var url = BASE_URL + "app/processUpdate/" + type + "/" + ID + "/" + value;
        console.log('update url: ' + url);
        window.location = url;
    }

    function getRoomReservation(room) {
        var url = BASE_URL + "app/getRoomReservation/" + room;
        console.log('update url: ' + url);
        window.location = url;
    }

    function closeWindow(type, page_number) {
        if (!type) {
            window.location = BASE_URL + "app";
        } else {
            window.location = BASE_URL + "resv/viewLists/" + type + "/" + page_number;
        }
    }
    
    function groupCloseWindow(type, page_number) {
        if (!type) {
            window.location = BASE_URL + "app";
        } else {
            window.location = BASE_URL + "group/viewLists/" + type + "/" + page_number;
        }
    }

    function printAction(action, url) {
        $('#print_box').hide();
        if (action === "print") {
            window.print();
        }
        window.location = url;
    }

    function printAll(type) {
        var url = BASE_URL + "report/printAllItems/" + type;
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
        var submit_but = formid + " input[type='submit']";

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
            case 'view':
                $(form_action).val("view");
                $(submit_but).attr('disabled', true);
                $(modal).addClass("in").css('display', 'block');
                var allforminputs = "#" + type + "_form :input";
                $(allforminputs).attr('readonly', 'readonly');
                $(itemid).val(id);
                console.log('case view');
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
            show = "viewLists";
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
        var status = $('.booking_radio.active .booking_hidden_status').text();

        console.log('resv_id is ' + resv_id);
        console.log('type is ' + type);
        var redirect = BASE_URL + "resv/guest/" + resv_id + "/0/" + page_number + "/" + type + "/" + mode;
        window.location = redirect;
    }
    
    function newGroupResv(page_number, mode){
        var master_id = $('.booking_radio.active .booking_hidden_id').val();
        var redirect = BASE_URL + "resv/guest/0/" + master_id + "/" + page_number + "/insert/" + mode;
        window.location = redirect;
    }
    
    function processGroupResv(type, page_number, mode) {/*handler for reservation actions
     * gets the resv id & type of operation, then calls controller*/
        var resv_id = $('.booking_radio.active .booking_hidden_id').val();

        console.log('resv_id is ' + resv_id);
        console.log('type is ' + type);
        var redirect = BASE_URL + "group/group/" + resv_id + "/" + page_number + "/" + type + "/" + mode;
        window.location = redirect;
    }

    function getFolio(page_number, mode, bill_type, room_number, departure) {
        /*handler to get folio actions
         * gets the resv id,client_name & type of operation, then calls controller*/
        var resv_id = $('.booking_radio.active .booking_hidden_id').val();
        var folio_room = $('.booking_radio.active .folio_hidden_folio_room').val();
        var master_id = $('.booking_radio.active .folio_hidden_master_id').val();
        master_id=(master_id)?(master_id):("0");
        var client_name = $('.booking_radio.active .booking_hidden_client').text();
        console.log('master_id is ' + master_id);

        var redirect = BASE_URL + "resv/viewFolios/" + resv_id + "/"+ master_id + "/" + page_number + "/" + mode + "/" + client_name + "/" + bill_type + "/" + folio_room + "/" + room_number;
        window.location = redirect;
    }

    function processFolio(mode) {
        var folio_action = $('.folio_row.active .folio_hidden_action').val();//sale/payment
        var modal = "";
        var form = "";
        var allforminputs = "";
        var description_field = "";
        var account_field = "";
        var amount_field = "";
        var account_ID = "";

        if (!folio_action) {
            folio_action = "sale";
        }
        modal = "#folio_" + folio_action + "_modal";
        form = "#folio_" + folio_action + "_form";

        switch (mode) {
            case 'new':
                newFolio(folio_action);
                break;
            case 'delete':
                var folio_id = $('.folio_row.active .folio_hidden_id').val();
                $('#delete_id').val(folio_id);
                $('#delete_type').val("reservationfolio");
                $("#delete_modal").modal({backdrop: false, keyboard: false});
                break;
            case 'edit':
                /*confirm if acct closing is > folio_creation
                 * get account_number & description
                 */
                var folio_id = $('.folio_row.active .folio_hidden_id').val();
                var folio_active = $('.folio_row.active .folio_hidden_active').val();
                var folio_account_number = $('.folio_row.active .folio_hidden_account_number').val();
                var folio_description = $('.folio_row.active .folio_description').text();
                var folio_incl_vat = $('.folio_row.active .folio_incl_vat').text();

                account_ID = "#folio_" + folio_action + "_ID";
                account_field = "#folio_" + folio_action + "_account";
                description_field = "#folio_" + folio_action + "_description";
                amount_field = "#folio_" + folio_action + "_amount";

                if (folio_action === "sale") {
                    var folio_plu_group = $('.folio_row.active .folio_hidden_plu_group').val();
                    var folio_plu = $('.folio_row.active .folio_hidden_plu').val();
                    var folio_price = $('.folio_row.active .folio_hidden_price').val();
                    var folio_sale_account_title = $('.folio_row.active .folio_hidden_sale_account_title').val();
                    var folio_qty = $('.folio_row.active .folio_qty').text();

                    $('#folio_sale_plu_group').val(folio_plu_group);
                    $('#folio_sale_plu').val(folio_plu);
                    $('#folio_sale_account_title').val(folio_sale_account_title);
                    $('#folio_sale_price').val(folio_price);
                    $('#folio_sale_qty').val(folio_qty);
                }

                $(modal).modal({backdrop: false, keyboard: false});
                $(account_ID).val(folio_id);
                $(account_field).val(folio_account_number);
                $(description_field).val(folio_description);
                $(amount_field).val(folio_incl_vat);
                if (folio_active === "") {
                    allforminputs = form + " :input";
                    $(allforminputs).attr('readonly', 'readonly');
                }
                break;
        }
    }

    function processPrintFolio(paper_type, billtype) {
        var folio_resv = $('.folio_row.active .folio_hidden_resv').val();
        folio_resv = (folio_resv > 0) ? (folio_resv) : (0);
        var url = BASE_URL + "report/printFolios/" + folio_resv + "/" + paper_type + "/" + billtype;
        console.log('update url: ' + url);
        window.location = url;
    }

    function processPrintCheckout(paper_type, resv_id, modifier) {
        var url = BASE_URL + "report/printCheckout/" + resv_id + "/" + paper_type + "/" + modifier;
        window.location = url;
    }

    function newFolio(folio_action) {
        var modal = "#folio_" + folio_action + "_modal";
        var form = "#folio_" + folio_action + "_form";
        $(modal).addClass("in").css('display', 'block');
        $(form).trigger('reset');
        $(modal).modal({backdrop: false, keyboard: false});
    }

    function showDialog(modal, error_id) {
        var folio_id = $('.folio_row.active .folio_hidden_id').val();
        if (folio_id) {
            $(error_id).removeClass('alert alert-danger error');
            $(error_id).text('');
            $(modal).modal({backdrop: false, keyboard: false});
        }
    }

    function showSingleDialog(page, subtype) {
        var type = "#" + page + "_type";
        var error_id = "#" + page + "_error";
        var modal = "#" + page + "_modal";
        var reason = "#" + page + "_reason";
        $(reason).val("");

        if (subtype) {
            $(type).val(subtype);//stores the subtype
            $(error_id).removeClass('alert alert-danger error');
            $(error_id).text('');
            $(modal).modal({backdrop: false, keyboard: false});
        }
    }

    function processClient(type) {/*handler for client actions
     * gets the person id & type of operation, then calls controller*/
        var person_id = $('.booking_radio.active .booking_hidden_id').val();
        console.log('person_id is ' + person_id);
        console.log('type is ' + type);
        modalLoader('person', '#person_modal', type, person_id);
    }

    function showErrorResponse(error_id, message) {
        $(error_id).addClass('alert alert-danger error');
        $(error_id).text(message);
    }

    function checkInOut() {
        //from resv::determine if a checkin/checkout is possible
        var mode = $('.booking_radio.active .booking_hidden_status').text();
        var arrival = $('.booking_radio.active .booking_hidden_arrival').text();
        var departure = $('.booking_radio.active .booking_hidden_departure').text();
        var client_name = $('.booking_radio.active .booking_hidden_client').text();
        var room_number = $('.booking_radio.active .booking_hidden_room').text();
        var resv_id = $('.booking_radio.active .booking_hidden_id').val();
        var app_date = "<?php echo date('d/m/Y', strtotime($app_date)); ?>";
        console.log('status : ' + mode);
        console.log('arrival : ' + arrival);
        console.log('app_date : ' + app_date);
        console.log('departure : ' + departure);
        if ((mode === "confirmed") && (arrival === app_date)) {
            checkin(mode, resv_id);
        } else if (mode === "staying") {
            //initiate checkout
            checkout(resv_id, client_name, room_number, departure);
        }
    }

    function checkin(mode, resv_id) {
        var redirect = BASE_URL + "resv/checkIn/" + mode + "/" + resv_id;
        console.log(redirect);
        window.location = redirect;
    }
    
    function groupCheckInOut() {
        //from resv::determine if a checkin/checkout is possible
        var mode = $('.booking_radio.active .booking_hidden_status').text();
        var arrival = $('.booking_radio.active .booking_hidden_arrival').text();
        var departure = $('.booking_radio.active .booking_hidden_departure').text();
        var client_name = $('.booking_radio.active .booking_hidden_client').text();
        var resv_id = $('.booking_radio.active .booking_hidden_id').val();
        var app_date = "<?php echo date('d/m/Y', strtotime($app_date)); ?>";
        console.log('status : ' + mode);
        console.log('arrival : ' + arrival);
        console.log('app_date : ' + app_date);
        console.log('departure : ' + departure);
        if ((mode === "confirmed") && (arrival === app_date)) {
            groupCheckin(mode, resv_id);
        } else if (mode === "staying") {
            //initiate checkout
            var room_number=0;
            checkout(resv_id, client_name,room_number, departure);
        }
    }
    
    function groupCheckin(mode, resv_id) {
        var redirect = BASE_URL + "group/checkIn/" + mode + "/" + resv_id;
        console.log(redirect);
        window.location = redirect;
    }

    function ledgerCheckin() {
        var resv_id = $('.booking_radio.active .booking_hidden_id').val();
        checkin('all', resv_id);
    }

    function checkout(resv_id, client_name, room_number, departure) {
        /*display days to departure(diff bw app_date & departure)
         * display folio summary
         * determine possible checkout or not & display appropriate form
         * yes()
         * */
        //display days to departure(diff bw app_date & departure)
        var app_date = "<?php echo date('d/m/Y', strtotime($app_date)); ?>";
        var days_to_dep = calcDateDiffWithSign(departure,app_date);        
        if (days_to_dep > 0) {
            alert("WARNING::Days to Departure: " + days_to_dep);
        }
        //display folio summary
        var redirect = BASE_URL + "resv/viewFoliosCheckout/" + resv_id + "/" + client_name + "/" + room_number;
        window.location = redirect;
    }

    function processOverdueDates() {
        //get checked rows
        var selected_rows = [];
        $('.overdue_row input:checked').each(function () {
            selected_rows.push($(this).next('input').val());
        });
        console.log('select ' + selected_rows);
        var checked_json = JSON.stringify(selected_rows);
        //insert progress bar here
        var notify = $.notify('<strong>Processing,</strong> Please wait...', {
            type: 'success',
            allow_dismiss: false,
            showProgressbar: true,
            z_index: 1100,
            delay: 3000
        });
        $.ajax({
            url: "<?php echo site_url('resv/updateOverdueDepartures'); ?>",
            type: "POST",
            dataType: "json",
            data: {
                "selected_rows": checked_json
            },
            success: function (data) {
                if (data.response === "success") {
                    notify.update('message', '<strong>Successful, </strong> Completing Action...');
                    setTimeout(function () {
                        var redirect = BASE_URL + "app/night";
                        window.location = redirect;
                    }, 3000);

                } else {
                    notify.update('message', '<strong>Update Not Successful, </strong> Ending Action...');
                    console.log(data.message);
                    alert(data.message);
                }
            },
            error: function () {
                notify.update('message', '<strong>Error Occured, </strong> Ending Action...');
                console.log('update overdue departures failed ');
            }
        });
    }


    $(document).ready(function () {
        setTimeout(function () {
            $('.alert-success').text("");
            $('.alert-success').css("display", "none");
        }, 3000);

        $('input:text').on('focus blur', function () {
            $(this).toggleClass('yellow');
        });

        $('#folio_payment_account').on('change', function () {
            var current_val = $(this).val();
            var url = BASE_URL + "resv/getFieldValue/account_payment/" + current_val + "/description";
            console.log(url);

            $.ajax({
                type: "POST",
                url: url,
                dataType: "text",
                success: function (data) {
                    console.log('data ' + data);
                    $('#folio_payment_description').val(data);
                },
                error: function () {
                    console.log('getFieldVale data failed');
                }
            });
        });

        $('body').on('change', '#folio_bills', function () {
            var bill_type = $(this).val();
            var page_number = $('#folio_payment_page_number').val();
            var mode = $('#folio_payment_type').val();
            console.log('bill_type ' + bill_type + ' page_number ' + page_number + ' mode ' + mode);

            var resv_id = $('#folio_payment_resv').val();
            var client_name = $('#folio_payment_client_name').val();
            var folio_room = $('#folio_payment_new_folio').val();
            var room_number = $('#folio_payment_room_number').val();
            var master_id = $('#folio_payment_master_ID').val();
            master_id=(master_id !=="")?(master_id):("0");
            console.log('resv_id is ' + resv_id);

            var redirect = BASE_URL + "resv/viewFolios/" + resv_id + "/"+ master_id + "/" + page_number + "/" + mode + "/" + client_name + "/" + bill_type + "/" + folio_room + "/" + room_number;
            window.location = redirect;
        });

        $('body').on('change', '#new_folio_bills', function () {
            var new_folio_bill = $(this).val();
            $('#folio_payment_new_folio').val(new_folio_bill);
            $('#folio_sale_new_folio').val(new_folio_bill);
        });

        $('#folio_sale_plu_group').on('change', function () {
            var current_val = $(this).val();
            fetchRowData("folio_sale", current_val);
        });

        $('body').on('blur', '#folio_sale_price,#folio_sale_qty', function () {
            var current_price = $('#folio_sale_price').val();
            current_price = (current_price > 0) ? (current_price) : (0);
            var current_qty = $('#folio_sale_qty').val();
            current_qty = (current_qty > 0) ? (current_qty) : (0);
            var current_amount = parseFloat(current_price * current_qty);
            $('#folio_sale_amount').val(current_amount);
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
                var resv_status = "<?php echo $resv_status; ?>";
                console.log('resv_status '+resv_status);
                if ((resv_status == "departed") || (resv_status == "ledger") || (resv_status == "staying") || (resv_status == "provisional")) {
                    $('#guest_arrival').jqxDateTimeInput({disabled: true});
                }else{
                    $('#guest_arrival').jqxDateTimeInput({disabled: false});
                }
                $('#guest_arrival').jqxDateTimeInput('setDate', arrival_date);

                var departure_date = "<?php echo date('d/m/Y', strtotime($departure)); ?>";
                $('#guest_departure').jqxDateTimeInput('setDate', departure_date);

            }
            if (arrivaldate) {//errors exist
                $('#guest_arrival').jqxDateTimeInput('setDate', arrivaldate);
                $('#guest_departure').jqxDateTimeInput('setDate', departuredate);
            }
//            reservation.calcRoomPrice();//calc room price
        }
        
        if (header_title === "Group") {
            var app_date = "<?php echo $app_date; ?>";
            var t = app_date.split(/[- :]/);
            var APP_DATE = new Date(Date.UTC(t[0], t[1] - 1, t[2]));
            var NEXT_DATE = new Date(Date.UTC(t[0], t[1] - 1, t[2]));
//            var NEXT_DATE = new Date(Date.UTC(t[0], t[1] - 1, t[2], t[3], t[4], t[5]));
            NEXT_DATE = new Date(NEXT_DATE.setTime(NEXT_DATE.getTime() + 1 * 86400000));

            $('#group_arrival').jqxDateTimeInput({width: 100, height: 25});
            $('#group_arrival').jqxDateTimeInput('setDate', APP_DATE);

            $('#group_departure').jqxDateTimeInput({width: 100, height: 25, disabled: true});
            $('#group_departure').jqxDateTimeInput('setDate', NEXT_DATE);

            var arrival = "<?php echo $arrival; ?>";
            var departuredate = "<?php echo $departuredate; ?>";
            var arrivaldate = "<?php echo $arrivaldate; ?>";
            if (arrival) {//data from db
                var arrival_date = "<?php echo date('d/m/Y', strtotime($arrival)); ?>";
                var resv_status = "<?php echo $resv_status; ?>";
                if ((resv_status == "departed") || (resv_status == "ledger") || (resv_status == "staying") || (resv_status == "provisional")) {
                    $('#group_arrival').jqxDateTimeInput({disabled: true});
                }
                $('#group_arrival').jqxDateTimeInput('setDate', arrival_date);

                var departure_date = "<?php echo date('d/m/Y', strtotime($departure)); ?>";
                $('#group_departure').jqxDateTimeInput('setDate', departure_date);

            }
            if (arrivaldate) {//errors exist
                $('#group_arrival').jqxDateTimeInput('setDate', arrivaldate);
                $('#group_departure').jqxDateTimeInput('setDate', departuredate);
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

        if (header_title === "Reports") {
            $('#report_from').jqxDateTimeInput({width: 100, height: 25});
            $('#report_to').jqxDateTimeInput({width: 100, height: 25});
        }

        if (header_title === "Person") {
            $('#person_birthday').jqxDateTimeInput({width: 100, height: 25});
            $('#person_pp_issued_date').jqxDateTimeInput({width: 100, height: 25});
            $('#person_pp_expiry_date').jqxDateTimeInput({width: 100, height: 25});
        }

        if (new_client) {
            console.log('new_client ' + new_client);
            $("#person_title").val(new_client);
            $("#new_person_modal .modal-title").text("Guest '" + new_client + "' was not found, Do you want to add it?");
            $("#new_person_modal").modal({backdrop: false, keyboard: false});
        }

        //reservation functs
        $('#guest_arrival').on('valueChanged', function () {
            reservation.calcRoomPrice('guest');
        });
        $('body').on('blur', '#guest_nights,#guest_weekday,#guest_weekend,#guest_holiday,\n\
        #guest_price_extra,#guest_comp_nights', function () {
            reservation.calcRoomPrice('guest');
        });

        $('#guest_client_name').keyup(function () {
            var searchterm = $(this).val();
            var trimedsearch = searchterm.trim();
            if (trimedsearch)
                search('client', 'person', trimedsearch);
        });
        
        //group functs
        $('#group_arrival').on('valueChanged',function(){
            reservation.calcRoomPrice('group');
        });
        $('body').on('blur','#group_nights,#group_weekday,#group_weekend,#group_holiday,\n\
        #group_price_extra,#group_comp_nights',function(){
            reservation.calcRoomPrice('group');
        });
               

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
            }
        });

        $('#guest_agency_name').on('blur', function () {
            if (!$("#agency_reservations_live").is(":hover")) {
                console.log('live_results is not hovered');
                $('#agency_reservations_live').html("");
                $('#agency_reservations_live').hide();
            }
        });

        //reservatiion submission
        $('#guest_form').submit(function () {
            $('#guest_status').prop('disabled', false);
            $('#guest_comp_visits').prop('disabled', false);
        });
        
        //group submission
        $('#group_form').submit(function () {
            $('#group_status').prop('disabled', false);
            $('#group_comp_visits').prop('disabled', false);
        });

        $('#checkin_form').submit(function () {
            $('#checkin_reservation_id').prop('disabled', false);
        });

        $('body').on('change', '#folio_move_room_number', function () {
            var current_val = $(this).val();
            $.ajax({
                url: "<?php echo site_url('resv/confirmMoveFolioRoom'); ?>",
                type: "POST",
                dataType: "json",
                data: {
                    "room_id": current_val
                },
                success: function (data) {
                    if (data.response === "success") {
                        $('#folio_move_error').removeClass('alert alert-danger error');
                        $('#folio_move_error').text('');
                        $('#folio_move_reservation_id').val(data.reservation);
                    } else {
                        console.log(data.message);
                        showErrorResponse('#folio_move_error', data.message);
                    }
                },
                error: function () {
                    console.log('Room Confirmation failed');
                    showErrorResponse('#folio_move_error', 'Room Confirmation failed');
                }
            });
        });

        //move dialog submission
        $('#folio_move_modal').submit(function (e) {
            e.preventDefault();
            $('#folio_move_error').removeClass('alert alert-danger error');
            $('#folio_move_error').text('');

            var receiver_resv = $('#folio_move_reservation_id').val();
            var receiver_folio = $('#folio_move_bills').val();
            var move_reason = $('#folio_move_reason').val();
            if (move_reason === "") {//confirm that move reason exists
                showErrorResponse('#folio_move_error', 'Provide a reason');
                return false;
            }
            if (receiver_resv === "") {//confirm that reservation_id exists
                showErrorResponse('#folio_move_error', 'Provide a reservation number');
                return false;
            }
            //get checked rows
            var selected_rows = [];
            $('.folio_row input:checked').each(function () {
                selected_rows.push($(this).next('input').val());
            });
            var checked_json = JSON.stringify(selected_rows);
            $.ajax({
                url: "<?php echo site_url('resv/moveFolios'); ?>",
                type: "POST",
                dataType: "json",
                data: {
                    "selected_rows": checked_json,
                    "reservation_id": receiver_resv,
                    "folio": receiver_folio,
                    "move_reason": move_reason
                },
                success: function (data) {
                    if (data.response === "success") {
                        $('#folio_move_error').removeClass('alert alert-danger error');
                        $('#folio_move_error').text('');
                        location.reload();
                    } else {
                        console.log(data.message);
                        showErrorResponse('#folio_move_error', data.message);
                    }
                },
                error: function () {
                    console.log('move failed ');
                    showErrorResponse('#folio_move_error', 'move failed');
                }
            });
        });

        //manual room charge submission
        $('#folio_manual_charge_modal').submit(function (e) {
            e.preventDefault();
            $('#folio_manual_charge_error').removeClass('alert alert-danger error');
            $('#folio_manual_charge_error').text('');

            var manual_charge_reason = $('#folio_manual_charge_reason').val();
            if (manual_charge_reason === "") {//confirm that manual_charge reason exists
                showErrorResponse('#folio_manual_charge_error', 'Provide a reason');
                return false;
            }
            var curr_resv = $('#folio_manual_charge_resv').val();
            console.log('manual_charge_reason ' + manual_charge_reason);
            console.log('curr_resv ' + curr_resv);

            $.ajax({
                url: "<?php echo site_url('resv/manualRoomCharge'); ?>",
                type: "POST",
                dataType: "json",
                data: {
                    "manual_charge_reason": manual_charge_reason,
                    "manual_charge_reservation": curr_resv
                },
                success: function (data) {
                    if (data.response === "success") {
                        $('#folio_manual_charge_error').removeClass('alert alert-danger error');
                        $('#folio_manual_charge_error').text('');
                        location.reload();
                    } else {
                        console.log(data.message);
                        showErrorResponse('#folio_manual_charge_error', data.message);
                    }
                },
                error: function () {
                    console.log('manual charge failed ');
                    showErrorResponse('#folio_manual_charge_error', 'manual charge failed');
                }
            });
        });

        //confirm
        $('#confirm_modal').submit(function (e) {
            e.preventDefault();
            $('#confirm_error').removeClass('alert alert-danger error');
            $('#confirm_error').text('');

            var reason = $('#confirm_reason').val();
            if (reason === "") {//confirm that reason exists
                showErrorResponse('#confirm_error', 'Provide a reason');
                return false;
            }
            var curr_type = $('#confirm_type').val();
            console.log('reason ' + reason);
            console.log('curr_type ' + curr_type);
            //disable submit & close buttons
            $('#confirm_modal input:submit').attr('disabled', true);
            $('#confirm_modal button').attr('disabled', true);
            //insert progress bar here
            var notify = $.notify('<strong>Processing, </strong> Please wait...', {
                type: 'success',
                allow_dismiss: false,
                showProgressbar: true,
                z_index: 1100,
                delay: 3000
            });
            var curr_url = "<?php echo site_url('resv/confirmOperations'); ?>";
            var values = {"reason": reason, "type": curr_type};

            switch (curr_type) {
                case 'return':
                    //get checked rows
                    var selected_rows = [];
                    $('.folio_row input:checked').each(function () {
                        selected_rows.push($(this).next('input').val());
                    });
                    var checked_json = JSON.stringify(selected_rows);
                    values = {"selected_rows": checked_json, "reason": reason, "type": curr_type};
                    
                    break;
                case 'reactivate':
                    var resv_id = $('.booking_radio.active .booking_hidden_id').val();
                    console.log('resv_id ' + resv_id);
                    values = {"reason": reason, "type": curr_type, "resv_id": resv_id};
                    break;
                case 'master':
                    var resv_id = $('.folio_row.active .folio_hidden_resv').val();
                    var master_id = $('#folio_payment_master_id').val();
                    console.log('resv_id ' + resv_id);
                    console.log('master_id ' + master_id);
                    values = {"reason": reason, "type": curr_type, "resv_id": resv_id,"master_id":master_id};
                    break;
            }

            $.ajax({
                url: curr_url,
                type: "POST",
                dataType: "json",
                data: values,
                success: function (data) {
                    if (data.response === "success") {
                        notify.update('message', '<strong>Successful, </strong> Completing Action...');
                        $('#confirm_error').removeClass('alert alert-danger error');
                        $('#confirm_error').text('');

                        setTimeout(function () {
                            if (curr_type === "close" && data.overdue_departures === "YES") {
                                var redirect = BASE_URL + "resv/viewOverdueDepartures/0";
                                window.location = redirect;
                            } else {
                                location.reload();
                            }
                        }, 2000);
                    } else {
                        notify.update('message', '<strong>Action Not Successful, </strong> Ending...');
                        console.log(data.message);
                        showErrorResponse('#confirm_error', data.message);
                        //enable submit & close buttons
                        $('#confirm_modal input:submit').attr('disabled', false);
                        $('#confirm_modal button').attr('disabled', false);
                    }
                },
                error: function () {
                    //enable submit & close buttons
                    $('#confirm_modal input:submit').attr('disabled', false);
                    $('#confirm_modal button').attr('disabled', false);
                    console.log(curr_type + ' failed ');
                    showErrorResponse('#confirm_error', curr_type + ' failed');
                },
                complete: function (xhr, status) {

                }
            });
        });

        $('body').on('click', '.booking_radio', function () {
            //select or deselect a row
            console.log('a radio was clicked');
            var $this = $(this);
            $('.booking_radio').removeClass('active');
            $this.addClass('active');
        });

        $('body').on('click', '.folio_row', function () {
            //select or deselect a row
            console.log('a radio was clicked');
            var $this = $(this);
            $('.folio_row').removeClass('active');
            $this.addClass('active');
        });

        $('body').on('click', '.overdue_row', function () {
            //select or deselect a row
            console.log('a radio was clicked');
            var $this = $(this);
            $('.overdue_row').removeClass('active');
            $this.addClass('active');
        });

        $('body').on('click', '#check_all_overdue', function () {
            //select all overdues
            if ($(this).is(':checked')) {
                $('.overdue_row input:checkbox').prop("checked", true);
                console.log('val 1');
            } else {//deselect all overdues
                $('.overdue_row input:checkbox').prop("checked", false);
                console.log('val 0');
            }
        });

    });


</script>
</body>
</html>

