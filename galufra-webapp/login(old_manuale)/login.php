<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


require_once ("controller/authController.php");

$auth = new Authorization();
list($status, $user) = $auth->getStatus();
if ($status == AUTH_LOGGED)
    echo "ciao " . $user['nome'] . ": sei gia connesso!\n";
else {
    require_once ('header.php');
    print '
 <link rel="stylesheet" type="text/css" href="login.css">
 <body>
 <div id="content">
            <div id="contentl">
                <div id="containerForm">
                    <div id="registerForm">
                        <form id="regForm" action="register.php" method="post">
                            <label>Username
                                <span class="suggest">Min 5 caratteri</span>
                            </label>
                            <input type="text" name="uname" id="textfield" tabindex="1" />
                            <label>Name
                                <span class="suggest">Min 5 caratteri</span>
                            </label>
                            <input type="text" name="name" id="textfield" tabindex="1" />
                            <label>Surname
                                <span class="suggest">Min 5 caratteri</span>
                            </label>
                            <input type="text" name="sname" id="textfield" tabindex="2" />
                            <label>Email
                                <span class="suggest">ins. Email valida</span>
                            </label>
                            <input type="text" name="email" id="textfield" tabindex="3" />
                            <label>Password
                                <span class="suggest">Min 5 caratteri</span>
                            </label>
                            <input type="password" name="pwd" id="textfield" tabindex="1" />
                            <label>Re-type Password
                                <span class="suggest">Min 5 caratteri</span>
                            </label>
                            <input type="password" name="repwd" id="textfield" tabindex="1" />
                            <label>Location
                                <span class="suggest">Min 5 caratteri</span>
                            </label>
                            <input type="text" name="city" id="textfield" tabindex="1" />
                            <button class="button" tabindex="4" name="action" value="send">ok</button>
                        </form>
                    </div><!--/loginForm-->

                </div><!--/containerForm-->
            </div>
            <div id="contentr"></div>
        </div>
    </body>
</html>';
}
?>
