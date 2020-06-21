getData();
function getData() {
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
        {
            // document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
            let data = JSON.parse(xmlhttp.responseText);
            let country = document.getElementById("country");
            let city = document.getElementById("city");

            for (let key in data){
                let option_country = document.createElement("option");
                option_country.innerHTML = key + "";
                country.appendChild(option_country);
            }
            country.addEventListener('change',select,false);

            function select() {
                let choice = (country.options[country.selectedIndex]).innerHTML;

                let options = city.children;
                for (let k = 0; k < options.length; k++){
                    city.removeChild(options[k--]);
                }

                for (let i in data[choice]) {
                    let option_city = document.createElement("option");
                    option_city.innerHTML = data[choice][i] + "";
                    city.appendChild(option_city);
                }
            }

        }
    };
    xmlhttp.open("GET","../forPhp/text.php",true);
    xmlhttp.send();
    // return data;
}