 var button = document.getElementById('btn');

 button.addEventListener('click', function(){

 	var http = new XMLHttpRequest();
    
    http.onreadystatechange = function() {
    	if (this.readyState == 4 && this.status ==200){
    		var products = JSON.parse(this.responseText);
    		products = products['records'];
            
           
    		
    		document.getElementById('products').innerHTML = this.responseText;


    	}
    };
    http.open("GET", "http://192.168.70.14/api/product/read.php", true);
    http.send();

 });


  