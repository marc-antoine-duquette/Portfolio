<!DOCTYPE html>
<html lang="en" style="background-color: #eee;">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Portfolio</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
    	<link rel="stylesheet" href="../css/bootstrap.min.css">
    	<link rel="stylesheet" href="css/style.css">
  		<script src="https://js.stripe.com/clover/stripe.js"></script>
    </head>
    
    <body id="page-top">
    	<section style="background-color: #eee;">
			<div class="container py-5">
				<div class="row d-flex justify-content-center align-items-center">
					<div class="col">
						<div class="card shopping-cart" style="border-radius: 15px;">
							<div class="card-body">
								<div id="infos" class="row">
									<div class="col-lg-6 px-5 py-4">
										<h3 class="mb-5 pt-2 text-center fw-bold text-uppercase">Vos produits</h3>
										<div>
    										<form id="itemsForm" class="mb-3">
<?
    											function Hs($str){
													return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
												}
    											$items = json_decode(file_get_contents("items.json"), true);
												foreach ($items as $item){
?>
												<div class="d-md-flex d-block align-items-center mb-5 text-md-start text-center">
													<div class="flex-shrink-0 col-12 col-md-auto">
														<img src="<?= $item["img"] ?>" class="img-fluid" style="width: 150px;" alt="Generic placeholder image">
													</div>
													<div class="flex-grow-1 ms-3 col-12 col-md-auto">
														<a href="#!" class="delete-item float-end text-danger"><i class="fas fa-times"></i></a>
														<h5 class="text-primary"><?= Hs($item["name"]) ?></h5>
														<h6 style="color: #9e9e9e;">Couleur: <?= Hs($item["color"]) ?></h6>
														<div class="d-md-flex d-block align-items-center">
															<p class="fw-bold mb-0 me-0 me-md-5 pe-0 pe-md-3"><?= Hs($item["price"]) ?> $</p>
															<div class="def-number-input number-input safari_only w-auto">
																<button data-mdb-button-init class="minus stepDown" type="button"></button>
                                        		            	<input type="hidden" name="id" value="<?= Hs($item["id"]) ?>" />
                                        		            	<input type="hidden" name="price" value="<?= Hs($item["price"]) ?>" />
																<input class="quantity fw-bold bg-body-tertiary text-body" min="0" name="quantity" value="<?= Hs($item["initialAmount"]) ?>" type="number">
																<button data-mdb-button-init class="plus stepUp" type="button"></button>
															</div>
														</div>
													</div>
												</div>

<?
                                        		}
?>
												<hr class="mb-4" style="height: 2px; background-color: #1266f1; opacity: 1;">
			
												<? /*
												<div class="d-flex justify-content-between px-x">
													<p class="fw-bold">Rabais:</p>
													<p class="fw-bold">95$</p>
												</div>
                                        		*/ ?>
												<div class="d-flex justify-content-between p-2 mb-2 bg-light">
													<h5 class="fw-bold mb-0">Total:</h5>
													<h5 id="total" class="fw-bold mb-0">2356$</h5>
												</div>
											</form>
										</div>
									</div>
									<div id="details" class="col-lg-6 px-5 py-4">
										<div>
											<h3 class="mb-5 pt-2 text-center fw-bold text-uppercase">Détails</h3>
                                        	<h5 class="fw-bold mb-3">
                                        	    <p>Utilisez des cartes de test pour "payer"</p>
												<a href="https://docs.stripe.com/testing?locale=fr-CA#cards" target="_blank"><i class="fa-solid fa-credit-card me-2"></i>Cartes de test</a>
											</h5>
                                        </div>
                                        <button id="btnSubmit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block btn-lg">Confirmer</button>
									</div>
