// 5307732125531191
const checkOut=()=>{
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if(xhr.readyState == 4){
            console.log(xhr.responseText);
            const response = JSON.parse(xhr.responseText);
            const payment = response.payment;
            console.log(payment);
            payhere.startPayment(payment);
        }
    }
    xhr.open("GET","process/checkout.php");
    xhr.send();
}

payhere.onCompleted = function onCompleted(orderId) {
    console.log("Payment completed. OrderID:" + orderId);
    // Note: validate the payment and show success or failure page to the customer
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if(xhr.readyState == 4){
            console.log(xhr.responseText);
            // const response = JSON.parse(xhr.responseText);
            // const payment = response.payment;
            // console.log(payment);
            // payhere.startPayment(payment);
        }
    }
    xhr.open("GET","process/clientcompletePayment.php?orderID="+orderId);
    xhr.send();
    loadCartData();
};

// Payment window closed
payhere.onDismissed = function onDismissed() {
    // Note: Prompt user to pay again or show an error page
    console.log("Payment dismissed");

};

// Error occurred
payhere.onError = function onError(error) {
    // Note: show an error page
    console.log("Error:"  + error);
};

// Put the payment variables here
var payment = {
    "sandbox": true,
    "merchant_id": "1221323",    // Replace your Merchant ID
    "return_url": "google.com",     // Important
    "cancel_url": "google.com",     // Important
    "notify_url": "http://sample.com/notify",
    "order_id": "ItemNo12345",
    "items": "Door bell wireles",
    "amount": "1000.00",
    "currency": "LKR",
    "hash": "45D3CBA93E9F2189BD630ADFE19AA6DC", // *Replace with generated hash retrieved from backend
    "first_name": "Saman",
    "last_name": "Perera",
    "email": "samanp@gmail.com",
    "phone": "0771234567",
    "address": "No.1, Galle Road",
    "city": "Colombo",
    "country": "Sri Lanka",
    "delivery_address": "No. 46, Galle road, Kalutara South",
    "delivery_city": "Kalutara",
    "delivery_country": "Sri Lanka",
    "custom_1": "",
    "custom_2": ""
};

const buyNow=(productID)=>{
    AddToCart(productID);

    const myModal = new bootstrap.Modal(document.getElementById('cartModal'));
    myModal.show();

    loadCartData();
}