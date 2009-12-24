<?php

$config = require('config.php');

$dbh = null;
try {
  $dbh = new PDO("mysql:host={$config['host']};dbname={$config['dbname']}",
          $config['username'], $config['password']);
} catch (PDOException $e) {
  print "Error!: " . $e->getMessage() . "<br/>";
  die();
}

if (! isset($_POST['client_id'])) {
  die("client_id cannot be empty");
}
if (! isset($_POST['access_id'])) {
  die("access_id cannot be empty");
}

function sync_for($access_id, $client_id) {
  global $dbh;
  $params = array('access_id' => $access_id, 'client_id' => $client_id);

  $sth = $dbh->prepare('SELECT `key`, `value` FROM `entries` WHERE `access_id`=:access_id AND '
          . '`client_id` <> :client_id');
  $data = array();
  $sth->execute($params);

  while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
    $data[$row['key']] = $row['value'];
  }

  $sth = $dbh->prepare("UPDATE `entries` SET `client_id`=:client_id "
    . "WHERE `access_id`=:access_id");
  $sth->execute($params);

  return array(
    'sync' => ! empty($data),
    'data' => $data
  );
}

if ($_GET['action'] == 'store') {
  $sth = $dbh->prepare(
    'INSERT INTO `entries` SET `access_id`=:access_id, `client_id`=:client_id, `key`=:key, '
          . '`value`=:value '
          . 'ON DUPLICATE KEY UPDATE `client_id`=:client_id, `value`=:value'
  );
  $sth->execute($_POST);

  echo json_encode(sync_for($_POST['access_id'], $_POST['client_id']));
}
elseif ($_GET['action'] == 'sync') {
  echo json_encode(sync_for($_POST['access_id'], $_POST['client_id']));
}
else {
  die("Unknown action.");
}
?>