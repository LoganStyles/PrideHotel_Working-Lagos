
function fetchGridData(grid_type) {
    console.log('grid_type' + grid_type);

    var form_page_number = "#" + grid_type + "_page_number";
    var form_action = "#" + grid_type + "_action";

    var page_number = $(form_page_number).val();
    var action = $(form_action).val();
    console.log('fetchGridData action: ' + action);

    var url = BASE_URL + "app/fetchJsonData/" + grid_type + "/0";
    console.log(url);
    var img = BASE_URL + "images/notif/ajax-loader.gif";
    var img_location = "#" + grid_type + "_loader";
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

            switch (grid_type) {
                case 'role':
                    datafields_data = [
                        {name: 'ID', type: 'number'},
                        {name: 'title', type: 'string'},
                        {name: 'description', type: 'string'}
                    ];

                    columndata = [
                        {text: 'Group', datafield: 'title', align: 'left', cellsalign: 'left'},
                        {text: 'Description', datafield: 'description'}
                    ];
                    break;
                case 'user':
                    datafields_data = [
                        {name: 'ID', type: 'number'},
                        {name: 'title', type: 'string'},
                        {name: 'role_title', type: 'string'},
                        {name: 'password', type: 'string'},
                        {name: 'signature', type: 'string'}
                    ];

                    columndata = [
                        {text: 'User Name', datafield: 'title', align: 'left', cellsalign: 'left'},
                        {text: 'Group', datafield: 'role_title'},
                        {text: 'Signature', datafield: 'signature'},
                        {text: 'Password', datafield: 'password'}
                        
                    ];
                    break;
                case 'roomclass':
                case 'account_type':
                case 'account_discount':
                case 'account_salescategory':
                case 'account_class':
                case 'account_plu_group':
                    datafields_data = [
                        {name: 'ID', type: 'number'},
                        {name: 'title', type: 'string'},
                        {name: 'description', type: 'string'}
                    ];

                    columndata = [
                        {text: 'Title', datafield: 'title', align: 'left', cellsalign: 'left'},
                        {text: 'Description', datafield: 'description'}
                    ];
                    break;
                case 'roomtype':
                    datafields_data = [
                        {name: 'ID', type: 'number'},
                        {name: 'title', type: 'string'},
                        {name: 'rc_title', type: 'string'},
                        {name: 'beds', type: 'string'},
                        {name: 'remark', type: 'string'},
                        {name: 'description', type: 'string'}
                    ];

                    columndata = [
                        {text: 'Room Type', datafield: 'title', align: 'left', cellsalign: 'left'},
                        {text: 'Description', datafield: 'description'},
                        {text: 'Roomclass', datafield: 'rc_title'},
                        {text: 'Beds', datafield: 'beds'},
                        {text: 'Remark', datafield: 'remark'}
                    ];
                    break;
                case 'room':
                    datafields_data = [
                        {name: 'ID', type: 'number'},
                        {name: 'title', type: 'string'},
                        {name: 'bed', type: 'string'},
                        {name: 'rc_title', type: 'string'},
                        {name: 'rt_title', type: 'string'},
                        {name: 'description', type: 'string'}
                    ];

                    columndata = [
                        {text: 'Room No.', datafield: 'title', align: 'left', cellsalign: 'left'},
                        {text: 'Description', datafield: 'description'},
                        {text: 'Beds', datafield: 'bed'},
                        {text: 'Roomclass', datafield: 'rc_title'},
                        {text: 'Roomtype', datafield: 'rt_title'}
                    ];
                    break;

                case 'housekeeping':
                    datafields_data = [
                        {name: 'ID', type: 'number'},
                        {name: 'title', type: 'string'},
                        {name: 'room_status', type: 'string'},
                        {name: 'rt_title', type: 'string'},
                        {name: 'remark', type: 'string'}
                    ];

                    columndata = [
                        {text: 'Room No.', datafield: 'title', align: 'left', cellsalign: 'left'},
                        {text: 'Room Type', datafield: 'rt_title'},
                        {text: 'Status', datafield: 'room_status'},
                        {text: 'Remarks', datafield: 'remark'}
                    ];
                    break;

                case 'price':
                    datafields_data = [
                        {name: 'ID', type: 'number'},
                        {name: 'roomtype_title', type: 'string'},
                        {name: 'acctsale_title', type: 'string'},
                        {name: 'weekday', type: 'string'},
                        {name: 'weekend', type: 'string'},
                        {name: 'holiday', type: 'string'},
                        {name: 'enable', type: 'string'},
                        {name: 'description', type: 'string'}
                    ];

                    columndata = [
                        {text: 'Room Type', datafield: 'roomtype_title', align: 'left', cellsalign: 'left'},
                        {text: 'Description', datafield: 'description'},
                        {text: 'Account Name', datafield: 'acctsale_title'},
                        {text: 'Weekday', datafield: 'weekday'},
                        {text: 'Weekend', datafield: 'weekend'},
                        {text: 'Holiday', datafield: 'holiday'},
                        {text: 'Show', datafield: 'enable'}
                    ];
                    break;

                case 'terminals':
                    datafields_data = [
                        {name: 'ID', type: 'number'},
                        {name: 'title', type: 'string'},
                        {name: 'signature', type: 'string'},
                        {name: 'role_title', type: 'string'},
                        {name: 'last_login_time', type: 'date'}
                    ];

                    columndata = [
                        {text: 'User Name', datafield: 'title', align: 'left', cellsalign: 'left'},
                        {text: 'Signature', datafield: 'signature'},
                        {text: 'User Group', datafield: 'role_title'},
                        {text: 'Last Active Since', datafield: 'last_login_time'}
                    ];
                    break;
                case 'account_plu_number':
                    datafields_data = [
                        {name: 'ID', type: 'number'},
                        {name: 'title', type: 'string'},
                        {name: 'plu_group_title', type: 'string'},
                        {name: 'acctsale_title', type: 'string'},
                        {name: 'price', type: 'string'},
                        {name: 'cost', type: 'string'},
                        {name: 'enable', type: 'string'},
                        {name: 'description', type: 'string'}
                    ];

                    columndata = [
                        {text: 'PLU No. ', datafield: 'title', align: 'left', cellsalign: 'left'},
                        {text: 'PLU Group  ', datafield: 'plu_group_title'},
                        {text: 'Description', datafield: 'description'},
                        {text: 'Account Name', datafield: 'acctsale_title'},
                        {text: 'Price', datafield: 'price'},
                        {text: 'Cost', datafield: 'cost'},
                        {text: 'Show', datafield: 'enable'}
                    ];
                    break;

                case 'account_payment':
                    datafields_data = [
                        {name: 'ID', type: 'number'},
                        {name: 'title', type: 'string'},
                        {name: 'code', type: 'string'},
                        {name: 'alias', type: 'string'},
                        {name: 'accttype_title', type: 'string'},
                        {name: 'debit_credit', type: 'string'},
                        {name: 'acctclass_title', type: 'string'},
                        {name: 'cash_declaration', type: 'string'},
                        {name: 'enable', type: 'string'},
                        {name: 'description', type: 'string'}
                    ];

                    columndata = [
                        {text: 'Code', datafield: 'code', align: 'left', cellsalign: 'left'},
                        {text: 'Name  ', datafield: 'title'},
                        {text: 'Description', datafield: 'description'},
                        {text: 'Account type', datafield: 'accttype_title'},
                        {text: 'Account class', datafield: 'acctclass_title'},
                        {text: 'Alias', datafield: 'alias'},
                        {text: 'Debit/Credit', datafield: 'debit_credit'},
                        {text: 'Cash Declaration', datafield: 'cash_declaration'},
                        {text: 'Show', datafield: 'enable'}
                    ];
                    break;

                case 'account_sale':
                    datafields_data = [
                        {name: 'ID', type: 'number'},
                        {name: 'title', type: 'string'},
                        {name: 'code', type: 'string'},
//                        {name: 'alias', type: 'string'},
                        {name: 'accttype_title', type: 'string'},
                        {name: 'acctclass_title', type: 'string'},
                        {name: 'salescategory_title', type: 'string'},
                        {name: 'discountcategory_title', type: 'string'},
                        {name: 'debit_credit', type: 'string'},
                        {name: 'default_price', type: 'string'},
                        {name: 'service_charge', type: 'string'},
                        {name: 'enable', type: 'string'},
                        {name: 'description', type: 'string'}
                    ];

                    columndata = [
                        {text: 'Code  ', datafield: 'code', align: 'left', cellsalign: 'left'},
                        {text: 'Name    ', datafield: 'title'},
                        {text: 'Account type', datafield: 'accttype_title'},
                        {text: 'Account class', datafield: 'acctclass_title'},
                        {text: 'Sales Category', datafield: 'salescategory_title'},
                        {text: 'Discount Category', datafield: 'discountcategory_title'},
                        {text: 'Debit/Credit', datafield: 'debit_credit'},
                        {text: 'Default Price', datafield: 'default_price'},
                        {text: 'Service Charge', datafield: 'service_charge'}
                    ];
                    break;
            }
            $(img_location).html('');

            configuration.grid(datafields_data, columndata, data, grid_type, "100%", page_number, action);

        },
        error: function () {
            console.log('fetch data failed');
        }
    });
}

