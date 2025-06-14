@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>

        <div class="row">
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-success">
                <i class="fas fa-arrow-up text-white fa-2x"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                    <h4>UANG MASUK</h4>
                </div>
                <div class="card-body">
                    {{-- Rp.{{ number_format(App\Models\Money::latest()->first()->saldo ?? '0', 0, ',', '.') }} --}}
                </div>
            </div>
            
            </div>
          </div> 
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-danger">
                <i class="fas fa-arrow-down text-white fa-2x"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                    <h4>UANG KELUAR</h4>
                </div>
                <div class="card-body">
                    {{-- Rp.{{ number_format(App\Models\Money::latest()->first()->total_keluar ?? '0', 0, ',', '.') }} --}}
                </div>
            </div>
            
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-info">
                <i class="fas fa-person-praying text-white fa-2x"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>IMAM</h4>
                </div>
                <div class="card-body">
                  {{ App\Models\Leader::count() ?? '0' }}
                </div>
              </div>
            </div>
          </div>  
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                  <i class="fa fa-book-open text-white fa-2x"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>BERITA</h4>
                  </div>
                  <div class="card-body">
                    {{ App\Models\Post::count() ?? '0' }}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                  <i class="fa fa-bell text-white fa-2x"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>AGENDA</h4>
                  </div>
                  <div class="card-body">
                    {{ App\Models\Event::count() ?? '0' }}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-secondary">
                  <i class="fa fa-tags text-white fa-2x"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>TAGS</h4>
                  </div>
                  <div class="card-body">
                    {{ App\Models\Tag::count() ?? '0' }}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-dark">
                  <i class="fa fa-users text-white fa-2x"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>USERS</h4>
                  </div>
                  <div class="card-body">
                    {{ App\Models\User::count() ?? '0' }}
                  </div>
                </div>
              </div>
            </div>
                              
            <canvas id="myChart" height="100px"></canvas>

          </div>

    </section>
</div>
@endsection