var data;
function truncate(n) {
    return Math[n > 0 ? "floor" : "ceil"](n);
}

function loadData() {
    $.getJSON('https://thingspeak.com/channels/100117/feed/last.json' , function(data) {
	$("#count2").text(truncate(data.field8));
	if (data.field3 == 0) {
	    $("#draw2").text("Closed");
	} else {
	    $("#draw2").text("Open");
	}
    });

    $.getJSON('https://thingspeak.com/channels/100093/feed/last.json' , function(data) {
	$("#count1").text(truncate(data.field7));
	if (data.field2 == 0) {
	    $("#draw1").text("Closed");
	} else {
	    $("#draw1").text("Open");
	}
    });
}

function loadData2() {
    $.ajax({
	url: 'latestrecord.php',
	data: "",
	dataType: 'json',
	success: function(data) {
	    var count1 = data[1]["count"];
	    var count2 = data[0]["people_count"];
	    $("#count1").text(truncate(count1));
	    $("#count2").text(truncate(count2));
	    var draw1 = "Closed";
	    var draw2 = "Closed";
	    if (data[1]["reed_switch1"] > 0) {
		draw1 = "Open";
	    }
	    if (data[0]["reed_switch2"] > 0) {
		draw1 = "Open";
	    }
	    $("#draw1").text(draw1);
	    $("#draw2").text(draw2);
	}
    });
}

loadData2();
setInterval('loadData2()', 5000);
