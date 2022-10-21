<?php
ini_set('display_errors', true);
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <script  src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js" integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>	
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" integrity="sha512-6S2HWzVFxruDlZxI3sXOZZ4/eJ8AcxkQH1+JjSe/ONCEqR9L4Ysq5JdT5ipqtzU7WHalNwzwBv+iE51gNHJNqQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />	
    <title>DES</title>
</head>
<body>
<div class="container p-4">
    <h2 class="border text-center bg-success text-white p-1"> 
        MATERIAL SECURE REMOTE COMMUNICATION USING DES
    </h2>
    <hr>
    <?php
        if(!isset($_SESSION['DES_operation']))
            $_SESSION['DES_operation'] = 'encryption';
    ?>
    <input type="text" name="" id="des_operation" value="<?php echo $_SESSION['DES_operation'] ?>" hidden>
    <ul class="nav nav-pills nav-fill mb-3 shadow rounded" id="pills-tab" role="tablist">
        <li class="nav-item m-2" role="presentation">
            <button class="nav-link <?php if(isset($_SESSION['DES_operation']) && $_SESSION['DES_operation']=='encryption') echo 'active'; ?>" id="pills-encryption-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">ENCRYPTION</button>
        </li>
        <li class="nav-item m-2 " role="presentation">
            <button class="nav-link <?php if(isset($_SESSION['DES_operation']) && $_SESSION['DES_operation']=='decryption') echo 'active'; ?>" id="pills-decryption-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">DECRYPTION</button>
        </li>
    </ul>
       
    <hr>
    <div class="tab-content" id="pills-tabContent">
        <?php if(isset($_SESSION['error'])) {?>
            <div class="alert alert-danger alert-dismissible fade show" id="error-div" role="alert">
                <strong>Error..!!!</strong> <span id="error-message"><?php echo $_SESSION['error'];?></span>
                
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } ?>

        <?php if(isset($_SESSION['cipher_text'])) { ?>
            <div class="alert alert-success alert-dismissible fade show" id="success-div-encrypted" role="alert">
                <div class="form-floating">
                        <textarea class="form-control mw-100 mh-100" id="copyableCipherText" placeholder="cipher_text" readonly><?php echo $_SESSION['cipher_text'];?></textarea>
                        <label for="encryption_key">
                            <strong>Cipher Text </strong> 
                        </label>
                </div>
                <div class="mt-1">
                    <button class="btn btn-sm btn-secondary w-100" id="copyButtonCipherText" >copy</button>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } ?>
        
        
        <?php if(isset($_SESSION['plain_text'])) { ?>
            <div class="alert alert-success alert-dismissible fade show" id="success-div-decrypted" role="alert">
                <div class="form-floating">
                        <textarea class="form-control mw-100 mh-100" id="copyablePlainText" placeholder="cipher_text" readonly><?php echo $_SESSION['plain_text'];?></textarea>
                        <label for="encryption_key">
                            <strong>Plain Text </strong> 
                        </label>
                </div>
                <div class="mt-1">
                    <button class="btn btn-sm btn-secondary w-100" id="copyButtonPlainText" >copy</button>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } ?>
        
        <div class="tab-pane fade <?php if(isset($_SESSION['DES_operation']) && $_SESSION['DES_operation']=='encryption') echo ' show active'; ?> " id="pills-home" role="tabpanel" aria-labelledby="pills-encryption-tab" tabindex="0">
            <div class="shadow pb-4 px-4 border border-primary">
                <h6 class="text-center p-2 bg-primary text-white">DES Encryption </h6>
                <form action="api/des.php" method="post" id="encryptionForm">
                    <div class="form-group mb-3">
                        <label for="plain_text">
                            Pain Text
                        </label>
                        <textarea class="form-control mw-100 mh-100" placeholder="Enter plain text" name="plain_text"  id="plain_text" required></textarea>
                        
                    </div>
                    <div class="input-group mb-3"> 
                        <span class="input-group-text">
                            <i class="fa-solid fa-key"></i>
                        </span>
                        <div class="form-floating">
                            <input type="text" class="form-control" name="key" minlength="8" maxlength="8" placeholder="key" id="encryption_key" required>
                            <label for="encryption_key">Key</label>
                        </div>
                    </div>
                    <button  id="cancelBtn" class="btn btn-danger">Cancel</button>
                    <button type="reset" id="resetButton1" class="btn btn-secondary">Reset</button>
                    <button type="submit" name="submit" class="btn btn-success">Encrypt</button>
                </form>
            </div>
        </div>
        <div class="tab-pane fade <?php if(isset($_SESSION['DES_operation']) && $_SESSION['DES_operation']=='decryption') echo ' show active'; ?>" id="pills-profile" role="tabpanel" aria-labelledby="pills-decryption-tab" tabindex="0">
            <div class="shadow pb-4 px-4 border border-primary">
                <h6 class="text-center p-2 bg-primary text-white">DES Decryption </h6>
                <form action="api/des.php" method="post" id="decryptionForm">
                    <div class="form-group mb-3">
                        <label for="cipher_text">
                            Cipher Text
                        </label>
                        <textarea class="form-control mw-100 mh-100" placeholder="Enter plain text" name="cipher_text"  id="cipher_text" required></textarea>
                        <textarea  name="des_cipher_text"  id="des_cipher_text" readonly hidden><?php if(isset($_SESSION['cipher_text'])) echo $_SESSION['cipher_text']; ?></textarea>
                    </div>
                    <div class="input-group mb-3"> 
                        <span class="input-group-text">
                            <i class="fa-solid fa-key"></i>
                        </span>
                        <div class="form-floating">
                            <input type="text" class="form-control" name="key" minlength="8" maxlength="8" placeholder="key" id="encryption_key" required>
                            <label for="encryption_key">Key</label>
                        </div>
                        <input type="text" name="DES_operation" id="" value="decryption" hidden>
                    </div>
                    <button  id="cancelBtn" class="btn btn-danger">Cancel</button>
                    <button type="reset" id="resetButton2" class="btn btn-secondary">Reset</button>
                    <button type="submit" name="submit" class="btn btn-success">Decrypt</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" id="openModalButton" hidden>
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" hidden>
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closeModalButton"></button>
      </div>
      <div class="modal-body">
        <div class="d-flex justify-content-center align-center">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
            </div>
            <div class="spinner-border text-secondary" role="status">
            <span class="visually-hidden">Loading...</span>
            </div>
            <div class="spinner-border text-success" role="status">
            <span class="visually-hidden">Loading...</span>
            </div>
            <div class="spinner-border text-danger" role="status">
            <span class="visually-hidden">Loading...</span>
            </div>
            <div class="spinner-border text-warning" role="status">
            <span class="visually-hidden">Loading...</span>
            </div>
            <div class="spinner-border text-info" role="status">
            <span class="visually-hidden">Loading...</span>
            </div>
            <div class="spinner-border text-light" role="status">
            <span class="visually-hidden">Loading...</span>
            </div>
            <div class="spinner-border text-dark" role="status">
            <span class="visually-hidden">Loading...</span>
            </div>
        </div>
      </div>
      <div class="modal-footer" hidden>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
