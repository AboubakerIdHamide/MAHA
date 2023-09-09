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
        $validator = new Validator([
            'from' => session('user')->get()->id_formateur ?? session('user')->get()->id_etudiant,
            'id_formateur' => strip_tags(trim($request->post('to'))),
            'message' => htmlspecialchars(trim($request->post('message'))),
            'nom_video' => strip_tags(trim($request->post('nom_video'))),
        ]);

        $validator->validate([
            'id_formateur' => 'required|min:4|exists:formateurs',
            'message' => 'required|max:255',
            'nom_video' => 'required|min:3|max:80'
        ]);

        $message = $validator->validated();
        $message["message"] =  $message["nom_video"]."@".$message["message"];
        $message["to"] = $message["id_formateur"];
        unset($message["id_formateur"]);
        unset($message["nom_video"]);
        unset($message["type"]);
        
        if(!$this->messageModel->create($message)){
            return Response::json(null, 500, "Something went wrong.");
        }
        return Response::json(null, 201, 'Sent successfuly.');
    }
}