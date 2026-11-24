
<section class="cd-hero" id="beranda">

    <div class="cd-hero-content">

        <span class="cd-badge">
            LOWKEY DECORATION • WEDDING SPECIALIST
        </span>

        <span class="cd-eyebrow">
            Mewujudkan Momen Berkesan
        </span>

        <h1>
            Wujudkan Momen
            <em>Istimewa</em>
            Bersama Lowkey Decoration
        </h1>

        <p>
            Spesialis dekorasi artistik bernuansa etnik-modern
            dengan sentuhan elegan untuk Lamaran, Pernikahan,
            dan Sunatan.
        </p>

        <div class="cd-hero-actions">

            <a href="#paket" class="cd-btn-primary">
                Eksplorasi Paket
            </a>

            <a href="#ketersediaan" class="cd-btn-light">
                Booking Tanggal & Kuota
            </a>

        </div>

        <div class="cd-statistics">

            <div>
                <strong>500+</strong>
                <span>Momen Sakral Terwujud</span>
            </div>

            <div>
                <strong>100%</strong>
                <span>Garansi Tepat Waktu</span>
            </div>

            <div>
                <strong>4.9/5</strong>
                <span>Rating Pelanggan</span>
            </div>

        </div>

    </div>

    <div class="cd-hero-image">

        <img
            src="https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=1200&q=85"
            alt="Dekorasi Pernikahan Lowkey Decoration"
        >

        <div class="cd-image-caption">

            <span>✦ SIGNATURE COMPOSITION</span>

            <strong>
                Elegant Wedding Decoration
            </strong>

        </div>

    </div>

    {{-- FORM KETERSEDIAAN --}}
 <form action="{{ route('customer.cek-kuota') }}" method="GET" class="cd-availability">

    <div class="cd-availability-item">
        <label>JENIS ACARA</label>

        <select name="jenis_acara" required>
            <option value="Pernikahan">Pernikahan</option>
            <option value="Lamaran">Lamaran</option>
            <option value="Khitan & Sunatan">Khitan & Sunatan</option>
            <option value="Acara Lainnya">Acara Lainnya</option>
        </select>
    </div>

    <div class="cd-availability-item">
        <label>RENCANA TANGGAL</label>

        <input
            type="date"
            name="tanggal"
            min="{{ date('Y-m-d') }}"
            required
        >
    </div>

    <div class="cd-availability-item">
        <label>KOTA LOKASI</label>

        <select name="kota" required>
            <option value="Jakarta">Jakarta</option>
            <option value="Bekasi">Bekasi</option>
            <option value="Karawang">Karawang</option>
            <option value="Depok">Depok</option>
            <option value="Bandung">Bandung</option>
        </select>
    </div>

    <button type="submit" class="cd-check-button">
        ⌕ Cek Kuota
    </button>

</form>

</section>
