// Contoh penggunaan AJAX
function fetchComplaints() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'fetch_complaints.php', true);
    xhr.onload = function () {
        if (this.status === 200) {
            const complaints = JSON.parse(this.responseText);
            let output = '';
            complaints.forEach(function(complaint) {
                output += `<tr>
                    <td>${complaint.id}</td>
                    <td>${complaint.complaint_text}</td>
                    <td>${complaint.status}</td>
                    <td>${complaint.created_at}</td>
                </tr>`;
            });
            document.querySelector('tbody').innerHTML = output;
        }
    };
    xhr.send();
}

document.addEventListener('DOMContentLoaded', fetchComplaints);