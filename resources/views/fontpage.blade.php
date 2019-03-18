<!DOCTYPE html>
<html>
<title>urban</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<style>
body {font-family: "Times New Roman", Georgia, Serif;}
h1,h2,h3,h4,h5,h6 {
    font-family: "Playfair Display";
    letter-spacing: 5px;
}
</style>
<body>
<!-- Navbar (sit on top) -->
<div class="w3-top">
  <div class="w3-bar w3-white w3-padding w3-card" style="letter-spacing:4px;">
    <a href="#home" class="w3-bar-item w3-button">Urban IT Solutions</a>
    <!-- Right-sided navbar links. Hide them on small screens -->
    <div class="w3-right w3-hide-small">
      <a href="#about" class="w3-bar-item w3-button">About</a>
      <a href="#menu" class="w3-bar-item w3-button">Our Work</a>
      <a href="#contact" class="w3-bar-item w3-button">Contact</a>
       @if (Route::has('login'))
                    @if (Auth::check())
                      <a href="{{ url('/home') }}" class="w3-bar-item w3-button">Home</a>
                    @else
                    <a href="{{ url('/login') }}" class="w3-bar-item w3-button">Login</a>
                    @endif
            @endif
    </div>
  </div>
</div>

<!-- Header -->
<header class="w3-display-container w3-content w3-wide" style="max-width:1600px;min-width:500px" id="home">
  <img class="w3-image" src="{{asset('image/header.jpg')}}" alt="Hamburger Catering" width="1600" height="800">
  <div class="w3-display-bottomleft w3-padding-large w3-opacity">
    <h1 class="w3-xxlarge" style="color:#fff;">Luxury Shoes</h1>
  </div>
</header>

<!-- Page content -->
<div class="w3-content" style="max-width:1100px">

  <!-- About Section -->
  <div class="w3-row w3-padding-64" id="about">
    <div class="w3-col m6 w3-padding-large w3-hide-small">
     <img src="{{asset('image/side.jpg')}}" class="w3-round w3-image w3-opacity-min" alt="Table Setting" width="600" height="750">
    </div>

    <div class="w3-col m6 w3-padding-large">
      <h1 class="w3-center">About Shoes</h1><br>
      <h5 class="w3-center"></h5>
      <p class="w3-large">A shoe is an item of footwear intended to protect and comfort the human foot while the wearer is doing various activities. Shoes are also used as an item of decoration and fashion. The design of shoes has varied enormously through time and from culture to culture, with appearance originally being tied to function. Additionally, fashion has often dictated many design elements, such as whether shoes have very high heels or flat ones.</p>
      <p class="w3-large w3-text-grey w3-hide-medium"> Contemporary footwear in the 2010s varies widely in style, complexity and cost. Basic sandals may consist of only a thin sole and simple strap and be sold for a low cost. High fashion shoes made by famous designers may be made of expensive materials, use complex construction and sell for hundreds or even thousands of dollars a pair. Some shoes are designed for specific purposes, such as boots designed specifically for mountaineering or skiing.</p>
    </div>
  </div>
  
  <hr>
  
  <!-- Menu Section -->
  <div class="w3-row w3-padding-64" id="menu">
    <div class="w3-col l6 w3-padding-large">
      <h1 class="w3-center">Our Work</h1><br>
      <h4>Shoes Making</h4>
      <p class="w3-text-grey">Making any kind of shoes.</p><br>
    
      <h4>Shoe Design</h4>
      <p class="w3-text-grey">Luxury Design</p><br>
    
      <h4>Making Software</h4>
      <p class="w3-text-grey">Any kind of Software.</p>    
    </div>
    
    <div class="w3-col l6 w3-padding-large">
      <img src="{{asset('image/side.jpg')}}" class="w3-round w3-image w3-opacity-min" alt="Menu" style="width:100%">
    </div>
  </div>

  <hr>

  <!-- Contact Section -->
  <div class="w3-container w3-padding-64" id="contact">
    <h1>Contact</h1><br>
    <p>We offer full-service for any business, large or small. We understand your needs and we will to satisfy the biggerst criteria of them all. Do not hesitate to contact us.</p>
    <p class="w3-text-blue-grey w3-large"><b>Urban IT Solutions, 241/2 South pirerbug Amtola, Mirpur,Dhaka-1216</b></p>
    <p>You can also contact us by phone 00553123-2323 or email urban@urbanitsolution.com, or you can send us a message here:</p>
    <form action="/action_page.php" target="_blank">
      <p><input class="w3-input w3-padding-16" type="text" placeholder="Name" required name="Name"></p>
      <!-- <p><input class="w3-input w3-padding-16" type="number" placeholder="How many people" required name="People"></p> -->
      <!-- <p><input class="w3-input w3-padding-16" type="datetime-local" placeholder="Date and time" required name="date" value="2017-11-16T20:00"></p> -->
      <p><input class="w3-input w3-padding-16" type="text" placeholder="Message " required name="Message"></p>
      <p><button class="w3-button w3-light-grey w3-section" type="submit">SEND MESSAGE</button></p>
    </form>
  </div>
  
<!-- End page content -->
</div>

<!-- Footer -->
<footer class="w3-center w3-light-grey w3-padding-32">
  <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-text-green">Urban IT Solutions</a></p>
</footer>

</body>
</html>
