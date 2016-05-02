var auto_refresh = setInterval(
    function() {
        cur = <?php require 'rfid_check.php'; ?>
	if (cur != last) {
            $('#embedded_video').text(last);
            last = cur;
        }
    }, 1000);
