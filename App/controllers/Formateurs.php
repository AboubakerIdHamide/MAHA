<?php

class Formateurs extends Controller
{
	public function __construct()
	{
		if (!isset($_SESSION['id_formateur'])) {
			redirect('users/login');
			return;
		}
		$this->stockedModel = $this->model("Stocked");
		$this->fomateurModel = $this->model("Formateur");
		$this->requestPaymentModel = $this->model("requestPayment");
		$this->notificationModel = $this->model("Notification");
	}

	public function index()
	{
		$this->dashboard();
	}

	public function dashboard()
	{
		if (isset($_SESSION['id_formation'])) unset($_SESSION['id_formation']);
		$categories = $this->stockedModel->getAllCategories();
		$langues = $this->stockedModel->getAllLangues();
		$levels = $this->stockedModel->getAllLevels();
		$balance = $this->fomateurModel->getFormateurByEmail($_SESSION['user']['email_formateur'])['balance'];
		$data = [
			'balance' => $balance,
			'categories' => $categories,
			'langues' => $langues,
			'levels' => $levels,
		];

		$this->view('formateur/index', $data);
	}

	public function requestPayment()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$requestInfo = json_decode($_POST['data']);
			if ($this->checkBalance($requestInfo)) {
				// placer la demande
				$this->requestPaymentModel->insertRequestPayment($_SESSION['id_formateur'], $requestInfo->montant);
				echo "votre demande a été placer avec success";
			}
		} else {
			$this->view('formateur/requestPayment');
		}
	}

	private function checkBalance($requestInfo)
	{
		if ($requestInfo->paypalEmail == $_SESSION['user']['paypalMail']) {
			if ($requestInfo->montant >= 10) {
				$formateur_balance = $this->fomateurModel->getFormateurByEmail($_SESSION['user']['email_formateur'])['balance'];
				if ($requestInfo->montant <= $formateur_balance)
					return true;
				return false;
			}
		}
	}

	public function getPaymentsHistory()
	{
		$requestsPayments = $this->requestPaymentModel->getRequestsOfFormateur($_SESSION['id_formateur']);
		echo json_encode($requestsPayments);
	}

	public function deleteRequest($id_req)
	{
		$this->requestPaymentModel->deleteRequest($id_req);
		echo 'request deleted with success';
	}

	public function getAllNotifications()
	{
		$notifications = $this->notificationModel->getNotificationsOfFormateur($_SESSION['id_formateur']);
		echo json_encode($notifications);
	}

	public function notifications()
	{
		$nbrNotifications = $this->notificationModel->getNewNotificationsOfFormateur($_SESSION['id_formateur']);
		$this->view('pages/notifications', $nbrNotifications);
	}

	public function setStateToSeen($id_notification)
	{
		$this->notificationModel->setStateToSeen($id_notification);
		echo 'DONE!!';
	}

	public function deleteSeenNotifications()
	{
		$this->notificationModel->deleteSeenNotifications();
		echo 'DONE **';
	}
}
