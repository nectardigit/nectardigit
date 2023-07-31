<section class="newsletter">
    <div class="container">
        <div class="newsletter-wrap">
            <div class="newsletter-left">
                <div class="newsletter-title">
                    <h3>पूरा समाचारको दैनिक विवरण</h3>
                </div>
                <div class="newsletter-form">
                    {{ Form::open(['url' => route('subscriberStore'), 'wire:submit.prevent' => 'subscribeMe']) }}
                    {{ Form::email('email', '', ['class' => 'form-control', 'placeholder' => 'Enter your email address...', 'required' => 'required', 'wire:model' => 'email']) }}
    
                    {{ Form::submit('Subscribe', ['class' => 'btn btn-primary']) }}
                    {{ Form::close() }}
                  
                     
                </div>
            </div>
            <div class="news-letter-media">
              

                    @if (isset($footer_data) && !empty($footer_data))

                                    @if (isset($footer_data->phone) && count($footer_data->phone))
                                    <span>
                                   
                                        @foreach ($footer_data->phone as $key => $phoneItem)
                                        @if(@$phoneItem['phone_number'])
                                        <a href="tel:{{ @$phoneItem['phone_number'] }}">
                                            <i class="fas fa-phone-alt"></i>
                                            @if (@$_website = 'Nepali')
                                                {{ getUnicodeNumber(@$phoneItem['phone_number']) }}
                                            @else
                                                {{ @$phoneItem['phone_number'] }}
                                            @endif
                                        </a>
                                            
                                        @endif
                                            @endforeach
                                        </span>
                                    @endif
                                @endif
                <ul class="social-newsletter">
                    @isset($footer_data->facebook)
                    <li class="facebook">
                        <a href="{{ $footer_data->facebook }}" target="_blank"><i
                                class="fab fa-facebook-f"></i></a>
                    </li>
                @endisset
                @isset($footer_data->twitter)
                    <li class="twitter">
                        <a href="{{ $footer_data->twitter }}" target="_blank">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </li>
                @endisset

                @isset($footer_data->instagram)
                    <li class="instagram">
                        <a href="{{ $footer_data->instagram }}" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </li>
                @endisset
                @isset($footer_data->youtube)
                    <li class="youtube">
                        <a href="{{ $footer_data->youtube }}" target="_blank">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </li>
                @endisset
                    {{-- <li class="facebook"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                    <li class="twitter"><a href="#"><i class="fab fa-twitter"></i></a></li>
                    <li class="linkedin"><a href="#"><i class="fab fa-linkedin"></i></a></li>
                    <li class="youtube"><a href="#"><i class="fab fa-youtube"></i></a></li>
                    <li class="instagram"><a href="#"><i class="fab fa-instagram"></i></a></li> --}}
                </ul>
            </div>
        </div>
        @if($message)
        <span class="  alert {{ @$message_class }}">{{ $message }}</span>
        @endif 
    </div>
</section>
