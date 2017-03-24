<?php
header('Content-type: text/html; charset=utf-8');
require 'function.php';
// debug
if(isset($_GET['debug']))
    define('DEBUG', true);
$cache = getcache();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="pragma" content="cache" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smilies - Smileys - Emoticons...</title>
    <style type="text/css">@import url("bootstrap/css/bootstrap.min.css");
        body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
    </style>
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container-fluid">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <a class="brand" href="#">Smileys</a>
                <div class="nav-collapse">
                    <ul class="nav">
                        <li <?php if($cache == "simple") { ?> class="active" <?php } ?>><a href="./">version légère</a></li>
                        <li <?php if($cache == "full") { ?> class="active" <?php } ?>><a href="./?cache=full">version complète</a></li>
                        <li <?php if($cache == "carre") { ?> class="active" <?php } ?>><a href="./?cache=carre">version carré</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </div>
    </div><!--navbar-->
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span2">
            <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header"><img alt="Smiley" id="img-preview" class="img-preview" src="s/s/arf.gif">&nbsp;Codes&nbsp;:&nbsp;</li>
              <li><label for="img-bbcode">BBCode&nbsp;:</label><input class="input" id="img-bbcode" onfocus="selectField(this)" type="text" style="width: 100%"></li>
              <li><label for="img-zcode">ZCode&nbsp;-&nbsp;NCode&nbsp;:</label><input class="input" id="img-zcode" onfocus="selectField(this)" type="text" style="width: 100%"></li>
              <li><label for="img-html">HTML&nbsp;:</label><input class="input" id="img-html" onfocus="selectField(this)" type="text" style="width: 100%"></li>
              <li><label for="img-markdown">Markdown&nbsp;: </label><input class="input" id="img-markdown" onfocus="selectField(this)" type="text" style="width: 100%"></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->
<?php gencache($cache); 
require_once './cache/'. $cache .'.cache'; ?>
        </div><!--/row-->
        <hr>
        <footer>
            <p>&copy; <a href="http://vivi.1.free.fr/">Vivi.1</a>, et d'autres ; adapté d'un projet de <a href="http://nayi.free.fr/">Thunderseb</a> — 2010 - 2017</p>
        </footer>
    </div><!--/.fluid-container-->
    <script>
        window.onload = function() {
            display("s/s/arf.gif");
        };
        function display(url) {
            var path = "http://vivi.1.free.fr/sdz/" + url;
            document.getElementById("img-preview").src = url;
            document.getElementById("img-html").value       = '<img src="' + path + '" alt="smiley" />';
            document.getElementById("img-bbcode").value = "[img]" + path + "[/img]";
            document.getElementById("img-zcode").value      = "<image>" + path + "</image>";
            document.getElementById("img-markdown").value   = "![smiley](" + path + ")";
            document.getElementById("sm-input-url").value       = path;
        }
        function selectField(field) {
            unselectField(document.getElementById("img-html"));
            unselectField(document.getElementById("img-bbcode"));
            unselectField(document.getElementById("img-zcode"));
            unselectField(document.getElementById("img-markdown"));
            unselectField(document.getElementById("img-url"));
            field.select();
        }
        function unselectField(field) {
            var tmp = field.value;
            field.value = "";
            field.value = tmp;  
        }
    </script>
</body>
</html>