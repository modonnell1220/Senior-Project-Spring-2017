<?php
// continue landlord session
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
if ($_SESSION['UserID'] === "" || $_SESSION['identifier'] !== 'L'){
    header('Location: ../../../Landlord/index.php');
}
else{
    $emailID = $_SESSION['UserID'];
	$PropertyID = $_SESSION['PropertyID'];
}

// Data passed from newLease.html form

// Legal lease dates
$dateCreated = $_POST['dateCreated'];	// Date lease is created
$startDate = $_POST['startDate'];		// first date lease is in effect
$endDate = $_POST['endDate'];			// Last date lease is in effect

// Name / Title of lease
$leaseName = $_POST['leaseName'];

// Names of tenant(s) and landlord / agency
$landlord = $_POST['landlord'];				// Name of landlord or leasing agency
$landlordEmail = $_POST['landlordEmail'];	// Email of landlord or leasing agency
$tenant = $_POST['tenant'];					// Name of tenant
$tenantEmail = $_POST['tenantEmail'];		// Email of tenant

// location information of property
$propertyAddress = $_POST['propertyAddress'];		// Street address of property
$propertyUnitNumber = $_POST['propertyUnitNumber'];	// Unit number of property (used for condos or townhomes)
$propertyCity = $_POST['propertyCity'];				// City of property
$propertyState = $_POST['propertyState'];			// State of property
$propertyZipCode = $_POST['propertyZipCode'];		// Zip code of property
$propertyCounty = $_POST['propertyCounty'];			// County of property

// Address for mailing or contacting landlord / leasing agency
$contactAddress = $_POST['contactAddress'];			// Street address for mailing to contact landlord
$contactUnitNumber = $_POST['contactUnitNumber'];	// Unit number for mailing to contact landlord (used for business unit numbers)
$contactCity = $_POST['contactCity'];				// City for mailing to contact landlord
$contactState = $_POST['contactState'];				// State for mailing to contact landlord
$contactZipCode = $_POST['contactZipCode'];			// Zip code for mailing to contact landlord

// Number of occupants of each type
$numberOfAdultOccupants = $_POST['numberOfAdultOccupants'];	// Number of adults occupying the property
$numberofChildOccupants = $_POST['numberOfChildOccupants'];	// Number of children occupying the property

// Logistical details regarding fees, deposits, and other criteria
$rentAmount = $_POST['rentAmount'];						// Amount of rent money due each month
$latePaymentFee = $_POST['latePaymentFee'];				// Fee amount for late rent payment
$returnCheckFee = $_POST['returnCheckFee'];				// Fee amount for returned check
$depositAmount = $_POST['depositAmount'];				// Deposit amount for property
$numberOfKeys = $_POST['numberOfKeys'];					// Number of keys supplied to the tenant
$replacementKeyFee = $_POST['replacementKeyFee'];		// Fee for a replacement key
$petDeposit = $_POST['petDeposit'];						// Deposit amount for each pet

// calculated data fields
date_default_timezone_set('EST'); // sets Eastern standars time
$totalNumberOfOccupants = $numberOfAdultOccupants + $numberOfChildOccupants;

