<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
* License, v. 2.0. If a copy of the MPL was not distributed with this
* file, You can obtain one at http://mozilla.org/MPL/2.0/. */

// Include required functions file
require_once(realpath(__DIR__ . '/../includes/assets.php'));
require_once(realpath(__DIR__ . '/../includes/authenticate.php'));
require_once(realpath(__DIR__ . '/../includes/display.php'));
require_once(realpath(__DIR__ . '/../includes/alerts.php'));
require_once(realpath(__DIR__ . '/../vendor/autoload.php'));

// Include Laminas Escaper for HTML Output Encoding
$escaper = new Laminas\Escaper\Escaper('utf-8');

// Add various security headers
add_security_headers();

// Add the session
$permissions = array(
        "check_access" => true,
        "check_assets" => true,
);
add_session_check($permissions);

// Include the CSRF Magic library
include_csrf_magic();

// Include the SimpleRisk language file
require_once(language_file());

// Check if the user has access to manage assets
if (!isset($_SESSION["asset"]) || $_SESSION["asset"] != 1)
{
  header("Location: ../index.php");
  exit(0);
}
else $manage_assets = true;

/**
* Get Asset Info
*/
$id = $_GET['id'];

?>

<!doctype html>
<html>

<head>
<?php
        // Use these jQuery scripts
        $scripts = [
                'jquery.min.js',
        ];

        // Include the jquery javascript source
        display_jquery_javascript($scripts);
?>
  <script src="../js/bootstrap.min.js"></script>
  <title>SimpleRisk: Enterprise Risk Management Simplified</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
  <link rel="stylesheet" href="../css/bootstrap.css">
  <link rel="stylesheet" href="../css/bootstrap-responsive.css">


  <link rel="stylesheet" href="../css/divshot-util.css">
  <link rel="stylesheet" href="../css/divshot-canvas.css">
  <link rel="stylesheet" href="../css/display.css">
  <link rel="stylesheet" href="../vendor/components/font-awesome/css/fontawesome.min.css">
  <link rel="stylesheet" href="../css/theme.css">
  <link rel="stylesheet" href="../css/side-navigation.css">
  
  <?php
      setup_favicon("..");
      setup_alert_requirements("..");
  ?>  

  <script type="text/javascript">
  var loading={
      ajax:function(st)
      {
        this.show('load');
      },
      show:function(el)
      {
        this.getID(el).style.display='';
      },
      getID:function(el)
      {
        return document.getElementById(el);
      }
    }
  </script>
</head>

<body>


  <?php
  view_top_menu("AssetManagement");

  // Get any alert messages
  get_alert();
  ?>
  <div id="load" style="display:none;">Scanning IPs... Please wait.</div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span3">
        <?php view_asset_management_menu("AddDeleteAssets"); ?>
      </div>
      <div class="span9">
        <div class="row-fluid">
          <div class="span12">
            <div class="hero-unit">
            <?php 
                display_asset_detail($id);
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>

</html>
