
<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cek Jadwal & Kuota | Lowkey Decoration</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f7f5f0;
            color: #243b32;
        }

        .quota-container {
            width: 90%;
            max-width: 1150px;
            margin: 60px auto;
        }

        .quota-heading {
            text-align: center;
            margin-bottom: 40px;
        }

        .quota-heading span {
            color: #b18b56;
            font-size: 12px;
            letter-spacing: 3px;
            font-weight: 600;
        }

        .quota-heading h1 {
            font-family: Georgia, serif;
            font-size: 38px;
            margin: 15px 0;
            color: #1c392f;
        }

        .quota-heading p {
            color: #777;
            font-size: 14px;
            line-height: 1.7;
        }

        .quota-information {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0,0,0,.05);
            margin-bottom: 30px;
        }

        .information-item span {
            display: block;
            font-size: 11px;
            letter-spacing: 1px;
            color: #999;
            margin-bottom: 10px;
        }

        .information-item strong {
            font-size: 16px;
            color: #1c392f;
        }

        .quota-calendar {
            background: white;
            border-radius: 15px;
            padding: 35px;
            box-shadow: 0 8px 30px rgba(0,0,0,.05);
        }

        .quota-calendar h2 {
            font-family: Georgia, serif;
            font-size: 25px;
            margin-bottom: 12px;
        }

        .quota-calendar p {
            color: #888;
            font-size: 14px;
            line-height: 1.7;
        }

        .selected-date {
            margin-top: 25px;
            padding: 20px;
            background: #f7f5f0;
            border-left: 4px solid #b18b56;
            border-radius: 5px;
        }

        .selected-date span {
            display: block;
            font-size: 12px;
            color: #888;
            margin-bottom: 8px;
        }

        .selected-date strong {
            font-size: 18px;
            color: #1c392f;
        }

        .quota-back {
            display: inline-block;
            margin-top: 30px;
            text-decoration: none;
            background: #1c392f;
            color: white;
            padding: 13px 25px;
            border-radius: 7px;
            font-size: 13px;
        }

        .quota-back:hover {
            background: #294d3f;
        }

        @media(max-width: 768px) {

            .quota-information {
                grid-template-columns: 1fr;
                gap: 25px;
            }

            .quota-heading h1 {
                font-size: 29px;
            }

            .quota-calendar {
                padding: 23px;
            }

        }

    </style>

</head>

<body>

    @include('customer.layouts.navbar')

    <main class="quota-container">

        <div class="quota-heading">

            <span>LOWKEY DECORATION</span>

            <h1>Cek Jadwal & Kuota</h1>

            <p>
                Temukan tanggal terbaik untuk mewujudkan
                momen istimewa bersama Lowkey Decoration.
            </p>

        </div>

        {{-- INFORMASI PENCARIAN --}}
        <div class="quota-information">

            <div class="information-item">

                <span>JENIS ACARA</span>

                <strong>{{ $jenisAcara }}</strong>

            </div>

            <div class="information-item">

                <span>RENCANA TANGGAL</span>

                <strong>
                    {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
                </strong>

            </div>

            <div class="information-item">

                <span>KOTA LOKASI</span>

                <strong>{{ $kota }}</strong>

            </div>

        </div>

        {{-- KALENDER KETERSEDIAAN --}}
        <div class="quota-calendar">

            <h2>Kalender Ketersediaan</h2>

            <p>
                Berikut adalah tanggal yang ingin kamu periksa.
                Informasi ketersediaan kuota akan ditampilkan
                setelah sistem terhubung dengan data reservasi.
            </p>

            <div class="selected-date">

                <span>TANGGAL YANG DIPILIH</span>

                <strong>
                    {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
                </strong>

            </div>

            <a href="{{ url('/') }}#ketersediaan" class="quota-back">
                ← Kembali ke Halaman Utama
            </a>

        </div>

    </main>

    @include('customer.layouts.footer')

</body>

</html>
