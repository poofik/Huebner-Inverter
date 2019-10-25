<?php
    include_once("common.php");
	$os = detectOS();

    if(isset($_GET["ajax"]))
    {
    	set_time_limit(100);
    	$file = urldecode($_GET["file"]);
        $cmd = urldecode($_GET["cmd"]);
        $interface = urldecode($_GET["interface"]);

        if (strpos($cmd, "100") !== false) {
        	$command = runCommand("esptool", $file. " " .$interface. " spiffs", $os, 0);
        }else{
            $command = runCommand("esptool", $file. " " .$interface, $os, 0);
        }
		exec($command, $output, $return);
		foreach ($output as $line) {
			$line = str_replace("... (", "...\n(", $line);
			echo "$line\n";
		}
	}else{
?>
<!DOCTYPE html>
<html>
 <head>
	<?php include "header.php" ?>
	<script src="js/esp8266.js"></script>
 </head>
 <body>
 	<?php include "menu.php" ?>
	<div class="container">
		<div class="row">
			<div class="col">
				<table class="table table-active bg-light table-bordered hidden" id="esp8266-download-firmware">
                    <tr>
                        <td>
                            <button type="button" class="btn btn-primary" onClick="window.open('https://github.com/dimecho/Huebner-Inverter/releases/download/1.0/Huebner.Inverter.ESP8266.zip')"><i class="icons icon-download"></i> Download Firmware</button>
                        </td>
                    </tr>
                </table>
                <table class="table table-active bg-light table-bordered hidden" id="esp8266-flash-firmware">
                	<tr>
                        <td>
	            		<?php
						if(isset($_FILES["spiffs"]) || isset($_FILES["firmware"])){
							require "upload-status.php";
	                    }else{
	                	?>
	                	<script>
								$(document).ready(function() {
									if(os != "esp8266") {

										unblockSerial();

										$.ajax("serial.php?com=list", {
											async: false,
											success: function(data) {
												//console.log(data);
												var s = data.split('\n');
												for (var i = 0; i < s.length; i++) {
													if(s[i] != "")
														$("#firmware-interface").append($("<option>",{value:s[i]}).append(s[i]));
												}
											}
										});
									}
									$("#firmware-interface").prop('selectedIndex', 0);
									$(".loader").hide();
									$(".input-group-addon").show();
								});
	                        </script>
                    	<center>
                        	<div class="loader"></div>
                            <div class="input-group w-100">
                                <span class="input-group-addon w-100">
									<select name="interface" class="form-control" id="firmware-interface"></select>
								</span>
                            </div>
                            <br/><br/><span class="badge badge-lg bg-danger">Solder <b>GPIO-0</b> to <b>0</b> and connect UART Pin 3 & 4 (USB-RS232-TTL)</span><br><br>
                            <img src="" class="img-thumbnail rounded" /><br/><br/>
                            </center>
                            <div class="input-group">
                            	<span class="input-group-addon w-100">
	                            	<div class="row w-100">
	                            		<div class="col"></div>
	                            		<div class="col">
	                            		WiFi SSID: Inverter<br>
	                                	WiFi Password: inverter123 <br>
	                                	Web Interface: http://192.168.4.1</div>
	                            		<div class="col"></div>
	                            	</div>
	                            </span>
                            </div>
	                    <?php
							} 
						?>
					    </td>
                    </tr>
                </table>
			    <table class="table table-active table-bordered hidden" id="esp8266-nvram">
                    <tr>
                        <td>
                        	<center><div class="loader"></div></center>
                        	<form class="hidden" method="POST" action="/nvram" id="parameters" oninput='WiFiPasswordConfirm.setCustomValidity(WiFiPasswordConfirm.value != WiFiPassword.value ? "Passwords do not match." : "")'>
                        		<fieldset class="form-group">
                        			<legend>ESP8266 Wireless Connection:</legend>
		                        	<div class="form-check">
		                        		<label class="form-check-label">
									    <input type="radio" class="form-check-input" id="WiFiModeAP" name="WiFiMode" value="0">
									        WiFi Access Point
									    </label>
									</div>
									<div class="form-check">
		                        		<label class="form-check-label">
									    <input type="radio" class="form-check-input" id="WiFiModeClient" name="WiFiMode" value="1">
									        WiFi Client
									    </label>
									</div>
									<br>
									<div class="form-check">
									  <label class="form-check-label">
									  	<input type="hidden" id="WiFiHidden" name="WiFiHidden" value="0">
									    <input type="checkbox" id="WiFiHiddenCheckbox" class="form-check-input" onclick="HiddenCheck('WiFiHidden',this)">
									    	Hidden SSID
									  </label>
									</div>
								</fieldset>
								<div class="form-group">
									<label for="WiFiChannel">Channel</label>
									<div class="input-group">
										<div class="input-group-addon"><i class="icons icon-graph-bar p-3"></i></div>
										<select id="WiFiChannel" class="form-control" name="WiFiChannel">
											<option>1</option>
											<option>2</option>
											<option>3</option>
											<option>4</option>
											<option>5</option>
											<option>6</option>
											<option>7</option>
											<option>8</option>
											<option>9</option>
											<option>10</option>
											<option>11</option>
										</select>
									</div>
								</div> 
								<div class="form-group">
									<div class="input-group">
								    	<div class="input-group-addon"><i class="icons icon-wifi p-3"></i></div>
								    	<input type="text" id="WiFiSSID" name="WiFiSSID" class="form-control" placeholder="SSID" required>
									</div>
								</div>
								<div class="form-group">
									<div class="input-group">
										<div class="input-group-addon"><i class="icons icon-password p-3"></i></div>
								    	<input type="password" id="WiFiPassword" name="WiFiPassword" class="form-control" placeholder="Password" required>
									</div>
								</div>
								<div class="form-group">
									<div class="input-group">
										<div class="input-group-addon"><i class="icons icon-password p-3"></i></div>
								    	<input type="password" id="WiFiPasswordConfirm" name="WiFiPasswordConfirm" class="form-control" placeholder="Password Confirm">
									</div>
								</div>
								<div class="form-group">
									<div class="form-check">
									  <label class="form-check-label">
										  	<input type="hidden" id="EnableSWD" name="EnableSWD" value="0">
									    	<input type="checkbox" id="EnableSWDCheckbox" class="form-check-input" onclick="HiddenCheck('EnableSWD',this)"> Enable SWD
									  </label>
									</div>
									<div class="form-check">
									  <label class="form-check-label">
										  	<input type="hidden" id="EnableCAN" name="EnableCAN" value="0">
								    		<input type="checkbox" id="EnableCANCheckbox" class="form-check-input" onclick="HiddenCheck('EnableCAN',this)"> Enable CAN
									  </label>
									</div>
								</div>
								<center><button type="submit" class="btn btn-success"><i class="icons icon-ok"></i> Save</button></center>
                            </form>
                        </td>
                    </tr>
                </table>
				<table class="table table-active table-bordered hidden" id="esp8266-flash-select">
					<tr align="center">
						<td align="center">
							<button class="btn btn-primary" type="button" id="browseSPIFFS"><i class="icons icon-chip"></i> Flash SPIFFS</button>
						</td>
						<td align="center">
							<button class="btn btn-primary" type="button" id="browseSketch"><i class="icons icon-chip"></i> Flash Sketch</button>
						</td>
					</tr>
					<tr align="center">
						<td colspan="2">
							<div class="progress progress-striped active hidden">
								<div class="progress-bar" style="width:1%" id="progressBar"></div>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<form method="POST" action="/update?cmd=0" enctype="multipart/form-data" id="formSketch">
		<input type="hidden" name="cmd" value="0" />
		<input type="hidden" name="interface" />
		<input type="file" name="firmware" id="fileSketch" hidden />
		<input type="submit" hidden />
	</form>
	<form method="POST" action="/update?cmd=100" enctype="multipart/form-data" id="formSPIFFS">
		<input type="hidden" name="cmd" value="100" />
		<input type="hidden" name="interface" />
		<input type="file" name="spiffs" id="fileSPIFFS" hidden />
		<input type="submit" hidden />
	</form>
</body>
</html>
<?php
	}
?>