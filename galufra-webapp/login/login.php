<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

 require('header.php');
 print '
 <link rel="stylesheet" type="text/css" href="login.css">
 <body>
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
                            <button class="button" tabindex="4">ok</button>
                        </form>
                    </div><!--/loginForm-->

                </div><!--/containerForm-->
            </div>
            <div id="contentr"></div>
        </div>
    </body>
</html>'





?>
