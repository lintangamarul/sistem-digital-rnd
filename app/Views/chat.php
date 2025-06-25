<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .chat-container {
            height: 500px;
            overflow-y: auto;
            border: 1px solid #ddd;
            padding: 15px;
            background-color: #f8f9fa;
        }
        .message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 10px;
        }
        .user-message {
            background-color: #007bff;
            color: white;
            margin-left: 20%;
        }
        .ai-message {
            background-color: white;
            border: 1px solid #ddd;
            margin-right: 20%;
        }
        .loading {
            text-align: center;
            color: #666;
        }
        .chat-container ul, .chat-container ol {
    padding-left: 20px;
    margin-bottom: 10px;
}

.chat-container li {
    margin-bottom: 5px;
}

    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="text-center mb-4"> AI Chat</h2>
                
                <div class="chat-container" id="chatContainer">
                    <div class="message ai-message">
                        <strong>AI:</strong> Halo! Saya adalah AI Assistant. Ada yang bisa saya bantu?
                    </div>
                </div>
                
                <div class="mt-3">
                    <div class="input-group">
                        <input type="text" class="form-control" id="messageInput" placeholder="Ketik pesan Anda...">
                        <button class="btn btn-primary" type="button" id="sendButton">Kirim</button>
                    </div>
                </div>
                
                <div class="mt-3">
                    <h5>Contoh Prompt:</h5>
                    <div class="d-flex flex-wrap gap-2">
                     <button class="btn btn-sm btn-outline-primary example-btn" data-prompt="Bagaimana cara mengisi Daily Report?">Cara isi Daily Report</button>
                     <button class="btn btn-sm btn-outline-primary example-btn" data-prompt="Apa fungsi menu Kalender?">Fungsi Kalender</button>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const chatContainer = document.getElementById('chatContainer');
        const messageInput = document.getElementById('messageInput');
        const sendButton = document.getElementById('sendButton');
        const exampleButtons = document.querySelectorAll('.example-btn');
        
        let conversationHistory = [];
        
        function addMessage(content, isUser = false) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${isUser ? 'user-message' : 'ai-message'}`;
            messageDiv.innerHTML = `<strong>${isUser ? 'You' : 'AI'}:</strong> ${content}`;
            chatContainer.appendChild(messageDiv);
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }
        
        function showLoading() {
            const loadingDiv = document.createElement('div');
            loadingDiv.className = 'loading';
            loadingDiv.id = 'loading';
            loadingDiv.innerHTML = '<em>AI sedang mengetik...</em>';
            chatContainer.appendChild(loadingDiv);
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }
        
        function hideLoading() {
            const loadingDiv = document.getElementById('loading');
            if (loadingDiv) {
                loadingDiv.remove();
            }
        }
        
        async function sendMessage(prompt) {
            if (!prompt.trim()) return;
            
            addMessage(prompt, true);
            conversationHistory.push({role: 'user', content: prompt});
            showLoading();
            
            try {
                const response = await fetch('/ppsAssistant/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        messages: conversationHistory
                    })
                });
                
                const data = await response.json();
                hideLoading();
                
                if (data.success) {
                    addMessage(formatAIResponse(data.response));
                    conversationHistory.push({role: 'assistant', content: data.response});
                } else {
                    addMessage('Maaf, terjadi kesalahan: ' + (data.message || 'Unknown error'));
                }
            } catch (error) {
                hideLoading();
                addMessage('Terjadi kesalahan koneksi: ' + error.message);
            }
        }
        
        sendButton.addEventListener('click', () => {
            const message = messageInput.value;
            sendMessage(message);
            messageInput.value = '';
        });
        
        messageInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                const message = messageInput.value;
                sendMessage(message);
                messageInput.value = '';
            }
        });
        
        exampleButtons.forEach(button => {
            button.addEventListener('click', () => {
                const prompt = button.getAttribute('data-prompt');
                messageInput.value = prompt;
                sendMessage(prompt);
                messageInput.value = '';
            });
        });
        function formatAIResponse(text) {
            text = text.replace(/\n\s*\n/g, '</p><p>');
            text = text.replace(/\n/g, '<br>');
            text = text.replace(/(?:^|\n)(\d+)\.\s+(.*?)(?=(?:\n\d+\.|\n*$))/gs, function(_, num, item) {
                const items = item.split('\n').map(i => `<li>${i.trim()}</li>`).join('');
                return `<ol start="${num}">${items}</ol>`;
            });
            text = text.replace(/(?:^|\n)[*-]\s+(.*?)(?=(?:\n[*-]|\n*$))/gs, function(_, item) {
                const items = item.split('\n').map(i => `<li>${i.replace(/^[-*]\s*/, '').trim()}</li>`).join('');
                return `<ul>${items}</ul>`;
            });
            text = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
            return `<p>${text}</p>`;
        }

    </script>
</body>
</html>