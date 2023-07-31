@include('admin.section.notify')
<!-- Newsletter -->
<section class="newsletter">
    <div class="container">
        <div class="newsletter-wrap">
            <h3>Subscribe To Our Newsletter</h3>
            <p>
            </p>
            <div class="newsletter-form">
                <form action="{{url('/subscribe')}}" method="get">
                    <input type="email" name="email" class="form-control" placeholder="Enter your email address" required="">
                    <button type="" class="btn btn-primary">Subscribe Now</button>
                </form>
            </div>
        </div>
    </div>
    <div class="shape">
        <img src="{{asset('template/images/shape2.png')}}" alt="images">
    </div>
    <div class="shape2">
        <img src="{{asset('template/images/shape3.png')}}" alt="images">
    </div>
    <div class="shape1">
        <img src="{{asset('template/images/shape4.png')}}" alt="images">
    </div>
</section>
<!-- Newsletter End -->
