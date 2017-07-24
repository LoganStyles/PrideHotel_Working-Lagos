/*reservation js operations*/
function calcDateDiffWithSign(date1, date2) {
    var comp, m1, d1, y1, m2, d2, y2;
    var oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
    comp = date1.split('/');
    d1 = parseInt(comp[0], 10);
    m1 = parseInt(comp[1], 10);
    y1 = parseInt(comp[2], 10);

    comp = date2.split('/');
    d2 = parseInt(comp[0], 10);
    m2 = parseInt(comp[1], 10);
    y2 = parseInt(comp[2], 10);

    var firstDate = new Date(y1, m1, d1);
    var secondDate = new Date(y2, m2, d2);

    var diffDays = Math.round((firstDate.getTime() - secondDate.getTime()) / (oneDay));
    return diffDays;
}


function getModalSelection(prefix, type, modal, ID, value, weekday, weekend, holiday) {
    var output_field = "#" + prefix + "_" + type;
    var hidden_field = "#" + prefix + "_" + type + "_id";
    console.log('output_field ' + output_field);
    console.log('hidden_field ' + hidden_field);
    $(hidden_field).val(ID);
    $(output_field).val(value);

    var weekday_field = "#" + prefix + "_weekday";
    var weekend_field = "#" + prefix + "_weekend";
    var holiday_field = "#" + prefix + "_holiday";
    var room_number_field = "#" + prefix + "_room_number";
    var room_number_id_field = "#" + prefix + "_room_number_id";
    var price_rate_field = "#" + prefix + "_price_rate";
    var price_rate_id_field = "#" + prefix + "_price_rate_id";

    $(weekday_field).val(weekday);
    $(weekend_field).val(weekend);
    $(holiday_field).val(holiday);
    if (type === "roomtype") {
        $(room_number_field).val("");
        $(room_number_id_field).val("");
        $(price_rate_field).val("");
        $(price_rate_id_field).val("");
        console.log('weekday ' + weekday);
        console.log('weekend ' + weekend);
        console.log('holiday ' + holiday);
    }

    $(modal).modal('hide');
    reservation.calcRoomPrice(prefix);

}

function closeResvModal(modal) {
    $(modal).removeClass("in").css('display', 'none');
    location.reload();
}

function printReservation(type, guest_type) {
    var url = BASE_URL + "report/printReservations/" + type + "/" + guest_type;
    console.log('update url: ' + url);
    window.location = url;
}

function deleteReservation() {
    /*chk if resv is not departed,..
     * show prompt for confirmation & remark..
     * if yes & remark exists on prompt update reservation status to cancelled,
     * log details of this action,
     * display updated cancelled resrvations*/

    var resv_id = $('.booking_radio.active .booking_hidden_id').val();
    var status = $('.booking_radio.active .booking_hidden_status').text();
    console.log('status is ' + status);
    if (status !== "departed") {
        $("#delete_resv_reason").val("");
        $("#delete_resv_id").val(resv_id);
        $("#delete_resv_type").val("reservation");
        $("#delete_resv_oldvalue").val(status);
        $("#delete_resv_newvalue").val("cancelled");
        $("#delete_resv_modal").modal({backdrop: false, keyboard: false});
    }
}

function deletePerson(type) {
    /*
     * show prompt for confirmation & remark..
     * if yes & remark exists on prompt,
     * log details of this action,
     * display updated components*/

    var delete_id = $('.booking_radio.active .booking_hidden_id').val();
    var name = $('.booking_radio.active .booking_hidden_id').parent().text();
    $("#delete_person_reason").val("");
    $("#delete_person_id").val(delete_id);
    $("#delete_person_title").val(name);
    $("#delete_person_type").val(type);
    $("#delete_person_modal").modal({backdrop: false, keyboard: false});
}

