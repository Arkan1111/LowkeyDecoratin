
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
        :root {
            --forest: #244438;
            --forest-dark: #193329;
            --forest-light: #e9f0eb;
            --ivory: #f7f5ef;
            --gold: #b89560;
            --gold-light: #f3eadb;
            --white: #ffffff;
            --text: #303b34;
            --muted: #85877f;
            --border: #e9e6dd;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: var(--ivory);
            color: var(--text);
        }

        .cq-page {
            min-height: 100vh;
            padding: 55px 20px 80px;
        }

        .cq-container {
            max-width: 1150px;
            margin: auto;
        }

        /* HEADER */

        .cq-heading {
            text-align: center;
            margin-bottom: 38px;
        }

        .cq-eyebrow {
            color: var(--gold);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 3px;
        }

        .cq-heading h1 {
            font-family: Georgia, serif;
            color: var(--forest);
            font-size: clamp(30px, 4vw, 43px);
            font-weight: 500;
            margin: 15px 0;
        }

        .cq-heading p {
            color: var(--muted);
            font-size: 14px;
            line-height: 1.8;
            max-width: 600px;
            margin: auto;
        }

        /* SEARCH INFORMATION */

        .cq-info-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 27px 30px;
            margin-bottom: 25px;
            box-shadow: 0 5px 20px rgba(30, 55, 42, .035);
        }

        .cq-info-title {
            font-family: Georgia, serif;
            color: var(--forest);
            font-size: 19px;
            margin-bottom: 23px;
        }

        .cq-info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .cq-info-item {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .cq-info-icon {
            width: 43px;
            height: 43px;
            border-radius: 10px;
            background: var(--forest-light);
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--forest);
            font-size: 19px;
            flex-shrink: 0;
        }

        .cq-info-item span {
            display: block;
            color: var(--muted);
            font-size: 10px;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }

        .cq-info-item strong {
            color: var(--forest);
            font-size: 14px;
            font-weight: 600;
        }

        /* MAIN CONTENT */

        .cq-main-grid {
            display: grid;
            grid-template-columns: 1.5fr 0.8fr;
            gap: 24px;
            align-items: start;
        }

        .cq-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 27px;
            box-shadow: 0 5px 20px rgba(30, 55, 42, .035);
        }

        .cq-card-heading {
            margin-bottom: 25px;
        }

        .cq-card-heading h2 {
            font-family: Georgia, serif;
            font-size: 23px;
            font-weight: 500;
            color: var(--forest);
            margin-bottom: 8px;
        }

        .cq-card-heading p {
            font-size: 12px;
            line-height: 1.7;
            color: var(--muted);
        }

        /* CALENDAR */

        .cq-calendar-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 25px;
        }

        .cq-month-title {
            color: var(--forest);
            font-family: Georgia, serif;
            font-size: 21px;
            font-weight: 600;
        }

        .cq-calendar-actions {
            display: flex;
            gap: 8px;
        }

        .cq-nav-btn {
            width: 36px;
            height: 36px;
            border: 1px solid var(--border);
            background: white;
            color: var(--forest);
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            transition: .2s;
        }

        .cq-nav-btn:hover:not(:disabled) {
            background: var(--forest);
            color: white;
        }

        .cq-nav-btn:disabled {
            opacity: .35;
            cursor: not-allowed;
        }

        .cq-weekdays,
        .cq-calendar-days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 7px;
        }

        .cq-weekdays {
            margin-bottom: 10px;
        }

        .cq-weekdays div {
            text-align: center;
            color: var(--muted);
            font-size: 11px;
            font-weight: 600;
            padding: 8px 0;
        }

        .cq-day {
            min-height: 54px;
            border: 1px solid transparent;
            border-radius: 9px;
            background: #f8f8f5;
            color: var(--text);
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 5px;
            transition: .2s;
            font-size: 13px;
        }

        .cq-day:hover:not(:disabled) {
            border-color: var(--gold);
            background: var(--gold-light);
        }

        .cq-day.empty {
            background: transparent;
            cursor: default;
        }

        .cq-day.past {
            background: #f5f4f1;
            color: #c6c4be;
            cursor: not-allowed;
        }

        .cq-day.selected {
            background: var(--forest);
            color: white;
            border-color: var(--forest);
        }

        .cq-day.today:not(.selected) {
            border-color: var(--gold);
        }

        .cq-day small {
            font-size: 8px;
            color: var(--gold);
        }

        .cq-day.selected small {
            color: #ead8b6;
        }

        /* CALENDAR LEGEND */

        .cq-legend {
            display: flex;
            flex-wrap: wrap;
            gap: 17px;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .cq-legend-item {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 10px;
            color: var(--muted);
        }

        .cq-legend-dot {
            width: 9px;
            height: 9px;
            border-radius: 3px;
        }

        .cq-dot-selected {
            background: var(--forest);
        }

        .cq-dot-past {
            background: #d9d7d0;
        }

        .cq-dot-unchecked {
            background: var(--gold);
        }

        /* DETAIL CARD */

        .cq-detail-card {
            background: var(--forest);
            border-radius: 14px;
            padding: 27px;
            color: white;
            margin-bottom: 20px;
        }

        .cq-detail-label {
            color: #d8c39e;
            font-size: 10px;
            letter-spacing: 2px;
            font-weight: 600;
        }

        .cq-detail-date {
            font-family: Georgia, serif;
            font-size: 25px;
            margin: 15px 0 10px;
            line-height: 1.4;
        }

        .cq-detail-day {
            font-size: 12px;
            color: #d5ddd7;
        }

        .cq-detail-divider {
            border: 0;
            border-top: 1px solid rgba(255,255,255,.18);
            margin: 23px 0;
        }

        .cq-detail-status {
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: 12px;
            color: #f2e8d7;
            line-height: 1.7;
        }

        .cq-status-icon {
            width: 9px;
            height: 9px;
            background: var(--gold);
            border-radius: 50%;
            flex-shrink: 0;
        }

        .cq-detail-note {
            margin-top: 17px;
            font-size: 11px;
            line-height: 1.8;
            color: #d0dbd3;
        }

        /* INFORMATION CARD */

        .cq-note-card {
            background: var(--gold-light);
            border: 1px solid #eadcc5;
            border-radius: 12px;
            padding: 20px;
        }

        .cq-note-card h3 {
            font-family: Georgia, serif;
            color: var(--forest);
            font-size: 16px;
            margin-bottom: 10px;
        }

        .cq-note-card p {
            color: #776c5b;
            font-size: 11px;
            line-height: 1.8;
        }

        /* BUTTONS */

        .cq-back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            margin-top: 30px;
            color: var(--forest);
            font-size: 12px;
            font-weight: 600;
            transition: .2s;
        }

        .cq-back-button:hover {
            color: var(--gold);
        }

        .cq-footer-note {
            text-align: center;
            margin-top: 50px;
            color: var(--muted);
            font-size: 10px;
            letter-spacing: .5px;
        }

        @media(max-width: 850px) {
            .cq-main-grid {
                grid-template-columns: 1fr;
            }
        }

        @media(max-width: 600px) {
            .cq-page {
                padding: 35px 14px 55px;
            }

            .cq-info-card,
            .cq-card {
                padding: 20px;
            }

            .cq-info-grid {
                grid-template-columns: 1fr;
                gap: 18px;
            }

            .cq-day {
                min-height: 43px;
                font-size: 12px;
            }

            .cq-weekdays,
            .cq-calendar-days {
                gap: 4px;
            }

            .cq-calendar-top {
                gap: 10px;
            }

            .cq-month-title {
                font-size: 18px;
            }

            .cq-legend {
                gap: 12px;
            }
        }
    </style>
