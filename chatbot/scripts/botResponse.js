/**
 * 
 * botResponse.js
 * 
 * This file includes the logic for the chatbot. It reads the input of the user
 * and determines the correct response.
 */


// formats and reads users input then calls readUserInput function to determine response
function getBotResponse(input){
    
    let text = input.toLowerCase();

    const textArray = text.split(" ");

    // iterate over the words entered by user and check them for keywords
    for (let i = 0; i < textArray.length; i++){
        let response = readUserInput(textArray[i]);
        
        if (response === ""){
            continue;
        }else{
            return response;
        }
    }
    return DEFAULT_MESSAGE;
}

// Determines which function will provide best response to user input
function readUserInput(text){

    if (PLEASANTRY_KEYWORDS.includes(text)){
        return pleasantryResponse(text);
    }
    else if(REVIEW_KEYWORDS.includes(text)){
        return reviewResponse(text);
    }
    else if(ACCOUNT_KEYWORDS.includes(text)){
        return accountResponse(text);
    }
    else if(RETURN_KEYWORDS.includes(text)){
        return returnResponse(text);
    }
    else{
        return "";
    }
}

// Respond to pleasantries
function pleasantryResponse(text){
    if (GREETING_KEYWORDS.includes(text)){
        return HELLO_RESPONSE;
    }
    else if (FAREWELL_KEYWORDS.includes(text)){
        return GOODBYE_RESPONSE;
    }else{
        return "";
    }
}

// Respond to requests to review products
function reviewResponse(text){

    if (REVIEW_KEYWORDS.includes(text)){
        return REVIEW_RESPONSE;
    }
    else{
        return ""
    }
}

// Send user to their account page
function accountResponse(text){
    if (ACCOUNT_KEYWORDS.includes(text)){
        return ACCOUNT_RESPONSE;
    }
    else{
        return "";
    }
}

// S
function returnResponse(text){
    if (RETURN_KEYWORDS.includes(text)){
        return RETURN_RESPONSE;
    }
    else{
        return "";
    }
}
