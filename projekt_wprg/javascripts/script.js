function showPostForm() {
    var postForm = document.getElementById("postForm");
    postForm.style.display = (postForm.style.display === "none") ? "block" : "none";;
    document.getElementById("ustawienia").style.display="none";
    var editPostForm = document.getElementById("editPost");
    editPostForm.style.display = "none";

    var ustawienia = document.getElementById("ustawienia");
    ustawienia.style.display = "none";

    var hlist = document.getElementById("hlist");
    hlist.style.display="none";
    var messages = document.getElementById("messages")
    messages.style.display="none";
}

function showEditPostForm(postId = null) {
    var editPostForm = document.getElementById("editPost");

    if (postId !== null) {
        fetch(`get_post.php?id=${postId}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    document.getElementById("editPostId").value = data.id;
                    document.getElementById("editTitle").value = data.title;
                    document.getElementById("editContent").value = data.content;
                    editPostForm.style.display = "block";
                    document.getElementById("postForm").style.display = "none";
                    document.getElementById("ustawienia").style.display = "none";
                    document.getElementById("messages").style.display = "none"; // Dodaj tę linię
                }
            })
            .catch(error => console.error('Error:', error));
    } else {
        editPostForm.style.display = (editPostForm.style.display === "none") ? "block" : "none";
        document.getElementById("postForm").style.display = "none";
        document.getElementById("ustawienia").style.display = "none";
        document.getElementById("messages").style.display = "none"; // Dodaj tę linię
    }
}






function deletePost(postId) {
    // Sprawdź uprawnienia przed usunięciem posta
    fetch('sprawdz_uprawnienia.php')
        .then(response => response.json())
        .then(data => {
            if (data.loggedin && data.role === 'admin') {
                if (confirm("Czy na pewno chcesz usunąć ten post?")) {
                    fetch('usun_post.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `post_id=${postId}`
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert("Post został usunięty.");
                                location.reload();
                            } else {
                                alert("Błąd podczas usuwania posta: " + data.error);
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }
            } else {
                alert("Nie masz uprawnień do usuwania postów jako redaktor.");
            }
        })
        .catch(error => console.error('Error:', error));
}

function showSettings() {
    var ustawienia = document.getElementById("ustawienia");
    ustawienia.style.display = (ustawienia.style.display === "none") ? "block" : "none";
    var editPostForm = document.getElementById("editPost");
    var postForm = document.getElementById("postForm");
    editPostForm.style.display = "none";
    postForm.style.display = "none";
    document.getElementById("postListContainer").style.display = "none"; // Ukryj listę postów
    var messages = document.getElementById("messages")
    messages.style.display="none";

}
function showMessages() {
    var messages = document.getElementById("messages");
    messages.style.display = "block";

    var editPostForm = document.getElementById("editPost");
    editPostForm.style.display = "none";

    var postForm = document.getElementById("postForm");
    postForm.style.display = "none";

    var ustawienia = document.getElementById("ustawienia");
    ustawienia.style.display = "none";

    var postListContainer = document.getElementById("postListContainer");
    postListContainer.style.display = "none"; // Ukryj listę postów

    var hlist = document.getElementById("hlist");
    hlist.style.display = "none";
}

function readMessage(id, postId) {
    fetch(`get_message.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
            } else {
                // Wyświetlenie treści wiadomości
                showMessageDetail(data.title, data.email, data.message, data.date_sent, postId);
            }
        })
        .catch(error => console.error('Error:', error));
}

function showMessageDetail(title, email, message, date_sent, postId) {
    // Wyświetlenie treści wiadomości
    document.getElementById("messageTitle").textContent = title;
    document.getElementById("messageEmail").textContent = "Email: " + email;
    document.getElementById("messageContent").textContent = "Treść wiadomości: " + message;
    document.getElementById("messageDate").textContent = "Data wysłania: " + date_sent;

    // Ustawienie ID posta w formularzu
    document.getElementById("postId").value = postId;

    // Pokaż sekcję z treścią wiadomości
    document.getElementById("messages").style.display = "none";
    document.getElementById("messageDetail").style.display = "block";
}
function deleteMessage(messageId) {
    if (confirm("Czy na pewno chcesz usunąć tę wiadomość?")) {
        // Przesłanie żądania do serwera
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "usun_wiadomosc.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                window.location.reload();
            }
        };
        xhr.send("action=delete&message_id=" + messageId);
    }
}
