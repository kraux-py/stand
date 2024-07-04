<?php
include '../fpdf/fpdf.php';
include 'connection.php';

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial','B',16);
        $this->Cell(0,10,utf8_decode('EXPO Ayolas 2024'),0,1,'C');
        $this->SetFont('Arial','B',14);
        $this->Cell(0,10,utf8_decode('Detalle del Usuario'),0,1,'C');
        $this->Ln(10);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',10);
        $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
    }

    function UserDetails($data) {
        $this->SetFont('Arial','',14);
        foreach($data as $key => $value) {
            $this->Cell(0,12,utf8_decode($key . ": " . $value),0,1,'C');
            $this->Ln(6);
        }
    }
}

$id = $_GET['id'];

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

$data = [];

$sql = "SELECT * FROM users WHERE id='$id'";
$result = $conn->query($sql);

if ($row = $result->fetch_assoc()) {
    $data = [
        
        'CI' => $row['id_card'],
        'Nombre de Local/Empresa' => $row['name'],
        'Nombre y Apellido' => $row['surname'],
        'Tel' => $row['phone'],
        'Categ' => $row['category'],
        'Comentarios de Categoría' => $row['category_comment'],
        'Estado de Pago' => $row['payment_status']
    ];
}

$pdf->UserDetails($data);
$pdf->Output();
$conn->close();
?>
