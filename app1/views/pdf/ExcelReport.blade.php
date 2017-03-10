<?php
function asMoney($value) {
  return number_format($value, 2);
}
$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);
?>
<html >
<body>
  
      <?php $i =1; ?>
       @foreach($nhifs as $nhif)
       {{  $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $nhif->personal_file_number) }}
       {{  $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $nhif->last_name.' '.$nhif->first_name) }}
       {{  $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $nhif->identity_number) }}
       {{  $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $nhif->hospital_insurance_number) }}
       {{  $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, asMoney($nhif->nhif_amount)) }}
      <?php $i++; ?>
    @endforeach
   
<?php $objPHPExcel = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objPHPExcel->save('nssf.xls');
?>

</body>
</html>



