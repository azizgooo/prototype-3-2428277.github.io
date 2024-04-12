<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROTOTYPE 3</title>
    <link rel="stylesheet" href="main.css">
    <script>
        function fetchWeather(city) {
            var cachedData = localStorage.getItem(city);
            if (cachedData) {
                display(JSON.parse(cachedData));
            } else {
                var url = "https://api.openweathermap.org/data/2.5/weather?units=metric&q=" + city + "&appid=2b762a623c4f95e31578d4f66a102bd0";
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        localStorage.setItem(city, JSON.stringify(data));
                        display(data);
                    })
                    .catch(error => {
                        console.error('Error fetching weather data:', error);
                    });
            }
        }

        function display(data) {
            var weatherContainer = document.getElementById('weather');
            weatherContainer.innerHTML = `
                <h1 id="city">${data.name}</h1>
                <h1 id="temp">${data.main.temp}</h1>
                <h1 id="weatherType">${data.weather[0].description}</h1>
                <h1 id="weather_when">${new Date(data.dt * 1000).toLocaleString()}</h1>
            `;
        }

        function handleSubmit(event) {
            event.preventDefault();
            var city = document.getElementById('city1').value;
            fetchWeather(city);
        }

        const searchBox = document.querySelector(".search input");
        const searchBtn = document.querySelector(".search button");
        const weatherIcon = document.querySelector(".weather-icon");


        async function checkWeather(city){
            const response = await fetch(apiUrl + city + `&appid=${apiKey}`);
            if(response.status == 404){
                document.querySelector(".error").style.display = "block";
                document.querySelector(".weather").style.display = "none";
            }else{
            var data = await response.json();
        document.querySelector(".city").innerHTML = data.name;
        document.querySelector(".temp").innerHTML = Math.round(data.main.temp) + "°C";
        document.querySelector(".humidity").innerHTML = data.main.humidity + "%";
        document.querySelector(".wind").innerHTML = data.main.pressure + " mb";

        if(data.weather[0].main == "Clouds"){
            weatherIcon.src = "images/clouds.png";
        }
        else if(data.weather[0].main == "Clear"){
            weatherIcon.src = "images/clear.png";
        }
        else if(data.weather[0].main == "Rain"){
            weatherIcon.src = "images/rain.png";
        }
        else if(data.weather[0].main == "Drizzle"){
            weatherIcon.src = "images/drizzle.png";
        }
        else if(data.weather[0].main == "Mist"){
            weatherIcon.src = "images/mist.png";
        }
        else if(data.weather[0].main == "Snow"){
            weatherIcon.src = "images/snow.png";
        }
        document.querySelector(".weather").style.display = "block";
        document.querySelector(".error").style.display = "none";
       }
    }
        
        searchBtn.addEventListener("click", ()=>{
            checkWeather(searchBox.value);
        })
    </script>
</head>
<body>
    <div class="container">
        <div class="search">
            <form onsubmit="handleSubmit(event)">
                <input type="text" id="city1" name="city"  placeholder="Enter the city name" spellcheck="false">
                <button type="submit">Search</button>
            </form>
        </div>
        <div id="weather" class="weather"></div>
    </div>

    <?php
        if(isset($_GET["btn"]))
        {
            include "saveData.php";
        }
    ?>  

</body>
</html>
