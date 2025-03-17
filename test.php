<?php
$html = "<html><body id=\"body\"></body></html>"; 
libxml_use_internal_errors(true);
$doc = new DOMDocument();
$doc->loadHTML($html);
$body = $doc->getElementById("body");
for ($i=0; $i < 100; $i++) { 
	$appended = $doc->createElement("div", $i);
	$body->appendChild($appended);
}
echo $doc->saveHTML();
?>
