/*reservation js operations*/
function getModalSelection(type, modal, ID, value, weekday, weekend, holiday) {
    var output_field = "#guest_" + type;
    var hidden_field = "#guest_" + type + "_id";
    console.log('output_field ' + output_field);
    console.log('hidden_field ' + hidden_field);
    $(hidden_field).val(ID);
    $(output_field).val(value);
    $('#guest_weekday').val(weekday);
    $('#guest_weekend').val(weekend);
    $('#guest_holiday').val(holiday);
    if (type == "roomtype") {
        $('#guest_room_number').val("");
        $('#guest_room_number_id').val("");
        $('#guest_price_rate').val("");
        $('#guest_price_rate_id').val("");
        console.log('weekday ' + weekday);
        console.log('weekend ' + weekend);
        console.log('holiday ' + holiday);
    }
    $(modal).modal('hide');
    reservation.calcRoomPrice();

}

function fetchModalGridData(grid_type) {
    var url = "";
    console.log('grid_type ' + grid_type);
    switch (grid_type) {
        case 'room_number':
        case 'price_rate':
            var roomtype = $('#guest_roomtype').val();
            var trimedroomtype = roomtype.trim();
            if (trimedroomtype) {
                url = BASE_URL + "resv/fetchModalData/" + grid_type + "/0/" + trimedroomtype;
            } else {
                return false;
            }
            break;
        default:
            url = BASE_URL + "resv/fetchModalData/" + grid_type + "/0";
            break;
    }
    console.log(url);

    $.ajax({
        type: "POST",
        url: url,
        dataType: "json",
        success: function (data) {
            var datafields_data;
            var columndata;

            switch (grid_type) {
                case 'roomtype':
                    datafields_data = [
                        {name: 'ID', type: 'number'},
                        {name: 'title', type: 'string'},
                        {name: 'description', type: 'string'},
                        {name: 'rooms', type: 'string'},
                        {name: 'beds', type: 'string'},
                        {name: 'vacant', type: 'string'},
                        {name: 'vacant_dirty', type: 'string'}
                    ];

                    columndata = [
                        {text: 'Room Type', datafield: 'title', align: 'left', cellsalign: 'left'},
                        {text: 'Description', datafield: 'description'},
                        {text: 'Rooms', datafield: 'rooms'},
                        {text: 'Beds', datafield: 'beds'},
                        {text: 'Vacant', datafield: 'vacant'},
                        {text: 'Vacant Dirty', datafield: 'vacant_dirty'}
                    ];
                    break;
                case 'room_number':
                    datafields_data = [
                        {name: 'ID', type: 'number'},
                        {name: 'title', type: 'string'},
                        {name: 'description', type: 'string'},
                        {name: 'room_status', type: 'string'},
                        {name: 'bed', type: 'string'}
                    ];

                    columndata = [
                        {text: 'Room ', datafield: 'title', align: 'left', cellsalign: 'left'},
                        {text: 'Description', datafield: 'description'},
                        {text: 'Beds', datafield: 'bed'},
                        {text: 'Status', datafield: 'room_status'}
                    ];
                    break;
                case 'price_rate':
                    datafields_data = [
                        {name: 'ID', type: 'number'},
                        {name: 'title', type: 'string'},
                        {name: 'description', type: 'string'},
                        {name: 'weekday', type: 'string'},
                        {name: 'weekend', type: 'string'},
                        {name: 'holiday', type: 'string'}
                    ];

                    columndata = [
                        {text: 'Room ', datafield: 'title', align: 'left', cellsalign: 'left'},
                        {text: 'Description', datafield: 'description'},
                        {text: 'Weekday', datafield: 'weekday'},
                        {text: 'Weekend', datafield: 'weekend'},
                        {text: 'Holiday', datafield: 'holiday'}
                    ];
                    break;
            }
            reservation.grid(datafields_data, columndata, data, grid_type, "100%");

        },
        error: function () {
            console.log('fetch data failed');
        }
    });
}
var reservation = {
    calcRoomPrice: function () {
        /*calcs room price*/
        var count = 0, weekend_count = 0, week_days = 0, price_total = 0, comp_nights = 0, price_extra = 0, price_total_comp = 0;

        var arrival_date = $('#guest_arrival').jqxDateTimeInput('getDate');
        console.log('arrival_date is ' + arrival_date);
        var curr_night = arrival_date;
        var firstday = arrival_date;
        var departure_date = arrival_date;
        console.log('curr_night is ' + curr_night);
        console.log('firstday is ' + firstday);

        var nights = $('#guest_nights').val();
        nights = (nights > 0) ? (parseInt(nights)) : (0);
        var weekday_rate = $('#guest_weekday').val();
        weekday_rate = (weekday_rate > 0) ? (parseFloat(weekday_rate)) : (0);
        var weekend_rate = $('#guest_weekend').val();
        weekend_rate = (weekend_rate > 0) ? (parseFloat(weekend_rate)) : (0);
        var holiday_rate = $('#guest_holiday').val();
        holiday_rate = (holiday_rate > 0) ? (parseFloat(holiday_rate)) : (0);

        departure_date.setDate(departure_date.getDate() + nights);
        console.log('departure_date is ' + departure_date);
        $('#guest_departure').jqxDateTimeInput('setDate', departure_date);

        //fnd weekends
        while (count < nights) {
            curr_night.setDate(firstday.getDate() + count);
            var curr_day = curr_night.getDay();//day of the week
            console.log('count inside while is ' + count);
            console.log('curr_night inside while is ' + curr_night);
            console.log('current day of the week is ' + curr_day);
            if (curr_day === 0 || curr_day === 5 || curr_day === 6) {
                //this is a weekend
                weekend_count++;
                console.log('weekend count is ' + weekend_count);
            }
            console.log('count is ' + count);
            count++;
        }

        console.log('nights is ' + nights);
        console.log('weekend_count is ' + weekend_count);

        week_days = nights - weekend_count;
        console.log('working days count is ' + week_days);
        console.log('final weekends count is ' + weekend_count);
        price_total = (weekday_rate * week_days) + (weekend_rate * weekend_count);

        price_extra = parseFloat($('#guest_price_extra').val());
//        console.log('price_extra before complimentary ' + price_extra);
//        console.log('price_total before complimentary ' + price_total);
//        console.log('week_days before complimentary ' + week_days);

        price_total_comp = price_total + price_extra;
        console.log('price total before complimentary ' + price_total_comp);

        //subtract complimentary nights if any
        comp_nights = $('#guest_comp_nights').val();
        comp_nights = (comp_nights > 0) ? (parseInt(comp_nights)) : (0);
        count = 0;
        if (comp_nights > 0 && comp_nights <= nights) {            /*chk if comp_nights is valid*/
            while (count < comp_nights) {
                curr_night.setDate(firstday.getDate() + count);
                var curr_day = curr_night.getDay();
                console.log('complimentary current night is ' + curr_day);
                if (curr_day === 0 || curr_day === 5 || curr_day === 6) {
                    //this is a weekend
                    price_total_comp = price_total_comp - weekend_rate;
                    console.log('current complimentary weekend price is ' + price_total_comp);
                } else if (curr_day === 1 || curr_day === 2 || curr_day === 3 || curr_day === 4) {
                    price_total_comp = price_total_comp - weekday_rate;
                    console.log('current complimentary weekday price is ' + price_total_comp);
                }
                count++;
            }
            $('#guest_comp_visits').val('yes');
        } else {
            $('#guest_comp_visits').val('no');
        }
        console.log('price total after complimentary ' + price_total_comp);
        var chkpr = $('#guest_price_rate').val();
        if (chkpr !== "") {
            $('#guest_weekday').val(weekday_rate);
            $('#guest_weekend').val(weekend_rate);
            $('#guest_holiday').val(holiday_rate);

            $('#guest_price_room').val(price_total);
            $('#guest_price_total').val(price_total_comp);
        }
    },
    storeNewClient: function () {
        //search for client, if not existing prompt staff to add

    },
    grid: function (datafields_data, columndata, fetched_data, grid_type, width) {
        var weekday = $('#guest_weekday').val(), weekend = $('#guest_weekend').val(), holiday = $('#guest_holiday').val();
        var select_button = "#" + grid_type + "_popup_select";
        var grid_location = "#" + grid_type + "_popup_data";
        var modal = "#" + grid_type + "_popup_modal";
        console.log('grid_location ' + grid_location);
        console.log('modal ' + modal);

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
            pagesize: 10,
            columns: columndata
        });

        $(grid_location).on('rowselect', function (event) {
            var args = event.args;
            var row_data = args.row;
            var ID = row_data.ID;
            var title = row_data.title;
            if (grid_type == "price_rate") {
                weekday = row_data.weekday;
                weekend = row_data.weekend;
                holiday = row_data.holiday;
            }
            console.log('single ID ' + ID);
            console.log('single title ' + title);
            console.log('single weekend ' + weekend);
            $(select_button).attr("onclick", "getModalSelection('" + grid_type + "','" + modal + "','" + ID + "','" + title + "','" + weekday + "','" + weekend + "','" + holiday + "')");
        });

        $(grid_location).on('rowdoubleclick', function (event) {
            var i = event.args.rowindex;
            var rowid = $(grid_location).jqxGrid('getrowid', i);
            var data = $(grid_location).jqxGrid('getrowdata', rowid);
            var ID = data.ID;
            var title = data.title;
            if (grid_type == "price_rate") {
                weekday = data.weekday;
                weekend = data.weekend;
                holiday = data.holiday;
            }
            console.log('dblclick: ' + title);
            getModalSelection(grid_type, modal, ID, title, weekday, weekend, holiday);
        });
//
        $(grid_location).jqxGrid('selectrow', 0);
        $(modal).modal({backdrop: false, keyboard: false});
    }

}


