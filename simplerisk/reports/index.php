<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
* License, v. 2.0. If a copy of the MPL was not distributed with this
* file, You can obtain one at http://mozilla.org/MPL/2.0/. */

// Include required functions file
require_once(realpath(__DIR__ . '/../includes/functions.php'));
require_once(realpath(__DIR__ . '/../includes/authenticate.php'));
require_once(realpath(__DIR__ . '/../includes/display.php'));
require_once(realpath(__DIR__ . '/../includes/reporting.php'));

// Include Zend Escaper for HTML Output Encoding
require_once(realpath(__DIR__ . '/../includes/Component_ZendEscaper/Escaper.php'));
$escaper = new Zend\Escaper\Escaper('utf-8');

// Add various security headers
add_security_headers();

// Add the session
add_session_check();

// Include the CSRF Magic library
include_csrf_magic();

// Include the SimpleRisk language file
require_once(language_file());

?>

<!doctype html>
<html lang="<?php echo $escaper->escapehtml($_SESSION['lang']); ?>" xml:lang="<?php echo $escaper->escapeHtml($_SESSION['lang']); ?>">

<head>
  <script src="../js/jquery.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/sorttable.js"></script>
  <script src="../js/obsolete.js"></script>
  <script src="../js/highcharts/code/highcharts.js"></script>
  <title>SimpleRisk: Enterprise Risk Management Simplified</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
  <link rel="stylesheet" href="../css/bootstrap.css">
  <link rel="stylesheet" href="../css/bootstrap-responsive.css">
  <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/theme.css">
  <link rel="stylesheet" href="../css/side-navigation.css">
  
  <?php
    setup_favicon("..");
    setup_alert_requirements("..");
  ?>
</head>

<body>

  <?php
    display_license_check();

    view_top_menu("Reporting");

    // Get any alert messages
    get_alert();
  ?>

  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span3">
        <?php view_reporting_menu("Overview"); ?>
      </div>
      <div class="span9">
        <div class="row-fluid">
          <div class="span4">
            <div class="well">
              <?php open_closed_pie(js_string_escape($lang['OpenVsClosed'])); ?>
            </div>
          </div>
          <div class="span4">
            <div class="well">
              <?php open_mitigation_pie(js_string_escape($lang['MitigationPlannedVsUnplanned'])); ?>
            </div>
          </div>
          <div class="span4">
            <div class="well">
              <?php open_review_pie(js_string_escape($lang['ReviewedVsUnreviewed'])); ?>
            </div>
          </div>
        </div>
      </div>
      <div class="span9">
        <div class="row-fluid">
          <div class="well">
            <?php risks_by_month_table(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>

