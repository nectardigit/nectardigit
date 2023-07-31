@extends('layouts.admin')
@section('title', 'Contacts')
@section('content')
    <section class="content-header pt-0"></section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Contacts Detail</h3>
                    <div class="card-tools">
                        <a href="{{ route('contact.index') }}" type="button" class="btn btn-tool">
                            <i class="fa fa-list"></i></a>
                    </div>
                </div>
                <div class="card-header">
                    <div class="btn-group">
                        <a href="{{ route('contact.index') }}" class="btn btn-primary btn-flat btn-sm">
                            <i class="fas fa-sync-alt fa-sm"></i> Go Back
                        </a>
                    </div>
                    <div class="card-tools">

                    </div>
                </div>
                <div class="card-body card-format">
                    <table class="table table-striped table-hover"> {{-- table-bordered--}}
                        <tbody>
                            <tr>
                                <th>Full Name</th>
                                <td>{{$contact_info->name}}</td>
                            </tr>
                            <tr>
                                <th>Phone Number</th>
                                <td>{{$contact_info->phone}}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{$contact_info->email}}</td>
                            </tr>
                            <tr>
                                <th>Subject</th>
                                <td>{{$contact_info->subject}}</td>
                            </tr>
                            <tr>
                                <th>Message</th>
                                <td>{{$contact_info->message}}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </section>
@endsection
