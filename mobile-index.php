<?php            //connects to the DB & checks if user is logged in.. This web page is the main index of the mobile site
require_once('db.php');
require_once('checkAuth.php');

if (isset($_POST['mloggedOut'])) {
    setcookie('loggedin', false);
    $id = 0;
}

?>

<!DOCTYPE html>
<html> 
	<head>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

        <title>Welcome to E-vents</title>
	<link rel="stylesheet" href="css/mobile-style.css" />
	<link rel="stylesheet" href="css/jquery.mobile-1.2.0.css" />
    <link href='http://cdn1.editmysite.com/editor/fonts/Capture_it/font.css?2' rel='stylesheet' type='text/css' />
    <link rel='stylesheet' href='http://cdn1.editmysite.com/editor/images/common/common-v2.css?buildTime=1346362758' type='text/css' />


        <script src="js/jquery-1.8.2.js"></script>
	<script src="js/jquery.mobile-1.2.0.js"></script>



        <script>
            $(document).ready(function(){
                $('#select-choice-1').change(function()  {
                    if($(this).children('option:selected').attr('value') != 'mobile-index')  {
                    var $vn = "mobile-events.php?category="+ $(this).children('option:selected').attr('value');
                        window.location.href = $vn;
                    }
                    else {
                        var $vn = $(this).children('option:selected').attr('value') + ".php" ;
                        window.location.href = $vn;
                    }
                });
            });


        </script>

</head> 
<body>

	<div id="wrapper" style="height: 100%">
        <div id="header" >
            <span class='wsite-logo'><span id="wsite-title" >E-venturePR</span></span>
            <div data-role="controlgroup" data-type="horizontal" style="float:left; width: 100%" >
                <?php if($loggedin) { ?>
                <a  href="mobile-profile.php" rel="external" data-role="button" data-theme="c" style="height: 40px; font-size: 15px;"  >Profile</a>
                <form style="float:left;" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" data-ajax="false">
                        <input  type='submit' name="mloggedOut" id="mloggedOut" value="logout" class='btn btn-eventPR' />
                </form>

                <?php }  else {?>
                <p style="font-size: 16px;font-weight: bold;text-shadow: none;">Dont have an account?</p>
                <a  href="mobile-register.php"  rel="external" data-role="button" data-theme="c" style="height: 40px; font-size: 15px;"  >Sign up!</a>
                <a  href="mobile-login.php"  rel="external" data-role="button" data-theme="c" style="height: 40px; font-size: 15px;"  >Log in!</a>

                <?php }?>
            </div>
        </div><!-- /header -->
        <div id="content" style=";margin:auto;">
            <div data-role="fieldcontain">
                <label for="select-choice-1" class="select" style="text-shadow: none;">Select an Option:</label>
                <select id="select-choice-1" name="select-choice-1" data-native-menu="true">
                    <option value="">MAIN MENU</option>
                    <option value="mobile-index">HOME</option>
                    <option value="Concert">CONCERTS</option>
                    <option value="Sports">SPORTS</option>
                    <option value="Entertainment">ENTERTAINMENT</option>
                    <option value="Business">BUSINESS & EDUCATION</option>
              </select>
            </div> <!--fieldcontain-->

            <div id="label" style="margin: auto;">
                <span style="font-size: 18px;color: white; font-weight: bold;text-shadow: none">Find an event: </span>

                <form action="results.html" method="post" data>
                    <div data-role="fieldcontain" data-inset="true">
                        <label for="search" style="font-size: 14px;color: white; padding-top: 5px;">Search:</label>
                        <input style="color: black !important;" type="search" name="query" id="search" value=""/>
                    </div> <!-- /fieldcontain -->
                </form>
            </div>

            <div data-role="fieldcontain" style="margin-top: 10%;">
                <ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b">
                    <li data-role="list-divider" style="font-size: 16px;color: white;  ">Featured Events:</li>
                    <li><a href=""><font size="2">"Luis Raul: Que Clase E Lengua!"</font></a></li>
                    <li><a href=""><font size="2">"Nightwish: Imaginareum"</font></a></li>
                    <li><a href=""><font size="2">"Baloncesto: Los Piratas de Quebradillas</font></a></li>


                </ul>
            </div>

            <div data-role="fieldcontain">
                <ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b">
                    <li data-role="list-divider" style="font-size: 16px;color: white;margin-top: 10%  ">Other Events:</li>
                    <li><a href=""><font size="2" >Mofongo Party</font></a></li>
                    <li><a href=""><font size="2">Alvaro's Supercalifragilisticexpialidocious Fest</font></a></li>
                    <li><a href=""><font size="2" >Mofongo Party</font></a></li>
                    <li><a href=""><font size="2">Improvisacion: TEATRUM</font></a></li>
                    <li><a href=""><font size="2" >DIGILIFE: Effective Project Management</font></a></li>
                    <li><a href=""><font size="2">ACM - Basic Python Programming Seminar</font></a></li>

                </ul>
            </div>

            </div> <!--content-->
    </div>         <!--wrapper-->

</body>
</html>
