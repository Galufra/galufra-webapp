<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

print '
    <html>
    <head>
        <script type="text/javascript" src="../js/jquery/jquery.js"></script>
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
                <form action="checkLoginInput.php" method="post">
                    <label>
                        username:
                    </label>
                    <input type="text" name="username" class="loginInput"/>
                    <label>
                        password:
                    </label>
                    <input type="password" name="password" class="loginInput"/>
                    <button class="button">logIn</button>
                </form>
            </div>
        </div>
        <div id="window"></div>
        </body>';

?>
