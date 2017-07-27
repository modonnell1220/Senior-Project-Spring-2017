<?php
// continue landlord session
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
if ($_SESSION['UserID'] === "" || $_SESSION['identifier'] !== 'T'){
    header('Location: ../../../Tenant/index.php');
}
else{
    $emailID = $_SESSION['UserID'];
	$PropertyID = $_SESSION['PropertyID'];
	$LeaseID = $_SESSION['LeaseID'];
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Signature Pad demo</title>
    <meta name="description" content="Signature Pad - HTML5 canvas based smooth signature drawing using variable width spline interpolation.">

    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">

    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <link rel="stylesheet" href="../css/signature-pad.css">

    <script id="mytext" type="text/javascript">
        var _URLesign = "text";
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-39365077-1']);
        _gaq.push(['_trackPageview']);
        (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();
    </script>
</head>
<body onselectstart="return false">

<div id="signature-pad" class="m-signature-pad">
    <div class="m-signature-pad--body">
        <canvas></canvas>
    </div>
    <div class="m-signature-pad--footer">
        <div class="description">Sign above</div>
        <div class="left">
            <button type="button" class="button clear" data-action="clear">Clear</button>
        </div>
        <div class="right">
            <button type="button" class="button save" data-action="save-png">Save</button>
        </div>
    </div>
</div>
<p id = "signator"> </p>
<script src="../js/signature_pad.js"></script>
<!--<script src="js/app.js"></script>
-->
<script>
    var wrapper = document.getElementById("signature-pad"),
        clearButton = wrapper.querySelector("[data-action=clear]"),
        savePNGButton = wrapper.querySelector("[data-action=save-png]"),
        saveSVGButton = wrapper.querySelector("[data-action=save-svg]"),
        canvas = wrapper.querySelector("canvas"),
        signaturePad;
    // Adjust canvas coordinate space taking into account pixel ratio,
    // to make it look crisp on mobile devices.
    // This also causes canvas to be cleared.
    function resizeCanvas() {
        // When zoomed out to less than 100%, for some very strange reason,
        // some browsers report devicePixelRatio as less than 1
        // and only part of the canvas is cleared then.
        var ratio =  Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
    }
    window.onresize = resizeCanvas;
    resizeCanvas();
    signaturePad = new SignaturePad(canvas);
    clearButton.addEventListener("click", function (event) {
        signaturePad.clear();
    });
    savePNGButton.addEventListener("click", function (event) {
        if (signaturePad.isEmpty()) {
            alert("Please provide signature first.");
        } else {
            // alteration loctaion
            var temp = signaturePad.toDataURL();
			
            try {
                // Opera 8.0+, Firefox, Safari
                ajaxPOSTTestRequest = new XMLHttpRequest();
            } catch (e) {
                // Something went wrong
                alert("Your browser broke!");
                return;
            }
            ajaxPOSTTestRequest.onreadystatechange = ajaxCalled_POSTTest;
            var url = "saveTenantSignature.php";
            var params = "lorem="+temp;
            ajaxPOSTTestRequest.open("POST", url, true);
            ajaxPOSTTestRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajaxPOSTTestRequest.send(params);
            function ajaxCalled_POSTTest() {
                if (ajaxPOSTTestRequest.readyState == 4) {
                   //alert(ajaxPOSTTestRequest.responseText);
                    window.location = '../viewLease.php';
                }
            }
/*
redirection location if needed
 */
        }
    });
    saveSVGButton.addEventListener("click", function (event) {
        if (signaturePad.isEmpty()) {
            alert("Please provide signature first.");
        } else {
            window.open(signaturePad.toDataURL('image/svg+xml'));
        }
    });
</script>


</body>
</html>