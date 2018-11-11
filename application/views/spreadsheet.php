<html>
<head>
<title>Import/Export using phpspreadsheet in codeigniter</title>
</head>
<body>
<style>
h3
{
font-family: Verdana;
font-size: 14pt;
font-style: normal;
font-weight: bold;
color:red;
text-align: center;
}
 
table.tr{
font-family: Verdana;
color:black;
font-size: 12pt;
font-style: normal;
font-weight: bold;
text-align:left;
}
 
</style>
<h3><u>Import/Export using phpspreadsheet in codeigniter</u></h3>
 
<?php echo form_open_multipart('spreadsheet/import',array('name' => 'spreadsheet')); ?>
<table align="center" cellpadding = "5">
<tr>
<td>File :</td>
<td><input type="file" size="40px" name="upload_file" /></td>
<td class="error"><?php echo form_error('name'); ?></td>
<td colspan="5" align="center">
<input type="submit" value="Import Users"/></td>
</tr>
</table>
<?php echo form_close();?>
</body>
</html>