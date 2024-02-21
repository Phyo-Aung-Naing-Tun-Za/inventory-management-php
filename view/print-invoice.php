<?php 

//for printing invoice and drawing table;
require_once("vendor/autoload.php");
use Fpdf\Fpdf;
$pdf = new Fpdf('P','mm',"A4");
$pdf->AddPage();
$pdf->SetFont('Arial','B',14);
$pdf->Cell(190,10,'Order Receipt
',0,1,"C");
$pdf->Ln(3);  
$pdf->SetFont('Arial','B',10);
$pdf->Cell(33,8,'Invoice NO :',0,0);
$pdf->Cell(0,8,$invoices[0]->invoice_no,0,1);
$pdf->Cell(33,8,'Order Date :',0,0);
$pdf->Cell(0,8,$invoices[0]->order_date,0,1);
$pdf->Cell(33,8,'Customer Name :',0,0);
$pdf->Cell(0,8,$invoices[0]->customer_name,0,1);
$pdf->Ln(5);  
$pdf->SetFont('Arial','B',12);
$pdf->Cell(10,10,'#',1,0,'C');
$pdf->Cell(80,10,'Product Name',1,0,'C');
$pdf->Cell(30,10,'Quantity',1,0,'C');
$pdf->Cell(30,10,'Price',1,0,'C');
$pdf->Cell(40,10,'Total (Kyats)',1,1,'C');
$pdf->SetFont('Arial','B',10);

foreach($invoices as $id => $invoice){
    $pdf->Cell(10,10,$id + 1,1,0,'C');
    $pdf->Cell(80,10,$invoice->product_name,1,0,'C');
    $pdf->Cell(30,10,$invoice->qty,1,0,'C');
    $pdf->Cell(30,10,$invoice->price,1,0,'C');
    $pdf->Cell(40,10,$invoice->price * $invoice->qty,1,1,'C');
}


$pdf->Ln(7);  
$pdf->Cell(30,7,'Sub Total :',0,0);
$pdf->Cell(0,7,$invoices[0]->sub_total . ' kyats',0,1);
$pdf->Cell(30,7,'Tax 5% :',0,0);
$pdf->Cell(0,7,$invoices[0]->tax  . ' kyats',0,1);
$pdf->Cell(30,7,'Discount :',0,0);
$pdf->Cell(0,7,$invoices[0]->discount . ' kyats',0,1);
$pdf->Cell(30,7,'Net Total :',0,0);
$pdf->Cell(0,7,$invoices[0]->net_total . ' kyats',0,1);
$pdf->Cell(30,7,'Paid Amount :',0,0);
$pdf->Cell(0,7,$invoices[0]->paid . ' kyats',0,1);
$pdf->Cell(30,7,'Change :',0,0);
$pdf->Cell(0,7,$invoices[0]->changes . ' kyats',0,1);
$pdf->Cell(30,7,'Due Amount :',0,0);
$pdf->Cell(0,7,$invoices[0]->due . ' kyats',0,1);
$pdf->Cell(30,7,'Payment Type :',0,0);
$pdf->Cell(0,7,$invoices[0]->payment_type,0,1);
$pdf->Cell(190,8,'-----------------------------------------------------------------------------------------------------------------------------------------------------------------',0,0);
$pdf->Ln(7);  
$pdf->Ln(7);  
$pdf->Cell(160,3,'Signature',0,0,"R");
$pdf->Cell(160,3,'.................',0,1);
$pdf->Ln(7);  
$pdf->Cell(190,10,'Thank You',0,1,"C");



$pdf->Output();
