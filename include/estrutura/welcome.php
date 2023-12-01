<div class="margin">
		<h5 class="mb-0 _200"><?php if (login_check($mysqli) == true): ?>
                        Olá <?php echo $_SESSION['username']; ?>, bem vindo(a) ao Orquestra!
						 
                                                                   <?php
                                    if(isset($_GET["msg"])){
                                        echo base64_decode($_GET["msg"]);
                                    }
                                    ?> 
                         <?php else : ?>
                                
                                <span class="error">Você não tem autorização para acessar esta página.</span> Por favor faça seu <a href="../index.php">login</a>.
                                
                        <?php endif; ?></h5><small class="text-muted"></small>
		
	</div>

	