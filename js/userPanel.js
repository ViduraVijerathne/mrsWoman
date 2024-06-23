
var selectedNavBtnID = "10"

const addAddress = ()=>{
    const country = document.getElementById("addAddress_country").value.trim();
    const province = document.getElementById("addAddress_province").value.trim();
    const district = document.getElementById("addAddress_district").value.trim();
    const city = document.getElementById("addAddress_city").value.trim();
    const postalcode = document.getElementById("addAddress_postalcode").value.trim();
    const address = document.getElementById("addAddress_address").value.trim();
    const contact = document.getElementById("addAddress_contact").value.trim();

    // Regular expressions for validation
    const postalCodePattern = /^[0-9]{5}(?:-[0-9]{4})?$/; // Example for US ZIP codes
    const contactPattern = /^[0-9]{10}$/; // Example for a 10-digit phone number


    // Validation checks
    if (!country) {
        showErrorToast("Error","Country is required");
        return ;
    }
    if (!province) {
        showErrorToast("Error","Province is required");
        return ;
    }
    if (!district) {
        showErrorToast("Error","District is required");
        return ;
    }
    if (!city) {
        showErrorToast("Error","City is required");
        return ;
    }
    if (!postalcode) {
        showErrorToast("Error","Postal code is required");
        return ;
    }
    if (!postalCodePattern.test(postalcode)) {
        showErrorToast("Error","Invalid postal code format");
        return ;
    }
    if (!address) {
        showErrorToast("Error","Address is required");
        return ;
    }if (!contact) {
        showErrorToast("Error", "Contact is required");
        return;
    }
    if (!contactPattern.test(contact)) {
        showErrorToast("Error", "Invalid contact format");
        return;
    }

    const form = new FormData();
    form.append("country",country);
    form.append("province",province);
    form.append("district",district);
    form.append("city",city);
    form.append("postalcode",postalcode);
    form.append("address",address);
    form.append("contact", contact);

    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function (){
        if(xhr.readyState == 4){
            console.log(xhr.responseText)
            const res = JSON.parse(xhr.responseText);
            console.log(res)
            if(res.statusCode == 1){
                showSuccessToast("Success",res.message)
                navigationAdminPanel(12)
            }else{
                showErrorToast("Error",res.message);
            }

        }
    }
    xhr.open("POST","process/addAddressProcess.php",true);
    xhr.send(form);


}


const deleteAddress = (id) => {
    if (confirm("Are you sure you want to delete this address?")) {
        const form = new FormData();
        form.append("address_id", id);
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    const res = JSON.parse(xhr.responseText);
                    if(res.status == 1){
                        showSuccessToast("Success",res.message)
                        navigationAdminPanel(12)
                    }else{
                        showErrorToast("Error",res.message);
                    }

                } else {
                    showErrorToast("error","Error deleting address");
                }
            }
        }
        xhr.open("POST", "process/deleteAddressProcess.php", true);
        xhr.send(form);
    }
}