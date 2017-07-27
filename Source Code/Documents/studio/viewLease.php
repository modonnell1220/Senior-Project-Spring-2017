<?php
// continue landlord session
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
if ($_SESSION['UserID'] === ""){
    header('Location: ../../Landlord/index.php');
}
else{
   $emailID = $_SESSION['UserID'];
	$PropertyID = $_SESSION['PropertyID'];
	$LeaseID = $_SESSION['LeaseID'];
}

// begin pdf-ing
require('fpdf/fpdf.php');

class PDF extends FPDF
{
	function Header()
	{
		global $title;

		// Arial bold 15
		$this->SetFont('Arial','B',15);
		// Calculate width of title and position
		$w = $this->GetStringWidth($title)+6;
		$this->SetX((210-$w)/2);
		// Colors of frame, background and text
		$this->SetDrawColor(0,0,0);
		$this->SetFillColor(200,200,200);
		$this->SetTextColor(0,0,0);
		// Thickness of frame (1 mm)
		$this->SetLineWidth(1);
		// Title
		$this->Cell($w,9,$title,1,1,'C',true);
		// Line break
		$this->Ln(10);
	}

	function Footer()
	{
		// Position at 1.5 cm from bottom
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Arial','I',8);
		// Text color in gray
		$this->SetTextColor(128);
		// Page number
		$this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
	}

	function ChapterTitle($label)
	{
		// Arial 12
		$this->SetFont('Arial','',12);
		// Background color
		$this->SetFillColor(200,220,255);
		// Title
		$this->Cell(0, 6, "$label", 0, 1, 'L', true);
		// Line break
		$this->Ln(4);
	}

	function ChapterBody($body)
	{
		// Times 12
		$this->SetFont('Times','',12);
		// Output justified text
		$this->MultiCell(0,5,$body);
		// Line break
		$this->Ln();
		// Mention in italics
		$this->SetFont('','I');
		//$this->Cell(0,5,'(end of excerpt)');
	}

	function PrintChapter($title, $body)
	{
		$this->AddPage();
		$this->ChapterTitle($title);
		$this->ChapterBody($body);
	}
}


//Establish a connection to the database
include 'databaseConnection.php';
$mySQLConnection = connectToDatabase();

// Build query for retrieving landlord signature data
$query = "SELECT AgreementBody, LandlordSign, TenantSign FROM Lease WHERE LeaseID = '$LeaseID'";

//Issue query against database
$result = $mySQLConnection->query($query, $mysql_access);

$data = mysqli_fetch_assoc($result);

$pdf = new PDF();
$title = 'LEASE AGREEMENT';
$pdf->SetTitle($title);
$pdf->SetAuthor('');
$pdf->PrintChapter('TERMS OF AGREEMENT', $data['AgreementBody']);

$pdf -> AddPage();	// Thisforces the signatures to be on a new page

const TEMPIMGL = 'tempImgL.png';						// Create new image file on server
$decoded = base64_decode($data['LandlordSign']);	// Base 64 decode image data
file_put_contents(TEMPIMGL, $decoded);					// write contents to image file
$pdf -> Image(TEMPIMGL, 10, null, 30, 20);				// stamp image file into pdf
$pdf -> Cell(0,5, 'Lessee');
$pdf -> Ln();

 
const TEMPIMGT = 'tempImgT.png';						// Create new image file on server
$decoded = base64_decode($data['TenantSign']);	// Base 64 decode image data
file_put_contents(TEMPIMGT, $decoded);					// write contents to image file
$pdf -> Image(TEMPIMGT, 10, null, 30, 20);				// stamp image file into pdf
$pdf -> Cell(0,5, 'Lessor');
$pdf -> Ln();

//Close database
$mySQLConnection->close();

$pdf->Output();
unlink(TEMPIMGL);	// destroy temproary image file 1
unlink(TEMPIMGT);	// destroy temporary image file 2
?>
