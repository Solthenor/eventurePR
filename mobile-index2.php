<!DOCTYPE html>
<html>
<head>
    <meta content="width=device-width, minimum-scale=1, maximum-scale=1" name="viewport">

    <title>Welcome to E-vents</title>
    <link rel="stylesheet" href="css/mobile-style.css" />
    <link rel="stylesheet" href="css/jquery.mobile-1.2.0.css" />
    <link href='http://cdn1.editmysite.com/editor/fonts/Capture_it/font.css?2' rel='stylesheet' type='text/css' />
    <link rel='stylesheet' href='http://cdn1.editmysite.com/editor/images/common/common-v2.css?buildTime=1346362758' type='text/css' />


    <script src="js/jquery-1.8.2.js"></script>
    <script src="js/jquery.mobile-1.2.0.js"></script>

    <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/libraries/jquery_effects.js?1346362758'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/libraries/fancybox/fancybox.min.js?1346362758'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/images/common/utilities-jq.js?1346362758'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/libraries/flyout_menus_jq.js?1346362758'></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>

    <script>
        $(document).ready(function(){
            $('#select-choice-1').change(function()  {
                var $vn = $(this).children('option:selected').attr('value') + ".html";

                window.location.href = $vn;
            });
        });


    </script>

</head>
<body>

<div id="wrapper" style="height: 100%">
    <div id="header" style="height: 25%">
        <span class='wsite-logo'><span id="wsite-title" >E-venturePR</span></span>
        <div data-role="controlgroup" data-type="horizontal" style="float:left;" >
            <a  href="mobile-login.php" rel="external" data-role="button" data-theme="b" style="height: 35px; font-size: 15px;" onclick="window.location.href = this.href" >Profile</a>
            <a  href="mobile-index.php" rel="external" data-role="button" data-theme="b" style="height: 35px; font-size: 15px;" onclick="window.location.href = this.href" >Log Out!</a>

        </div>
    </div><!-- /header -->
    <div id="content" style="height: 75%;margin:auto;">
        <div data-role="fieldcontain">
            <label for="select-choice-1" class="select" style="text-shadow: none;">Select an Option:</label>
            <select id="select-choice-1" name="select-choice-1" data-native-menu="true">
                <option value="">MAIN MENU</option>
                <option value="mobile-index2">HOME</option>
                <option value="mobile-concerts2">CONCERTS</option>
                <option value="mobile-sports2">SPORTS</option>
                <option value="mobile-entertainment2">ENTERTAINMENT</option>
                <option value="mobile-business2">BUSINESS & EDUCATION</option>
            </select>
        </div> <!--fieldcontain-->

        <div id="label" style="margin: auto;">
            <span style="font-size: 18px;color: white; font-weight: bold;text-shadow: none">Find an event: </span>

            <form action="results.html" method="post">
                <div data-role="fieldcontain" data-inset="true">
                    <label for="search" style="font-size: 14px;color: white; padding-top: 5px;">Search:</label>
                    <input type="search" name="query" id="search" value=""/>
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