// The following giant block of text is in fact the lease agreement as dynamically contructed from the passed in form data
$lease = "By this Agreement made and entered into on ".formatDate($dateCreated).", between $landlord, herein referred to as Lessor, and $tenant, herein referred to as Lessee, Lessor leases to Lessee the premises situated at $propertyAddress $propertyUnitNumber $propertyCity, $propertyState $propertyZipCode, $propertyCounty county, together with all appurtenances, for a term of one (1) year to commence on ".formatDate($startDate).", and to end on ".formatDate($endDate).", at 12:00 p.m.  
\n1.	RENT.  Lessee agrees to pay, without demand, to Lessor as rent for the demised premises the sum of ".numToWord($rentAmount)." dollars (".'$'."$rentAmount) per month in advance on the first day of each calendar month beginning ".formatDate($startDate).", at $contactAddress $contactUnitNumber $contactCity, $contactState $contactZipCode or at such other place as Lessor may designate.
\n2.	FORM OF PAYMENT.  Lessee agrees to pay rent each month in the form of one personal check, or one cashier's check or one money order made out to $landlord.
\n3.	LATE PAYMENTS.  For any rent payment not paid by the date due, Lessee shall pay a late fee in the amount of ".numToWord($latePaymentFee)." dollars (".'$'."$latePaymentFee).
\n4.	RETURNED CHECKS.  If, for any reason, a check used by lessee to pay Lessor is returned without having been paid, Lessee will pay a charge of ".numToWord($returnCheckFee)." dollars (".'$'."$returnCheckFee) as additional rent AND take whatever other consequences their might be in making a late payment.  After the second time a Lessee check has returned, Lessee must thereafter secure a cashier's check or a money order for payment of rent.  
\n5.	SECURITY DEPOSIT.  On execution of this lease, Lessee deposits with Lessor ".numToWord($depositAmount)." dollars (".'$'."$depositAmount), receipt of which is acknowledged by Lessor, as security for the faithful performance by Lessee of the terms hereof, to be returned to Lessee, without interest, on the full and faithful performance by him of the provisions hereof.
\n6.	QUIET ENJOYMENT.  Lessor covenants that on paying the rent and performing the covenants herein contained, Lessee shall peacefully and quietly have, hold, and enjoy the demised premises for the agreed term.
\n7.	USE OF PREMISES.  The demised premises shall be used and occupied by Lessee exclusively as a private single family residence, and neither the premises nor any part thereof shall be used at any time during the term of this lease by Lessee for carrying on any business, profession, or trade of any kind, or for any purpose other than as a private single family residence.  Lessee shall comply with all the sanitary laws, ordinances, rules, and orders of appropriate governmental authorities affecting the cleanliness, occupancy and preservation of the demised premises during the term of this lease.
\n8.	NUMBER OF OCCUPANTS.  Lessee agrees that the demised premises shall be occupied by no more than $totalNnumberOfOccupants persons, consisting of $numberOfAdultOccupants adults and $numberOfChildOccupants children under the age of 18 years, without the written consent of Lessor.
\n9.	CONDITION OF PREMISES.  Lessee stipulates that he has examined the demised premises, including the grounds and all buildings and improvements, and that they are, at the time of this lease, in good order, repair, and a safe, clean, and tenant-able condition.
\n10.	KEYS.  Lessee will be given $numberOfKeys key(s) to the premises.  If all keys are not returned to the Lessor following termination of lease, Lessee shall be charged ".numToWord($replacementKeyFee)." dollars (".'$'."$replacementKeyFee) per key.  The Lessee will at no time make or have made duplicates of the keys to the premises or buildings thereof.
\n11.	LOCKS.  Lessee agrees not to change locks on any door without first obtaining Lessor's written permission.  Having obtained written permission, Lessee agrees to pay for changing the locks and to provide Lessor with one duplicate key per lock.
\n12.	LOCKOUT.  If Lessee becomes locked out of the premises, Lessee will be required to secure a private locksmith to regain entry at Lessee's sole expense.
\n13.	PARKING.  Lessor is not responsible for, nor does Lessor assume any liability for damages caused by fire, theft, casualty or any other cause whatsoever with respect to any car or its contents.  
\n14.	ASSIGNMENT AND SUBLETTING.  Without the prior written consent of Lessor, Lessee shall not assign this lease, or sublet or grant any concession or license to use the premises or any part thereof.  A consent by Lessor to one assignment, subletting, concession, or license shall not be deemed to be a consent to any subsequent assignment, subletting, concession, or license.  An assignment, subletting, concession, or license without the prior written consent of Lessor, or an assignment or subletting by operation of law, shall be void and shall, at Lessor's option, terminate this lease.
\n15.	ALTERATIONS AND IMPROVEMENTS.  Lessee shall make no alterations to the buildings on the demised premises or construct any buildings or make other improvements on the demised premises without the prior written consent of Lessor.  All alterations, changes, and improvements built, constructed, or placed on the demised premises by Lessee, except for fixtures removable without damage to the premises and movable personal property, shall, unless otherwise provided by written agreement between Lessor and Lessee, be the property of Lessor and remain on the demised premises at the expiration or sooner termination of this lease.
\n16.	DAMAGE OF PREMISES.  If the demised premises, or any part thereof, shall be partially damaged by fire or other casualty not due to Lessee's negligence or willful act or that of his employee, family, agent, or visitor, the premises shall be promptly repaired by Lessor and there shall be an abatement of rent corresponding with the time during which, and the extent to which, the leased premises may have been untenant-able; but, if the leased premises should be damaged other than by Lessee’s negligence or willful act or that of his employee, family, agent, or visitor to the extent that Lessor shall decide not to rebuild or repair, the term of this lease shall end and the rent shall be prorated up to the time of the damage.
\n17.	DANGEROUS MATERIALS.  Lessee shall not keep or have on the lease premises any article or thing of a dangerous, inflammable, or explosive character that might unreasonably increase the danger of fire on the lease premises or that might be considered hazardous or extra hazardous by any responsible insurance company.  
\n18.	UTILITIES.  Lessee shall be responsible for arranging for and paying all utility services required on the premises.
\n19.	RIGHT OF INSPECTION.  Lessor and his agents shall have the right at all reasonable times during the term of this lease and any renewal thereof to enter the demised premises for inspecting the premises and all building and improvements thereon.
\n20.	MAINTAINENCE AND REPAIR.  Lessee will, at his sole expense, keep and maintain the leased premises and appurtenances in good and sanitary condition and repair during the term of this lease and any renewal thereof.  In particular, Lessee shall keep the fixtures in the house or on or about the leased premises in good order and repair; keep the electric bells in order, keep the yards free from debris; and, at his sole expense, shall make all required repairs to the plumbing, range, heating, apparatus, and electric fixtures whenever damage thereto shall have resulted from Lessee's misuse waste, or neglect or that of his employee, family, agent, or visitor, shall be the responsibility of Lessor or his assigns.  Lessee agrees that no signs shall be placed or painting done on or about the leased premises by Lessee or at his direction without the written consent of Lessor.
\n21.	PAINTING.  Lessor reserves the right to determine when the dwelling will be painted.  Lessee will not paint or in any way alter any property covered under this Agreement without the express written consent of the Lessor.
\n22.	INSURANCE.  Lessor has obtained insurance to cover fire damage to the building itself and liability insurance to cover certain personal injuries occurring as a result of property defects or Lessor negligence.  Lessor's insurance does not cover Lessee’s possessions or Lessee's negligence.  Lessee shall obtain a Lessee's insurance policy to cover damage or loss of personal possessions as well as losses resulting from their negligence.
\n23.	PETS.  Pets shall not be allowed without the prior written consent of the Lessor.  At the time of signing this lease, Lessee shall pay to Lessor, in trust, non-refundable deposit of ".numToWord($petDeposit)." dollars (".'$'."$petDeposit), to be held and disbursed for pet damages to the Premises. This deposit is in addition to any other security deposit stated in this lease. Any Lessee who wishes to keep a pet in the rented unit must sign a Pet Agreement Addendum.
\n24.	DISPLAY OF SIGNS.  During the last seven (7) days of this lease, Lessor or his agent shall have the privilege of displaying the usual \“For Sale\” or \“For Rent\” signs on the demised premises and of showing the property to prospective purchasers or tenants.
\n25.	REPLACEMENT OF APPLIANCES.  The demised premises include appliances and equipment which may from time to time need to be replaced.  The selection of such replacement of such appliances or equipment is at the sole discretion of the Lessor.
\n26.	SUBORDINATION OF LEASE.  The lease and Lessee's leasehold interest here under are and shall be subject, subordinate, and inferior to any liens or encumbrances now or hereafter placed on the demised premises by Lessor, all advances made under any such liens or encumbrances, the interest payable on any such liens or encumbrances, and all renewals or extensions of such liens or encumbrances.
\n27.	HOLDOVER BY LESSEE.  Shall Lessee remain in possession of the demised premises with the consent of Lessor after the natural expiration of this lease, a new month-to-month tenancy shall automatically be created between Lessor and Lessee which shall be subject to all the terms and conditions hereof but shall be terminated on thirty (30) days' written notice served by either Lessor or Lessee on the other party.
\n28.	NOTICE OF INTENT TO VACATE.  (This paragraph applies only when this Agreement is or has become a month-to-month Agreement.)  Lessor shall advise Lessee of any changes in terms of tenancy with notice of at least 30 days.  Changes may include notices of termination, rent adjustments or other reasonable changes in the terms of this Agreement.
\n29.	SURRENDER OF PREMISES.  At the expiration of the Lease as set forth in this Agreement, Lessee shall quit or surrender the premises hereby demised in as good state and condition as they were at the commencement of this lease, reasonable use and wear thereof and damages by the elements excepted.
\n30.	DEFAULT.  If any default is made in the payment of rent, or any part thereof, at the times herein before specified, or if any default is made in the performance of or compliance with any other term or condition hereof, the lease, at the option of Lessor, shall terminate and be forfeited, and Lessor may re-enter the premises and remove all persons there from.  Lessee shall be given written notice of any default or breach, and termination and forfeiture of the lease shall not result if, with five (5) days of receipt of such notice, Lessee has corrected the default or breach or has acted reasonably likely to affect such correction within a reasonable time.
\n31.	ABANDONMENT.  If at any time during the term of the lease Lessee abandons the demised premises or any part thereof, Lessor may, at his option, enter the demised premises by any means without being liable for any prosecution therefore, and without becoming liable to Lessee for danger or for any payment of any kind whatever, and may, at his discretion, as agent for Lessee, re-let the demised premises, or any part thereof, for the whole or any part of the then unexpired term, and may receive and collect all rent payable by virtue of such re-letting, and, at Lessor's option, hold Lessee liable for any difference between the rent that would have been payable under this lease during the balance of the unexpired term, if this lease had continued in force, and the net rent for such period realized by Lessor by means of such re-letting.  If Lessor's right of re-entry is exercised following abandonment of the premises by Lessee, then Lessor may consider any personal property belonging to the Lessee and left on the premises to also have been abandoned, in which case Lessor may dispose of all such personal property in any manner Lessor shall deem proper and is hereby relieved of all liability for doing so.
\n32.	BINDING EFFECT.  The covenants and conditions herein contained shall apply to and bind the heirs, legal representatives, and assigns of the parties hereto, and all covenants are to be construed as conditions of this lease.
\n33.	RADON GAS DISCLOSURE.  As required by law, Lessor make the following disclosure: \"Radon Gas\" is a naturally occurring radioactive gas that, when it has accumulated in a building in sufficient quantities, may present health risks to persons who are exposed to it over time.  Levels of radon that exceed federal and state guidelines have been found in buildings in every state.  Additional information regarding radon and radon testing may be obtained from your county public health unit.
\n34.	LEAD PAINT DISCLOSURE.  Housing built before 1978 may contain lead-based paint.  Lead from paint, paint chips, and dust can pose health hazards if not managed properly.  Lead exposure is especially harmful to young children and pregnant women.  Before renting per 1978 housing, lessors must disclose the presence of known lead-based paint and/or lead-based paint hazards in the dwelling.  Lessees must also receive a federally approved pamphlet on led poisoning prevention.
\n35.	SEVERABILITY.  If any portion of this lease shall be held to be invalid or unenforceable for any reason, the remaining provisions shall continue to be valid and enforceable.  If a court finds that any provision of this lease is invalid or unenforceable, but that by limiting such provision it would become valid and enforceable, then such provision shall be deemed to be written, construed and enforced as so limited
"; // end of lease

