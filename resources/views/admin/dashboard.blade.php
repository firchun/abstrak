@extends('layouts.backend.admin')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('backend_theme') }}/assets/css/widgets/modules-widgets.css">
@endpush
@section('content')
    <div class="jumbotron text-center" style="margin-top:20px !important; padding-bottom:30px; margin-bottom:10px;">
        <img src="{{ asset('img/musamus.png') }}" style="height: 100px;">
        <p>Selamat datang di </p>
        <h2>Sistem Informasi Pelayanan Abstrak</h2>
        <h4>Universitas Musamus</h4>
    </div>
    @if (Auth::user()->role == 'Admin' || Auth::user()->role == 'UPT')
    @include('admin.dashboard_component.grafik')
    @endif
    @if (Auth::user()->role == 'Admin')
        <div class="row justify-content-center">
            @include('admin.dashboard_component.card1', [
                'count' => $admin,
                'title' => 'Admin',
                'subtitle' => 'Total Admin',
                'color' => 'primary',
                'icon' => 'user',
            ])
            @include('admin.dashboard_component.card1', [
                'count' => $upt,
                'title' => 'Staff UPT',
                'subtitle' => 'Total Staff',
                'color' => 'primary',
                'icon' => 'user',
            ])
            @include('admin.dashboard_component.card1', [
                'count' => $mahasiswa,
                'title' => 'mahasiswa',
                'subtitle' => 'Total mahasiswa',
                'color' => 'success',
                'icon' => 'user',
            ])
        </div>
    @endif
    @if (Auth::user()->role == 'Mahasiswa')
        @include('admin.dashboard_component.mahasiswa')
    @endif
@endsection
@push('js')
    <script src="{{ asset('backend_theme') }}/assets/js/widgets/modules-widgets.js"></script>
@endpush
