<?php
$conftmp = file('/usr/local/share/nems/nems.conf');
if (is_array($conftmp) && count($conftmp) > 0) {
  foreach ($conftmp as $line) {
    $tmp = explode('=',$line);
    $config[trim($tmp[0])] = trim($tmp[1]);
  }
}

  // Really, no validation security needed since this folder (/config) requires a password to execute
  if (isset($_POST) && isset($_POST['name']) && isset($_POST['value'])) {
    $name = trim($_POST['name']); // doing it this way just to protect from accidentally enabling/disabling the wrong service after a copy-and-paste

    switch ($_POST['name']) {

      case 'nagios-api':
        if ($_POST['value'] == 'off') {
          $config['service.' . $name] = 0;
	} elseif ($_POST['value'] == 'on') {
          $config['service.' . $name] = 1;
        }
        break;

      case 'rpi-monitor':
        if ($_POST['value'] == 'off') {
          $config['service.' . $name] = 0;
	} elseif ($_POST['value'] == 'on') {
          $config['service.' . $name] = 1;
        }
        break;


    }
  }

// writeout the config
if (is_array($config) && count($config) > 0) {
  $confstring = '';
  foreach ($config as $key=>$value) {
    $confstring .= $key . '=' . $value . PHP_EOL;
  }
  file_put_contents('/usr/local/share/nems/nems.conf',$confstring);
}
?>