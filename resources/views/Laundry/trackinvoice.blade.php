<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bearry | Track Invoice</title>
    <link rel="stylesheet" href="{{ asset('trackinvoice/styles.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Understood</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container-custom">
        <div class="hero-image-wrapper wrapper">
            <div class="bg-img">
                <img src="{{ asset('trackinvoice/washing.jpg') }}" alt="" style="filter: brightness(45%);" />
            </div>
            <div class="front-img">
                <img src="{{ asset('trackinvoice/hero.png') }}" alt="" style="border-radius: 25px;" />
            </div>
        </div>
        <div class="content-wrapper wrapper">
            <nav>
                <!-- <p>Don't forget to check our socials! <a href="#">@cocoladas</a></p> -->
                <button>
                    <a href="{{ route('home') }}">Close</a>
                </button>
            </nav>
            <header>
                <div class="h2">
                    <h2>Track Your <span style="font-weight: 600;">Invoice!</span></h2>
                    <div class="header-revealer"></div>
                </div>
                <div class="form-wrapper">
                    <form action="">
                        <input type="text" id="transaction-id" placeholder="Your Transaction ID" />
                        <button id="download-invoice">Track</button>
                    </form>
                    <p>
                        Makesure that you know you're cucian is right on time!
                        Get your invoice status and enjoy your life!
                    </p>
                </div>
            </header>
            <p>Transaksi: <span id="transaction-id-placeholder">-</span> <span id="transaction-status-placeholder">-</span></p>
            <footer>
                <p>Bearry <span>Laundry</span></p>
            </footer>
        </div>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>
<script src="{{ asset('trackinvoice/script.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>

</html>
