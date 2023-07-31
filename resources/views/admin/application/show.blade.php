@extends('layouts.admin')
@section('title', $title)
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-text-width"></i>
                            {{ $title }}
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <dl>
                            <dt>Name</dt>
                            <dd>{{ $application->name }}</dd>
                            <dt>Applied For:</dt>
                            <dd><a href="{{ ($application->career) ?  route('career.show', $application->career->slug) : '#' }}">{{ ($application->career) ? $application->career->title : 'Not Defined' }}</a>
                            </dd>
                            <dt>Email</dt>
                            <dd>{{ $application->email }}</dd>
                            <dt>Applied At</dt>
                            <dd>{{ $application->created_at->toDayDateTimeString() }}</dd>
                            <dt>Verification status</dt>
                            <dd>
                                @if ($application->verified)
                                    <span class="badge badge-pill badge-success">Verified</span>
                                @else
                                    <span class="badge badge-pill badge-danger">Not-Verified</span>
                                @endif
                            </dd>
                            <dt>
                                <div class="offset-6 col-md-4 col-sm-6 col-12">
                                    <form action="{{ route('application.download', $application->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-flat">
                                            <div class="info-box">

                                                <span class="info-box-icon bg-info">
                                                    <i class="fas fa-download"></i></span>

                                                <div class="info-box-content">
                                                    <span class="info-box-text">Download Cv</span>

                                                </div>
                                                <!-- /.info-box-content -->
                                            </div>
                                        </button>
                                    </form>
                                    <!-- /.info-box -->
                                </div>
                            </dt>
                        </dl>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
@endsection
