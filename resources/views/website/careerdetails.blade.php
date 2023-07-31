@extends('layouts.front')
@section('page_title', @$career->title)
@section('meta')
    @include('website.shared.meta')
@endsection

@section('content')
    {{-- {{ dd($career) }} --}}

    <!-- Bg Section -->
    <section class="bg-section"
        style="background-image: url({{ asset(@$banner_img ?? 'template/images/career.jpg') }})">
        <div class="container">
            <div class="bg-section-wrap">

                <h1>
                @if (isset($career)) {{ $career->title }} @else Career Details
                    @endif
                </h1>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}" title="Home">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                        @if (isset($career)){{ $career->title }} @else Career Details
                            @endif
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        </div>
    </section>
    <!-- Bg Sectdion End -->
    <section class="career mt mb">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12">
                    <div class="career-details">
                        <h2>{{ $career->title }}</h2>
                        {!! $career->description !!}
                        <div class="carer-form">
                            <button type="submit" class="career-btn" data-toggle="modal"
                                data-target="#exampleModal">Apply Now</button>
                            </button>
                            <!-- Modals -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Apply Now</h5>
                                            <button type="button" class="btn-close" data-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="career-forms">
                                                {!! Form::open(['url' => route('careerAdd', $career->slug), 'method' => 'POST', 'encType' => 'multipart/form-data', 'id' => 'careerModelForm']) !!}
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" name="name" class="form-control"
                                                                placeholder="Enter your name*" value="{{ old('name') }}"
                                                                required>
                                                            @error('name')
                                                                <span class="form-text text-danger">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="email" value="{{ old('email') }}" name="email"
                                                                class="form-control" placeholder="Enter your email*"
                                                                required>
                                                            @error('email')
                                                                <span class="form-text text-danger">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <input type="text" value="{{ old('mobile') }}" name="mobile"
                                                                class="form-control" placeholder="Enter your mobile*"
                                                                required>
                                                            @error('mobile')
                                                                <span class="form-text text-danger">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <textarea name="description" class="form-control"
                                                                placeholder="Cover Letter*">{{ old('description') }}</textarea>
                                                            @error('description')
                                                                <span class="form-text text-danger">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <input type="file" class="form-control" name="documents">
                                                            <span>Please upload your CV. Only pdf, docx and doc
                                                                document.</span>
                                                            @error('documents')
                                                                <span class="form-text text-danger">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn btn-primary">Submit
                                                            Application</button>
                                                    </div>
                                                </div>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modals End -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-12">
                    <div class="career-images">
                        <img src="{{ asset(@$career->image ?? 'template/images/careers.png') }}"
                            alt="{{ $career->title }}">
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@push('scripts')
    @if ($errors->any())
        <script>
            $(document).ready(function() {
                $('#exampleModal').modal('show');
            });
        </script>
    @endif
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('assets/front/js/validator.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

    @if (session('success') || session('error'))
        <script>
            @if (session('success'))
                toastr.success("{{ Session::get('success') }}","Success !")
            @endif
            @if (session('error'))
                toastr.error("{{ Session::get('error') }}","Error !")
            @endif
        </script>
    @endif
    <script>
        $("#careerModelForm").validate({
            rules: {
                name: 'required',
                email: {
                    required: true,
                    email: true,
                },
                mobile: {
                    required: true,
                    digits: true,
                },
                description: 'required',
                documents: {
                    required: true,
                    extension: "pdf|docx|doc"
                },
            },
            messages: {
                documents: 'Please provide PDF,DOCX or DOC File',
                name: 'Name is invalid',
                email: 'Email is invalid',
                mobile: 'Mobile is invalid',
                description: 'Cover is invalid',
            }
        });
    </script>

@endpush
