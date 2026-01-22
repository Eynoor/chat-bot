<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Asisten Chatbot Akuntansi</title>
    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 25%, #f59e0b 75%, #fb923c 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 14px;
            padding: 0;
        }

        .chat-container {
            width: 100%;
            max-width: 450px;
            height: 600px;
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.25);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .chat-header {
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 40%, #f59e0b 80%, #fb923c 100%);
            color: white;
            padding: 16px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            min-height: 60px;
        }

        .chat-header h2 {
            font-size: 16px;
            font-weight: 600;
            letter-spacing: -0.02em;
            line-height: 1.4;
        }

        .clear-button {
            background: rgba(251, 191, 36, 0.25);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 8px 14px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 11px;
            font-weight: 500;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
            letter-spacing: 0.01em;
            white-space: nowrap;
            min-height: 36px;
        }

        .clear-button:hover {
            background: rgba(251, 191, 36, 0.4);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-1px);
        }

        .clear-button:active {
            transform: translateY(0);
        }

        .chat-messages {
            flex: 1;
            padding: 16px;
            overflow-y: auto;
            overflow-x: hidden;
            background: #f8fafc;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 #f1f5f9;
        }

        .message {
            margin-bottom: 12px;
            display: flex;
            opacity: 0;
            animation: messageSlideIn 0.3s ease forwards;
        }

        @keyframes messageSlideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message-content {
            display: flex;
            flex-direction: column;
            gap: 4px;
            max-width: 85%;
        }

        .message-content p {
            padding: 12px 16px;
            border-radius: 18px;
            word-wrap: break-word;
            word-break: break-word;
            overflow-wrap: break-word;
            white-space: pre-wrap;
            margin: 0;
            max-width: 100%;
            line-height: 1.6;
            font-size: 14px;
            font-weight: 400;
            letter-spacing: 0.01em;
            transition: all 0.2s ease;
        }

        .bot-message {
            justify-content: flex-start;
        }

        .bot-message .message-content p {
            background: linear-gradient(135deg, #dbeafe 0%, #fed7aa 100%);
            color: #1e40af;
            border-bottom-left-radius: 4px;
            border: 1px solid rgba(251, 191, 36, 0.2);
        }

        .bot-message .message-content p:hover {
            background: linear-gradient(135deg, #bfdbfe 0%, #fcd34d 100%);
        }

        .user-message {
            justify-content: flex-end;
        }

        .user-message .message-content {
            align-items: flex-end;
        }

        .user-message .message-content p {
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 50%, #f59e0b 100%);
            color: white;
            border-bottom-right-radius: 4px;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.3);
        }

        .user-message .message-content p:hover {
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
        }

        .timestamp {
            font-size: 11px;
            opacity: 0;
            margin-top: 4px;
            font-weight: 400;
            letter-spacing: 0.02em;
            animation: fadeIn 0.3s ease 0.15s forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 0.6;
            }
        }

        .bot-message .timestamp {
            color: #64748b;
        }

        .user-message .timestamp {
            color: #64748b;
            text-align: right;
        }

        /* Skeleton Loading */
        .skeleton-message {
            margin-bottom: 12px;
            display: flex;
            justify-content: flex-start;
            opacity: 0;
            animation: messageSlideIn 0.3s ease forwards;
        }

        .skeleton-content {
            display: flex;
            flex-direction: column;
            gap: 8px;
            max-width: 85%;
        }

        .skeleton-line {
            height: 16px;
            background: linear-gradient(90deg, #dbeafe 25%, #fcd34d 50%, #dbeafe 75%);
            background-size: 200% 100%;
            border-radius: 8px;
            animation: skeletonLoading 1.5s ease-in-out infinite;
        }

        .skeleton-line:first-child {
            width: 180px;
        }

        .skeleton-line:nth-child(2) {
            width: 140px;
        }

        .skeleton-line:last-child {
            width: 100px;
        }

        @keyframes skeletonLoading {
            0% {
                background-position: 200% 0;
            }
            100% {
                background-position: -200% 0;
            }
        }

        .skeleton-wrapper {
            background: linear-gradient(135deg, #dbeafe 0%, #fed7aa 100%);
            border: 1px solid rgba(251, 191, 36, 0.2);
            padding: 12px 16px;
            border-radius: 18px;
            border-bottom-left-radius: 4px;
        }

        .chat-input-area {
            padding: 12px 16px;
            background: white;
            border-top: 1px solid #e2e8f0;
            display: flex;
            gap: 8px;
            align-items: flex-end;
        }

        #messageInput {
            flex: 1;
            padding: 12px 16px;
            border: 2px solid transparent;
            background: linear-gradient(white, white) padding-box,
                        linear-gradient(135deg, #3b82f6, #f59e0b) border-box;
            border-radius: 25px;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
            resize: none;
            max-height: 100px;
            overflow-y: auto;
            overflow-x: hidden;
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            font-weight: 400;
            letter-spacing: 0.01em;
            min-height: 44px;
            
            /* Hide scrollbar completely */
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        #messageInput::placeholder {
            color: #94a3b8;
            font-weight: 400;
            transition: color 0.3s ease;
        }

        #messageInput:focus {
            background: linear-gradient(white, white) padding-box,
                        linear-gradient(135deg, #2563eb, #f59e0b) border-box;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
        }

        #messageInput:focus::placeholder {
            color: #cbd5e1;
        }

        #messageInput:disabled {
            background: #f1f5f9;
            border-color: #cbd5e1;
            color: #94a3b8;
            cursor: not-allowed;
            opacity: 0.6;
        }

        #messageInput:disabled::placeholder {
            color: #cbd5e1;
        }

        #messageInput::-webkit-scrollbar {
            display: none;
        }

        #sendButton {
            padding: 12px 20px;
            background: linear-gradient(135deg, #f59e0b 0%, #f97316 50%, #fb923c 100%);
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
            font-family: 'Inter', sans-serif;
            letter-spacing: 0.02em;
            min-height: 44px;
            min-width: 70px;
        }

        #sendButton:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(245, 158, 11, 0.4);
        }

        #sendButton:active:not(:disabled) {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
            transition: all 0.1s ease;
        }

        #sendButton:disabled {
            background: linear-gradient(135deg, #cbd5e1 0%, #e2e8f0 100%);
            color: #94a3b8;
            cursor: not-allowed;
            opacity: 0.6;
            box-shadow: none;
            transform: none;
        }

        .chat-messages::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .chat-messages::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
            margin: 4px 0;
        }

        .chat-messages::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
            transition: background 0.3s ease;
        }

        .chat-messages::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .chat-messages::-webkit-scrollbar-corner {
            background: transparent;
        }

        /* ===== MEDIA QUERIES ===== */
        
        @media screen and (max-width: 480px) {
            body {
                padding: 0;
            }

            .chat-container {
                max-width: 100%;
                height: 100vh;
                height: 100dvh;
                border-radius: 0;
                box-shadow: none;
            }

            .chat-header {
                padding: 14px 16px;
                min-height: 56px;
            }

            .chat-header h2 {
                font-size: 15px;
            }

            .clear-button {
                padding: 7px 12px;
                font-size: 10px;
            }

            .chat-messages {
                padding: 12px;
            }

            .message-content {
                max-width: 80%;
            }

            .message-content p {
                font-size: 14px;
                padding: 10px 14px;
            }

            .skeleton-line:first-child {
                width: 160px;
            }

            .skeleton-line:nth-child(2) {
                width: 120px;
            }

            .skeleton-line:last-child {
                width: 90px;
            }

            .chat-input-area {
                padding: 10px 12px;
            }

            #messageInput {
                font-size: 16px;
                padding: 10px 14px;
            }

            #sendButton {
                padding: 10px 18px;
                min-width: 65px;
                font-size: 13px;
            }
        }

        @media screen and (min-width: 481px) and (max-width: 768px) {
            body {
                padding: 20px;
            }

            .chat-container {
                max-width: 100%;
                height: calc(100vh - 40px);
                border-radius: 20px;
            }

            .message-content {
                max-width: 75%;
            }
        }

        @media screen and (min-width: 769px) and (max-width: 1024px) {
            body {
                padding: 30px;
            }

            .chat-container {
                height: 650px;
                border-radius: 24px;
            }
        }

        @media screen and (min-width: 1025px) {
            body {
                padding: 20px;
            }

            .chat-container {
                border-radius: 24px;
            }

            .message-content {
                max-width: 70%;
            }

            .chat-header h2 {
                font-size: 18px;
            }

            .clear-button {
                font-size: 12px;
                padding: 8px 16px;
            }
        }

        @media screen and (max-height: 500px) and (orientation: landscape) {
            .chat-container {
                height: 100vh;
            }

            .chat-header {
                padding: 10px 16px;
                min-height: 48px;
            }

            .chat-messages {
                padding: 10px 12px;
            }

            .chat-input-area {
                padding: 8px 12px;
            }
        }

        @media (hover: none) and (pointer: coarse) {
            .clear-button,
            #sendButton {
                min-height: 44px;
            }

            #messageInput {
                min-height: 44px;
            }

            * {
                touch-action: manipulation;
            }
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">
            <h2>Asisten Chatbot Akuntansi</h2>
            <button id="clearButton" class="clear-button">Clear Chat</button>
        </div>
        
        <div class="chat-messages" id="chatMessages">
            <div class="message bot-message">
                <div class="message-content">
                    <p>Halo! Ada yang bisa saya bantu?</p>
                    <span class="timestamp"></span>
                </div>
            </div>
        </div>
        
        <div class="chat-input-area">
            <textarea id="messageInput" placeholder="Ketik pesan..." rows="1"></textarea>
            <button id="sendButton">Kirim</button>
        </div>
    </div>
    
    <script>
        const messageInput = document.getElementById('messageInput');
        const sendButton = document.getElementById('sendButton');
        const chatMessages = document.getElementById('chatMessages');
        const clearButton = document.getElementById('clearButton');
        
        let isBotTyping = false;

        messageInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 100) + 'px';
        });

        function getCurrentTime() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            return `${hours}:${minutes}`;
        }

        function disableInput() {
            isBotTyping = true;
            messageInput.disabled = true;
            sendButton.disabled = true;
            messageInput.placeholder = "Tunggu balasan bot...";
        }

        function enableInput() {
            isBotTyping = false;
            messageInput.disabled = false;
            sendButton.disabled = false;
            messageInput.placeholder = "Ketik pesan...";
            messageInput.focus();
        }

        function addMessage(message, isUser) {
            const messageDiv = document.createElement('div');
            messageDiv.className = isUser ? 'message user-message' : 'message bot-message';
            
            const messageContent = document.createElement('div');
            messageContent.className = 'message-content';
            
            const messagePara = document.createElement('p');
            messagePara.textContent = message;
            
            const timestamp = document.createElement('span');
            timestamp.className = 'timestamp';
            timestamp.textContent = getCurrentTime();
            
            messageContent.appendChild(messagePara);
            messageContent.appendChild(timestamp);
            messageDiv.appendChild(messageContent);
            chatMessages.appendChild(messageDiv);
            
            setTimeout(() => {
                chatMessages.scrollTo({
                    top: chatMessages.scrollHeight,
                    behavior: 'smooth'
                });
            }, 50);
        }

        function showSkeletonLoading() {
            const skeletonDiv = document.createElement('div');
            skeletonDiv.className = 'skeleton-message';
            skeletonDiv.id = 'skeletonLoader';
            
            const skeletonWrapper = document.createElement('div');
            skeletonWrapper.className = 'skeleton-wrapper';
            
            const skeletonContent = document.createElement('div');
            skeletonContent.className = 'skeleton-content';
            
            for (let i = 0; i < 3; i++) {
                const line = document.createElement('div');
                line.className = 'skeleton-line';
                skeletonContent.appendChild(line);
            }
            
            skeletonWrapper.appendChild(skeletonContent);
            skeletonDiv.appendChild(skeletonWrapper);
            chatMessages.appendChild(skeletonDiv);
            
            setTimeout(() => {
                chatMessages.scrollTo({
                    top: chatMessages.scrollHeight,
                    behavior: 'smooth'
                });
            }, 50);
        }

        function removeSkeletonLoading() {
            const skeletonLoader = document.getElementById('skeletonLoader');
            if (skeletonLoader) {
                skeletonLoader.style.animation = 'messageSlideIn 0.2s ease reverse';
                setTimeout(() => {
                    skeletonLoader.remove();
                }, 200);
            }
        }

        function sendMessage() {
            if (isBotTyping) return;
            
            const message = messageInput.value.trim();
            
            if (message === '') return;
            
            addMessage(message, true);
            
            messageInput.value = '';
            messageInput.style.height = 'auto';
            
            disableInput();
            
            showSkeletonLoading();
            
            setTimeout(() => {
                removeSkeletonLoading();
                const botResponse = 'Terima kasih atas pesannya! Backend sedang dalam pengembangan.';
                addMessage(botResponse, false);
                
                enableInput();
            }, 2000);
        }

        function clearChat() {
            chatMessages.innerHTML = `
                <div class="message bot-message">
                    <div class="message-content">
                        <p>Halo! Ada yang bisa saya bantu?</p>
                        <span class="timestamp">${getCurrentTime()}</span>
                    </div>
                </div>
            `;
        }

        sendButton.addEventListener('click', sendMessage);

        messageInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });

        clearButton.addEventListener('click', () => {
            if (confirm('Yakin mau hapus semua percakapan?')) {
                clearChat();
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            const firstTimestamp = document.querySelector('.timestamp');
            if (firstTimestamp && firstTimestamp.textContent === '') {
                firstTimestamp.textContent = getCurrentTime();
            }
        });
    </script>
</body>
</html>
