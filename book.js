var el_log_in = document.getElementById('log_in');

el_log_in.addEventListener('click', function(){ window.location = 'finalLog.php' }, false);



function checkUsername(){

	
	var xhr = new XMLHttpRequest;


	xhr.onload = function(){


		if(xhr.status === 200){
			
			//Get the list of usernames already existing.
			username_list = JSON.parse(xhr.responseText);

			//Get the username that is in the input field.
			var username = document.getElementById('username');

			//Get the status report area.
			var el_status = document.getElementById('username_status');

			//Get the Button to be Disabled if Username is incorrect.
			var submit = document.getElementById('register');


				var exists = false;

				//Look to see if there is a match.
				for( var i = 0; i < username_list.length; i++){
					if( username.value == username_list[i] ){
						exists = true;
					}

				}

				var username_unavail_msg = 'Username is unavailable.';

				if( exists === true){
					el_status.innerHTML = username_unavail_msg;
					submit.disabled = true;

				}else{
					el_status.innerHTML = '';
					submit.disabled = false;

				}

			

		}

	};

	xhr.open('GET','user_names.php',true);
	xhr.send(null);

}


//Get Username Input Field
var el_username = document.getElementById('username');


//Get the status report area.
el_username.addEventListener('keyup',checkUsername,false);


