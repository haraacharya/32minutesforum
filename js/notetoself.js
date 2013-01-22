window.onload = init;
function init(){
	var postItName = getPostItName();
	var nameElement = document.getElementById("postit_name");
	nameElement.innerHTML = postItName + "'s POST IT PAGE";
	var button = document.getElementById("addbutton");
	button.onclick = createSticky;
	var stickiesArray = getStickiesArray();	
	
	for (var i = 0; i < stickiesArray.length; i++){
		var key = stickiesArray[i];
		var value = localStorage.getItem(key);
		addStickyToDOM(key, value);
	}
	var changeName = document.getElementById("change_name");
	changeName.onclick = changeNameFunction;
}

function deleteSticky(e) {
	//var key = e.target.id;
	//if(e.target.tagname.toLowerCase() == "span"){
		key = e.target.parentNode.id;
		
	//}
	
	localStorage.removeItem(key);
	var stickiesArray = getStickiesArray();
	for (var i = 0; i < stickiesArray.length; i++) {
		if(key == stickiesArray[i]){
			stickiesArray.splice(i,1);
		}
	}
	localStorage.setItem("stickiesArray", JSON.stringify(stickiesArray));
	removeStickyFromDOM(key);
}
function removeStickyFromDOM(key){
	var sticky = document.getElementById(key);
	sticky.parentNode.removeChild(sticky);
}
function addStickyToDOM(key, value){
	var stickies = document.getElementById("stickies");
	var sticky = document.createElement("li");
	sticky.setAttribute("id", key)
	var span = document.createElement("span");
	span.setAttribute("class", "sticky");
	span.innerHTML = "X";
	var para = document.createElement("p");
	para.innerHTML = value;
	span.appendChild(para);
	sticky.appendChild(span);
	stickies.appendChild(sticky);
	sticky.onclick = deleteSticky;
}
function createSticky(){
	var value = document.getElementById("note_text").value;
	if (value == null || value == ""){
		alert ("Please add a note");
	}
	else{
		var currentDate = new Date();
		var key = "sticky_" + currentDate.getTime();
			
		var stickiesArray = getStickiesArray();
		localStorage.setItem(key, value);
		stickiesArray.push(key);	
		
		localStorage.setItem("stickiesArray", JSON.stringify(stickiesArray));
		addStickyToDOM(key, value);
	}
}

function getStickiesArray(){
	var stickiesArray = localStorage.getItem("stickiesArray");
	if(!stickiesArray){
		stickiesArray = [];
		localStorage.setItem("stickiesArray", JSON.stringify(stickiesArray));
	}
	else {
		stickiesArray = JSON.parse(stickiesArray);
	}
	return stickiesArray;
}

function getPostItName(){
	var postItName = localStorage.getItem("postItAppName");
	if(!postItName){
		postItName = prompt("Please input your name", "Type your Name")
		localStorage.setItem("postItAppName", JSON.stringify(postItName));	
	}
	else{
		postItName = JSON.parse(postItName);
	}	
	return postItName;
}

function changeNameFunction(){
	postItName = prompt("Please input your name", "Type your Name")
	localStorage.setItem("postItAppName", JSON.stringify(postItName));	
	window.location.reload();
}