</head>

<body>

    @include('customer.layouts.navbar')

    <main class="cq-page">

        <div class="cq-container">

            {{-- PAGE HEADER --}}
            <header class="cq-heading">

                <span class="cq-eyebrow">
                    LOWKEY DECORATION • BOOKING INFORMATION
                </span>

                <h1>Cek Jadwal & Kuota</h1>

                <p>
                    Temukan tanggal terbaik untuk merayakan momen
                    istimewa bersama Lowkey Decoration.
                    Periksa kalender sebelum melanjutkan reservasi.
                </p>

            </header>


            {{-- INFORMASI PENCARIAN --}}
            <section class="cq-info-card">

                <h2 class="cq-info-title">
                    Informasi Pencarian
                </h2>

                <div class="cq-info-grid">

                    <div class="cq-info-item">

                        <div class="cq-info-icon">✦</div>

                        <div>
                            <span>JENIS ACARA</span>
                            <strong>{{ $jenisAcara }}</strong>
                        </div>

                    </div>

                    <div class="cq-info-item">

                        <div class="cq-info-icon">▦</div>

                        <div>
                            <span>RENCANA TANGGAL</span>

                            <strong>
                                {{ \Carbon\Carbon::parse($tanggal)->locale('id')->translatedFormat('d F Y') }}
                            </strong>
                        </div>

                    </div>

                    <div class="cq-info-item">

                        <div class="cq-info-icon">⌖</div>

                        <div>
                            <span>KOTA LOKASI</span>
                            <strong>{{ $kota }}</strong>
                        </div>

                    </div>

                </div>

            </section>


            {{-- CALENDAR AND DETAILS --}}
            <section class="cq-main-grid">

                {{-- CALENDAR --}}
                <div class="cq-card">

                    <div class="cq-card-heading">

                        <h2>Kalender Ketersediaan</h2>

                        <p>
                            Pilih tanggal untuk melihat informasi
                            jadwal yang ingin kamu periksa.
                        </p>

                    </div>

                    <div class="cq-calendar-top">

                        <h3 class="cq-month-title" id="cqMonthTitle">
                            -
                        </h3>

                        <div class="cq-calendar-actions">

                            <button
                                type="button"
                                class="cq-nav-btn"
                                id="cqPrevMonth"
                                aria-label="Bulan sebelumnya"
                            >
                                ‹
                            </button>

                            <button
                                type="button"
                                class="cq-nav-btn"
                                id="cqNextMonth"
                                aria-label="Bulan berikutnya"
                            >
                                ›
                            </button>

                        </div>

                    </div>


                    <div class="cq-weekdays">

                        <div>Min</div>
                        <div>Sen</div>
                        <div>Sel</div>
                        <div>Rab</div>
                        <div>Kam</div>
                        <div>Jum</div>
                        <div>Sab</div>

                    </div>


                    <div
                        class="cq-calendar-days"
                        id="cqCalendarDays"
                    >
                    </div>


                    <div class="cq-legend">

                        <div class="cq-legend-item">
                            <span class="cq-legend-dot cq-dot-selected"></span>
                            Tanggal dipilih
                        </div>

                        <div class="cq-legend-item">
                            <span class="cq-legend-dot cq-dot-past"></span>
                            Sudah berlalu
                        </div>

                        <div class="cq-legend-item">
                            <span class="cq-legend-dot cq-dot-unchecked"></span>
                            Belum diperiksa
                        </div>

                    </div>

                </div>


                {{-- DETAIL TANGGAL --}}
                <div>

                    <div class="cq-detail-card">

                        <span class="cq-detail-label">
                            TANGGAL YANG DIPILIH
                        </span>

                        <h2
                            class="cq-detail-date"
                            id="cqSelectedDate"
                        >
                            -
                        </h2>

                        <p
                            class="cq-detail-day"
                            id="cqSelectedDay"
                        >
                            -
                        </p>

                        <hr class="cq-detail-divider">

                        <div class="cq-detail-status">

                            <span class="cq-status-icon"></span>

                            <span>
                                Status ketersediaan belum diperiksa.
                            </span>

                        </div>

                        <p class="cq-detail-note">
                            Silakan hubungi pihak Lowkey Decoration
                            atau lanjutkan ke proses reservasi untuk
                            mendapatkan konfirmasi ketersediaan tanggal.
                        </p>

                    </div>


                    <div class="cq-note-card">

                        <h3>Informasi Penting</h3>

                        <p>
                            Kalender ini merupakan tampilan pemilihan
                            tanggal. Status kuota sebenarnya akan
                            mengikuti data reservasi yang telah
                            dikonfirmasi oleh pihak Lowkey Decoration.
                        </p>

                    </div>

                </div>

            </section>


            <a href="{{ route('home') }}#ketersediaan" class="cq-back-button">
                ← Kembali ke Halaman Utama
            </a>


            <div class="cq-footer-note">
                LOWKEY DECORATION © {{ date('Y') }} •
                CREATING BEAUTIFUL MOMENTS
            </div>

        </div>

    </main>

    @include('customer.layouts.footer')


    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const selectedDateInput = @json($tanggal);

            const initialDate = new Date(selectedDateInput + 'T00:00:00');

            const today = new Date();
            today.setHours(0, 0, 0, 0);

            let selectedDate = new Date(initialDate);

            let currentMonth = new Date(
                initialDate.getFullYear(),
                initialDate.getMonth(),
                1
            );

            const monthNames = [
                'Januari', 'Februari', 'Maret',
                'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September',
                'Oktober', 'November', 'Desember'
            ];

            const dayNames = [
                'Minggu', 'Senin', 'Selasa',
                'Rabu', 'Kamis', 'Jumat', 'Sabtu'
            ];

            const calendarDays = document.getElementById('cqCalendarDays');
            const monthTitle = document.getElementById('cqMonthTitle');

            const selectedDateElement = document.getElementById('cqSelectedDate');
            const selectedDayElement = document.getElementById('cqSelectedDay');

            const prevButton = document.getElementById('cqPrevMonth');
            const nextButton = document.getElementById('cqNextMonth');

            function formatDate(date) {
                return date.getDate() + ' ' +
                    monthNames[date.getMonth()] + ' ' +
                    date.getFullYear();
            }

            function renderSelectedDate() {

                selectedDateElement.textContent = formatDate(selectedDate);

                selectedDayElement.textContent =
                    dayNames[selectedDate.getDay()];
            }

            function renderCalendar() {

                calendarDays.innerHTML = '';

                const year = currentMonth.getFullYear();
                const month = currentMonth.getMonth();

                monthTitle.textContent =
                    monthNames[month] + ' ' + year;

                const firstDay = new Date(year, month, 1).getDay();

                const daysInMonth = new Date(
                    year,
                    month + 1,
                    0
                ).getDate();

                const minMonth = new Date(
                    today.getFullYear(),
                    today.getMonth(),
                    1
                );

                prevButton.disabled =
                    currentMonth <= minMonth;

                // Empty cells before first day
                for (let i = 0; i < firstDay; i++) {

                    const empty = document.createElement('div');

                    empty.className = 'cq-day empty';

                    calendarDays.appendChild(empty);

                }

                // Render calendar dates
                for (let day = 1; day <= daysInMonth; day++) {

                    const date = new Date(year, month, day);

                    const button = document.createElement('button');

                    button.type = 'button';
                    button.className = 'cq-day';

                    const isPast = date < today;

                    const isSelected =
                        date.getFullYear() === selectedDate.getFullYear() &&
                        date.getMonth() === selectedDate.getMonth() &&
                        date.getDate() === selectedDate.getDate();

                    const isToday =
                        date.getFullYear() === today.getFullYear() &&
                        date.getMonth() === today.getMonth() &&
                        date.getDate() === today.getDate();

                    button.textContent = day;

                    if (isPast) {

                        button.classList.add('past');
                        button.disabled = true;

                    } else {

                        const status = document.createElement('small');

                        status.textContent = 'Belum diperiksa';

                        button.appendChild(status);

                        button.addEventListener('click', function () {

                            selectedDate = new Date(date);

                            renderCalendar();
                            renderSelectedDate();

                        });

                    }

                    if (isSelected) {
                        button.classList.add('selected');
                    }

                    if (isToday) {
                        button.classList.add('today');
                    }

                    button.setAttribute(
                        'aria-label',
                        formatDate(date)
                    );

                    calendarDays.appendChild(button);

                }

            }

            prevButton.addEventListener('click', function () {

                if (prevButton.disabled) return;

                currentMonth.setMonth(
                    currentMonth.getMonth() - 1
                );

                renderCalendar();

            });

            nextButton.addEventListener('click', function () {

                currentMonth.setMonth(
                    currentMonth.getMonth() + 1
                );

                renderCalendar();

            });

            renderSelectedDate();
            renderCalendar();

        });
    </script>

</body>
</html>
