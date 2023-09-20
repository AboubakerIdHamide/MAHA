<?php

use App\Controllers\Api\ApiController;

use App\Models\Message;

use App\Libraries\Response;
use App\Libraries\Validator;

class MessageController extends ApiController
{
    private $messageModel;

    public function __construct()
    {
        if(!auth()){
            return Response::json(null, 401);
        }

        $this->messageModel = new Message;
        parent::__construct();
    }

    public function store($request)
    {
        $senders = ['etudiant', 'formateur'];
        $sender = $request->post('sender');
        if(!in_array($sender, $senders)) {
            return Response::json(null, 400, 'Bad Request');
        }

        if($sender === 'etudiant'){
            return $this->_storeEtudiantMsg($request);
        }
        return $this->_storeFormateurMsg($request);
    }

    private function _storeEtudiantMsg($request)
    {
        $validator = new Validator([
            'from' => session('user')->get()->id_etudiant,
            'id_formateur' => strip_tags(trim($request->post('to'))),
            'message' => htmlspecialchars(trim($request->post('message'))),
        ]);

        $validator->validate([
            'id_formateur' => 'required|min:4|exists:formateurs',
            'message' => 'required|max:255',
        ]);

        $relationship = [
			"from" => "inscriptions",
			"join" => "formateurs",
			"using" => "id_formateur",
			"where" => [
				"id_etudiant" => session('user')->get()->id_etudiant,
				"id_formateur" => $request->post('to')
			]
		];
        
        // PREVENT SENDING MESSAGE TO NOT AUTORIZED FORMATEUR
        $validator->checkPermissions($relationship);

        $message = $validator->validated();
        $nomVideo = strip_tags(trim($request->post('nom_video')));
        if(strlen($nomVideo) > 1 || strlen($nomVideo) > 80){
            $message['nom_video'] = $nomVideo."@";
        }else{
            $message['nom_video'] = "";
        }
        $message["message"] =  $message["nom_video"].$message["message"];
        $message["to"] = $message["id_formateur"];
        unset($message["id_formateur"]);
        unset($message["nom_video"]);
        unset($message["type"]);
        
        if($conversation = $this->messageModel->create($message)){
            return Response::json($conversation, 201, 'Sent successfuly.');
        }
        return Response::json(null, 500, "Something went wrong.");
    }

    private function _storeFormateurMsg($request)
    {
        $validator = new Validator([
            'from' => session('user')->get()->id_formateur,
            'id_etudiant' => strip_tags(trim($request->post('to'))),
            'message' => htmlspecialchars(trim($request->post('message'))),
        ]);

        $validator->validate([
            'id_etudiant' => 'required|min:4|exists:etudiants',
            'message' => 'required|max:255',
        ]);

        $relationship = [
			"from" => "inscriptions",
			"join" => "etudiants",
			"using" => "id_etudiant",
			"where" => [
				"id_formateur" => session('user')->get()->id_formateur,
				"id_etudiant" => $request->post('to')
			]
		];
        
        // PREVENT SENDING MESSAGE TO NOT AUTORIZED FORMATEUR
        $validator->checkPermissions($relationship);

        $message = $validator->validated();
        $nomVideo = strip_tags(trim($request->post('nom_video')));
        if(strlen($nomVideo) > 1 || strlen($nomVideo) > 80){
            $message['nom_video'] = $nomVideo."@";
        }else{
            $message['nom_video'] = "";
        }
        $message["message"] =  $message["nom_video"].$message["message"];
        $message["to"] = $message["id_etudiant"];
        unset($message["id_etudiant"]);
        unset($message["nom_video"]);
        unset($message["type"]);
        
        if($conversation = $this->messageModel->create($message)){
            return Response::json($conversation, 201, 'Sent successfuly.');
        }
        return Response::json(null, 500, "Something went wrong.");
    }
}