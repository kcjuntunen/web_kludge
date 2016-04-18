var auto_refresh = setInterval(
    function() {
	$('#load_status').load('status.php').fadeIn("slow");
    }, 5000);
