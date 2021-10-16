<?php 

    if($_GET['city'])
    {
        
      $_GET['city']=str_replace(' ', '', $_GET['city']);
      $forecast = "";
      $error = "";
      $file_headers = @get_headers("https://www.weather-forecast.com/locations/".$_GET['city']."/forecasts/latest");
      if($file_headers[0] == 'HTTP/1.1 404 Not Found')
      {
        $error = "Could not find the city!";
      }else{
          
        $weatherPage = file_get_contents("https://www.weather-forecast.com/locations/".$_GET['city']."/forecasts/latest");
        $textsplit = explode("Weather Today</h2> (1&ndash;3 days):</div><p class=\"location-summary__text\"><span class=\"phrase\">", $weatherPage);
        if(sizeof ($textsplit) > 1){
            $textsplit2 = explode("</span></p></div>", $textsplit[1]);  
            if(sizeof ($textsplit2)>1)
            {
                $forecast = $textsplit2[0];
            } else{
                $error = "Could not find the weather forecast information!";
            }
        }
        else
        {
            $error = "No information!"; 
        }
      }
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>WeatherApp</title>
    <style type = "text/css">
        html { 
            background: url(back.jpg) no-repeat center center fixed; 
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
        body{
            background: none;
        }
        .container{
            font-weight: bold;
            font-family: 'Times New Roman', Times, serif;
            text-align: center;
            margin-top: 220px;
            width: 600px;
        }
        input{
            margin-top: 30px;
        }
        #weather{
            margin:20px;
        }
    </style>
  </head>
  <body>
    <div class = "container">
        <h1>What's the Weather?</h1>
        <form>
            <div class="form-row align-items-center">
              <div class="col-auto">
                <label class="sr-only" for="city">Enter the name of a city</label>
                <input type="text" class="form-control mb-2" id="city" name="city" placeholder="e.g., London" value="<?php echo $_GET['city'];?>">
              </div>
              <div class="col-auto">
                <button type="submit" class="btn  btn-outline-light btn-lg">Search</button>
              </div>
            </div>
        </form>
        <div id = "weather">
            <?php
            if ($forecast){
                echo '<div class="alert alert-info" role="alert">'.$_GET['city']." : ".$forecast.'</div>';
            }
            else if($error){
                echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
            }
            
            ?>
            
        </div>
    </div>
    
    <!-- Optional JavaScript; choose one of the two! -->
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>