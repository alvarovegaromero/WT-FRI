"use strict";

function domRemoveParticipant(event) {

    let row = event.target.parentElement
    let table = event.target.parentElement.parentElement

    if(confirm("Do you really want to delete the row?")){
        table.removeChild(row)
        localStorage.removeItem(row.lastChild.innerHTML) //get id of the content of the row
    }
}

function domAddParticipant(participant) {
    const table = document.querySelector("#participant-table");

    const tr = document.createElement("tr");
    table.appendChild(tr);
    tr.ondblclick = domRemoveParticipant

    for(let attr in participant){
        if(attr == 'key'){
            const td = document.createElement("td")
            td.innerText = participant[attr]
            td.style.display = 'none' 
            tr.appendChild(td)
        }
        else{
            const td = document.createElement("td")
            td.innerText = participant[attr]
            tr.appendChild(td)
        }
    }
}

function addParticipant(event) {
    // Get values
    const first = document.querySelector("#first").value;
    const last = document.querySelector("#last").value;
    const role = document.querySelector("#role").value;
    
    //Set input fields to empty values
    document.querySelector("#first").value = "";
    document.querySelector("#last").value = "";

    let newKey = getNewKey()

    // Create participant object
    const participant = {
        first: first,
        last: last,
        role: role,
        key : newKey
    };

    //participants.push(participant)
    localStorage.setItem(newKey, JSON.stringify(participant));

    // Add participant to the HTML
    domAddParticipant(participant);

    // Move cursor to the first name input field
    document.getElementById("first").focus();
}

function getNewKey(){    
    const entries = Object.entries(localStorage)
    
    if(entries.length != 0)// not empty
        return getMaximumKey(entries) + 1
    else //empty
        return 0; 
}

//get the maximum key, before this number we should check for adding participant
function getMaximumKey(){
    let max = 0

    const entries = Object.entries(localStorage)

    for(let i = 0; i < entries.length; i++){
        if(parseInt(entries[i][0], 10) > max)
            max = parseInt(entries[i][0], 10)
    }

    return max;
}    

function addOldParticipants(){
    const entries = Object.entries(localStorage)
    const maxKey = getMaximumKey(entries)

    if(entries.length > 0){
        for(let i = 0; i <= maxKey; i++){ //values should be under maxKey
            let string = localStorage.getItem(i)
            let json = JSON.parse(string)
            
            if(json != null){
                let participant = {
                    first: json.first,
                    last: json.last,
                    role: json.role,
                    key: json.key
                };
        
                domAddParticipant(participant)
            }
        }
    }
}

window.onload = addOldParticipants(); //add old participant for the table

document.addEventListener("DOMContentLoaded", () => {
    // This function is run after the page contents have been loaded
    // Put your initialization code here
    //addOldParticipants();
    document.getElementById("addButton").onclick = addParticipant; //executed only when full page is loaded
})

// The jQuery way of doing it - Same function as before but for jquery
$(document).ready(() => {
    // Alternatively, you can use jQuery to achieve the same result
});
