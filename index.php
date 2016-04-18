<html>
  <head>
    <title>Amstore Smart Fixtures</title>
    <link rel="stylesheet" href="code/css/960.css">
    <link rel="stylesheet" href="style.css">
    <style>
    </style>
  </head>
  
  <body>
    <h1>Amstore Smart Fixtures</h1>
    <div class="container_12">
      <div class="grid_1"> </div>
      <div class="grid_11">
	<div id="load_status"><br></div>
      </div>
      <div class="clear"></div>
      <!-- Thingspeak chart -->
      <div class="grid_6">
	<iframe width="450" height="260" style="border: 1px solid #111111;" src="https://thingspeak.com/channels/100117/charts/6?bgcolor=%23ffffff&color=%23202020&days=2&dynamic=true&average=240&type=spline"></iframe>
      </div>
      <div class="grid_6">
	<iframe width="450" height="260" style="border: 1px solid #111111;" src="https://thingspeak.com/channels/100093/charts/5?bgcolor=%23ffffff&color=%23202020&days=1&dynamic=true&average=240&type=spline"></iframe>
      </div>
    </div>
    
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/
					libs/jquery/1.3.0/jquery.min.js"></script>
    <script type="text/javascript" src="reload.js"></script>
  </body>
</html>
