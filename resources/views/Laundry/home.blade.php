<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bearry Laundry</title>
    <link rel="stylesheet" href="{{ asset('landing/styles.css') }}" />
  </head>
  <body>
    <div class="container">
      <div class="loader">
        <div class="loader-imgs">
          <div class="img">
            <img src="{{ asset('landing/assets/img1.jpg') }}" alt="" />
          </div>
          <div class="img">
            <img src="{{ asset('landing/assets/img2.jpg') }}" alt="" />
          </div>
          <div class="img">
            <img src="{{ asset('landing/assets/laundry-art.jpg') }}" alt="" />
          </div>
          <div class="img" id="loader-logo">
            <img src="{{ asset('landing/assets/logo.gif') }}" alt="" />
          </div>
          <div class="img">
            <img src="{{ asset('landing/assets/img4.jpg') }}" alt="" />
          </div>
          <div class="img">
            <img src="{{ asset('landing/assets/img5.jpg') }}" alt="" />
          </div>
          <div class="img">
            <img src="{{ asset('landing/assets/img1.jpg') }}" alt="" />
          </div>
        </div>
      </div>
      <div class="website-content">
        <nav>
          <div class="nav-item">
            <img src="{{ asset('landing/assets/bear.gif') }}" alt="" class="logo-img">
          </div>
          <div class="nav-item" id="logo">
            <a href="{{ route('home') }}">Bearry Laundry</a>
          </div>
          <div class="nav-item">
            <a href="{{ route('trackinvoice') }}">Track Your Invoice</a>
          </div>
        </nav>

        <div class="hero">
          <div class="h1">
            <h1>kami melindungi</h1>
          </div>
          <div class="h1">
            <h1>pakaian anda</h1>
          </div>
          <div class="h1">
            <h1><span>dengan tulus</span></h1>
          </div>
        </div>

        <footer>
          <div class="item">
            <img src="{{ asset('landing/assets/laundry-art.jpg') }}" alt="" />
          </div>
        </footer>
      </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="{{ asset('landing/script.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
  </body>
</html>