<? /*
									<div class="col-lg-6 px-5 py-4">
										<form class="mb-5">
											<div data-mdb-input-init class="form-outline mb-5">
												<label class="form-label" for="cardNumber">Numéro</label>
												<input type="text" id="cardNumber" class="form-control form-control-lg" name="cardNumber" autocomplete="cc-number" inputmode="numeric" pattern="[0-9]*" minlength="13" maxlength="19" required />
											</div>
											<div data-mdb-input-init class="form-outline mb-5">
												<label class="form-label" for="cardName">Nom</label>
												<input type="text" id="cardName" class="form-control form-control-lg" name="cardName" autocomplete="cc-name" required />
											</div>
											<div class="row">
												<? /*<div class="col-md-6 mb-5">
													<div data-mdb-input-init class="form-outline">
														<label class="form-label" for="cardExp">Expiration</label>
														<input type="text" id="cardExp" class="form-control form-control-lg" autocomplete="cc-exp" size="7" name="cardExp" id="exp" minlength="7" maxlength="7" required />
													</div>
												</div>*/ /* ?>
												<div class="col-md-6 mb-5">
													<div data-mdb-input-init class="form-outline">
														<label class="form-label" for="cardCvc">Cvv</label>
														<input type="password" id="cardCvc" class="form-control form-control-lg" autocomplete="cc-csc" size="1" name="cardCvc" minlength="3" maxlength="3" required />
													</div>
												</div>
											</div>
                                            <div id="error" class="alert alert-danger" style="display: none;">Le paiement a échoué. Veuillez réessayer</div>
											<button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block btn-lg">Payer</button>
                                            <div id="spinner" style="display: none;">
                                            	<div class="spinner-border" role="status">
													<span class="sr-only">Loading...</span>
												</div>
                                            </div>
										</form>
									</div>
*/ ?>
								</div>
								<div id="checkout" style="display: none;">
									<!-- Checkout will insert the payment form here -->
								</div>
								<div id="success" class="alert text-center" style="display: none;">
                                    <div>
                                        <i class="fa-solid fa-check" style="font-size: 2rem;"></i>
                                    </div>
                                    <h5>Le paiement a été complété avec succès</h5>
                                    <a href="index.php" class="btn btn-primary">Retour</a>
                                </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
        
        <!-- Footer-->
        <footer class="footer bg-black small text-center text-white-50"></footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="jquery.min.js"></script>

		<script defer>
            //code en js
            function UpdateTotal(){
                var totalPrice = 0;
                document.getElementsByName("price").forEach(element => {
                    let price = parseFloat(element.value);
                    let qtVal = element.parentNode.querySelector("[name=quantity]").value;
                    if (qtVal == ""){
                        qtVal = 0;
                    }
                    let quantity = parseFloat(qtVal);
                    totalPrice += price * quantity;
                });
                
                document.querySelector("#total").innerText = totalPrice + " $";
            }
            
            UpdateTotal();
            
            document.querySelectorAll(".delete-item").forEach(element => {
                element.addEventListener("click", function(event){
                    element.parentNode.parentNode.remove();
                    UpdateTotal();
                });
            });
            
            document.getElementsByName("quantity").forEach(element => {
                element.addEventListener("input", function(event){
                    UpdateTotal();
                });
            });
            
            document.querySelectorAll(".stepUp").forEach(element => {
                element.addEventListener("click", function(event){
                	element.parentNode.querySelector('input[type=number]').stepUp()
                    UpdateTotal();
                });
            });
            
            document.querySelectorAll(".stepDown").forEach(element => {
                element.addEventListener("click", function(event){
                	element.parentNode.querySelector('input[type=number]').stepDown()
                    UpdateTotal();
                });
            });
            
            // Initialize Stripe.js
			const stripe = Stripe('pk_test_51SziPOKIPrI6ulAkZCFYlG7Pa1hOMFYa45vA0SyimnKk4uq0JXLHwScQ1gTye2AROgVdtMhhfTvRAi96uZAbKhBe00a8fOPu0d');
			
			// Fetch Checkout Session and retrieve the client secret
			async function initializeCheckout() {
                let items = [];
                
                $("input[name=id]").each(function () {
					items.push({
					    id: $(this).val(),
					    qte: $(this).parent().find("input[name=quantity]").val()
					});
                });
                
				const fetchClientSecret = async () => {
					const response = await fetch("create-checkout-session.php", {
						method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ items }),
					});
			    	const { clientSecret } = await response.json();
			    	return clientSecret;
				};
                
                const handleComplete = async function() {
					checkout.destroy();
                    $("#checkout").remove();
                    $("#success").show();
                    $(".htmlContainer").css("height", "100%");
                    $(".htmlContainer").removeClass("htmlContainer");
				}
			
				// Initialize Checkout
				const checkout = await stripe.initEmbeddedCheckout({
					fetchClientSecret,
					onComplete: handleComplete
				});
			
				// Mount Checkout
				checkout.mount('#checkout');
			}
            
            let isPaying = false;
            
            //code jquery
            $("#btnSubmit").click(function(ev){
                isPaying = !isPaying;
                ev.preventDefault();
                
                if (isPaying){
                    initializeCheckout();
                    //TODO update the cart here
                    $("#infos").hide();
                	$("#checkout").show();
                    $("#return").show();
                    $("#confirm").hide();
                    $(".delete-item").hide();
                	
                	$(".def-number-input button").hide();
                	$(".def-number-input input").prop("disabled", true);
                }
                else{
                    $("#infos").show();
                	$("#checkout").hide();
                    $("#return").hide();
                    $("#confirm").show();
                    $(".delete-item").show();
                	
                	$(".def-number-input button").show();
                	$(".def-number-input input").prop("disabled", false);
                }
                
                return false;
            });
            /*$("form").submit(function(ev){
                ev.preventDefault();
                let items = [];
                
                $("input[name=id]").each(() => {
                    items.push({"id": $(this).val(), "qte": $(this).parent().find("input[name=quantity]").val()});
                });
                
                $("#spinner").show();
                
                $.post("create-checkout-session.php", {"items": items}, function(data, status){
                    window.location.href = data;
                	$("#spinner").hide();
                    $("#error").hide();
                }).fail(function(){
                    $("#error").show();
                	$("#spinner").hide();
                });
                
                return false;
            });*/
		</script>
    </body>
</html>
