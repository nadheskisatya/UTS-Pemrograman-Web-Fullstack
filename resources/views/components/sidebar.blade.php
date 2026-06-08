<aside class="w-64 min-h-screen bg-kopi-surface border-r border-kopi-border fixed left-0 top-0 flex flex-col">

    {{-- Logo --}}
    <div class="px-6 py-6 border-b border-kopi-border">
        <p class="text-gold text-xs tracking-widest uppercase"
           style="font-family:'Montserrat',sans-serif">POS Kopi</p>
        <p class="text-kopi-muted text-xs mt-1" style="font-family:'Montserrat',sans-serif">
            Admin Panel
        </p>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 px-4 py-6 space-y-1">
        @php
            $navItems = [
                ['route' => 'admin.dashboard',       'label' => 'Dashboard'],
                ['route' => 'admin.orders.index',    'label' => 'Orders'],
                ['route' => 'admin.produk.index',    'label' => 'Produk'],
                ['route' => 'admin.kategori.index',  'label' => 'Kategori'],
            ];
        @endphp

        @foreach($navItems as $nav)
        <a href="{{ route($nav['route']) }}"
           class="flex items-center px-4 py-3 text-sm transition-all duration-200
                  {{ request()->routeIs($nav['route']) || request()->routeIs($nav['route'] . '.*')
                     ? 'text-kopi-black bg-kopi-gold'
                     : 'text-kopi-muted hover:text-kopi-white hover:bg-kopi-card' }}"
           style="font-family:'Montserrat',sans-serif">
            {{ $nav['label'] }}
        </a>
        @endforeach
    </nav>

    {{-- Logout --}}
    <div class="px-4 pb-6">
        <a href="{{ route('admin.logout') }}"
           class="flex items-center px-4 py-3 text-sm text-kopi-muted
                  hover:text-kopi-danger transition-colors duration-200"
           style="font-family:'Montserrat',sans-serif">
            Logout
        </a>
    </div>

</aside>
