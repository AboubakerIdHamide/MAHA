<?php

use App\Models\Formation;
use App\Models\Inscription;
use App\Models\Formateur;

class PaypalController
{
	private $access_token;
	private $formationModel;
	private $inscriptionModel;

	public function __construct()
	{
		if (!auth() || !session('user')->get()->type === 'etudiant') {
			return redirect('user/login');
		}

		$this->formationModel = new Formation;
		$this->inscriptionModel = new Inscription;
		$this->access_token = $this->_getAccessToken();
	}

	private function _getAccessToken()
	{

		$client = new \GuzzleHttp\Client();
		$url = 'https://api-m.sandbox.paypal.com/v1/oauth2/token';
		$response = $client->request(
			'POST', // instead of POST, you can use GET, PUT, DELETE, etc
			$url,
			[
				'auth' => [
					$_ENV['USERNAME_PAYPAL'], // username
					$_ENV['PASSWORD_PAYPAL'] // password
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

	public function payment($id_formation = null)
	{
		$formation = $this->formationModel->select($id_formation, [
			'id_formation', 
			'prix',
			'nom',
			'id_formateur'
		]);

		if (!$formation) {
			// cette formation n'existe pas
			return view('errors/page_404');
		}

		$inscription = $this->inscriptionModel->checkIfAlready(session('user')->get()->id_etudiant, $id_formation);
		if ($inscription) {
			if ($inscription->payment_state === "approved") {
				// vous etes deja inscrit dans cette formation
				return redirect('etudiant/formation/'.$id_formation);	
			}

			// redirect to paypal page to make payment, because the order already created
			http_response_code(303);
			header('location: ' . $inscription->approval_url);
			exit;
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
					"description" => "{$formation->nom}",
					"payment_options" => [
						"allowed_payment_method" => "INSTANT_FUNDING_SOURCE"
					],
					"item_list" => [
						"items" =>
						[
							[
								"name" => "{$formation->nom}",
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
				"return_url" => URLROOT . '/paypal/success/' . $id_formation,
				"cancel_url" => URLROOT . '/paypal/cancel/' . $id_formation
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

		$inscription = [
			"id_formation" => $formation->id_formation,
			"id_etudiant" => session('user')->get()->id_etudiant,
			"id_formateur" => $formation->id_formateur,
			"prix" => $formation->prix,
			"transaction_info" => json_encode($paypalData),
			"payment_id" => $paymentID,
			"payment_state" => $paymentState,
			"date_inscription" => $createdDate,
			"approval_url" => $approvalURL
		];

		$this->inscriptionModel->create($inscription);

		// redirect to paypal page to make payment
		http_response_code(303);
		header('location: ' . $approvalURL);
		exit;
	}

	public function success($id_formation = null)
	{
		if (!auth() || !session('user')->get()->type === 'etudiant') {
			return view('errors/page_404');
		}

		$formation = $this->formationModel->select($id_formation, ['slug']);
		if (!isset($_GET['paymentId'], $_GET['token'], $_GET['PayerID'])) {
			return view('errors/page_404');
		}

		$inscription = $this->inscriptionModel->wherePaymentID($_GET['paymentId'] ?? "", session('user')->get()->id_etudiant);

		if (!$inscription) {
			return view('errors/page_404');
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
			return redirect('courses/' . $formation->slug);
		}

		$paymentState = json_decode($response->getBody())->state;
		$this->inscriptionModel->updatePaymentState($_GET['paymentId'], $paymentState);
		$formateurModel = new Formateur;
		$formateurProfit = (100 - $_ENV['PLATFORM_PROFIL']) / 100;
		$formateurModel->updateBalance($inscription->id_formateur, $inscription->prix * $formateurProfit);
		return view('payments/paymentSuccess', ["id_formation" => $id_formation]);
	}

	public function cancel($id_formation = null)
	{
		if (!auth() || !session('user')->get()->type === 'etudiant') {
			return view('errors/page_404');
		}

		$formation = $this->formationModel->select($id_formation, ['slug']);
		if (isset($_GET['token'])) {
			return view('payments/paymentCancel', ['slug' => $formation->slug]);
		} 
		return redirect('courses/' . $formation->slug);
	}
}
