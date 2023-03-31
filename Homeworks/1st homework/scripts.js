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

    const comments = document.getElementById("comments")
    const children_size = comments.children.length

    //if this happen, its because it's because we want to sort it by time
    if(children_size > 4){ //4 first children should be always there  

        //We remove the unordered comments    
        for(let i = children_size-1; i >= 4 ; i--){
          //console.log(comments.children[i+3])
          comments.removeChild(comments.children[i])
        }

        document.getElementById("sort_time_button").hidden = true;
        document.getElementById("sort_alph_button").hidden = false;
    }

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
    
    if(name != "" && opinion != "" ){
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

    entries = Object.entries(localStorage);
    const maxKey = getMaximumKey(entries)

    if(entries.length > 0){

        //We remove the unordered comments    
        for(let i = entries.length-1; i >= 0 ; i--){
            //console.log(comments.children[i+3])
            comments.removeChild(comments.children[i+4])
        }

        //Create an array of the names, and sort them alphabetically
        const names = [];

        for(let i = 0; i <= maxKey; i++){
            let string = localStorage.getItem(i)
            let json = JSON.parse(string)

            if(json != null)
                names.push([json.name, json.key]);
        }
        
        names.sort(function(a, b) { //sort the array
            if (a[0] < b[0]) {
              return -1;
            } else if (a[0] > b[0]) {
              return 1;
            } else {
              return 0;
            }
          });

        //we have an array with the names sorted and its key
        
        //we add the comments ordered
        for(let i = 0; i < names.length; i++){
            let string = localStorage.getItem(names[i][1])
            let json = JSON.parse(string)
            
            let comment = {
                name: json.name,
                opinion: json.opinion,
                key: json.key
            };

            domAddComment(comment)
        }

        document.getElementById("sort_time_button").hidden = false;
        document.getElementById("sort_alph_button").hidden = true;
    }
}