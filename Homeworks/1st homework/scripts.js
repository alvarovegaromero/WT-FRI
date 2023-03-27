// We will storage in LocalStorage: {name, comment, key of the product, key of the comment}

window.onload = addOldComments(); //add old comments 

document.addEventListener("DOMContentLoaded", () => {
    // This function is run after the page contents have been loaded
    // Put your initialization code here
    document.getElementById("post_comment").onclick = addComment; //executed only when full page is loaded
})

function addOldComments(){
    const entries = Object.entries(localStorage)
    const maxKey = getMaximumKey(entries)

    if(entries.length > 0){
        for(let i = 0; i <= maxKey; i++){ //values should be under maxKey
            let string = localStorage.getItem(i)
            let json = JSON.parse(string)
            
            if(json != null){
                let comment = {
                    name: json.name,
                    opinion: json.opinion
                };
        
                domAddComment(comment)
            }
        }
    }
}

function getMaximumKey(){
    let max = 0

    const entries = Object.entries(localStorage)

    for(let i = 0; i < entries.length; i++){
        if(parseInt(entries[i][0], 10) > max)
            max = parseInt(entries[i][0], 10)
    }

    return max;
}    


function getNewKey(){    
    const entries = Object.entries(localStorage)
    
    if(entries.length != 0)// not empty
        return getMaximumKey(entries) + 1
    else //empty
        return 0; 
}

function addComment(event) {
    // Get values
    const name = document.querySelector("#name").value;
    const opinion = document.querySelector("#opinion").value;
    
    //Set input fields to empty values
    document.querySelector("#name").value = "";
    document.querySelector("#opinion").value = "";

    let newKey = getNewKey()

    print("hola")

    const comment = {
        name: name,
        opinion: opinion,
        key: newKey
    };

    localStorage.setItem(newKey, JSON.stringify(comment));

    domAddComment(comment);
}

function domAddComment(comment) {
    const comments = document.getElementById("comments");;
    comments.appendChild(comment_to_add);

    let comment_to_add = document.createElement("div");

    //comment_to_add.ondblclick = domRemoveComment

    comment_to_add.innerHTML = 'hola';

}

/*
'<div class="comentario"> <p class= "autor">' + autor //html a poner en el comentariio este
  + '</p> <p class = "fechayhora">' + fecha.getDate() + "/" + (fecha.getMonth()+1) + "/" + (fecha.getFullYear()) + '</p> <p class = "fechayhora">'
  + fecha.getHours()+":"+fecha.getMinutes() + '</p> <p class = "textocomentario">'
  + texto + '</p> </div>';
*/

/*
function domRemoveParticipant(event) {

    let row = event.target.parentElement
    let table = event.target.parentElement.parentElement

    if(confirm("Do you really want to delete the row?")){
        table.removeChild(row)
        localStorage.removeItem(row.lastChild.innerHTML) //get id of the content of the row
    }
}*/