#!/usr/bin/php
<?php
require_once ('path.inc');
require_once ('get_host_info.inc');
require_once ('rabbitMQLib.inc');

function foodInfo($request)
{

	try
	{
		//$req = $argv[1];
		//$limit = 1;
		//echo "Search For: " . $req . "\n";


		$req = $request['foodName'];
		$url = "https://api.fda.gov/food/enforcement.json?search=product_description=".$req."";
		$result = file_get_contents($url);
		
		$data = json_decode($result, true);

		$productDec = $data['results'][0]['product_description'];
                $recallReportDate = $data['results'][0]['report_date'];
                $recallReason = $data['results'][0]['reason_for_recall'];
                $recallNum = $data['results'][0]['recall_number'];
                $recallFirm= $data['results'][0]['recalling_firm'];
                $recallNotification = $data ['results'][0]['initial_firm_notification'];
                $terminationDate = $data ['results'][0]['termination_date'];
                $recallInitDate = $data ['results'][0]['recall_initiation_date'];

                $status = $data['results'][0]['status'];
                $productType = $data ['results'][0]['product_type'];
                $address1= $data ['results'][0]['address_1'];
                $address2= $data ['results'][0]['address_2'];
                $city= $data ['results'][0]['city'];
                $state= $data ['results'][0]['state'];
                $postalCode =$data['results'][0]['postal_code'];
                $country =$data['results'][0]['country'];
		
		$stmt = array();
                $stmt['productDec'] = $productDec;
                $stmt['recallReportDate'] = $recallReportDate;
                $stmt['recallReason'] = $recallReason;
                $stmt['recall_number'] = $recallNum;
                $stmt['recalling_firm'] = $recallFirm;
                $stmt['inital_firm_notification'] = $recallNotification;
                $stmt['termination_date'] = $terminationDate;
                $stmt['recall_initiation_date'] = $recallInitDate;

                $stmt['status'] = $status;
                $stmt['product_type'] = $productType;
                $stmt['address_1']= $address1;
                $stmt['address_2']= $address2;
                $stmt['city']= $city;
                $stmt['state']= $state;
                $stmt['postal_code']= $postalCode;
                $stmt['country']= $country;

		//echo $url;
		return $stmt;

	}
	catch (Exception $e)
	{
		$client = new rabbitMQClient("testRabbitMQ.ini", "testSever");
		$request = array();
		$request["type"] = "log";
		$request["message"] = $e->getMessage();
		$client->publish($request);
		echo ("\nException: ". $e->getMessage());
	}

}

function requestProcessor($request)
{
	echo "\nreceived request".PHP_EOL;
	if(!isset($request['type']))
	{
		return "ERROR: Unsupported Message Type";
	}
	switch ($request['type'])
	{
		case "apiPull":
		return foodInfo($request);
	}

	return array ("returnCode" => '0', 'message'=> "Server received request and processed");

}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");
$server->process_requests('requestProcessor');
exit();
?>

		
		