function fetchModalGridData(prefix, grid_type) {
    var url = "";
    console.log('grid_type ' + grid_type);
    switch (grid_type) {
        case 'room_number':
        case 'price_rate':
            var field = "#" + prefix + "_roomtype";
            var roomtype = $(field).val();
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
            reservation.grid(datafields_data, columndata, data, grid_type, "100%", prefix);

        },
        error: function () {
            console.log('fetch data failed');
        }
    });
}
var reservation = {
    calcRoomPrice: function (resv_type) {
        /*calcs room price*/
        var count = 0, weekend_count = 0, week_days = 0, price_total = 0, comp_nights = 0, price_extra = 0, price_total_comp = 0;
        var arrival_field = "#" + resv_type + "_arrival";
        var departure_field = "#" + resv_type + "_departure";
        var night_field = "#" + resv_type + "_nights";
        var weekday_field = "#" + resv_type + "_weekday";
        var weekend_field = "#" + resv_type + "_weekend";
        var holiday_field = "#" + resv_type + "_holiday";
        var price_rate_field = "#" + resv_type + "_price_rate";
        var price_room_field = "#" + resv_type + "_price_room";
        var price_total_field = "#" + resv_type + "_price_total";
        var price_extra_field = "#" + resv_type + "_price_extra";
        var comp_nights_field = "#" + resv_type + "_comp_nights";
        var comp_visits_field = "#" + resv_type + "_comp_visits";

        var arrival_date = $(arrival_field).jqxDateTimeInput('getDate');
        console.log('arrival_date is ' + arrival_date);
        var curr_night = arrival_date;
        var firstday = arrival_date;
        var departure_date = arrival_date;
        console.log('curr_night is ' + curr_night);
        console.log('firstday is ' + firstday);

        var nights = $(night_field).val();
        nights = (nights > 0) ? (parseInt(nights)) : (0);
        var weekday_rate = $(weekday_field).val();
        weekday_rate = (weekday_rate > 0) ? (parseFloat(weekday_rate)) : (0);
        var weekend_rate = $(weekend_field).val();
        weekend_rate = (weekend_rate > 0) ? (parseFloat(weekend_rate)) : (0);
        var holiday_rate = $(holiday_field).val();
        holiday_rate = (holiday_rate > 0) ? (parseFloat(holiday_rate)) : (0);

        departure_date.setDate(departure_date.getDate() + nights);
        console.log('departure_date is ' + departure_date);
        $(departure_field).jqxDateTimeInput('setDate', departure_date);

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

        price_extra = parseFloat($(price_extra_field).val());

        price_total_comp = price_total + price_extra;
        console.log('price total before complimentary ' + price_total_comp);

        //subtract complimentary nights if any
        comp_nights = $(comp_nights_field).val();
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
            $(comp_visits_field).val('yes');
        } else {
            $(comp_visits_field).val('no');
        }
        console.log('price total after complimentary ' + price_total_comp);
        var chkpr = $(price_rate_field).val();
        if (chkpr !== "") {
            $(weekday_field).val(weekday_rate);
            $(weekend_field).val(weekend_rate);
            $(holiday_field).val(holiday_rate);

            $(price_room_field).val(price_total);
            $(price_total_field).val(price_total_comp);
        }
    }, 
    calcDuration: function (resv_type) {
        /*calcs room price*/
        var count = 0;
        var arrival_field = "#" + resv_type + "_arrival";
        var departure_field = "#" + resv_type + "_departure";
        var night_field = "#" + resv_type + "_nights";
        
        var arrival_date = $(arrival_field).jqxDateTimeInput('getDate');
        console.log('arrival_date is ' + arrival_date);
        var curr_night = arrival_date;
        var firstday = arrival_date;
        var departure_date = arrival_date;
        console.log('curr_night is ' + curr_night);
        console.log('firstday is ' + firstday);

        var nights = $(night_field).val();
        nights = (nights > 0) ? (parseInt(nights)) : (0);

        departure_date.setDate(departure_date.getDate() + nights);
        console.log('departure_date is ' + departure_date);
        $(departure_field).jqxDateTimeInput('setDate', departure_date);
    }, 
    grid: function (datafields_data, columndata, fetched_data, grid_type, width, prefix) {
        var weekday, weekend, holiday;
        var weekday_field = "#" + prefix + "_weekday";
        var weekend_field = "#" + prefix + "_weekend";
        var holiday_field = "#" + prefix + "_holiday";
        weekday = $(weekday_field).val(), weekend = $(weekend_field).val(), holiday = $(holiday_field).val();

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
            if (grid_type === "price_rate") {
                weekday = row_data.weekday;
                weekend = row_data.weekend;
                holiday = row_data.holiday;
            }
            console.log('single ID ' + ID);
            console.log('single title ' + title);
            console.log('single weekend ' + weekend);
            $(select_button).attr("onclick", "getModalSelection('" + prefix + "','" + grid_type + "','" + modal + "','" + ID + "','" + title + "','" + weekday + "','" + weekend + "','" + holiday + "')");
        });

        $(grid_location).on('rowdoubleclick', function (event) {
            var i = event.args.rowindex;
            var rowid = $(grid_location).jqxGrid('getrowid', i);
            var data = $(grid_location).jqxGrid('getrowdata', rowid);
            var ID = data.ID;
            var title = data.title;
            if (grid_type === "price_rate") {
                weekday = data.weekday;
                weekend = data.weekend;
                holiday = data.holiday;
            }
            console.log('dblclick: ' + title);
            getModalSelection(prefix, grid_type, modal, ID, title, weekday, weekend, holiday);
        });

        $(grid_location).jqxGrid('selectrow', 0);
        $(modal).modal({backdrop: false, keyboard: false});
    }


}


