<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Invoice Transaksi #{{ $transaksi->id_transaksi }}</title>
    <style>
        @charset "UTF-8";

        body {
            text-align: center;
            color: #777;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        .invoice-box table tr.total td {
            padding: 15px 0;
            border-top: 2px solid #eee;
        }

        .invoice-box .no-discount {
            color: #999;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table>
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <h1>Invoice Transaksi</h1>
                            </td>
                            <td>
                                Invoice #: {{ $transaksi->id_transaksi }}<br />
                                Tanggal Dibuat: {{ $transaksi->created_at }}<br />
                                Estimasi Pengambilan: {{ $transaksi->estimasi_tanggal_pengambilan }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                Nama Customer: {{ $transaksi->customer->nama_customer }}<br />
                                Alamat: {{ $transaksi->customer->alamat }}<br />
                                No. Telepon: {{ $transaksi->customer->no_telp }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Item</td>
                <td>Harga</td>
            </tr>

            @foreach ($transaksi->detailTransaksi as $detail)
                <tr class="item">
                    <td>{{ $detail->jenisCucian->nama_jenis_cucian }} ({{ $detail->berat }} kg)</td>
                    <td>Rp {{ number_format($detail->harga_per_timbangan * $detail->berat, 0, ',', '.') }}</td>
                </tr>
            @endforeach

            <tr class="total">
                <td></td>
                <td>
                    Total: Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}<br>
                    Total Harga Setelah Diskon :
                    @if ($transaksi->total_harga_setelah_diskon == 0)
                        <span class="no-discount">Tidak ada diskon</span>
                    @else
                        Rp {{ number_format($transaksi->total_harga_setelah_diskon, 0, ',', '.') }}
                    @endif
                </td>
                <td></td>
            </tr>
        </table>
    </div>
</body>

</html>
