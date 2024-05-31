<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>General</h3>
        <ul class="nav side-menu">
            <li>  <a class="nav-link {{ Request::is('jenisbarang') ? '' : 'collapsed' }}" href="{{ route('JenisBarang') }}">
                <i class="bi bi-grid"></i>
                <span>Jenis Barang</span>
            </a>
            </li>
            <li>  <a class="nav-link {{ Request::is('barang') ? '' : 'collapsed' }}" href="{{ route('Barang') }}">
                <i class="bi bi-grid"></i>
                <span> Barang</span>
            </a>
            </li>
            <li>  <a class="nav-link {{ Request::is('pengeluaran') ? '' : 'collapsed' }}" href="{{ route('pengeluaran') }}">
                <i class="bi bi-grid"></i>
                <span> Pengeluaran</span>
            </a>
            </li>
            
             <li class=""><a><i class="fa fa-table"></i> Transaksi <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('transaksi_belumterkonfirmasi') }}">Data Belum Terkonfirmasi</a></li>
                    <li><a href="{{ route('transaksi_pembayaran') }}">Data Terkonfirmasi dan Pembayaran</a></li>
                </ul>
            </li>
           
            <li><a><i class="fa fa-clone"></i>Layouts <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="fixed_sidebar.html">Fixed Sidebar</a></li>
                    <li><a href="fixed_footer.html">Fixed Footer</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="menu_section">
        <h3>Live On</h3>
        
    </div>

</div>