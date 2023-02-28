<?php

namespace app\models;

use Yii;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

use app\models\Rfio;
use app\models\Fio;
use app\models\Family;
use app\models\Paspfio;
use app\models\Reestr;
use app\models\Finans;
use app\models\After;
use app\models\Lgot;

class Excel extends \yii\db\ActiveRecord
{
//----------------------------------------------------------
public static function fio_excel($id_fio) {
	$model=Fio::findOne($id_fio);
	$pasp=Paspfio::findOne($id_fio);
	$rfmodel=Rfio::findOne($model->tab);
	$finmodel=Finans::findOne($model->id);
	$fmodel=Family::findAll(['id_fio'=>$model->id]);
	$amodel=After::findOne(['id_fio'=>$model->id]);

	if(!isset($rfmodel)) $rfmodel=new Rfio;

$title=$model->find_for_excel($id_fio);       

$reader =  IOFactory::createReader('Xlsx');
$reader->setReadDataOnly(true);
 
    //считываем образец
	$filename='output/Форма_1.xlsx';
        $xls = $reader->load($filename);
	$xls->setActiveSheetIndex(0);
	$read = $xls->getActiveSheet();
    //создаем новый
    $document = new Spreadsheet();
    $mass=[];

	$write = $document->setActiveSheetIndex(0); // Выбираем первый лист в документе

    $columnPosition = 1; // Начальная позиция 
	$startLine = 1; 


    $nColumn=$read->getHighestColumn();
    $nRow=$read->getHighestRow();
	for ($i = 1; $i <=$nRow; $i++) {   
        $z=0; 
     	for ($j ='A'; $j!= $nColumn; $j++) {          
                       $mass[$i][$z] = $read->getCell($j.$i)->getValue(); //массив с контентом из читаемого файла
                       $z++;
		}
	}

    $border=['borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM]]];

     	$document->getActiveSheet()->getColumnDimension('B')->setWidth(50);
		$document->getActiveSheet()->getColumnDimension('C')->setWidth(50);

		$document->getActiveSheet()->getStyle('A5:A17') ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$document->getActiveSheet()->getStyle('A20:A27')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$document->getActiveSheet()->getStyle('A30:A45')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$document->getActiveSheet()->getStyle('A48:A50')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $write->getStyle("B1:C1")->applyFromArray($border);
                $write->getStyle("A5:C17")->applyFromArray($border);
                $write->getStyle("A20:C27")->applyFromArray($border);
                $write->getStyle("A30:C45")->applyFromArray($border);
                $write->getStyle("A48:C50")->applyFromArray($border);

	$write->setTitle('Общие сведения');
    $write->setCellValueByColumnAndRow($columnPosition+1, 1,$mass[1][1]);

	$write->getStyle('B1')->getAlignment()->setWrapText(true); 
    $write->getStyle('B7')->getAlignment()->setWrapText(true); 
    $write->getStyle('B10:C52')->getAlignment()->setWrapText(true); 

    $write->setCellValueByColumnAndRow($columnPosition, 3,$mass[3][0]);

    $write->setCellValueByColumnAndRow($columnPosition+2, 5, $pasp->fam.' '.$pasp->im.' '.$pasp->ot);

    $write->setCellValueByColumnAndRow($columnPosition+2, 6, date("d.m.Y",strtotime($pasp->rod)));
	
    $write->setCellValueByColumnAndRow($columnPosition+2, 7, $model->give_me_adr($id_fio,1));

	$array=[19,20,23,29,47]; //Заголовок
	$array_2=[];//контент

for($i=5;$i<51;$i++) {
        if(!in_array($i,$array) and $i!=28 and $i!=46)
                array_push($array_2,$i);
};

foreach($array as $arr) {
        $write->setCellValueByColumnAndRow($columnPosition, $arr,$mass[$arr][0]);
        $document->getActiveSheet()->getStyle('A'.$arr) ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
};

foreach($array_2 as $arr) {
        $write->setCellValueByColumnAndRow($columnPosition, $arr,$mass[$arr][0]);
        $write->setCellValueByColumnAndRow($columnPosition+1,$arr,$mass[$arr][1]);
};

        $write->setCellValueByColumnAndRow($columnPosition+2, 8, $model->give_me_adr($id_fio));

        $write->setCellValueByColumnAndRow($columnPosition+2, 9, $model->give_me_adr($id_fio,1));

        $write->setCellValueByColumnAndRow($columnPosition+2, 10,$model->tel);

        $write->setCellValueByColumnAndRow($columnPosition+2, 11, (Family::find_wife($model->id)!=''?Family::find_wife($model->id):''));

        $write->setCellValueByColumnAndRow($columnPosition+2, 12, $model->org.' '.$model->dolg);

        $write->setCellValueByColumnAndRow($columnPosition+2, 13, $model->obr.' '.$model->spec);

        $write->setCellValueByColumnAndRow($columnPosition+2, 14, Lgot::find_lgot($model->lgtype));

        $write->setCellValueByColumnAndRow($columnPosition+2, 15, Lgot::find_lgot_dop($model->id,1));

        $write->setCellValueByColumnAndRow($columnPosition+2, 16, Lgot::find_lgot_dop($model->id,2));

        $write->setCellValueByColumnAndRow($columnPosition+2, 17, Lgot::find_lgot_dop($model->id,3));

        $write->setCellValueByColumnAndRow($columnPosition+2, 21,$finmodel->aliment);

        $write->setCellValueByColumnAndRow($columnPosition+2, 22,$finmodel->find_credit($id_fio));

        $write->setCellValueByColumnAndRow($columnPosition+2, 24,$finmodel->uch_ip);

        $write->setCellValueByColumnAndRow($columnPosition+2, 25,$finmodel->dir_ip);

        $write->setCellValueByColumnAndRow($columnPosition+2, 26,$finmodel->third_face);

        $write->setCellValueByColumnAndRow($columnPosition+2, 27,$finmodel->poruch);

        $write->setCellValueByColumnAndRow($columnPosition+2, 30,$amodel->reability);

        $write->setCellValueByColumnAndRow($columnPosition+2, 31,$amodel->medicine);

        $write->setCellValueByColumnAndRow($columnPosition+2, 32,$amodel->psiho);

        $write->setCellValueByColumnAndRow($columnPosition+2, 33,$amodel->indiv);

        $write->setCellValueByColumnAndRow($columnPosition+2, 34,$amodel->sanatory);

        $write->setCellValueByColumnAndRow($columnPosition+2, 35,$amodel->social);

        $write->setCellValueByColumnAndRow($columnPosition+2, 36,$amodel->uridict);

        $write->setCellValueByColumnAndRow($columnPosition+2, 37,$amodel->trud);

        $write->setCellValueByColumnAndRow($columnPosition+2, 38,$amodel->vosstan);

        $write->setCellValueByColumnAndRow($columnPosition+2, 39,$amodel->new_trud);

        $write->setCellValueByColumnAndRow($columnPosition+2, 40,$amodel->stady);

        $write->setCellValueByColumnAndRow($columnPosition+2, 41,$amodel->perepod);

        $write->setCellValueByColumnAndRow($columnPosition+2, 42,$amodel->finans_help);

        $write->setCellValueByColumnAndRow($columnPosition+2, 43,$amodel->veterans);

        $write->setCellValueByColumnAndRow($columnPosition+2, 44,$amodel->initiative);

        $write->setCellValueByColumnAndRow($columnPosition+2, 45,$amodel->others);

        $write->setCellValueByColumnAndRow($columnPosition+2, 48,$rfmodel->fio);

        $write->setCellValueByColumnAndRow($columnPosition+2, 49,$rfmodel->tel);

        $write->setCellValueByColumnAndRow($columnPosition+2, 50,($rfmodel->fio.', '.$rfmodel->dolg));

		$objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($document, 'Xlsx');
		$objWriter->save('output/ФОРМА_'.$title.'_1.xlsx'); 
}
//----------------------------------------------------------
public static function reestr_excel($id_fio) {
	
$reader =  IOFactory::createReader('Xlsx');
$reader->setReadDataOnly(true);
$pasp=Paspfio::findOne($id_fio);
$model=Fio::findOne($id_fio);
$rfmodel=Rfio::findOne($model->tab);
$title=$model->find_for_excel($id_fio);       
if(!isset($rfmodel)) $rfmodel=new Rfio;
    //считываем образец
	$filename='output/Форма_2.xlsx';
        $xls = $reader->load($filename);
	$xls->setActiveSheetIndex(0);
	$read = $xls->getActiveSheet();
    //создаем новый
    $document = new Spreadsheet();
    $mass=[];

	$write = $document->setActiveSheetIndex(0); // Выбираем первый лист в документе

        $columnPosition = 1; // Начальная позиция 
	$startLine = 1; 


            $nColumn=$read->getHighestColumn();
            $nRow=$read->getHighestRow();
	    for ($i = 1; $i <=$nRow; $i++) {   
                $z=0; 
     		for ($j ='A'; $j!= $nColumn; $j++) {          
                       $mass[$i][$z] = $read->getCell($j.$i)->getValue(); //массив с контентом из читаемого файла
                       $z++;
		}
	}

        $border=['borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM]]];

	$write->setTitle('Сопровождение семьи');
	$write->getStyle('A14:H14')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	$write->setCellValueByColumnAndRow($columnPosition+1, 1,$mass[1][1]);
	$write->getStyle('B1')->getAlignment()->setWrapText(true); 
	$write->getColumnDimension('A')->setWidth(15);
	$write->getColumnDimension('B')->setWidth(50);
	$write->getColumnDimension('C')->setWidth(45);
	$write->getColumnDimension('D')->setWidth(30);
	$write->getColumnDimension('E')->setWidth(40);
	$write->getColumnDimension('F')->setWidth(30);
	$write->getColumnDimension('G')->setWidth(30);
	$write->getColumnDimension('H')->setWidth(30);
	
	$write->setCellValueByColumnAndRow($columnPosition, 3,$mass[3][0]);
	
			for($i=5;$i<12;$i++) {
					$write->setCellValueByColumnAndRow($columnPosition+1, $i,$mass[$i][1]); 
			}
			$write->setCellValueByColumnAndRow($columnPosition+2, 6,$pasp->fam.' '.$pasp->im.' '.$pasp->ot);
		 
			$write->setCellValueByColumnAndRow($columnPosition+2, 7,$pasp->tel);
	
			$write->setCellValueByColumnAndRow($columnPosition+2, 9,$rfmodel->fio);
	
			$write->setCellValueByColumnAndRow($columnPosition+2, 10,$rfmodel->tel);
	
			$write->setCellValueByColumnAndRow($columnPosition+2, 11,($rfmodel->fio.', '.$rfmodel->dolg));
			$write->getStyle('C11')->getAlignment()->setWrapText(true); 
			$write->getStyle('A14:G14')->getAlignment()->setWrapText(true); 
			for($i=0;$i<8;$i++){
				$write->setCellValueByColumnAndRow($columnPosition+$i,14,$mass[14][$i]);             
		};
		$reestr=Reestr::findAll(['id_fio'=>$id_fio]);
		$s=15;
		$vypl=['0'=>'','1'=>'однократное','2'=>'длящееся'];
		$write->getStyle("A14:H".(14+count((array)$reestr)))->applyFromArray($border);
			$write->getStyle("B1:C1")->applyFromArray($border);
		$write->getStyle("B6:C7")->applyFromArray($border);
		$write->getStyle("B9:C11")->applyFromArray($border);
		$write->getStyle('A14:H14')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$write->getStyle('B15:F'.(15+count((array)$reestr)))->getAlignment()->setWrapText(true); 
	
		foreach($reestr as $r) { 
			$write->setCellValueByColumnAndRow($columnPosition,$s,date("d.m.Y",strtotime($r['date'])));		
			$write->setCellValueByColumnAndRow($columnPosition+1,$s,Reestr::find_theme($r['theme']));
			 $write->setCellValueByColumnAndRow($columnPosition+2,$s,($r['zag']));
			$write->setCellValueByColumnAndRow($columnPosition+3,$s,$vypl[$r['vypl']]);
			$write->setCellValueByColumnAndRow($columnPosition+4,$s,$r['otvet']);
			$write->setCellValueByColumnAndRow($columnPosition+5,$s,$r['prim']);
			$write->setCellValueByColumnAndRow($columnPosition+6,$s,date("d.m.Y",strtotime($r['srok'])));
			$write->setCellValueByColumnAndRow($columnPosition+7,$s,Reestr::find_status($r['status']));      
		$s++;	
		};

	$objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($document, 'Xlsx');
	$objWriter->save('output/ФОРМА_'.$title.'_2.xlsx'); 	
}

//-------------------------------------------------------

}