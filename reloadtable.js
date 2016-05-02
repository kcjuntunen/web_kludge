var auto_refresh = setInterval(
    function() {
	$('#load_status').load('status.php').fadeIn(0);
    }, 5000);
