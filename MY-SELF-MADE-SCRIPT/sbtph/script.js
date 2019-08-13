var callbtn = document.getElementById('callme');

callbtn.addEventListener('click', function(){
	var  exten = prompt("Enter Your Extension:");


		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
	    	document.getElementById("demo").innerHTML = this.responseText;
		  }
		};

		xhttp.open("GET", "callme.php?exten=" + exten, true);

		xhttp.send();

	
});