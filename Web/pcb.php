<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css">
        <?php include "header.php" ?>
        <script src="js/jquery.fancybox.js"></script>
        <script src="js/pcb.js"></script>
        <script>
        $(document).ready(function () {
            buildMenu(function () {
                <?php
                if(isset($_GET["hardware"])){
                    echo "loadComponents('" . $_GET["hardware"] . "');";
                }else{
                    echo "loadList();";
                }
                ?>
            });
        });
        </script>
        <style>
        .tooltip {
          opacity: 1 !important;
        }
        .tooltip > .tooltip-inner {
          border: 1px solid;
          padding: 10px;
          max-width: 450px;
          color: black;
          text-align: left;
          background: #fff;
          opacity: 1.0;
          filter: alpha(opacity=100);
        }
        .tooltip > .tooltip-arrow { border-bottom-color:black; }
        </style>
    </head>
    <body>
    	<div class="navbar navbar-expand-lg fixed-top navbar-light bg-light" id="mainMenu"></div>
        <div class="row mt-5"></div>
        <div class="row mt-5"></div>
        <div class="container">
             <div class="row">
                <div class="col">
                    <div class="container bg-light d-none" id="pcbList">
                        <div class="row"><hr></div>
                        <div class="row">
                            <div class="col">
                                <div class="card" id="h1">
                                    <a href="">
                                        <img class="card-img-top" src="" alt="">
                                    </a>
                                    <div class="card-body">
                                    <h5 class="card-title text-center"></h5>
                                    <p class="card-text"></p>
                                  </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card" id="h1d">
                                    <a href="">
                                        <img class="card-img-top" src="" alt="">
                                    </a>
                                    <div class="card-body">
                                    <h5 class="card-title text-center"></h5>
                                    <p class="card-text"></p>
                                  </div>
                                </div>
                            </div>
                        </div>
                        <div class="row"><hr></div>
                        <div class="row">
                            <div class="col">
                                <div class="card" id="h2">
                                    <a href="">
                                        <img class="card-img-top" src="" alt="">
                                    </a>
                                    <div class="card-body">
                                    <h5 class="card-title text-center"></h5>
                                    <p class="card-text"></p>
                                  </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card" id="h3">
                                    <a href="">
                                        <img class="card-img-top" src="" alt="">
                                    </a>
                                    <div class="card-body">
                                    <h5 class="card-title text-center"></h5>
                                    <p class="card-text"></p>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container bg-light d-none" id="pcbComponents">
                        <div class="row"><hr></div>
                        <div class="row">
                            <div class="col" id="pcbComponentsTable">
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </body>
</html>