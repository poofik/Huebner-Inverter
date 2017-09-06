<!DOCTYPE html>
<html>
    <head>
        <?php include "header.php" ?>
        <script type="text/javascript" src="/js/jspdf.js"></script>
        <script>
        $(document).ready(function () {
            <?php

            $pinout = "";
            $wiring = "";

            if(isset($_GET["hardware"])){
                if($_GET["hardware"] == "1"){
                    $pinout = rawurlencode("/pcb/Hardware v1.0/wiring.csv");
                    $wiring = rawurlencode("/pcb/Hardware v1.0/wiring.png");
                    echo '$("#johannes").show();';
                }else if($_GET["hardware"] == "damien"){
                    $pinout = rawurlencode("/pcb/Hardware (Damien Mod)/wiring.csv");
                    $wiring = rawurlencode("/pcb/Hardware (Damien Mod)/wiring.png");
                }
                echo '$("#wiring").show();';
            ?>
            $.ajax("<?php echo $pinout; ?>",{
                //async: false,
                success: function(data)
                {
                    //console.log(data);
                    var tbody = $("#pinout tbody").empty();
                    var row = data.split("\n");
                    for (var i = 0; i < row.length; i++) {
                        var split = row[i].split(",");
                        var tr = $("<tr>");
                        tr.append($("<td>").append(split[0]));
                        tr.append($("<td>").append(split[1]));
                        tr.append($("<td>").append(split[2]));
                        tbody.append(tr);
                    }
                    $("#pinout").show();
                },
                error: function(xhr, textStatus, errorThrown){
                }
            });
            <?php }else{ echo '$("#hardware").show();'; } ?>

            function printWiring()
            {
                var doc = new jsPDF('l', 'mm', [279, 215]);
                doc.setDisplayMode(1);
                doc.setFontSize(28);
                doc.text(110, 20, "Wiring Diagram");
                var img = new Image();
                img.onload = function() {
                    doc.addImage(this, 'PNG' , 25, 40, 225, 150, "wiring", "none");
                    doc.save("wiring.pdf");
                };
                img.src = "<?php echo $wiring; ?>";
            }
        });
        </script>
    </head>
    <body>
        <div class="container">
            <?php include "menu.php" ?>
            <br/>
             <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-10">
                    <table class="table table-active table-bordered" id="hardware" style="display:none">
                        <tbody>
                            <tr align="center">
                                <td>
                                    <a href="/wiring.php?hardware=1">
                                        <img src="/img/hardware_v1.jpg" class="img-thumbnail img-rounded" />
                                    </a><br/><br/>
                                    Hardware v1.0 (Johannes Huebner)
                                </td>
                                <td>
                                    <a href="/wiring.php?hardware=damien">
                                        <img src="/img/hardware_damien.jpg" class="img-thumbnail img-rounded" />
                                    </a><br/><br/>
                                    Hardware v1.0 (Damien Maguire)
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-active table-bordered" id="johannes" style="display:none">
                        <tbody>
                            <tr>
                                <td>
                                <center>
                                    <a href="http://johanneshuebner.com/quickcms/index.html%3Fen_main-board,21.html" target="_blank">Main Board</a>
                                </center>
                                </td>
                                <td>
                                <center>
                                    <a href="http://johanneshuebner.com/quickcms/index.html%3Fen_sensor-board,22.html" target="_blank">Sensor Board</a>
                                </center>
                                </td>
                                <td>
                                <center>
                                    <a href="http://johanneshuebner.com/quickcms/index.html%3Fen_gate-drivers,23.html" target="_blank">Gate Drivers</a>
                                </center>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-active table-bordered" id="wiring" style="display:none">
                        <tbody>
                            <tr>
                                <td colspan="3">
                                    <a data-fancybox href="<?php echo $wiring; ?>">
                                        <img src="<?php echo $wiring; ?>" class="img-thumbnail img-rounded" />
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <button type="button" class="btn btn-info" onClick="printWiring();">Print</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div id="pinout" style="display:none">
                        <p>Main Connector Pin Summary</p>
                        <table  class="table table-bordered table-striped" >
                            <thead></thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-1"></div>
            </div>
        </div>
    </body>
</html>