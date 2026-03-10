<?php $this->load->view('layout/header', ['title' => 'Chat Admin']); ?>

<div class="max-w-7xl mx-auto p-4 flex flex-col h-screen">
    <!-- Header with Back Button -->
    <div class="bg-white p-4 shadow-sm rounded-lg mb-4 flex items-center justify-between">
        <div class="flex items-center">
            <a href="javascript:history.back()" class="mr-4 text-gray-400 hover:text-gray-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-xl font-bold text-gray-800">
                <?= isset($partner_name) ? $partner_name : 'Chat Admin' ?>
            </h1>
        </div>
        <div class="flex items-center text-sm text-green-500">
             <span class="block h-2 w-2 rounded-full bg-green-500 mr-2"></span> Online
        </div>
    </div>

    <!-- Chat Box -->
    <div id="chat-box" class="flex-1 bg-white rounded-lg shadow-sm p-4 overflow-y-auto space-y-4 mb-4">
        <!-- Messages will be loaded here via AJAX -->
        <div class="text-center text-gray-400 text-sm mt-10">Memuat percakapan...</div>
    </div>

    <!-- Input Area -->
    <div class="bg-white p-4 rounded-lg shadow-sm flex items-center space-x-2">
        <input type="text" id="message-input" class="flex-1 border border-gray-300 rounded-full px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Tulis pesan...">
        <button id="send-btn" class="bg-indigo-600 text-white p-2 rounded-full hover:bg-indigo-700 transition">
             <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
            </svg>
        </button>
    </div>
</div>

<script>
    const baseUrl = "<?= base_url() ?>";
    const chatBox = document.getElementById('chat-box');
    const messageInput = document.getElementById('message-input');
    const sendBtn = document.getElementById('send-btn');
    
    // Dynamic logic based on partner
    <?php if(isset($partner_id)): ?>
        const fetchUrl = baseUrl + 'chat/get_messages/<?= $partner_id ?>';
        const sendUrl = baseUrl + 'chat/send_message';
        const partnerId = "<?= $partner_id ?>";
        const emptyMsg = "Belum ada pesan. Mulai chat dengan <?= $partner_name ?>.";
    <?php else: ?>
        const fetchUrl = baseUrl + 'chat/get_admin_messages';
        const sendUrl = baseUrl + 'chat/send_to_admin';
        const partnerId = null;
        const emptyMsg = "Belum ada pesan. Mulai chat dengan Admin.";
    <?php endif; ?>

    function loadMessages() {
        fetch(fetchUrl)
            .then(response => response.json())
            .then(data => {
                chatBox.innerHTML = '';
                if(data.length === 0) {
                     chatBox.innerHTML = `<div class="text-center text-gray-400 text-sm mt-10">${emptyMsg}</div>`;
                     return;
                }

                data.forEach(msg => {
                    const isMe = msg.sender_id == "<?= $this->session->userdata('user_id') ?>";
                    const align = isMe ? 'justify-end' : 'justify-start';
                    const bg = isMe ? 'bg-indigo-600 text-white rounded-br-none' : 'bg-white border border-gray-200 text-gray-800 rounded-bl-none';
                    const time = new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                    
                    // Read Status
                    let statusIcon = '';
                    if(isMe) {
                         if(msg.is_read == 1) {
                             statusIcon = '<span class="text-blue-300 ml-1">✓✓</span>';
                         } else {
                             statusIcon = '<span class="text-indigo-200 ml-1">✓</span>';
                         }
                    }

                    chatBox.innerHTML += `
                        <div class="flex ${align}">
                            <div class="${bg} px-4 py-2 rounded-2xl max-w-[75%] shadow-sm relative group break-words">
                                <p class="text-sm leading-relaxed">${msg.message}</p>
                                <p class="text-[10px] opacity-70 mt-1 text-right flex items-center justify-end">
                                    ${time}
                                    ${statusIcon}
                                </p>
                            </div>
                        </div>
                    `;
                });
            });
    }

    function sendMessage() {
        const message = messageInput.value.trim();
        if (!message) return;

        const formData = new FormData();
        formData.append('message', message);
        if(partnerId) {
             formData.append('receiver_id', partnerId);
        }

        fetch(sendUrl, {
            method: 'POST',
            body: formData
        }).then(() => {
            messageInput.value = '';
            loadMessages();
        });
    }

    sendBtn.addEventListener('click', sendMessage);
    messageInput.addEventListener('keypress', (e) => {
        if(e.key === 'Enter') sendMessage();
    });

    setInterval(loadMessages, 3000);
    loadMessages();
</script>

<?php $this->load->view('layout/footer'); ?>
