 <div class="container-fluid bg-dark mb-30">
     <div class="row px-xl-5">
         <div class="col-lg-3 d-none d-lg-block">
             <a class="btn d-flex align-items-center justify-content-between bg-primary w-100" data-toggle="collapse"
                 href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
                 <h6 class="text-dark m-0"><i class="fa fa-bars mr-2"></i>Phân Loại</h6>
                 <i class="fa fa-angle-down text-dark"></i>
             </a>
             <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light"
                 id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
                 <div class="navbar-nav w-100">
                     @forelse ($typenav as $item)
                         <div class="nav-item dropdown dropright">
                             <a href="{{ route('product.index', ['maphanloai' => $item['id']]) }}"
                                 class="nav-link dropdown-toggle">{{ $item['name'] }}
                                 {{-- <i class="fa fa-angle-right float-right mt-1"></i> --}}
                             </a>
                             {{-- <div class="dropdown-menu position-absolute rounded-0 border-0 m-0">
                                 @forelse ($item['categories'] as $itemcate)
                                     <a href="" class="dropdown-item">{{ $itemcate['name'] }}</a>
                                 @empty
                                 @endforelse
                             </div> --}}
                         </div>
                     @empty
                     @endforelse
                 </div>
             </nav>
         </div>
         <div class="col-lg-9">
             <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                 <a href="" class="text-decoration-none d-block d-lg-none">
                     <span class="h1 text-uppercase text-dark bg-light px-2">Multi</span>
                     <span class="h1 text-uppercase text-light bg-primary px-2 ml-n1">Shop</span>
                 </a>
                 <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                     <span class="navbar-toggler-icon"></span>
                 </button>
                 <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                     <div class="navbar-nav mr-auto py-0">
                         <a href="{{ route('index') }}" class="nav-item nav-link">Trang Chủ</a>
                         <a href="{{ route('product.index') }}" class="nav-item nav-link">Cửa Hàng</a>
                         <div class="nav-item dropdown">
                             <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Trang <i
                                     class="fa fa-angle-down mt-1"></i></a>
                             <div class="dropdown-menu bg-primary rounded-0 border-0 m-0">
                                 <a href="{{ route('cart.index') }}" class="dropdown-item">Giỏ Hàng</a>
                                 <a href="{{ route('product.viewfavorite') }}" class="dropdown-item">Sản phẩm yêu
                                     thích</a>
                             </div>
                         </div>
                         <a href="{{ route('user.contact') }}" class="nav-item nav-link">Kết Nối</a>
                         @if (auth()->check() &&
                             (auth()->user()->hasRole('manager') ||
                                 auth()->user()->hasRole('admin')))
                             <div class="nav-item">
                                 <a href="{{ route('admin.index') }}" class="nav-link">Quản Lý
                                 </a>
                             </div>
                         @endif
                         @if (auth()->check())
                             <form action="{{ route('orders.index') }}" method="GET" class="nav-item">
                                 <input type="submit" href="{{ route('orders.index') }}"
                                     style="background: none;border: none;" class="nav-link" value="Hóa Đơn">
                             </form>
                         @endif
                     </div>
                     <div class="navbar-nav ml-auto py-0 d-none d-lg-block">
                         <a href="{{ route('product.viewfavorite') }}" class="btn px-0">
                             <i class="fas fa-heart text-primary"></i>
                             <span class="badge text-secondary border border-secondary rounded-circle"
                                 style="padding-bottom: 2px;">{{ $Favorite }}</span>
                         </a>
                         <a href="{{ route('cart.index') }}" class="btn px-0 ml-3">
                             <i class="fas fa-shopping-cart text-primary"></i>
                             <span class="badge text-secondary border border-secondary rounded-circle cart"
                                 style="padding-bottom: 2px;">{{ $numerberOfcart }}</span>
                         </a>
                     </div>
                 </div>
             </nav>
         </div>
     </div>
 </div>
