<section id="services" class="bg-light">
    <div class="container text-center">
        <div class="section-title" data-aos="fade-down" data-aos-offset="200" data-aos-delay="20" data-aos-duration="1000" data-aos-easing="ease-in-out"  data-aos-mirror="true">
            <h2>{{ $gs->service_title }}</h2>
            <span class="section-separator"></span>
            <p class="text-nb">{{ $gs->service_details }}</p>
        </div>
        <div class="row text-center">
            @foreach($services as $service)
                <div class="col-md-4 services" data-aos="fade-down" data-aos-offset="200" data-aos-delay="30" data-aos-duration="1000" data-aos-easing="ease-in-out"  data-aos-mirror="true">
                    <i class="{{ $service->icon }} fa-2x"></i>
                    <h4>{{ $service->title }}</h4>
                    <p class="text-nb">
                        {{ Str::limit(strip_tags($service->details), 111) }}
                        @if (Str::limit(strip_tags($service->details)) > 111)
                            <a href="javascript:void(0)" class="btn btn-info btn-sm">{{ __('lang.read_more') }}</a>
                        @endif
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</section>