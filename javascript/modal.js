let photoId;
let photoDir = "upload_photos_normal/";

window.onload = function(){
	//loen kokku kõik pisipildid ja määran kõigile hiirekliki kuulamise.
	let allThumbs = document.querySelector("#gallery").querySelectorAll(".thumbs");
	//console.log(allThumbs);
	for(let i = 0; i < allThumbs.length; i++) {
		allThumbs[i].addEventListener("click", openModal);
	}
	document.querySelector("#modalclose").addEventListener("click", closeModal);
}

function openModal(evt){
	//evt.target
	document.querySelector("#modalimg").src = photoDir + evt.target.dataset.fn;
	document.querySelector("#modalcaption").innerHTML = evt.target.alt;
	photoId = evt.target.dataset.id;
	//kõik hinded ekraanil tühjaks
	for(let i = 1; i < 6; i++) {
		document.querySelector("#rate" + i).checked = false;
	}
	document.querySelector("#modalarea").style.display = "block";
	document.querySelector("#storeRating").addEventListener("click", storeRating)
}

function closeModal(){
    document.querySelector("#modalarea").style.display = "none";
    document.querySelector("#modalimg").src = "pics/empty.png";
    document.querySelector("#modalcaption").innerHTML = "";
    document.querySelector("#avgRating").innerHTML = "";
}

function storeRating(){
	let rating = 0;
	for(let i = 1; i < 6; i++){
		if(document.querySelector("#rate" + i).checked){
			rating = i;
		}
	}
	if(rating > 0){
		//AJAX
		let webRequest = new XMLHttpRequest();
		//kui asjad tööle hakkavad, siis jälgi
		webRequest.onreadystatechange = function(){
			//kas õnnestus
			if(this.readyState == 4 && this.status == 200){
				//mida teha, kui vastus tuli
				document.querySelector("#avgRating").innerHTML = this.responseText;
				document.querySelector("#rating" + photoId).innerHTML = this.responseText;
                document.querySelector("#storeRating").removeEventListener("click", storeRating);
			}
		}; //funktsioonisisene funktsioon on kui üks rida. readyState == 4 - server on saatnud vastuse. || - or
		//panemegi tööle
		webRequest.open("GET", "store_photorating.php?photo=" + photoId + "&rating=" + rating, true);
		webRequest.send();
		//AJAX lõppes
	}
}