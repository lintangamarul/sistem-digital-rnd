<?php

namespace App\Controllers;

use App\Libraries\PpsAssistant;

class PpsAssistantController extends BaseController
{
    private $ai;
    
    public function __construct()
    {
        $this->ai = new PpsAssistant();
    }
    
    public function index()
    {
        return view('chat');
    }
    
    public function generate()
    {
        $request = $this->request->getJSON();
        
        if (!$request || !isset($request->prompt)) {
            return $this->response->setJSON([
                'error' => true,
                'message' => 'Prompt is required'
            ]);
        }
        
        $response = $this->ai->generateContent($request->prompt);
        
        if (isset($response['error'])) {
            return $this->response->setJSON($response);
        }
        
        $generatedText = $response['candidates'][0]['content']['parts'][0]['text'] ?? 'No response generated';
        
        return $this->response->setJSON([
            'success' => true,
            'response' => $generatedText
        ]);
    }
    
    public function chat()
    {
        $request = $this->request->getJSON();
        
        if (!$request || !isset($request->messages)) {
            return $this->response->setJSON([
                'error' => true,
                'message' => 'Messages are required'
            ]);
        }
        
        $response = $this->ai->chatCompletion($request->messages);
        
        if (isset($response['error'])) {
            return $this->response->setJSON($response);
        }
        
        $generatedText = $response['candidates'][0]['content']['parts'][0]['text'] ?? 'No response generated';
        
        return $this->response->setJSON([
            'success' => true,
            'response' => $generatedText
        ]);
    }
}