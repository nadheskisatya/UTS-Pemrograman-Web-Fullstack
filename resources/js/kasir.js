// ── State ──────────────────────────────────────────────────────────────────
let cart = {};

// ── Helpers ────────────────────────────────────────────────────────────────
function formatRupiah(angka) {
    return 'Rp ' + Number(angka).toLocaleString('id-ID');
}

function getTotal() {
    return Object.values(cart).reduce((sum, item) => sum + item.price * item.qty, 0);
}

// ── Cart Operasi ────────────────────────────────────────────────────────────
function addToCart(id, name, price) {
    if (cart[id]) {
        cart[id].qty++;
    } else {
        cart[id] = { id, name, price, qty: 1 };
    }
    renderCart();
}

function changeQty(id, delta) {
    if (!cart[id]) return;
    cart[id].qty += delta;
    if (cart[id].qty <= 0) {
        delete cart[id];
    }
    renderCart();
}

function removeItem(id) {
    delete cart[id];
    renderCart();
}

function clearCart() {
    cart = {};
    renderCart();
}

// ── Render ──────────────────────────────────────────────────────────────────
// ── Render ──────────────────────────────────────────────────────────────────
function renderCart() {
    const container = document.getElementById('cart-items');
    const items     = Object.values(cart);

    // Jika keranjang kosong, cetak elemen "Belum ada item"
    if (items.length === 0) {
        container.innerHTML = `
            <p id="cart-empty" class="text-kopi-muted text-sm text-center mt-8" style="font-family:'Montserrat',sans-serif">
                Belum ada item
            </p>
        `;
        document.getElementById('subtotal').textContent = formatRupiah(0);
        hitungKembalian();
        return;
    }

    // Jika ada isinya, cetak daftar item keranjang
    container.innerHTML = items.map(item => `
        <div class="bg-kopi-card border border-kopi-border p-3">
            <div class="flex justify-between items-start mb-2">
                <p class="text-kopi-white text-sm leading-tight flex-1 pr-2">${item.name}</p>
                <button onclick="removeItem(${item.id})"
                        class="text-kopi-muted hover:text-kopi-danger text-xs flex-shrink-0 transition-colors">
                    ✕
                </button>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <button onclick="changeQty(${item.id}, -1)"
                            class="w-6 h-6 border border-kopi-border text-kopi-muted hover:border-kopi-gold hover:text-kopi-gold text-sm flex items-center justify-center transition-all">
                        −
                    </button>
                    <span class="text-kopi-white text-sm w-6 text-center">${item.qty}</span>
                    <button onclick="changeQty(${item.id}, 1)"
                            class="w-6 h-6 border border-kopi-border text-kopi-muted hover:border-kopi-gold hover:text-kopi-gold text-sm flex items-center justify-center transition-all">
                        +
                    </button>
                </div>
                <span class="text-gold text-xs" style="font-family:'Montserrat',sans-serif">
                    ${formatRupiah(item.price * item.qty)}
                </span>
            </div>
        </div>
    `).join('');

    document.getElementById('subtotal').textContent = formatRupiah(getTotal());
    hitungKembalian();
}

// ── Kembalian Real-time ─────────────────────────────────────────────────────
function hitungKembalian() {
    const uang      = parseFloat(document.getElementById('uang-pelanggan').value) || 0;
    const total     = getTotal();
    const kembalian = uang - total;

    const el = document.getElementById('kembalian');
    if (kembalian < 0) {
        el.textContent = '— kurang';
        el.style.color = 'var(--kopi-danger, #ef4444)'; // Fallback color added
    } else {
        el.textContent = formatRupiah(kembalian);
        el.style.color = 'var(--kopi-gold, #c9a84c)'; // Fallback color added
    }
}

// ── Selesai Transaksi ───────────────────────────────────────────────────────
async function selesaiTransaksi() {
    const items = Object.values(cart);
    if (items.length === 0) {
        alert('Keranjang masih kosong.');
        return;
    }

    const uang  = parseFloat(document.getElementById('uang-pelanggan').value) || 0;
    const total = getTotal();

    if (uang < total) {
        alert('Uang pelanggan kurang dari total harga.');
        return;
    }

    // Ambil token CSRF (Pastikan meta tag ada di HTML/layout)
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        alert('Keamanan CSRF tidak ditemukan. Pastikan ada tag meta csrf-token di layout HTML Anda.');
        return;
    }

    const payload = {
        items: items.map(i => ({ id: i.id, qty: i.qty })),
        uang_pelanggan: uang,
    };

    try {
        const res  = await fetch('/kasir/checkout', {
            method:  'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken.content
            },
            body:    JSON.stringify(payload),
        });

        const data = await res.json();

        if (res.ok && data.success) {
            tampilkanNota(data.transaksi);
            clearCart();
            document.getElementById('uang-pelanggan').value = '';
        } else {
            alert(data.message || 'Terjadi kesalahan. Coba lagi.');
        }
    } catch (e) {
        alert('Koneksi gagal. Periksa jaringan Anda.');
        console.error(e);
    }
}

// ── Tampilkan Nota ──────────────────────────────────────────────────────────
function tampilkanNota(transaksi) {
    // Handling perbedaan cara Laravel me-return JSON relasi (bisa camelCase atau snake_case)
    const detail = transaksi.detail_transaksi || transaksi.detailTransaksi || [];

    document.getElementById('nota-waktu').textContent =
        new Date(transaksi.created_at).toLocaleString('id-ID');

    document.getElementById('nota-items').innerHTML = detail.map(d => `
        <div class="flex justify-between text-sm">
            <span class="text-kopi-muted" style="font-family:'Montserrat',sans-serif">
                ${d.produk?.nama_produk || '-'} × ${d.quantity}
            </span>
            <span class="text-kopi-white" style="font-family:'Montserrat',sans-serif">
                ${formatRupiah(d.total_harga)}
            </span>
        </div>
    `).join('');

    document.getElementById('nota-total').textContent     = formatRupiah(transaksi.total_harga);
    document.getElementById('nota-bayar').textContent     = formatRupiah(transaksi.uang_pelanggan);
    document.getElementById('nota-kembalian').textContent = formatRupiah(transaksi.kembalian);

    document.getElementById('modal-nota').classList.remove('hidden');
}

function tutupNota() {
    document.getElementById('modal-nota').classList.add('hidden');
}

// Expose ke global (window) agar bisa dipanggil oleh tag onclick di HTML
window.addToCart = addToCart;
window.changeQty = changeQty;
window.removeItem = removeItem;
window.clearCart = clearCart;
window.hitungKembalian = hitungKembalian;
window.selesaiTransaksi = selesaiTransaksi;
window.tutupNota = tutupNota;