var configuration = {
    grid: function (datafields_data, columndata, fetched_data, grid_type, width, page_number, action) {
        var edit_button = "#" + grid_type + "_edit";
        var delete_button = "#" + grid_type + "_delete";
        var grid_location = "#" + grid_type + "_data";
        var update_button = "#housekeeping_room_status_button";

        var source =
                {datatype: "json",
                    datafields: datafields_data,
                    localdata: fetched_data
                };

        var dataAdapter = new $.jqx.dataAdapter(source);
        $(grid_location).jqxGrid({
            width: width,
            source: dataAdapter,
            pageable: true,
            autoheight: true,
            sortable: true,
            altrows: false,
            enabletooltips: true,
            editable: false,
            selectionmode: 'singlerow',
            pagesize: 20,
            columns: columndata
        });

        var data_len = fetched_data.length;
        console.log('data len: ' + data_len);
        console.log('config received page_number: ' + page_number);

        var pagesize = parseInt($(grid_location).jqxGrid('pagesize'));
        console.log('config received pagesize: ' + pagesize);

        var page_number_temp;
        console.log('action: ' + action);

        switch (action) {
            case 'insert':
                console.log('insert occurred');
                //get last page number
                if (data_len % pagesize === 0) {
                    page_number = Math.floor(data_len / pagesize) - 1;
                } else {
                    page_number = Math.floor(data_len / pagesize);
                }
                break;
            case 'delete':
                console.log('delete occurred');
                //get last page number
                if (data_len % pagesize === 0) {
                    page_number_temp = Math.floor(data_len / pagesize) - 1;
                } else {
                    page_number_temp = Math.floor(data_len / pagesize);
                }

                page_number = (page_number > page_number_temp) ? (page_number_temp) : (page_number);
                console.log('delete page_number: ' + page_number);
                break;
        }

        $(grid_location).jqxGrid('gotopage', page_number);

        var modal = grid_location.replace("data", "modal");
        var form_page_number = grid_location.replace("data", "page_number");

        $(grid_location).on('rowselect', function (event) {
            var args = event.args;
            var row_data = args.row;
            var id = row_data.ID;

            $(edit_button).attr("onclick", "modalLoader('" + grid_type + "','" + modal + "','edit'," + id + ")");
            $(update_button).attr("onclick", "updateModallLoader('" + id + "')");

            if (grid_type === "housekeeping") {
                //create button for operations
                var room_status = row_data.room_status;
                var room_title = row_data.title;
                var house_button = "#" + grid_type + "_status";
                var house_blocked_button = "#" + grid_type + "_block";
                var house_details_button = "#" + grid_type + "_details";
                var house_resv_button = "#" + grid_type + "_resv";

                $(house_button).attr("onclick", "updateItem('room','" + id + "','1')");
                $(house_blocked_button).attr("onclick", "updateItem('room','" + id + "','7')");
                $(house_details_button).attr("onclick", "fetchRowDataWithIdentifier('room','" + id + "','housekeeping_room')");
                if (room_status === "occupied" || room_status === "occupied_dirty") {
                    $(house_resv_button).attr('onclick', "getRoomReservation('" + room_title + "')");
                } else {
                    $(house_resv_button).attr('onclick', "");
                }

            } else {
                $(delete_button).attr("onclick", "modalLoader('" + grid_type + "','" + modal + "','delete'," + id + ")");
            }

            //store page number
            var paginginformation = $(grid_location).jqxGrid('getpaginginformation');
            var page_number = paginginformation.pagenum;
            console.log('row select page_number: ' + page_number);
            console.log('form_page_number: ' + form_page_number);
            $(form_page_number).val(page_number);
            $('#delete_page').val(page_number);
        });

        $(grid_location).on('rowdoubleclick', function (event) {
            var i = event.args.rowindex;
            var rowid = $(grid_location).jqxGrid('getrowid', i);
            var data = $(grid_location).jqxGrid('getrowdata', rowid);
            var id = data.ID;
            console.log('dblclick: ' + id);
            modalLoader(grid_type, modal, "edit", id);
        });

        if (data_len > 0) {
            $(grid_location).jqxGrid('selectrow', 0);
        }


    }
}


