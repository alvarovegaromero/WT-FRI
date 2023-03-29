//  We will storage in LocalStorage: {name, comment, key of the comment}

//  Whenever we use more pages, we should storage the key of the product, for
//showing the product's comments

//window.onload = addOldComments(); //add old comments 

document.addEventListener("DOMContentLoaded", () => {
    // This function is run after the page contents have been loaded
    // Put your initialization code here
    addOldComments()
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
                    opinion: json.opinion,
                    key: json.key
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

    const comment = {
        name: name,
        opinion: opinion,
        key: newKey
    };

    localStorage.setItem(newKey, JSON.stringify(comment));

    domAddComment(comment);
}

function domAddComment(comment) {
    var comments = document.getElementById("comments")
   
    let comment_to_add = document.createElement("div");
    comment_to_add.className = "comment";
    comment_to_add.innerHTML = `<p> <b> ${comment.name} </b> </p> 
                                <p> ${comment.opinion} </p> 
                                <p class="delete_comment_button" onclick="domRemoveComment(this)"> Delete Comment </p>`;
    comment_to_add.id = comment.key; //add the key of the comment 

    comments.appendChild(comment_to_add);
}


function domRemoveComment(html_comment) {
    let comment = html_comment.parentNode;
    let comments = comment.parentNode;     
    
    if(confirm("Do you really want to delete the comment?")){
        comments.removeChild(comment);
        localStorage.removeItem(comment.id) //get id of the comment and remove it
    }
}

function domSortAlphabeticallyComments(){ //Alphabetically in function of the author
    var comments = document.getElementById("comments")

    while (comments.firstChild) {
        comments.removeChild(comments.firstChild);
    }
    
    //Create an array of the names, and sort them alphabetically
    entries = Object.entries(localStorage);
    const names = [];

    if(entries.length > 0){
        for(let i = 0; i < entries; i++){
            let string = localStorage.getItem(i)
            let json = JSON.parse(string)

            names.push(json.name);
        }

        names.sort()
        console.log(names)
    }

}