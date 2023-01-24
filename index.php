<?php 
    session_start();
    $_SESSION['title'] = "Home";
    include_once("header.php"); 
?>
    <h2 class="text-center p-2 fs-4 bg-light"> 
        MATERIAL SECURE REMOTE COMMUNICATION USING DES
    </h2>
    <div class="p-4 pb-0 pt-0 border border-primary">
        <h6 class="p-2 mb-4 fs-5 pt-0  bg-primary text-white">Send Encrypted Email Form</h6>
            <div class="alert alert-danger alert-dismissible fade show" id="error-div" role="alert">
                <strong>Error..!!!</strong> <span id="error-message">...</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="alert alert-success alert-dismissible fade show" id="success-div" role="alert" >
                <strong>Success..!!!</strong> <span id="success-message">...</span>
                
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <form action="forward-to-email.php" method="POST" id="encryption_mail_form">
            <div class="mb-3 row">
                <div class="col-md-6 mb-2">
                    <div class="input-group"> 
                        <span class="input-group-text">
                            <i class="fa-solid fa-user-tie"></i>
                        </span>
                        <div class="form-floating">
                            <input type="text" class="form-control" name="sender_name" minlength="3" maxlength="20" placeholder="Enter your name" id="sender_name" required>
                            <label for="sender_name">Your name</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <div class="input-group"> 
                        <span class="input-group-text">
                            <i class="fa-solid fa-at"></i>
                        </span>
                        <div class="form-floating">
                            <input type="email" class="form-control" name="sender_email" placeholder="Your email" id="sender_email" required>
                            <label for="sender_email">Your email address</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-md-6 mb-2">
                    <div class="input-group"> 
                        <span class="input-group-text">
                            <i class="fa-solid fa-user-tie"></i>
                        </span>
                        <div class="form-floating">
                            <input type="text" class="form-control" name="receiver_name" minlength="3" maxlength="20" placeholder="Receiver name" id="receiver_name" required>
                            <label for="receiver_name">Receiver's name</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <div class="input-group"> 
                        <span class="input-group-text">
                            <i class="fa-solid fa-at"></i>
                        </span>
                        <div class="form-floating">
                            <input type="email" class="form-control" name="receiver_email" placeholder="Receiver email" id="receiver_email" required>
                            <label for="receiver_email">Receiver's email</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3"> 
                <span class="input-group-text">
                    <i class="fa-solid fa-key"></i>
                </span>
                <div class="form-floating">
                    <input type="text" class="form-control" name="key" minlength="8" maxlength="8" placeholder="key" id="encryption_key" required>
                    <label for="key">Key</label>
                </div>
            </div>
            <div class="input-group mb-3"> 
                <span class="input-group-text">
                    <i class="fa-solid fa-envelope"></i>
                </span>
                <div class="form-floating">
                    <input type="text" class="form-control" name="subject" placeholder="Receiver email" id="subject" required>
                    <label for="subject">Mail Subject</label>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Your Message</label>
                <textarea name="message" class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Enter your plain message"></textarea>
            </div>
            <div class="mb-3">

                <div class="form-check">
                    <input name="send_me_a_copy" class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                    <label class="form-check-label" for="flexRadioDefault1">
                        send me a copy
                    </label>
                </div>
            </div>
            <button type="reset" id="cancelBtn" class="btn btn-lg btn-danger mb-3">Cancel</button>
            <button type="reset" id="resetBtn" class="btn btn-lg btn-secondary mb-3">Reset</button>
            <button type="submit" class="btn btn-lg btn-primary mb-3">Send</button>
        </form>
    </div>   
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" id="openModalButton" hidden>
    Launch demo modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static"  data-bs-keyboard="false">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" hidden>
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closeModalButton"></button>
                </div>
                <div class="modal-body" id="modal-body">
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
                <div class="modal-footer" id="modal-footer">
                    <button type="button" class="btn btn-secondary" id="footerCloseModalButton" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#success-div').hide();
        $('#error-div').hide();
        var spinner = '<div class="d-flex justify-content-center align-center">'
                +'<div class="spinner-border text-primary" role="status">'
                    +'<span class="visually-hidden">Loading...</span>'
                +'</div>'
                +'<div class="spinner-border text-secondary" role="status">'
                    +'<span class="visually-hidden">Loading...</span>'
                +'</div>'
                +'<div class="spinner-border text-success" role="status">'
                    +'<span class="visually-hidden">Loading...</span>'
                +'</div>'
                +'<div class="spinner-border text-danger" role="status">'
                    +'<span class="visually-hidden">Loading...</span>'
                +'</div>'
                +'<div class="spinner-border text-warning" role="status">'
                    +'<span class="visually-hidden">Loading...</span>'
                +'</div>'
                +'<div class="spinner-border text-info" role="status">'
                    +'<span class="visually-hidden">Loading...</span>'
                +'</div>'
                +'<div class="spinner-border text-light" role="status">'
                    +'<span class="visually-hidden">Loading...</span>'
                +'</div>'
                +'<div class="spinner-border text-dark" role="status">'
                    +'<span class="visually-hidden">Loading...</span>'
                +'</div>'
            +'</div>';
        $(document).ready(function () {
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

            $('#encryption_mail_form').submit(function (event){
                event.preventDefault();
                $('#error-div').hide('');
                $('#success-div').hide('');
                $('#openModalButton').click();
                $('#modal-body').html(spinner);
                $("#modal-footer").hide();
                var form_data = new FormData(this);

                /**
                 * using fetch api for the ajax request.
                 * @documentation link  https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API/Using_Fetch
                */
                fetch('forward-to-email.php', {
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
                        $('#footerCloseModalButton').click();

                    }else {
                        // Get the server response
                        response.json().then((promise) => {
                            if(promise.status==200){
                                toastr.success(promise.message);
                                $('#success-div').show();
                                $('#success-message').html('<p>'+promise.message+'</p>');
                                $('#resetBtn').click();
                            }else{
                                toastr.error("Request error");
                                $("#modal-body").html('<p class="text-danger">'+promise.message+'</p>');
                                $("#modal-footer").show();
                                $('#error-div').show();
                                $('#error-message').html('<p>'+promise.message+'</p>');
                            }	

                            $('#closeModalButton').click();
                            
                        })
                    }
                })
                .catch((error) => {
                    $('#closeModalButton').click();
                    $('#exampleModal').hide();
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

<?php 
    include_once("footer.php")
?>