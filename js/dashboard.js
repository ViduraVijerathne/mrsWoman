const loadDashboardChart =()=>{
    const ctx = document.getElementById('myLineChart').getContext('2d');

    const xhr= new XMLHttpRequest();
    xhr.open("GET","process/totalSalesProcess.php",true)
    xhr.onreadystatechange = function (){
        if(xhr.readyState == 4){
            const response = JSON.parse(xhr.responseText);
            if(response.statusCode == 1){
                const dataMap = response.body;
               // const dataMap = {
               //     "2023 Jul": 0,
               //     "2023 Aug": 0,
               //     "2023 Sep": 0,
               //     "2023 Oct": 0,
               //     "2023 Nov": 0,
               //     "2023 Dec": 0,
               //     "2024 Jan": 0,
               //     "2024 Feb": 0,
               //     "2024 Mar": 0,
               //     "2024 Apr": 253,
               //     "2024 May": 106,
               //     "2024 Jun": 104
               // }



                const data = {
                    labels: Object.keys(dataMap),
                    datasets: [{
                        label: 'Last Year Sales',
                        fill: true,
                        backgroundColor: 'rgba(45,47,47,0.2)',
                        borderColor: 'rgb(0,0,0)',
                        pointBackgroundColor: 'rgb(0,0,0)',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: 'rgb(0,0,0)',
                        data: Object.values(dataMap),
                        curve:10,
                        
                    }]
                };

                const config = {
                    type: 'line',
                    data: data,

                    options: {
                        responsive: true,

                        scales: {
                            x: {
                                display: true,
                                title: {
                                    display: true,
                                    text: 'Month'
                                }
                            },
                            y: {
                                display: true,
                                title: {
                                    display: true,
                                    text: 'Value'
                                }
                            }
                        }
                    }
                };

                const myLineChart = new Chart(ctx, config);

            }else{
                showErrorToast("Cannot load Chart","Something went wrong please refresh the page")
            }
        }
    }
    xhr.send();


}

const  addQuantityToStock=(id,panelID)=>{
    const addedQty = document.getElementById('addStockField_'+id).value;
    const form = new FormData();
    form.append("id",id);
    form.append("qty",addedQty);
    if(addedQty <= 0 ){
        showErrorToast("Input Error","please add valid quantity")
        return;
    }
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function (){
        if(xhr.readyState === 4){
            const response = JSON.parse(xhr.responseText);
            if(response.statusCode === 1){
                if(panelID !=null){
                    loadAdminPages(panelID)
                }
            }else{
                showErrorToast("Error",response.message)
            }
        }

    }
    xhr.open('POST',"process/addQuantityToStock.php",true)
    xhr.send(form);

}