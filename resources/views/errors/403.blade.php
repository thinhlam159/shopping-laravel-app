@auth
    <h1>Bạn ko có quyền sử dụng chức năng này!</h1>
@endauth
@guest
    <h1>Bạn cần phải đăng nhập!</h1>
    <a href="{{route('auth.login')}}">Đăng nhập</a>
@endguest

