 <div class="container-fluid">
     <div class="row bg-secondary py-1 px-xl-5">
         <div class="col-lg-6 d-none d-lg-block">
             <div class="d-inline-flex align-items-center h-100">
                 <a class="text-body mr-3" href="">About</a>
                 <a class="text-body mr-3" href="">Contact</a>
                 <a class="text-body mr-3" href="">Help</a>
                 <a class="text-body mr-3" href="">FAQs</a>
             </div>
         </div>
         <div class="col-lg-6 text-center text-lg-right">
             <div class="d-inline-flex align-items-center">
                 <div class="btn-group">
                     <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">Tài
                         Khoản</button>
                     <div class="dropdown-menu dropdown-menu-right">
                         @if (!auth()->check())
                             <a href="{{ route('auth.login') }}" class="dropdown-item" type="button">Đăng nhập</a>
                         @else
                             <a href="{{ route('auth.logout') }}" class="dropdown-item" type="button">Đăng xuất</a>
                             <a href="{{ route('auth.updateaccont') }}" class="dropdown-item" type="button">Đổi mật
                                 khẩu</a>
                             <form action="{{ route('user.index') }}" method="POST" class="nav-item">
                                 @csrf
                                 <input type="text" class="d-none" name="id" value={{ auth()->user()->id }}>
                                 <input type="submit" style="background: none;border: none;" class="nav-link"
                                     value="Cập nhật thông tin">
                             </form>
                         @endif
                         <a href="{{ route('auth.register') }}" class="dropdown-item" type="button">Đăng kí</a>
                     </div>
                 </div>
             </div>
             <div class="btn-group">
                 <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">VN</button>
                 <div class="dropdown-menu dropdown-menu-right">
                     <button class="dropdown-item" type="button">VN</button>
                     <button class="dropdown-item" type="button">EN</button>
                 </div>
             </div>
         </div>
         <div class="d-inline-flex align-items-center d-block d-lg-none">
             <a href="" class="btn px-0 ml-2">
                 <i class="fas fa-heart text-dark"></i>
                 <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;">0</span>
             </a>
             <a href="" class="btn px-0 ml-2">
                 <i class="fas fa-shopping-cart text-dark"></i>
                 <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;">0</span>
             </a>
         </div>
     </div>
 </div>
 <div class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex">
     <div class="col-lg-4">
         <a href="" class="text-decoration-none">
             <span class="h1 text-uppercase text-primary bg-dark px-2">Multi</span>
             <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">Shop</span>
         </a>
     </div>
     <div class="col-lg-4 col-6 text-left">

     </div>
     <div class="col-lg-4 col-6 text-right">
         <p class="m-0">Dịch vụ chăm sóc khách hàng</p>
         <h5 class="m-0">+012 345 6789</h5>
     </div>
 </div>
 </div>
