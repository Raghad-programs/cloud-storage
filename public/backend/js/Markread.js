document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('markAllAsRead').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default action
        fetch(markAllAsReadUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        }).then(response => {
            if (response.ok) {
                location.reload();
            }
        }).catch(error => {
            console.error('Error:', error);
        });
    });
});
