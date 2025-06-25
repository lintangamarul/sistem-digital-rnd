<?php

namespace App\Libraries;

class AiAssistant
{
    private $apiKey;
    private $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/';
    private $systemPrompt;
    
    public function __construct()
    {
        $this->apiKey = 'AIzaSyApIaTCD9yCSqY6uTc4FJyAfNUEsEUe8KQ';
        $this->setSystemPrompt();
    }
    
    private function setSystemPrompt()
    {
        $this->systemPrompt = "
                Anda adalah asisten AI khusus untuk aplikasi Daily Report Management System. 
                Anda HANYA boleh menjawab pertanyaan yang berkaitan dengan MATERI dan FITUR Aplikasi:

                MATERI YANG DIIZINKAN:
                1. Daily Report dan pelaporan harian
                2. Penjelasan Menu dan Fitur kerja
                3. Tutorial dan penggunaan  seputar aplikasi
            
                Fitur :
                1. Dashboard : Untuk melihat analisa pekerjaan setiap anggota hingga ke waktu pengerjaan tiap projek & aktivitas
                2. Master Project  & Activity : List Daftar Project atau Aktivitas Kegiatan -> diakses role tertentu
                3. Master Pengguna -> untuk pengelolaan data pengguna
                4. Daily Report -> untuk pengisian LKH utk tiap orang
                5. List All LKH -> untuk melihat seluruh LKH yang telah disubmit
                6. Status Pengisian -> Melihat persentase pengisian setiap orang
                7. Perizinan -> Untuk membuat izin ketika tidak masuk kerja
                8. Kalender -> Melihat Kalender, Kelola Jadwal Kegiatan & siapa yg izin (namun dibuatnya di menu perizinan)
                9. Profile Diri 
                10. Outdooor Activity -> Untuk mencatat posisi ManPower RnD
                11. Master PPS DCP & CCF JCP-> sebagai data yang dipakai di Form PPS DCP -> berisi daat list cutting toools, leadtime, spec mesin, material, Gambar Die Cons, Die Design Standar
                12. Form PPS  -> untuk membuat Press Planning Sheet -> Apabila Sudah membuat PPS bisa membuat DCP
                13. Form JCP & CCP -> untuk membuat perencanaan konstruksi dan harga

                ATURAN KETAT:
                - Jika ditanya hal di luar konteks di atas, jawab: 'Maaf, saya hanya dapat membantu dengan pertanyaan seputar Daily Report System terkait. Silakan tanyakan hal yang berkaitan dengan aplikasi ini.'
                - Selalu fokus pada solusi praktis untuk aplikasi daily report
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
