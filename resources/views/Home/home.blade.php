<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laundryan</title>
    <link rel="shortcut icon" href="./icon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/locomotive-scroll@3.5.4/dist/locomotive-scroll.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #search-section {
            padding: 20px;
            text-align: center;
        }

        #search-section input {
            padding: 10px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #search-section button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #search-section button:hover {
            background-color: #0056b3;
        }

        .alert {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }

        .alert-danger {
            background-color: #ffebee;
            color: #c62828;
        }
    </style>
</head>

<body>
    <div id="loader">
        <h1>I</h1>
        <h1>LOPPP UU</h1>
        <h1>COMACC</h1>
    </div>
    <div id="fixed-image"></div>
    <div id="main">
        <div id="page1">
            <nav>
                <img src="{{ asset('images/bear.gif') }}" alt="Bearry Laundry">
                <div id="nav-part2">
                    <h4><a href="#">Layanan</a></h4>
                    <h4><a href="#">Hubungi Kami</a></h4>
                    <h4><a href="{{ route('filament.staff.auth.login') }}">Staff</a></h4>
                </div>
                <h3>Menu</h3>
            </nav>
            <div id="center">
                <div id="left">
                    <h3>Bearry Laundry hadir untuk memberikan layanan laundry berkualitas dengan hasil bersih, wangi,
                        dan
                        rapi.</h3>
                </div>
                <div id="right">
                    <h1>CUCI <br>
                        BERSIH <br>
                        TANPA RIBET</h1>
                </div>
            </div>
            <div id="hero-shape">
                <div id="hero-1"></div>
                <div id="hero-2"></div>
                <div id="hero-3"></div>
            </div>
            <video autoplay loop muted src="{{ asset('assets/video/laundry.mp4') }}"></video>
        </div>
        <div id="page2">
            <div id="moving-text">
                <div class="con">
                    <h1>CEPAT</h1>
                    <div id="gola"></div>
                    <h1>TERJANGKAU</h1>
                    <div id="gola"></div>
                    <h1>BERKUALITAS</h1>
                    <div id="gola"></div>
                </div>
            </div>
            <div id="page2-bottom">
                <h1>Kami menyediakan layanan laundry profesional dengan harga terbaik. Kepercayaan pelanggan adalah
                    prioritas kami.</h1>
                <img src="{{ asset('assets/img/washing.png') }}" alt="Laundry Service">
            </div>
            <div id="gooey"></div>
        </div>
        <div id="page3">
            <div id="elem-container">
                <div class="elem" data-image="{{ asset('assets/img/wash.jpg') }}">
                    <div class="overlay"></div>
                    <h2>Cuci Reguler</h2>
                </div>
                <div class="elem" data-image="{{ asset('assets/img/dry-clean.jpg') }}">
                    <div class="overlay"></div>
                    <h2>Dry Cleaning</h2>
                </div>
                <div class="elem" data-image="{{ asset('assets/img/ironing.jpg') }}">
                    <div class="overlay"></div>
                    <h2>Setrika</h2>
                </div>
            </div>
        </div>
        <div id="page5">
            <!-- Form Pencarian -->
            <div id="search-section">
                <form id="searchInvoiceForm">
                    <input type="text" name="id_transaksi" placeholder="Masukkan ID Transaksi" required>
                    <button type="submit" class="btn btn-primary">Cari Invoice</button>
                </form>
            </div>
        </div>
        <div id="full-scr">
            <div id="full-div1"></div>
        </div>
    </div>
    <div id="footer">
        <div id="footer-div"></div>
        <h1>Faza.</h1>
        <div id="footer-bottom"></div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="invoiceModalLabel">Invoice Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Tempat untuk menampilkan data invoice -->
                    <div id="invoiceData"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <a id="downloadInvoiceLink" href="#" class="btn btn-primary">Download PDF</a>
                </div>
            </div>
        </div>
    </div>



    <!-- Tampilkan Pesan Error -->
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/locomotive-scroll@3.5.4/dist/locomotive-scroll.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
</body>

</html>
