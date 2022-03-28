/**
 * 
 * chatbot.js
 * 
 * This file includes the functionality for the chatbot. 
 * 
 * 
 */


// Sends initial bot message
function initialMessage(){
    
    document.getElementById("botStarterMessage").innerHTML="<p class='botText'><span>" + WELCOME_MESSAGE + "</span></p>";
    document.getElementById("userInput").scrollIntoView(false);
}

initialMessage();


// retrieves the response
function getResponse(userText){
    let botResponse = getBotResponse(userText);
    let botHtml = '<p class="botText"><span>' + botResponse + "</span></p>";
    $("#chatbox").append(botHtml);

    document.getElementById("input-block-bottom").scrollIntoView(true);
}

// send button handler
function sendButton(){
    // get user input
    let userText = $("#textInput").val();
    // format user input into html tags
    let userHtml = "<p class='userText'><span>" + userText + "</span></p>";
    
    // clear input
    $("#textInput").val("");
    // display
    $("#chatbox").append(userHtml);
    document.getElementById("input-block-bottom").scrollIntoView(true);

    setTimeout(() => {
        getResponse(userText);
    }, 1250)
}


// Press enter to send a message
$("#textInput").keypress(function (e) {
    if (e.which == 13) {
        sendButton();
    }
});

// Hide or show chat window by clicking top bar
function changeView(){
    var box = document.getElementById("full-chat-box");
    if(box.style.display === "block"){
        box.style.display = "none";
    }else{
        box.style.display = "block";
    }
}
