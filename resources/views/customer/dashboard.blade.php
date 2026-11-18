
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LowkeyDecoratin | Customer</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f7f4f0;
            color: #342c27;
        }

        header {
            background: #594333;
            color: white;
            padding: 20px 6%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        header h2 {
            margin: 0;
        }

        header nav {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        header a {
            color: white;
            text-decoration: none;
        }

        header button {
            background: #d6b99c;
            color: #342c27;
        }

        .container {
            padding: 35px 6%;
        }

        .hero {
            background: #e9ddd0;
            padding: 35px;
            border-radius: 14px;
            margin-bottom: 30px;
        }

        .hero h1 {
            margin-top: 0;
        }

        .products {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 20px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 3px 12px #0000000d;
        }

        .card h3 {
            margin-top: 0;
        }

        .price {
            color: #805b3d;
            font-weight: bold;
            font-size: 18px;
        }

        input, textarea {
            width: 100%;
            padding: 11px;
            border: 1px solid #ddd;
            border-radius: 7px;
            margin: 7px 0 15px;
            font-family: inherit;
        }

        button {
            background: #79583e;
            color: white;
            padding: 11px 16px;
            border: 0;
            border-radius: 7px;
            cursor: pointer;
        }

        button:hover {
            background: #594333;
        }

        button:disabled {
            background: #aaa;
            cursor: not-allowed;
        }

        .checkout {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-top: 35px;
            max-width: 700px;
        }

        .message {
            padding: 12px;
            background: #d9efdc;
            border-radius: 7px;
            margin-bottom: 20px;
        }

        .error {
            color: #b42318;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin: 12px 0;
            border-bottom: 1px solid #eee;
            padding-bottom: 12px;
        }

        .cart-item button {
            background: #a94442;
            padding: 7px 10px;
        }

        .empty {
            color: #888;
        }

        @media(max-width: 600px) {
            header {
                align-items: flex-start;
            }

            header nav {
                flex-wrap: wrap;
            }

            .container {
                padding: 22px 5%;
            }

            .hero {
                padding: 25px;
            }
        }
    </style>
</head>

<body>

<header>
    <h2>LowkeyDecoratin</h2>

    <nav>
        <a href="{{ route('customer.dashboard') }}">Beranda</a>
        <a href="{{ route('customer.orders') }}">Pesanan Saya</a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </nav>
</header>

<div class="container">

    <div class="hero">
        <h1>Selamat Datang, {{ auth()->user()->name }}!</h1>
        <p>
            Temukan dekorasi terbaik untuk membuat setiap momen
            lebih indah dan berkesan.
        </p>
    </div>

    @if(session('success'))
        <div class="message">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="message" style="background:#fce4e4">
            <strong>Periksa kembali data pesanan:</strong>

            @foreach($errors->all() as $error)
                <div class="error">{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <h2>Katalog Produk</h2>
    <p>Pilih produk dekorasi yang ingin kamu pesan.</p>

    <div class="products">

        @forelse($products as $product)

            <div class="card">

                <h3>{{ $product->name }}</h3>

                <p>
                    {{ $product->category->name ?? 'Tanpa kategori' }}
                </p>

                <p>
                    {{ $product->description ?? 'Produk dekorasi pilihan.' }}
                </p>

                <p class="price">
                    Rp{{ number_format($product->price, 0, ',', '.') }}
                </p>

                <p>Stok tersedia: {{ $product->stock }}</p>

                <label>Jumlah:</label>

                <input
                    type="number"
                    class="quantity"
                    min="1"
                    max="{{ $product->stock }}"
                    value="1"
                    data-id="{{ $product->id }}"
                    data-name="{{ $product->name }}"
                    data-price="{{ $product->price }}"
                >

                <button
                    type="button"
                    onclick="addToCart({{ $product->id }})">
                    Tambah ke Keranjang
                </button>

            </div>

        @empty

            <p>Belum ada produk tersedia.</p>

        @endforelse

    </div>

    <form
        action="{{ route('customer.checkout') }}"
        method="POST"
        id="checkoutForm">

        @csrf

        <div class="checkout">

            <h2>Keranjang Belanja</h2>

            <div id="cartItems" class="empty">
                Belum ada produk dipilih.
            </div>

            <h3 id="cartTotal">Total: Rp0</h3>

            <div id="selectedProducts"></div>

            <hr>

            <h2>Checkout</h2>

            <label>Nama Penerima</label>

            <input
                type="text"
                name="customer_name"
                value="{{ old('customer_name', auth()->user()->name) }}"
                required
            >

            <label>Nomor Telepon</label>

            <input
                type="text"
                name="phone"
                value="{{ old('phone') }}"
                required
            >

            <label>Alamat Pengiriman</label>

            <textarea
                name="address"
                rows="4"
                required>{{ old('address') }}</textarea>

            <button type="submit" id="checkoutButton">
                Buat Pesanan
            </button>

        </div>

    </form>

</div>

<script>
    let cart = {};

    function rupiah(number) {
        return 'Rp' + Number(number).toLocaleString('id-ID');
    }

    function addToCart(id) {
        const input = document.querySelector(
            '.quantity[data-id="' + id + '"]'
        );

        const quantity = Number(input.value);
        const stock = Number(input.max);

        if (!Number.isInteger(quantity) || quantity < 1) {
            alert('Masukkan jumlah produk yang benar.');
            return;
        }

        const name = input.dataset.name;
        const price = Number(input.dataset.price);

        const currentQuantity = cart[id]
            ? cart[id].quantity
            : 0;

        if (currentQuantity + quantity > stock) {
            alert('Jumlah produk melebihi stok yang tersedia.');
            return;
        }

        cart[id] = {
            name: name,
            price: price,
            quantity: currentQuantity + quantity,
            stock: stock
        };

        renderCart();
        input.value = 1;
    }

    function removeFromCart(id) {
        delete cart[id];
        renderCart();
    }

    function renderCart() {
        const cartItems = document.getElementById('cartItems');
        const selected = document.getElementById('selectedProducts');

        cartItems.innerHTML = '';
        selected.innerHTML = '';

        let total = 0;
        let count = 0;

        for (const id in cart) {
            const item = cart[id];
            const subtotal = item.price * item.quantity;

            total += subtotal;
            count++;

            const row = document.createElement('div');
            row.className = 'cart-item';

            const info = document.createElement('span');
            info.textContent =
                item.name + ' (' + item.quantity + ' x ' +
                rupiah(item.price) + ')';

            const actions = document.createElement('span');
            actions.textContent = rupiah(subtotal) + ' ';

            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.textContent = 'Hapus';
            removeButton.addEventListener('click', function() {
                removeFromCart(id);
            });

            actions.appendChild(removeButton);
            row.appendChild(info);
            row.appendChild(actions);
            cartItems.appendChild(row);

            const productInput = document.createElement('input');
            productInput.type = 'hidden';
            productInput.name = 'product_id[]';
            productInput.value = id;

            const quantityInput = document.createElement('input');
            quantityInput.type = 'hidden';
            quantityInput.name = 'quantity[]';
            quantityInput.value = item.quantity;

            selected.appendChild(productInput);
            selected.appendChild(quantityInput);
        }

        if (count === 0) {
            cartItems.textContent = 'Belum ada produk dipilih.';
            cartItems.className = 'empty';
        } else {
            cartItems.className = '';
        }

        document.getElementById('cartTotal').textContent =
            'Total: ' + rupiah(total);

        document.getElementById('checkoutButton').disabled =
            count === 0;
    }

    document.getElementById('checkoutForm').addEventListener(
        'submit',
        function(event) {
            if (Object.keys(cart).length === 0) {
                event.preventDefault();
                alert('Silakan tambahkan produk ke keranjang terlebih dahulu.');
            }
        }
    );

    renderCart();
</script>

</body>
</html>
