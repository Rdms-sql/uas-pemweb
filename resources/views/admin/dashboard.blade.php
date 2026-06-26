@extends('layouts.admin')

@section('header', 'Dashboard Admin')

@section('main')

{{-- Kartu Statistik --}}
<div class="row">

    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $total_tiket }}</h3>
                <p>Total Tiket</p>
            </div>
            <div class="icon"><i class="fas fa-ticket-alt"></i></div>
            <a href="{{ url('admin/tiket') }}" class="small-box-footer">
                Lihat Semua <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $tiket_urgent }}</h3>
                <p>Tiket Urgent</p>
            </div>
            <div class="icon"><i class="fas fa-exclamation-triangle"></i></div>
            <a href="{{ url('admin/tiket?urgent=1') }}" class="small-box-footer">
                Lihat <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $total_mahasiswa }}</h3>
                <p>Total Mahasiswa</p>
            </div>
            <div class="icon"><i class="fas fa-user-graduate"></i></div>
            <a href="{{ url('admin/mahasiswa') }}" class="small-box-footer">
                Lihat <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $total_agen }}</h3>
                <p>Total Agen</p>
            </div>
            <div class="icon"><i class="fas fa-headset"></i></div>
            <a href="{{ url('admin/agen') }}" class="small-box-footer">
                Lihat <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

</div>

@endsection