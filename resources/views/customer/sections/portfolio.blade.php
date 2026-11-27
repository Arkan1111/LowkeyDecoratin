<section class="cd-section" id="portfolio">

    <div class="cd-section-heading">

        <div>
            <span class="cd-section-label">
                PORTOFOLIO LAYANAN
            </span>

            <h2>Sentuhan Artistik untuk Momen Sakral</h2>
        </div>

        <p>
            Harmonisasi elemen kayu artistik, flora semi-fresh
            & fresh import, serta tata pencahayaan hangat
            berstandar arsitektural.
        </p>

    </div>

    {{-- AMBIL DATA DARI DATABASE (HANYA YANG DIPUBLIKASIKAN) --}}
    @php
        $portfolioItems = \App\Models\Inspiration::with('category')
            ->where('is_featured', true)
            ->latest()
            ->get();
    @endphp

    <div class="cd-portfolio-grid">
        @forelse ($portfolioItems as $item)
        <article class="cd-portfolio-card">

            <div class="cd-card-top">
                <span>{{ $item->venue_type ?? $item->category->name ?? 'Dekorasi' }}</span>
                <small>{{ $item->guest_capacity ?? 'Kapasitas disesuaikan' }}</small>
            </div>

            <h3>{{ $item->title }}</h3>

            <p>
                {{ Str::limit($item->description ?? 'Dokumentasi dekorasi dari Lowkey Decoration.', 120) }}
            </p>

            <img
                src="{{ asset('storage/' . $item->image_path) }}"
                alt="{{ $item->title }}"
                loading="lazy">

        </article>
        @empty
        <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #888;">
            <p>Belum ada portofolio yang dipublikasikan.</p>
        </div>
        @endforelse
    </div>

</section>