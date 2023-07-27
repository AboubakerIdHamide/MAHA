<?php

// for Guzzel Library
require_once './../vendor/autoload.php';

class PaymentPaypal extends Controller
{
	private $access_token;
	private $username;
	private $password;
	private $adminModel;
	private $formationModel;
	private $inscriptionModel;

	public function __construct()
	{
		if (!isset($_SESSION['id_etudiant'])) {
			redirect('users/login');
			exit;
		}

		$this->formationModel = $this->model("Formation");
		$this->inscriptionModel = $this->model("Inscription");
		$this->adminModel = $this->model("Administrateur");
		$settings = $this->model("Administrateur")->getProfitAndPaypalToken();
		$this->username = $settings->username_paypal;
		$this->password = $settings->password_paypal;
		$this->access_token = $this->getAccessToken();
	}


	public function getAccessToken()
	{

		$client = new \GuzzleHttp\Client();
		$url = 'https://api-m.sandbox.paypal.com/v1/oauth2/token';
		$response = $client->request(
			'POST', // instead of POST, you can use GET, PUT, DELETE, etc
			$url,
			[
				'auth' => [
					$this->username, // username
					$this->password // password
				],
				'headers' => [
					'Content-Type' => 'application/x-www-form-urlencoded'
				],

				'form_params' => [
					'grant_type' => 'client_credentials'
				]
			],

		);

		$paypalData = json_decode($response->getBody());
		return $paypalData->access_token;
	}


	public function makePayment($idFormation = null)
	{
		if ($idFormation === null || !is_numeric($idFormation)) {
			redirect('pageFormations/coursDetails/' . $idFormation);
			exit;
		}



		$formation = $this->formationModel->getFormationById($idFormation);
		if (empty($formation)) {
			// cette formation n'existe pas redirect to URLROOT
			redirect();
			exit;
		}



		$inscription = $this->inscriptionModel->checkIfAlready($_SESSION['id_etudiant'], $idFormation);
		if (!empty($inscription)) {
			if ($inscription->payment_state == "approved") {
				// vous etes deja inscrit dans cette formation
				redirect('etudiants/dashboard');
				exit;
			} else {
				// redirect to paypal page to make payment, because the order already created
				header('location: ' . $inscription->approval_url);
				exit;
			}
		}


		$client = new \GuzzleHttp\Client([
			'headers' => [
				'Content-Type' => 'application/json',
				'Authorization' => 'Bearer ' . $this->access_token
			]
		]);




		$url = 'https://api-m.sandbox.paypal.com/v1/payments/payment';
		$data = [
			"intent" => "sale",
			"payer" => [
				"payment_method" => "paypal"
			],
			"transactions" => [
				[
					"amount" => [
						"total" => "{$formation->prix}",
						"currency" => "USD",
						"details" => [
							"subtotal" => "{$formation->prix}",
							"tax" => "0.00",
							"shipping" => "0.00",
							"handling_fee" => "0.00",
							"shipping_discount" => "0.00",
							"insurance" => "0.00"
						]
					],
					"description" => "{$formation->nomFormation}",
					"payment_options" => [
						"allowed_payment_method" => "INSTANT_FUNDING_SOURCE"
					],
					"item_list" => [
						"items" =>
						[
							[
								"name" => "{$formation->nomFormation}",
								"description" => "Online Course",
								"quantity" => "1",
								"price" => "{$formation->prix}",
								"tax" => "0.00",
								"sku" => "1",
								"currency" => "USD"
							]
						]
					]
				]
			],
			"note_to_payer" => "Contact us for any questions on your order.",
			"redirect_urls" => [
				"return_url" => URLROOT . '/PaymentPaypal/success/' . $idFormation,
				"cancel_url" => URLROOT . '/PaymentPaypal/cancel/' . $idFormation
			]
		];



		$response = $client->post(
			$url,
			[
				'body' => json_encode($data)
			]
		);



		$paypalData = json_decode($response->getBody());
		$paymentID = $paypalData->id;
		$paymentState = $paypalData->state;
		$createdDate = date_format(date_create($paypalData->create_time), "Y/m/d H:i:s");
		$approvalURL = $paypalData->links[1]->href;

		$inscriptionData = [
			"id_formation" => $formation->id_formation,
			"id_etudiant" => $_SESSION['id_etudiant'],
			"id_formateur" => $formation->id_formateur,
			"prix" => $formation->prix,
			"transaction_info" => json_encode($paypalData),
			"payment_id" => $paymentID,
			"payment_state" => $paymentState,
			"date_inscription" => $createdDate,
			"approval_url" => $approvalURL
		];

		$this->inscriptionModel->insertInscription($inscriptionData);


		// redirect to paypal page to make payment
		header('location: ' . $approvalURL);
	}

	public function success($idFormation)
	{
		if (!isset($_GET['paymentId'], $_GET['token'], $_GET['PayerID'])) {
			redirect('pageFormations/coursDetails/' . $idFormation);
			exit;
		}

		$inscription = $this->inscriptionModel->getInscriptionByPaymentID($_GET['paymentId']);


		if (empty($inscription)) {
			// payment ID n'existe pas
			redirect('pageFormations/coursDetails/' . $idFormation);
			exit;
		}

		$url = "https://api.sandbox.paypal.com/v1/payments/payment/{$inscription->payment_id}/execute";

		$client = new \GuzzleHttp\Client([
			'headers' => [
				'Content-Type' => 'application/json',
				'Authorization' => 'Bearer ' . $this->access_token
			]
		]);

		$response = $client->post(
			$url,
			[
				'body' => json_encode(["payer_id" => $_GET['PayerID']])
			]
		);

		if ($response->getStatusCode() != 200) {
			redirect('pageFormations/coursDetails/' . $idFormation);
			exit;
		}

		$paymentState = json_decode($response->getBody())->state;
		$this->inscriptionModel->updateInscriptionByPaymentID($_GET['paymentId'], $paymentState);
		$formateurModel = $this->model('Formateur');
		$formateurProfit = (100 - $this->adminModel->getProfitAndPaypalToken()->platform_pourcentage) / 100;
		$formateurModel->updateFormateurBalance($inscription->id_formateur, $inscription->prix * $formateurProfit);
		return return view('payment/paymentSuccess');
	}

	public function cancel($idFormation)
	{
		if (isset($_GET['token'])) {
			return return view('payment/paymentCancel', ['idFormation' => $idFormation]);
		} else {
			redirect('pageFormations/coursDetails/' . $idFormation);
			exit;
		}
	}
}
