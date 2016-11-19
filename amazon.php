<?php
// The region you are interested in
$aws_secret_key = "9FcxIWXWZmP93oEH6LIOKIukW/CxpLpwBnfiTq1o";
$endpoint = "webservices.amazon.com";
$uri = "/onca/xml";
$params = array(
    "Service" => "AWSECommerceService",
    "AWSAccessKeyId" => "AKIAJVHOR2KAO47KRRVQ",
    "AssociateTag" => "",
    "Operation" => "ItemSearch",
    "Keywords" => "MacBook%20Pro",
    "SearchIndex" => "Computers",
    "Timestamp" => ""
);
// Set current timestamp if not set
if (empty($params['Timestamp'])) {
    $params['Timestamp'] = gmdate('Y-m-d\TH:i:s\Z');
}
// Sort the parameters by key
ksort($params);
$pairs = array();
foreach ($params as $key => $value) {
    array_push($pairs, rawurlencode($key)."=".rawurlencode($value));
}
// Generate the canonical query
$canonical_query_string = join("&", $pairs);
// Generate the string to be signed
$string_to_sign = "GET\n".$endpoint."\n".$uri."\n".$canonical_query_string;
// Generate the signature required by the Product Advertising API
$signature = base64_encode(hash_hmac("sha256", $string_to_sign, $aws_secret_key, true));
// Generate the signed URL
$request_url = 'http://'.$endpoint.$uri.'?'.$canonical_query_string.'&Signature='.rawurlencode($signature);
// echo "Signed URL: \"".$request_url."\"";

$ch = curl_init($request_url); // such as http://example.com/example.xml
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, 0);
$data = curl_exec($ch);
curl_close($ch);
echo $data;
?>