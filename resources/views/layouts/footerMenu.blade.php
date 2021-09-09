
<div class="col-md-4 footer-box footerContent" data-aos="fade-right" data-aos-offset="200" data-aos-delay="20" data-aos-duration="1000" data-aos-easing="ease-in-out"  data-aos-mirror="true">
    <img src="@if($gs->logo){{ asset(symImagePath().$gs->logo) }} @else {{ asset($publicPath.'/images/logo.png') }} @endif">
    <p>{{ $gs->footer_text}}</p>
</div>
<div class="col-md-4 footer-box footerContent" data-aos="fade-down" data-aos-offset="200" data-aos-delay="20" data-aos-duration="1000" data-aos-easing="ease-in-out"  data-aos-mirror="true">
    <p class="text-uppercase"><b>{{ $gs->contact_title }}</b></p>
    <p><i class="fa fa-map-marker"></i> {{ $gs->contact_address }}</p>
    <p><i class="fa fa-phone"></i> {{ $gs->contact_phone }}</p>
    <p><i class="fa fa-envelope-o"></i> {{ $gs->contact_email }}</p>
</div>