echo "<!DOCTYPE html>
		<html>
			<head>
				<meta charset='utf-8'>
				<meta name='viewport' content='width=device-width, initial-scale=1.0'>
				<title>RentingFromMe.com</title>
				<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'>
				<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap-theme.min.css'>
				<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700'>
				<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
				<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/material-design-icons/3.0.1/iconfont/material-icons.min.css'>
				<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.css'>
				<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css'>
				<link rel = 'stylesheet' type = 'text/css' href = '../css/styles.css' />
			</head>
			<body>
				<nav class='navbar navbar-default navigation-clean-search' id='navigationBar'>
					<div class='container'>
						<div class='navbar-header' id='homeIcon'>
							<img height='35.1875' width='39.4375' src='../img/logo.png'>
							<a class='navbar-brand navbar-link' href='../../../Landlord/index.php'>Renting From Me</a>
							<button class='navbar-toggle collapsed' data-toggle='collapse' data-target='#navcol-1'>
								<span class='sr-only'>Toggle navigation</span>
								<span class='icon-bar'></span>
								<span class='icon-bar'></span>
								<span class='icon-bar'></span>
							</button>
						</div>
						<div class='collapse navbar-collapse' id='navcol-1'>
							<a id='logoutTab' href='../../../User/logout.php' class='navbar-text navbar-right nav-links'>
								<i class='icon-logout'></i>
								<span>Logout</span>
							</a>
							<a id='settingsTab' href='../../../Landlord/profile.php' class='navbar-text navbar-right nav-links'>
								<i class='icon-settings'></i>
								<span>Settings</span>
							</a>
							<a id='inboxTab' href='../../../Inbox/index.php' class='navbar-text navbar-right nav-links'>
								<i class='icon-envelope'></i>
								<span>Inbox</span>
							</a>
							<p id='userBanner' class='navbar-text navbar-right'>
								<span>Welcome, <?php echo $firstName; ?></span>
							</p>
						</div>
					</div>
				</nav>
				
				<div class = 'container'>
					<h1>LEASE AGREEMENT</h1>
					<form class = 'well form-horizontal' method = 'POST' action = 'saveLeaseData.php' id = 'leaseAgreement'>
						
						<h3>$leaseName</h3>
						<br>
						<label for 'editableLease'>
							<em>
								Review and edit lease agreement below before submitting.
								<br>
								<strong>DO NOT REMOVE ANY SLASH MARKS OR THIS WILL RUIN THE LEASE</strong>
							</em>
						</label>
						<br>
						<br>
						<textarea form = 'leaseAgreement' name = 'editableLease' rows = '40' cols = '130'>
							$lease
						</textarea>
						<input type = 'hidden' name = 'dateCreated' value = '$dateCreated'>
						<input type = 'hidden' name = 'startDate' value = '$startDate'>
						<input type = 'hidden' name = 'endDate' value = '$endDate'>
						<input type = 'hidden' name = 'leaseName' value = '$leaseName'>
						<input type = 'hidden' name = 'landlord' value = '$landlord'>
						<input type = 'hidden' name = 'landlordEmail' value = '$landlordEmail'>
						<input type = 'hidden' name = 'tenant' value = '$tenant'>
						<input type = 'hidden' name = 'tenantEmail' value = '$tenantEmail'>
						<input type = 'hidden' name = 'propertyAddress' value = '$propertyAddress'>
						<input type = 'hidden' name = 'propertyUnitNumber' value = '$propertyUnitNumber'>
						<input type = 'hidden' name = 'propertyCity' value = '$propertyCity'>
						<input type = 'hidden' name = 'propertyState' value = '$propertyState'>
						<input type = 'hidden' name = 'propertyZipCode' value = '$propertyZipCode'>
						<input type = 'hidden' name = 'propertyCounty' value = '$propertyCounty'>
						<input type = 'hidden' name = 'contactAddress' value = '$contactAddress'>
						<input type = 'hidden' name = 'contactUnitNumber' value = '$contactUnitNumber'>
						<input type = 'hidden' name = 'contactCity' value = '$contactCity'>
						<input type = 'hidden' name = 'contactState' value = '$contactState'>
						<input type = 'hidden' name = 'contactZipCode' value = '$contactZipCode'>
						<input type = 'hidden' name = 'numberOfAdultOccupants' value = '$numberOfAdultOccupants'>
						<input type = 'hidden' name = 'numberOfChildOccupants' value = '$numberOfChildOccupants'>
						<input type = 'hidden' name = 'rentAmount' value = '$dateCreated'>
						<input type = 'hidden' name = 'latePaymentFee' value = '$dateCreated'>
						<input type = 'hidden' name = 'returnCheckFee' value = '$dateCreated'>
						<input type = 'hidden' name = 'depositAmount' value = '$dateCreated'>
						<input type = 'hidden' name = 'numberOfKeys' value = '$dateCreated'>
						<input type = 'hidden' name = 'replacementKeyFee' value = '$dateCreated'>
						<input type = 'hidden' name = 'numberOfPetsAllowed' value = '$dateCreated'>
						<input type = 'hidden' name = 'petDeposit' value = '$dateCreated'>
						<input type = 'hidden' name = 'petRent' value = '$dateCreated'>
						<br><br>					
						<div class = 'form-group'>
							<label class = 'col-md-4 control-label'></label>
							<div class = 'col-md-4 inputGroupContainer'>
								<div class = 'input-group'>
									<input class = 'btn btn-primary' type = 'submit' value = 'Sign Lease'>
								</div>
							</div>
						</div>
					</form>
				</div>
			</body>
		</html>";

function numToWord($num) {
    $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
    $numToWord = $f->format($num);
    return $numToWord;
}
function formatDate($dateToFormat){
    $date=date_create($dateToFormat);
    return date_format($date,'F j, Y');
}
?>