<?php

namespace setasign\Fpdi;

require_once(__DIR__ . "/../vendor/setasign/fpdf/Fpdf.php");
require_once(__DIR__ . "/../vendor/setasign/fpdi/src/autoload.php");


/**
 * PDF文件加水印
 * composer命令安装：composer require setasign/fpdf
 * composer命令安装：composer require setasign/fpdi
 */
class PdfWater3
{
    function addTxtWater($oldFile, $newFile, $waterText)
    {
        $pdf = new Fpdi();
        //获取页数
        $pageCount = $pdf->setSourceFile($oldFile);
        //遍历所有页面
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            //导入页面
            $templateId = $pdf->importPage($pageNo);
            //获取导入页面的大小
            $size = $pdf->getTemplateSize($templateId);

            if ($size['width'] > $size['height']) {
                $pdf->AddPage('L', array($size['width'], $size['height']));
            } else {
                $pdf->AddPage('P', array($size['width'], $size['height']));
            }

            $pdf->useTemplate($templateId);//使用导入的页面


            $pdf->SetFont('Arial', 'B', '24');//设置字体
            $family = ['courier', 'helvetica', 'times', 'symbol', 'zapfdingbats'];
            $pdf->SetFont('helvetica', 'U', '50');
            $pdf->SetXY($size['width'], $size['height']);

            $pdf->Write(7, $waterText);//写入水印 - 中文会乱码 建议使用中文图片


        }
        //I输出output，D下载download，F保存file_put_contents，S返回return
        $pdf->Output('F', $newFile, false);
    }

    function addImageWater($oldFile, $newFile, $waterFile)
    {
        $pdf = new Fpdi();

        $pageCount = $pdf->setSourceFile($oldFile);//获取页数

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {//遍历所有页面

            $templateId = $pdf->importPage($pageNo);//导入页面

            $size = $pdf->getTemplateSize($templateId); //获取导入页面的大小

            if ($size['width'] > $size['height']) {//创建页面（横向或纵向取决于导入的页面大小）
                $pdf->AddPage('L', array($size['width'], $size['height']));
            } else {
                $pdf->AddPage('P', array($size['width'], $size['height']));
            }
            $pdf->useTemplate($templateId);//使用导入的页面

            $pdf->image($waterFile, 0, 0, $size['width'], $size['height']);//全屏背景水印
        }

        $pdf->Output('F', $newFile, false);//I输出output，D下载download，F保存file_put_contents，S返回return
    }

}

$oldFile = __DIR__ . "/../pdf.pdf";
$newFile = __DIR__ . "/../output.pdf";
$waterFile = __DIR__ . "/../water.png";

$pdfwater = new PdfWater3();
$pdfwater->addImageWater($oldFile, $newFile, $waterFile);
//$pdfwater->addTxtWater($oldFile, $newFile, "xueersibook" );