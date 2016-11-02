<?php
include "connect.php";
ini_set("memory_limit","1000M");
error_reporting(0);
set_time_limit(0);

$type = $_POST['type'];
$filename = $_POST['filename'];

date_default_timezone_set('Singapore');
$date = date('Y-m-d h:i:s');

/** Include path **/
set_include_path(get_include_path() . PATH_SEPARATOR . '../../../Classes/');

/** PHPExcel_IOFactory */
include 'PHPExcel/IOFactory.php';

include('config.php');
$inputFileName = './Import_Sample.xlsx';

	$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
	$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

	$objReader = PHPExcel_IOFactory::createReader('Excel2007');
	$objPHPExcel = $objReader->load($inputFileName);
	$sheet = $objPHPExcel->getActiveSheet();
	//$data=$sheet->getCell("D9")->getValue();


for (; $n <= $objPHPExcel->setActiveSheetIndex(0)->getHighestRow(); $n++)
{
	$cnt = mysql_query('select * from products where id="'.$sheetData[$n]["A"].'"');
	$cnt = mysql_num_rows($cnt);
	//echo 'insert into products (id,product_name,unit_price,selling_price,created_at,updated_at,updated_by) values
//		("'.$sheetData[$n]["A"].'","'.$sheetData[$n]["B"].'","'.$sheetData[$n]["C"].'","'.$sheetData[$n]["D"].'","'.$date.'","'.$date.'",1)'."<br>";
	if ($cnt == 0)
	{	
		$unit_price = explode('$',$sheetData[$n]["C"]);
		$selling_price = explode('$',$sheetData[$n]["D"]);
		mysql_query('insert into products (id,product_name,unit_price,selling_price,created_at,updated_at,updated_by) values
		("'.$sheetData[$n]["A"].'","'.$sheetData[$n]["B"].'","'.$unit_price[1].'","'.$selling_price[1].'","'.$date.'","'.$date.'",1)') or die(mysql_error());
	}
}