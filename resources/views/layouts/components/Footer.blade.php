<footer>
    <div class="footer d-flex flex-column justify-content-between align-items-center flex-lg-row px-5">
        <div class="d-flex flex-column flex-lg-row align-items-center">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ url('/svg/logo.svg') }}" alt="DDDK Logo">
            </a>
            <p class="my-3">© {{ date("Y") }} DDDK | Všetky práva vyhradené Dellon IT Solutions &amp; DJDS</p>
        </div>

        <div>
            <ul class="d-flex flex-row">
                <li>
                    <a class="mobile-tag   hover-blue" href="#">GDPR</a>
                </li>
                <li>
                    <a class="mobile-tag  hover-blue" href="#">Stanovy klubu</a>
                </li>
                <li>
                    <a class="mobile-tag  hover-blue" href="#">Kalendár</a>
                </li>
                <li>
                    <a class="mobile-tag  hover-blue" href="#">Kontakty</a>
                </li>
                <li><a href="#"><img src="{{url('svg/insta.svg')}}" alt=""></a><a href="#"><img
                            src="{{url('svg/fb.svg')}}" alt=""></a></li>
            </ul>
        </div>
    </div>
</footer>
