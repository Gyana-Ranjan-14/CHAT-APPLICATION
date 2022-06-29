const form = document.querySelector(".typing-area"),
    incoming_id = form.querySelector(".incoming_id").value, //select the values that he sent the message
    inputField = form.querySelector(".input-field"),
    sendBtn = form.querySelector("button"),
    chatBox = document.querySelector(".chat-box");

// when the submission happen dont relooad the page
form.onsubmit = (e) => {
    e.preventDefault();
}

// focus() method gives focus to an element (if it can be focused).
inputField.focus();
inputField.onkeyup = () => {
    if (inputField.value != "") {
        sendBtn.classList.add("active");
    } else {
        sendBtn.classList.remove("active");
    }
}

// when click on the chat button
sendBtn.onclick = () => {
        let xhr = new XMLHttpRequest(); //create a new xmlhttp request
        xhr.open("POST", "php/insert-chat.php", true); //open the insert chart app

        xhr.onload = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    inputField.value = "";
                    scrollToBottom();
                }
            }
        }
        let formData = new FormData(form);
        xhr.send(formData);
    }
    // occurs when the mouse pointer is moved onto an element. Tip: This event is often used together 
    //with the onmouseleave event, which occurs when the mouse pointer is moved out of an element.
chatBox.onmouseenter = () => {
    chatBox.classList.add("active");
}

chatBox.onmouseleave = () => {
    chatBox.classList.remove("active");
}

setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/get-chat.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                chatBox.innerHTML = data;
                if (!chatBox.classList.contains("active")) {
                    scrollToBottom();
                }
            }
        }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // send msg to incomming id
    xhr.send("incoming_id=" + incoming_id);
}, 500);

// automatic scroll
function scrollToBottom() {
    chatBox.scrollTop = chatBox.scrollHeight;
}