<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<html>
    <head>
        <script type="text/javascript" src="/js/jquery/jquery.js"></script>
        <script type="text/javascript">
            $(function() {
                $(".show").click(function ( event ) {
                    //event.preventDefault();
                    $("#window").show("slow");
                });
                $(".hide").click(function( event ){
                    //event.preventDefaul();
                    $("#window").hide("slow");
                });
            });
        </script>
        <link rel="stylesheet" type="text/css" href="login.css">
    </head>
    <body>
        <div id="box">
            <div id="boxl">
                <button class="button show"><b>show</b></button>
                <button class="button hide"><b>hide</b></button>
            </div>
            <div id="boxr">
                <label>
                    username:                    
                </label>
                <input type="text" class="loginInput"/>
                <label>
                    password:
                </label>
                <input type="text" class="loginInput"/>
            </div>
        </div>
        <div id="window"></div>
        <div id="content">
            <div id="contentl">
                <div id="containerForm">
                    <div id="registerForm">
                        <form id="form1" name="form" method="post" action="">

                            <label>Name
                                <span class="suggest">Min 5 caratteri</span>
                            </label>
                            <input type="text" name="textfield" id="textfield" tabindex="1" />

                            <label>Surname
                                <span class="suggest">Min 5 caratteri</span>
                            </label>
                            <input type="text" name="textfield" id="textfield" tabindex="2" />

                            <label>Email
                                <span class="suggest">ins. Email valida</span>
                            </label>
                            <input type="text" name="textfield" id="textfield" tabindex="3" />
                            <button class="button" tabindex="4"></button>
                        </form>
                    </div><!--/loginForm-->

                </div><!--/containerForm-->
            </div>
            <div id="contentr"></div>
        </div>
    </body>
</html>