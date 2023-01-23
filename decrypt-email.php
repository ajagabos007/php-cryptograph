<?php 
    session_start();
    require __DIR__.'/vendor/autoload.php';
    require __DIR__.'/connections/databases/MysqlConnection.php';
    use connections\database\MysqlConnection;

    // Create Database Coonection
    $mysql_db = new MysqlConnection();
    $mysql_con = $mysql_db->connect();

    $valid_link = false;
    $operational_log = null;
    $decrypted_succesfully = false;
    $error = null;
    $success = null;

    if ($_SERVER['REQUEST_METHOD'] == 'GET'){
        try {
            $request = [
                'res' => $_REQUEST['res']?? null,
                'des_operation' => $_REQUEST['des_operation']?? null,
                'salt' => $_REQUEST['salt']?? null,
                'uuid' => $_REQUEST['uuid']?? null,
                'hash' => $_REQUEST['hash']?? null,
            ];
            if($request['uuid']){
                foreach ($request as $key => $value) {
                    if($value==null){
                        throw new Exception("The link is invalid or broken:".$key." query string is missing",1);
                        continue;
                    }
                }

                // get the operation log to save the mailable 
                $uuid = $request['uuid'];
                $sql_query = "SELECT * FROM `operational_logs` WHERE `uuid` = '$uuid'  LIMIT 1 ";
                $result = $mysql_con->query($sql_query);
                if ($result->num_rows <= 0) 
                    // throw new Exception("Error Processing Request: ".$sql_query . "<br/>" . $mysql_con->error."<br/>", 1);
                    throw new Exception("Error Processing Request, invalid or broken link", 1);
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    $operational_log =  $row;
                    $valid_link=true;
                    continue;
                }

            }else
                throw new Exception("The link is invalid or broken",1);
            
        } catch (\Throwable $th) {
            $error = $th;
        }
          
    }
   
    $_SESSION['title'] = "Home";
    include_once("header.php"); 
?>
    <h2 class="text-center p-2 fs-4 bg-light"> 
        MATERIAL SECURE REMOTE COMMUNICATION USING DES
    </h2>
    <div class="p-4 pb-0 pt-0 border border-primary">
        <h6 class="p-2 mb-4 fs-5 pt-0  bg-primary text-white">Decryption Email Form</h6>
            <?php if(!is_null($error)) { ?>
            <div class="alert alert-danger alert-dismissible fade show" id="error-div" role="alert">
                <strong>Error..!!!</strong> <span id="error-message"><?php echo $error; ?></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php } ?>
           
        <?php if($valid_link) { ?>
            <form action="api/decrypt-mail.php" method="POST" id="decryption_mail_form">
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Encrypted Message</label>
                    <textarea name="message" class="form-control" id="exampleFormControlTextarea1" rows="1" placeholder="encrypted message" readonly disabled><?php echo $operational_log['des_result'] ?></textarea>
                </div>
                <div class="mb-3" id="decrypted-div">
                    <label for="exampleFormControlTextarea1" class="form-label text-success ">Decrypted Message <i class="fa-solid fa-check"></i></label>
                    <textarea name="message" class="form-control" rows="6" placeholder="Decrypted message"  id="decrypted-text-area" readonly disabled></textarea>
                </div>
                    
                <?php if ($operational_log) { ?>
                    <input type="text" class="form-control" name="uuid"  placeholder="uuid" id="uuid" hidden value="<?php echo $operational_log['uuid']?? null ?>">
                <?php } ?>

                <div class="input-group mb-3"> 
                    <span class="input-group-text">
                        <i class="fa-solid fa-key"></i>
                    </span>
                    <div class="form-floating">
                        <input type="text" class="form-control" name="key"  placeholder="key" id="dencryption_key" required>
                        <label for="key">Enter key</label>
                    </div>
                </div>           
                <a href="index.php" class="btn btn-lg btn-danger mb-3">Cancel</a>                
                <button type="submit" class="btn btn-lg btn-primary mb-3">Decrypt</button>
            </form>
        <?php  } else { ?>
            <p class="text-danger">We can not proceed with this request. kindly check your email for right link or cancel the operation </p>
            <a href="index.php" class="btn btn-lg btn-danger mb-3">
                Cancel
            </a>
        <?php } ?>
       
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
        $('#decrypted-div').hide();

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

            $('#decryption_mail_form').submit(function (event){
                event.preventDefault();
                $('#error-div-js').hide('');
                $('#success-div').hide('');
                $('#openModalButton').click();
                $('#modal-body').html(spinner);
                $("#modal-footer").hide();
                var form_data = new FormData(this);

                /**
                 * using fetch api for the ajax request.
                 * @documentation link  https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API/Using_Fetch
                */
                fetch('api/decrypt-mail.php', {
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
                        $('#error-message').append('<p>'+response.statusText+'</p>')	;		

                        // Get the server response
                        response.json().then((promise) => {
                            toastr.error(promise.message);
                            /* this is an example for new snippet extension make by me xD */
                            if(promise.errors)
                            for(const error of Object.entries(promise.errors))	
                                toastr.error(error);
                        });
                        $('#footerCloseModalButton').click();

                    }else {
                        // Get the server response
                        response.json().then((promise) => {
                            if(promise.status==200){
                                toastr.success(promise.message);
                                $('#decrypted-div').show();
                                $('#decrypted-text-area').val(promise.des_text);
                                $("#modal-footer").show();
                                $("#modal-body").html('<p class="text-success">'+promise.des_text+'</p>');
                                $('#closeModalButton').click();
                                $('#resetBtn').click();
                            }else{
                                toastr.error(promise.message);
                                $("#modal-footer").show();
                                $("#modal-body").html('<p class="text-danger">'+promise.message+'</p>');
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
            
        });
    </script>

<?php 
    include_once("footer.php")
?>