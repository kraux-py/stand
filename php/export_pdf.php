<?php
include '../fpdf/fpdf.php';
include 'connection.php';

class PDF extends FPDF {
    protected $angle = 0;

    function Header() {
        // Logo de la Municipalidad de Ayolas
        $this->Image('../images/logo.png', 10, 6, 30); // Ajusta la ruta y el tamaño según sea necesario

        // Encabezado
        $this->SetFont('Arial','B',16);
        $this->Cell(0,10,utf8_decode('EXPO Ayolas 2024'),0,1,'C');
        $this->SetFont('Arial','B',14);
        $this->Cell(0,10,utf8_decode('Detalle del Usuario'),0,1,'C');
        $this->Ln(10);
    }

    function Footer() {
        $this->SetY(-40); // Ajustar para dar espacio a los términos y condiciones
        $this->SetFont('Arial','I',10);
        $this->MultiCell(0,10,utf8_decode("He leído y acepto los términos y condiciones del registro del stand en EXPO Ayolas 2024."),0,'C');
        $this->Ln(5); // Espacio entre términos y número de página
        $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
    }

    function UserDetails($data) {
        $this->SetFont('Arial','',14);
        foreach($data as $key => $value) {
            $this->Cell(0,12,utf8_decode($key . ": " . $value),0,1,'C');
            $this->Ln(6);
        }
    }

    function Rotate($angle, $x=-1, $y=-1) {
        if($x == -1) $x = $this->x;
        if($y == -1) $y = $this->y;
        if($this->angle != 0) $this->_out('Q');
        $this->angle = $angle;
        if($angle != 0) {
            $angle *= M_PI/180;
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.5F %.5F cm 1 0 0 1 %.5F %.5F cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
        }
    }

    function _endpage() {
        if($this->angle != 0) {
            $this->angle = 0;
            $this->_out('Q');
        }
        parent::_endpage();
    }

    function AddWatermark() {
        // Marca de agua en el centro
        $this->SetFont('Arial','B',50);
        $this->SetTextColor(255,192,203); // Color rosa claro
        $this->Rotate(45, $this->w / 2, $this->h / 2);
        $this->Text(($this->w - 70) / 2, $this->h / 2, utf8_decode('DOCUMENTO ORIGINAL'));
        $this->Rotate(0);
        
        // Volver a los colores normales para el contenido
        $this->SetTextColor(0,0,0);
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

$pdf->AddWatermark(); // Aplicar la marca de agua primero
$pdf->UserDetails($data); // Luego agregar los detalles del usuario
$pdf->Output();
$conn->close();
?>
