<?php
namespace Food2\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Food2\Model\FoodTable;
use Food2\Model\Food;

class FoodController extends AbstractActionController
{
    private $table;

    public function __construct(FoodTable $table){
        $this->table = $table;
    
    }
    public function indexAction()
    {
        $foodTypes = $this->table->getFoodTypes();
        $types = [];
        foreach($foodTypes as $foodType)
            $types[$foodType->id] = $foodType->name;
        
        $form = new \Zend\Form\Form();
        $form->setAttribute('id', 'formType');
        $form->add([
            'name' => 'typeId',
            'type' => 'select',
            'options' => [
                'label' => 'Chọn loại: ',
                'value_options' => $types
            ],
            'attributes' => [
                'class' => 'form-control',
                'id' => 'typeId'
            ]
        ]);
        $view = new ViewModel(['form'=>$form]);
        
        if($this->getRequest()->isXmlHttpRequest())
        {
            
            $stt=1;
            $typeId = $this->params()->fromPost('typeId', 1);
            $foods = $this->table->fetchByTypeId($typeId);    
            if($foods->count()==0)
            {
                echo '<tr><td colspan="6">Không có dữ liệu</td></tr>';
            }
            else{
            foreach($foods as $food){
                
                echo '<tr>';
                echo '<td>'. $stt++ .'</td>';
               
                echo '<td>'. $food->name.' </td>';
             
                echo '<td>'. $food->summary.' </td>';
                
                echo '<td>'. $food->price.' </td>';
                echo '<td>'. $food->promotion.' </td>';
                echo '</tr>';
                
            }
        }
            return $this->getResponse(); //LOAIJ BOR layout
        }
        
        // 'foods'=>$foods, 
    return $view;
    }

    public function exportExcelAction()
    {
        if($this->getRequest()->isPost())
        {
            $typeId = $this->params()->fromPost('typeId', 1);
            $foods = $this->table->fetchByTypeId($typeId);

            $objExcel = new \PHPExcel();
            $objExcel->setActiveSheetIndex(0);
            $sheet = $objExcel->getActiveSheet()->setTitle('Danh sách đồ ăn');
            $sheet->getColumnDimension('A')->setAutoSize(true);
            $sheet->getColumnDimension('C')->setWidth(30);
            
            // tieu de
            $sheet->setCellValue('A1', "Danh sách thức ăn");
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                                                ->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $sheet->mergeCells('A1:I1');
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(18);
            $sheet->getRowDimension(1)->setRowHeight(30);
            
            //Chen ten cot
            $rowCount = 2;
            $sheet->getStyle('A2:I2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A2:I2')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('00ffff00');
                    
            $sheet->setCellValue('A'.$rowCount, 'STT');
            $sheet->setCellValue('B'.$rowCount, 'Mã món');
            $sheet->setCellValue('C'.$rowCount, 'Tên món');
            $sheet->setCellValue('D'.$rowCount, 'Mô tả ngắn');
            $sheet->setCellValue('E'.$rowCount, 'Mô tả chi tiết');
            $sheet->setCellValue('F'.$rowCount, 'Giá');
            $sheet->setCellValue('G'.$rowCount, 'Đơn vị tính');
            $sheet->setCellValue('H'.$rowCount, 'Khuyến mãi');
            $sheet->setCellValue('I'.$rowCount, 'Ngày cập nhật');

            foreach($foods as $food)
            {
                $rowCount++;
                $sheet->setCellValue('A'.$rowCount, $rowCount-1);
                $sheet->setCellValue('B'.$rowCount, $food->id);
                $sheet->setCellValue('C'.$rowCount, $food->name);
                $sheet->setCellValue('D'.$rowCount, $food->summary);
                $sheet->setCellValue('E'.$rowCount, $food->detail);
                $sheet->setCellValue('F'.$rowCount, $food->price);
                $sheet->setCellValue('G'.$rowCount, $food->unit);
                $sheet->setCellValue('H'.$rowCount, $food->promotion);
                $sheet->setCellValue('I'.$rowCount, $food->update_at);
            }

            $styles=[
                'borders' => [
                    'allborders' => [
                        'style' => \PHPExcel_Style_Border::BORDER_THIN
                    ],
                ],
            ];
            $sheet->getStyle('A2:I'.$rowCount)->applyFromArray($styles);
            $sheet->getStyle('A2:B'.$rowCount)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            //luu va tai xuong
            $objWriter = new \PHPExcel_Writer_Excel2007($objExcel);
            $filename = "food.xlsx";
            $objWriter->save($filename);

            header('Content-Disposition: attachment; filename="'.$filename.'"');
            header('Content-Type: application/vnd.openxmlformatsofficedocument.spreadsheetml.sheet');
            // header('Content-Type: application/vnd.ms-excel');
            header('Content-Length: '.filesize($filename));
            header('Content-Transfer-Encoding: binary');
            header('Cache-Control: must-revalidate');
            header('Pragma: no-cache');
            readfile($filename);
        }

        return false;
    }

    public function importAction()
    {
        
    }
}

?>