<script>
	$(document).ready(function () {
        var des_operation = $('#des_operation');
        if(des_operation.val()=='encryption'){
            $('#success-div-encrypted').show('');
            $('#success-div-decrypted').hide('');

        }
        else {
            $('#success-div-encrypted').hide('');
             $('#success-div-decrypted').show('');
        }
       
        $('#pills-decryption-tab').click(function (event){
           $('#success-div-encrypted').hide('');
           $('#success-div-decrypted').show('');
        });

        $('#pills-encryption-tab').click(function (event){
            $('#success-div-encrypted').show('');
           $('#success-div-decrypted').hide('');
        });
        
        // Tastr seetings 
		toastr.options.closeMethod = 'fadeOut';
		toastr.options.closeDuration = 5000;
		toastr.options.extendedTimeOut = 5000; // How long the toast will display after a user hovers over it
		toastr.options.closeEasing = 'swing';
		toastr.options.closeButton = true;
		toastr.options.progressBar = true;


        $('#cancelBtn').click(function(event){
            event.preventDefault();
            location.reload();
        });

        $('#encryptionForm').submit(function (event){
            event.preventDefault();

            $('#openModalButton').click();
			var form_data = new FormData(this);
            form_data.append('DES_operation','encryption');

            /**
			 * using fetch api for the ajax request.
			 * @documentation link  https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API/Using_Fetch
			*/
			fetch('api/des.php', {
				method: "POST", 
				body: form_data,
                headers: {
                    'Accept': 'application/json'
                },
			})
			// Get the browser response 
			.then((response) => {
				if(!response.ok){
					// alert the browser response error
                    $('#closeModalButton').click();

					toastr.error(response.statusText);
                    $('#error-div').show('');
                    $('#error-message').append('<p>'+response.statusText+'</p>')	;		

					// Get the server response
					response.json().then((promise) => {
						toastr.error(promise.message);
						/* this is an example for new snippet extension make by me xD */
						if(promise.errors)
						$('#error-div').show('');
						for(const error of Object.entries(promise.errors))	
							$('#error-message').append('<p>'+error+'</p>')	;		
					});
				}else {
					 
					// Get the server response
					response.json().then((promise) => {
						if(promise.status==200){
                            toastr.success(promise.message);
							$('#success-div').show('');
							$('#success-div').append('<p>'+promise.message+'</p>')	;
							$('#clear-button').click;
                            location.reload()

						}else{
                            toastr.error(promise.message);
							$('#error-div').show('');
							/* this is an example for new snippet extension make by me xD */
							$('#error-div').append('<p>'+promise.message+'</p>');
                            location.reload()
						}	
					})
				}
			})
			.catch((error) => {
                $('#closeModalButton').click();
				toastr.error(error);
			});
        });

        $('#decryptionForm').submit(function (event){
			event.preventDefault();
            $('#openModalButton').click();
			var form_data = new FormData(this);
            form_data.append('DES_operation','decryption');

            /**
			 * using fetch api for the ajax request.
			 * @documentation link  https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API/Using_Fetch
			*/
			fetch('api/des.php', {
				method: "POST", 
				body: form_data,
                headers: {
                    'Accept': 'application/json'
                },
			})
			// Get the browser response 
			.then((response) => {
				if(!response.ok){
                    $('#closeModalButton').click();

					// alert the browser response error
					toastr.error(response.statusText);
                    // $('#error-div').show('');
                    // $('#error-message').append('<p>'+response.statusText+'</p>')	;		
                    
					// Get the server response
					response.json().then((promise) => {
						console.log(promise);	
					});
				}else {
					 
					// Get the server response
					response.json().then((promise) => {
						if(promise.status==200){
                            toastr.success(promise.message);
							$('#success-div').show('');
							$('#success-div').append('<p>'+promise.message+'</p>')	;
							$('#clear-button').click;
                           
                            location.reload()

						}else{
                            toastr.error(promise.message);
							$('#error-div').show('');
							/* this is an example for new snippet extension make by me xD */
							$('#error-div').append('<p>'+promise.message+'</p>');
                            location.reload()
						}	
					})
				}
			})
			.catch((error) => {
                $('#closeModalButton').click();
				toastr.error(error);
			});
        });
        $('#resetButton1').click(function (){
            $('#openModalButton').click();

			fetch('api/reset.php', {
				method: "POST",             
			})
			// Get the browser response 
			.then((response) => {
				if(!response.ok){
                    $('#closeModalButton').click();

					toastr.error(response.statusText);
                }else{
                    location.reload()
                }
				
			})
			.catch((error) => {
                $('#closeModalButton').click();
				toastr.error(error);
			});
        });
        $('#resetButton2').click(function (){
            $('#openModalButton').click();

			fetch('api/reset.php', {
				method: "POST",             
			})
			// Get the browser response 
			.then((response) => {
				if(!response.ok){
                    $('#closeModalButton').click();

					toastr.error(response.statusText);
                }else{
                    location.reload()
                }
				
			})
			.catch((error) => {
                $('#closeModalButton').click();
				toastr.error(error);
			});
        });
       
        $('#copyButtonCipherText').click(function (){
            // Get the text field
            var copyable = document.getElementById('copyableCipherText');
            // Select the text field
            copyable.select();
            copyable.setSelectionRange(0, 99999); // For mobile devices

            // Copy the text inside the text field
            navigator.clipboard.writeText(copyable.value);
            toastr.success("Copied");
        });
        $('#copyButtonPlainText').click(function (){
            // Get the text field
            var copyable = document.getElementById('copyablePlainText');
            // Select the text field
            copyable.select();
            copyable.setSelectionRange(0, 99999); // For mobile devices

            // Copy the text inside the text field
            navigator.clipboard.writeText(copyable.value);
            toastr.success("Copied");
        });        
        
    });
</script>
</body>
</html>
<?php
//    unset($_SESSION['cipher_text']);
//    unset($_SESSION['plain_text']);
//    unset($_SESSION['DES_operation']);
   unset($_SESSION['error']);
   ?>