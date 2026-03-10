<main class="flex-1 overflow-hidden bg-gray-50 flex flex-col h-screen md:h-[calc(100vh-theme('spacing.16'))]"> <!-- Fixed height calculation -->
    <div class="flex-1 flex overflow-hidden relative"> <!-- Relative for absolute positioning on mobile -->
        
        <!-- LEFT: Contacts Sidebar -->
        <!-- Logic: hidden on mobile if chat active, block if no chat active or desktop -->
        <div id="contacts-panel" class="w-full md:w-80 bg-white border-r border-gray-200 flex flex-col z-10 absolute inset-0 md:relative">
            <!-- Header -->
            <div class="p-4 border-b border-gray-100 bg-gray-50">
                <h2 class="text-lg font-bold text-gray-800 mb-3">Pesan</h2>
                <!-- Role Toggles -->
                <div class="flex bg-gray-200 rounded-lg p-1">
                    <button onclick="loadContacts('driver')" id="btn-driver" class="flex-1 px-3 py-1.5 rounded-md text-sm font-medium transition-all text-gray-600 hover:text-gray-900">Driver</button>
                    <button onclick="loadContacts('customer')" id="btn-customer" class="flex-1 px-3 py-1.5 rounded-md text-sm font-medium transition-all text-gray-600 hover:text-gray-900">Penumpang</button>
                </div>
            </div>

            <!-- Contacts List -->
            <div id="contact-list" class="flex-1 overflow-y-auto p-2 space-y-1">
                <div class="p-4 text-center text-gray-400 text-sm">Memuat kontak...</div>
            </div>
        </div>

        <!-- RIGHT: Chat Window -->
        <!-- Logic: hidden on mobile if no chat active, block/absolute if active. Desktop always flex -->
        <div id="chat-panel" class="w-full md:flex-1 flex flex-col bg-white absolute inset-0 md:relative transform translate-x-full md:translate-x-0 transition-transform duration-300 z-20">
            <!-- Chat Header -->
            <div id="chat-header" class="h-16 border-b border-gray-200 px-4 flex items-center justify-between bg-white shadow-sm z-30">
                <div class="flex items-center">
                    <!-- Back Button (Mobile Only) -->
                    <button onclick="closeChat()" class="p-2 -ml-2 mr-2 text-gray-600 hover:text-gray-900 md:hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    
                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-lg mr-3" id="header-avatar">
                        ?
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg leading-tight" id="header-name">Select User</h3>
                        <span class="text-xs text-green-500 font-medium flex items-center">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-1"></span> Online
                        </span>
                    </div>
                </div>
            </div>

            <!-- Empty State (Desktop Only) -->
            <div id="empty-state" class="flex-1 hidden md:flex flex-col items-center justify-center text-gray-400">
                <svg class="h-20 w-20 mb-4 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                <p class="text-lg font-medium">Pilih kontak untuk mulai chat</p>
            </div>

            <!-- Messages Area -->
            <div id="messages-area" class="flex-1 overflow-y-auto p-4 md:p-6 space-y-4 bg-gray-50 flex flex-col">
                <!-- Messages go here -->
            </div>

            <!-- Input Area -->
            <div id="input-area" class="p-3 md:p-4 bg-white border-t border-gray-200">
                <form id="chat-form" class="flex items-end space-x-2">
                    <input type="hidden" id="receiver-id">
                    <input type="text" id="message-input" placeholder="Tulis pesan..." class="flex-1 bg-gray-100 border-0 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all shadow-inner text-sm md:text-base">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl p-3 shadow-md transition-colors flex-shrink-0">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
    let currentRole = 'driver';
    let currentPartnerId = null;
    let messageInterval = null;
    let isMobile = window.innerWidth < 768; // Simple breakpoint

    // Load Contacts
    function loadContacts(role) {
        currentRole = role;
        
        // Update Toggle UI
        document.getElementById('btn-driver').className = role === 'driver' 
            ? 'flex-1 px-3 py-1.5 rounded-md text-sm font-bold bg-white shadow text-indigo-600 transition-all'
            : 'flex-1 px-3 py-1.5 rounded-md text-sm font-medium text-gray-500 hover:text-gray-700 transition-all';
        document.getElementById('btn-customer').className = role === 'customer' 
            ? 'flex-1 px-3 py-1.5 rounded-md text-sm font-bold bg-white shadow text-indigo-600 transition-all'
            : 'flex-1 px-3 py-1.5 rounded-md text-sm font-medium text-gray-500 hover:text-gray-700 transition-all';

        fetch(`<?= base_url('admin/chat_get_contacts') ?>?role=${role}`)
            .then(res => res.json())
            .then(data => {
                const list = document.getElementById('contact-list');
                list.innerHTML = '';
                
                if(data.length === 0) {
                    list.innerHTML = '<div class="p-4 text-center text-gray-400 text-sm">Tidak ada data.</div>';
                    return;
                }

                data.forEach(user => {
                    const activeClass = (currentPartnerId == user.id) ? 'bg-indigo-50 border-l-4 border-indigo-500' : 'hover:bg-gray-50 border-l-4 border-transparent';
                    
                    // Unread Badge Logic
                    let badgeHtml = '';
                    if(user.unread_count > 0) {
                        badgeHtml = `<span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full ml-auto">${user.unread_count}</span>`;
                    }

                    const el = document.createElement('div');
                    el.className = `p-3 cursor-pointer ${activeClass} transition-colors border-b border-gray-50 last:border-0`;
                    el.onclick = () => openChat(user.id, user.name);
                    el.innerHTML = `
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-sm mr-3 flex-shrink-0">
                                ${user.name.charAt(0)}
                            </div>
                            <div class="overflow-hidden flex-1">
                                <h4 class="text-sm font-bold text-gray-800 truncate">${user.name}</h4>
                                <p class="text-xs text-gray-500 truncate">Klik untuk chat</p>
                            </div>
                            ${badgeHtml}
                        </div>
                    `;
                    list.appendChild(el);
                });
            });
    }

    // Open Chat
    function openChat(userId, userName) {
        currentPartnerId = userId;
        document.getElementById('receiver-id').value = userId;
        document.getElementById('header-name').innerText = userName;
        document.getElementById('header-avatar').innerText = userName.charAt(0);

        // Mobile View Transition
        const chatPanel = document.getElementById('chat-panel');
        chatPanel.classList.remove('translate-x-full');
        
        // Hide Empty State (Desktop)
        document.getElementById('empty-state').classList.remove('md:flex');
        document.getElementById('empty-state').classList.add('hidden');

        // Fetch Messages immediately & mark read
        loadMessages(); 
        
        // Reload contacts to clear unread badge locally for this user
        // Short delay to allow DB update
        setTimeout(() => loadContacts(currentRole), 500);

        if(messageInterval) clearInterval(messageInterval);
        messageInterval = setInterval(loadMessages, 3000);
    }

    // Close Chat (Mobile Back Button)
    function closeChat() {
        currentPartnerId = null;
        const chatPanel = document.getElementById('chat-panel');
        chatPanel.classList.add('translate-x-full');
        
        // Stop polling to save resources
        if(messageInterval) clearInterval(messageInterval);
    }

    // Load Messages
    function loadMessages() {
        if(!currentPartnerId) return;

        fetch(`<?= base_url('admin/chat_get_messages') ?>?user_id=${currentPartnerId}`)
            .then(res => res.json())
            .then(data => {
                const area = document.getElementById('messages-area');
                
                // Optimized: Only redraw if count differs or last message differs? 
                // For now, full redraw is safer for "read status" updates.
                
                let html = '';
                data.forEach(msg => {
                    const isMe = (msg.sender_id == <?= $this->session->userdata('user_id') ?>);
                    const align = isMe ? 'justify-end' : 'justify-start';
                    const bubble = isMe ? 'bg-indigo-600 text-white rounded-br-none' : 'bg-white border border-gray-200 text-gray-800 rounded-bl-none';
                    
                    // Read Status Indicator (Double Check)
                    let statusIcon = '';
                    if(isMe) {
                         if(msg.is_read == 1) {
                             // Double Tick Blue
                             statusIcon = '<span class="text-blue-300 ml-1">✓✓</span>';
                         } else {
                             // Single Tick
                             statusIcon = '<span class="text-indigo-200 ml-1">✓</span>';
                         }
                    }

                    html += `
                        <div class="flex ${align}">
                            <div class="max-w-[75%] px-4 py-2 rounded-2xl shadow-sm ${bubble} break-words">
                                <p class="text-sm">${msg.message}</p>
                                <p class="text-[10px] opacity-70 mt-1 text-right flex items-center justify-end">
                                    ${new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                                    ${statusIcon}
                                </p>
                            </div>
                        </div>
                    `;
                });
                area.innerHTML = html;
            });
    }

    // Send Message
    document.getElementById('chat-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const input = document.getElementById('message-input');
        const message = input.value.trim();
        const receiverId = document.getElementById('receiver-id').value;

        if(!message) return;

        const formData = new FormData();
        formData.append('receiver_id', receiverId);
        formData.append('message', message);

        fetch('<?= base_url('admin/chat_send') ?>', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success') {
                input.value = '';
                loadMessages();
            }
        });
    });

    // Init
    loadContacts('driver');

</script>
