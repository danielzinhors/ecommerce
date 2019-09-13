<?php
use \Hcode\Model\Cart;
use \Hcode\Model\Address;
use \Hcode\Model\User;
use \Hcode\Model\Order;
use \Hcode\Model\OrderStatus;

$app->get('/checkout', function() {

    User::verifyLogin(false);

    $cart = Cart::getFromSession();

    $address = new Address();
    if (!isset($_GET['zipcode'])) {
		    $_GET['zipcode'] = $cart->getdeszipcode();

	  }
    if (isset($_GET['zipcode'])){
        $address->loadFromCep($_GET['zipcode']);
        $cart->setdeszipcode($_GET['zipcode']);
        $cart->save();
        $cart->getCalculateTotals();
    }
    if (!$address->getdesaddress()) $address->setdesaddress('');
  	if (!$address->getdesnumber()) $address->setdesnumber('');
  	if (!$address->getdescomplement()) $address->setdescomplement('');
  	if (!$address->getdesdistrict()) $address->setdesdistrict('');
  	if (!$address->getdescity()) $address->setdescity('');
  	if (!$address->getdesstate()) $address->setdesstate('');
  	if (!$address->getdescountry()) $address->setdescountry('');
  	if (!$address->getdeszipcode()) $address->setdeszipcode('');

		chamaTpl("checkout",
        array(
          'cart' => $cart->getValues(),
          'address' => $address->getValues(),
          'products' => $cart->getProducts(),
          'error' => Address::getMsgError()
        ),
        true, true
    );
});

$app->post('/checkout', function() {

    User::verifyLogin(false);

    if (!isset($_POST['zipcode']) || $_POST['zipcode'] === '') {
  		Address::setMsgError("Informe o CEP.");
  		header('Location: /checkout');
  		exit;
  	}

  	if (!isset($_POST['desaddress']) || $_POST['desaddress'] === '') {
    		Address::setMsgError("Informe o endereço.");
    		header('Location: /checkout');
    		exit;
  	}

  	if (!isset($_POST['desdistrict']) || $_POST['desdistrict'] === '') {
    		Address::setMsgError("Informe o bairro.");
    		header('Location: /checkout');
    		exit;
  	}

  	if (!isset($_POST['descity']) || $_POST['descity'] === '') {
    		Address::setMsgError("Informe a cidade.");
    		header('Location: /checkout');
    		exit;
  	}

  	if (!isset($_POST['desstate']) || $_POST['desstate'] === '') {
    		Address::setMsgError("Informe o estado.");
    		header('Location: /checkout');
    		exit;
  	}

  	if (!isset($_POST['descountry']) || $_POST['descountry'] === '') {
    		Address::setMsgError("Informe o país.");
    		header('Location: /checkout');
    		exit;
  	}

    $user = User::getFromSession();

    $address = new Address();
    $_POST['deszipcode'] = $_POST['zipcode'];
    $_POST['idperson'] = $user->getidperson();

    $address->setData($_POST);

    $address->save();

    $cart = Cart::getFromSession();

    $order = new Order();

    $totals = $cart->getCalculateTotal();

    $order->setData(
        array(
            'idcart' => $cart->getidcart(),
            'idaddress' => $address->getidaddress(),
            'iduser' => $user->getiduser(),
            'idstatus' => OrderStatus::EM_ABERTO,
            'vltotal' => $cart->getvltotal()
        )
    );

    $order->save();

    header("Location: /order/" . $order->getidorder() . "/pagseguro");
    exit;

});


 ?>
