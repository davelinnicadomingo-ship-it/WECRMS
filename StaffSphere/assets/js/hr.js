function updateTicketStatus(ticketId, status) {
    if (!status) return;
    
    const notes = prompt('Add notes (optional):');
    
    fetch('api/update_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `ticket_id=${ticketId}&status=${encodeURIComponent(status)}&notes=${encodeURIComponent(notes || '')}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error updating status: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to update status');
    });
}

function assignTicket(ticketId, assignedTo) {
    if (!assignedTo) {
        assignedTo = null;
    }
    
    fetch('api/assign_ticket.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `ticket_id=${ticketId}&assigned_to=${assignedTo}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error assigning ticket: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to assign ticket');
    });
}
