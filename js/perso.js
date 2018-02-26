var geocoder;

function initMap() {
    geocoder = new google.maps.Geocoder();
}


// A exécuter une fois le document chargé
$(document).ready(function() {

//météo
    $("#btn-meteo").click(function() {
        event.preventDefault();//pour ne pas soumettre le formulaire associé
        var latitude = $("#latitude").val();
        // Si les coordonnées ne sont pas définies on centre sur Londres
        if (latitude == "") {
            latitude = 51.5085300;
        }
        var longitude = $("#longitude").val();
        if (longitude == "") {
            longitude = -0.1257400;
        }
        var url = "http://api.openweathermap.org/data/2.5/weather?APPID=3197fe41f1e53852ea7c7bc7da7e9fec&lat=" + latitude + "&lon=" + longitude;
        $.getJSON(url, function(data) {
            //var info = data.weather[0].main; -> donne le temps
            var info = "Il fait actuellement " + Math.round(data.main.temp - 273.15) + "° Celsius";
            //// il faut soustraire car la température est en Kelvin…
            alert(info);
        });
    });
    //fonction remplissant les champs du formulaire avec des coordonnées GPS en argument

    function remplir(position) {
        $("#latitude").val(position.coords.latitude);
        $("#longitude").val(position.coords.longitude);
    }

    // bouton de géolocalisation
    $("#btn-geoloc").click(function() {
        event.preventDefault();//pour ne pas soumettre le formulaire associé
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(remplir);
        }
        else {
            alert("géolocalisation non supportée");
        }
    });

    var map;
    function initialize(lat, lon) {
        var mapOptions = {
            zoom: 15,
            center: new google.maps.LatLng(lat, lon)
        };
        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
    }

    // bouton affichage de la carte
    $("#btn-carte").click(function() {
        event.preventDefault();//pour ne pas soumettre le formulaire associé
        // affichage de la carte
        var latitude = $("#latitude").val();
        // Si les coordonnées ne sont pas définies on centre sur Londres
        if (latitude == "") {
            latitude = 51.5085300;
        }
        var longitude = $("#longitude").val();
        if (longitude == "") {
            longitude = -0.1257400;
        }
        initialize(latitude, longitude);
        // ajout du marqueur
        var myLatlng = new google.maps.LatLng(latitude, longitude);
        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            title: 'Ma position'
        });
    });



    function codeAddress(address) {
        geocoder.geocode({'address': address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                $("#latitude").val(results[0].geometry.location.lat());
                $("#longitude").val(results[0].geometry.location.lng());
            } else {
            }
        });
    }


    $("#btn-geocode").click(function() {
        event.preventDefault();//pour ne pas soumettre le formulaire associé
        var address = $("#adresse").val();
        if (address === "") {//adresse par défaut
            address = "Paris, Texas";
            
        }
        codeAddress(address);
    });


});