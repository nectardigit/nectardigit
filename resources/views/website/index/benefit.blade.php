@isset($benefit)
    <!-- About Section -->
    <section class="about-section">
        <div class="container">
            <div class="about-section-title">
                <h3>How Can Your Company Get Benefit From Nectar Digit?</h3>
                <p>
                    See some of the industries we have vast experience working in as a full-service.
                </p>
                <a href="#" class="main-btn1">View More Services</a>
            </div>
            <div class="about-section-wrap">
                @foreach ($benefit as $item)
                    <div class="about-section-item">
                        <i class="{{ $item['icon'] }}"></i>
                        <span>{{ $item['title'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- About Section End -->


@endisset
