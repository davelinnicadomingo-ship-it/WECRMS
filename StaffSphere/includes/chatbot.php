<div id="chatbotContainer" class="chatbot-container" style="display: none;">
    <div class="chatbot-header">
        <h3>💬 HR Assistant</h3>
        <button class="chatbot-close" onclick="toggleChatbot()">×</button>
    </div>
    <div class="chatbot-messages" id="chatbotMessages">
        <div class="bot-message">
            <p>Hello! I'm your HR assistant. How can I help you today?</p>
            <p class="chatbot-help">Ask me about leave requests, payroll, benefits, or any other HR-related questions.</p>
        </div>
    </div>
    <div class="chatbot-input">
        <input type="text" id="chatbotInput" placeholder="Type your question..." onkeypress="if(event.key === 'Enter') sendChatMessage()">
        <button onclick="sendChatMessage()">Send</button>
    </div>
    <div class="chatbot-suggestions" id="chatbotSuggestions"></div>
</div>
