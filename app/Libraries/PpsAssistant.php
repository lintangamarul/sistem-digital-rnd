<?php

namespace App\Libraries;

class PpsAssistant
{
    private $apiKey;
    private $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/';
    private $systemPrompt;
    
    public function __construct()
    {
        $this->apiKey = 'AIzaSyB0jKZcHiZxJR5G1iGUZDQjdgcCN5PzfYE';
        $this->setSystemPrompt();
    }
    
    private function setSystemPrompt()
    {
        $this->systemPrompt = "
                Anda adalah asisten AI khusus untuk membantu Press Planning Sheet dan Dies Concept Planning System. 
                Anda HANYA boleh menjawab pertanyaan yang berkaitan dengan MATERI dan FITUR Aplikasi:

                MATERI YANG DIIZINKAN:
                1. Penjelasan Menu dan Fitur kerja
                2. Tutorial dan penggunaan  seputar aplikasi
            
                Fitur :
                1. Part Information : list project yang diambil dari Master Project,
                2. Material : List material yang diambil dari Master PPS DCP -> Material
                3. Total Dies : maks 8 dan akan berpengaruh ke kolom TABEL
                4. Estimasi Size Part akan berpengaruh ke kolom keliling & Main press  yang terdiri dari :
                    a. p dan l akan berpengaruh ke ukuran dies, lalu apabila prosesnya pembentuk maka akan berpengaruh ke keliling
                    b. Panjang Proses berpengaruh ke Main Press & keliling ketika prosesnya pemotong
                    c. Diameter & Jumlah Hole akan berpengaruh ke keliling & Main Press apabila dia Pie
                    d. Centang pada estimasi ukuran part akan digunakan untuk apa saja yg digunakan sebagai aspek perhitungan keliling. INI yg utama dibanding poin a-c karena apabila dicentang maka itu yg menentukan perhitungan keliling
                5. Die Size Standar dari Master PPS DCP -> PPS (bentuknya  PDF )
                6. Die Class dikategorikan bedasarkan Die Weight(klik petunjuk untuk melihat detail)
                6. Mesin hasil generate data dapat diubah dan untuk melihat list yang memenuhi syarat klik Machine Match List
                7. Detail Material Construction dapat dilihat di Petunjuk
                8. Gambar Die Construction akan menyesuaikan dengan Proses yang dipilih, namun juga bisa uplaod apabila tidak sesuai
                9. Gambar Proses Layout akan otomatis dengan banyaknya proses namun juga bisa uplaod apabila tidak sesuai
                10. DCP bisa dibuat ketika PPS selesai
                11. Data yang tersedia di DCP akan menyesuaikan dari Die Class PPS dan datanya dari Master PPS DCP
       

                ATURAN KETAT:
                - Jika ditanya hal di luar konteks di atas, jawab: 'Maaf, saya hanya dapat membantu dengan pertanyaan seputar Daily Report System terkait. Silakan tanyakan hal yang berkaitan dengan aplikasi ini.'
                - Selalu fokus pada solusi praktis untuk aplikasi dcp DCP
                - Berikan jawaban dalam bahasa Indonesia yang mudah dipahami

                Mulai percakapan dengan ramah dan profesional. 
            ";
    }
    
    public function generateContent($prompt, $model = 'gemini-2.0-flash')
    {
        $url = $this->baseUrl . $model . ':generateContent?key=' . $this->apiKey;
        
        // ✅ Gabungkan system prompt dengan user prompt
        $fullPrompt = $this->systemPrompt . "\n\nPERTANYAAN USER: " . $prompt;
        
        $data = [
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' => $fullPrompt
                        ]
                    ]
                ]
            ]
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode === 200) {
            return json_decode($response, true);
        } else {
            return [
                'error' => true,
                'message' => 'API request failed',
                'http_code' => $httpCode,
                'response' => $response
            ];
        }
    }
    
    public function chatCompletion($messages, $model = 'gemini-2.0-flash')
    {
        $url = $this->baseUrl . $model . ':generateContent?key=' . $this->apiKey;
        
        $contents = [];
        
        $contents[] = [
            'parts' => [
                [
                    'text' => $this->systemPrompt
                ]
            ],
            'role' => 'user'
        ];
        
        $contents[] = [
            'parts' => [
                [
                    'text' => 'Saya mengerti. Saya akan membantu Anda dengan pertanyaan seputar Daily Report Management System dan web development terkait.'
                ]
            ],
            'role' => 'model'
        ];
        
        // Proses messages dari user
        foreach ($messages as $message) {
            if (is_object($message)) {
                $messageArray = (array) $message;
            } else {
                $messageArray = $message;
            }
            
            $contents[] = [
                'parts' => [
                    [
                        'text' => $messageArray['content'] ?? ''
                    ]
                ],
                'role' => ($messageArray['role'] ?? 'user') === 'user' ? 'user' : 'model'
            ];
        }
        
        $data = [
            'contents' => $contents
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode === 200) {
            return json_decode($response, true);
        } else {
            return [
                'error' => true,
                'message' => 'API request failed',
                'http_code' => $httpCode,
                'response' => $response
            ];
        }
    }
    
    public function setApplicationContext($appName, $allowedTopics, $restrictionMessage = null)
    {
        $topicsList = implode("\n", array_map(fn($topic) => "- $topic", $allowedTopics));
        
        $defaultRestrictionMessage = "Maaf, saya hanya dapat membantu dengan pertanyaan seputar $appName dan topik terkait yang telah ditentukan. Silakan tanyakan hal yang relevan dengan aplikasi ini.";
        
        $this->systemPrompt = "
            Anda adalah asisten AI khusus untuk aplikasi $appName. 
            Anda HANYA boleh menjawab pertanyaan yang berkaitan dengan:

            KONTEKS YANG DIIZINKAN:
            $topicsList

            ATURAN KETAT:
            - Jika ditanya hal di luar konteks di atas, jawab: '" . ($restrictionMessage ?? $defaultRestrictionMessage) . "'
            - Selalu fokus pada solusi praktis untuk aplikasi ini
            - Berikan jawaban dalam bahasa Indonesia yang mudah dipahami
            - Jika diminta membuat kode, pastikan relevan dengan sistem aplikasi

            Mulai percakapan dengan ramah dan profesional.
                    ";
                }
}
