function toggleChatbot() {
    const chatbot = document.getElementById('chatbotContainer');
    if (chatbot.style.display === 'none' || chatbot.style.display === '') {
        chatbot.style.display = 'flex';
        loadChatbotSuggestions();
    } else {
        chatbot.style.display = 'none';
    }
}

function sendChatMessage() {
    const input = document.getElementById('chatbotInput');
    const query = input.value.trim();
    
    if (!query) return;
    
    const messagesDiv = document.getElementById('chatbotMessages');
    messagesDiv.innerHTML += `<div class="user-message"><p>${escapeHtml(query)}</p></div>`;
    
    input.value = '';
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
    
    fetch('api/chatbot.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'query=' + encodeURIComponent(query)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.responses && data.responses.length > 0) {
            data.responses.forEach(r => {
                messagesDiv.innerHTML += `
                    <div class="bot-message">
                        <p><strong>${escapeHtml(r.question)}</strong></p>
                        <p>${escapeHtml(r.response)}</p>
                        ${r.category ? `<p class="chatbot-help">Category: ${escapeHtml(r.category)}</p>` : ''}
                    </div>
                `;
            });
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }
    })
    .catch(error => {
        console.error('Chatbot error:', error);
        messagesDiv.innerHTML += `
            <div class="bot-message">
                <p>Sorry, I encountered an error. Please try again.</p>
            </div>
        `;
    });
}

function loadChatbotSuggestions() {
    fetch('api/chatbot.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'query='
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.responses) {
            const suggestionsDiv = document.getElementById('chatbotSuggestions');
            suggestionsDiv.innerHTML = '<p style="margin-bottom: 0.5rem; color: var(--text-light);">Quick Questions:</p>';
            
            data.responses.slice(0, 3).forEach(r => {
                const btn = document.createElement('button');
                btn.className = 'suggestion-btn';
                btn.textContent = r.question;
                btn.onclick = () => {
                    document.getElementById('chatbotInput').value = r.question;
                    sendChatMessage();
                };
                suggestionsDiv.appendChild(btn);
            });
        }
    })
    .catch(error => console.error('Error loading suggestions:', error));
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchTicket');
    const statusFilter = document.getElementById('statusFilter');
    const categoryFilter = document.getElementById('categoryFilter');
    
    if (searchInput) {
        searchInput.addEventListener('input', filterTickets);
    }
    
    if (statusFilter) {
        statusFilter.addEventListener('change', filterTickets);
    }
    
    if (categoryFilter) {
        categoryFilter.addEventListener('change', filterTickets);
    }
});

function filterTickets() {
    const searchTerm = document.getElementById('searchTicket')?.value.toLowerCase() || '';
    const statusFilter = document.getElementById('statusFilter')?.value || '';
    const categoryFilter = document.getElementById('categoryFilter')?.value || '';
    
    const tickets = document.querySelectorAll('.ticket-card');
    
    tickets.forEach(ticket => {
        const text = ticket.textContent.toLowerCase();
        const ticketStatus = ticket.getAttribute('data-status') || '';
        const ticketCategory = ticket.getAttribute('data-category') || '';
        
        const matchesSearch = text.includes(searchTerm);
        const matchesStatus = !statusFilter || ticketStatus === statusFilter;
        const matchesCategory = !categoryFilter || ticketCategory === categoryFilter;
        
        if (matchesSearch && matchesStatus && matchesCategory) {
            ticket.style.display = 'block';
        } else {
            ticket.style.display = 'none';
        }
    });
}
