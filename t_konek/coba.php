<?php require_once('Connections/konek.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_konek, $konek);
$query_Recordset1 = "SELECT * FROM mhs";
$Recordset1 = mysql_query($query_Recordset1, $konek) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$maxRows_apalah = 10;
$pageNum_apalah = 0;
if (isset($_GET['pageNum_apalah'])) {
  $pageNum_apalah = $_GET['pageNum_apalah'];
}
$startRow_apalah = $pageNum_apalah * $maxRows_apalah;

mysql_select_db("db_apalah");
$query_apalah = "SELECT * FROM mhs";
$query_limit_apalah = sprintf("%s LIMIT %d, %d", $query_apalah, $startRow_apalah, $maxRows_apalah);
$apalah = mysql_query($query_limit_apalah, $konek) or die(mysql_error());
$row_apalah = mysql_fetch_assoc($apalah);

if (isset($_GET['totalRows_apalah'])) {
  $totalRows_apalah = $_GET['totalRows_apalah'];
} else {
  $all_apalah = mysql_query($query_apalah);
  $totalRows_apalah = mysql_num_rows($all_apalah);
}
$totalPages_apalah = ceil($totalRows_apalah/$maxRows_apalah)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table border="1">
  <tr>
    <td width="84">npm</td>
    <td width="90">nama</td>
    <td width="101">jurusan</td>
    <td width="89">kelas</td>
    <td colspan="2">Setting</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_apalah['npm']; ?></td>
      <td><?php echo $row_apalah['nama']; ?></td>
      <td><?php echo $row_apalah['jurusan']; ?></td>
      <td><?php echo $row_apalah['kelas']; ?></td>
      <td width="51"><a href="edit.php?npm=<?php echo $row_Recordset1['npm']; ?>">Edit</a></td>
      <td width="49"><a href="hapus.php?npm=<?php echo $row_Recordset1['npm']; ?>">Hapus</a></td>
    </tr>
    <?php } while ($row_apalah = mysql_fetch_assoc($apalah)); ?>
</table>
<p><a href="index.php">Input</a></p>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($apalah);
?>
