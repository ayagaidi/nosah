@extends('layouts.app')

@section('title', 'إحصائيات النظام')

@section('content')
<div class="row small-spacing">
    <div class="col-xs-12">
        <div class="box-content">
            <h4 class="box-title">إحصائيات النظام</h4>
            <!-- /.box-title -->
           
            <!-- /.dropdown js__dropdown -->
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="row">
                <div class="col-lg-4 col-md-6 col-xs-12">
                    <div class="box-content">
                        <h4 class="box-title">عدد الأطباء</h4>
                        <!-- /.box-title -->
                      
                        <!-- /.dropdown js__dropdown -->
                        <div class="content widget-stat">
                            <div class="percent bg-primary"><i class="fa fa-user-md"></i></div>
                            <!-- /.percent -->
                            <div class="right-content">
                                <h2 class="counter">{{ $doctorsCount ?? 0 }}</h2>
                                <!-- /.counter -->
                                <p class="text">عدد الأطباء</p>
                                <!-- /.text -->
                            </div>
                            <!-- /.right-content -->
                            <div class="clear"></div>
                            <!-- /.clear -->
                            
                            <!-- /.process-bar -->
                        </div>
                        <!-- /.content widget-stat -->
                    </div>
                    <!-- /.box-content -->
                </div>
                <!-- /.col-lg-3 col-md-6 col-xs-12 -->
                <div class="col-lg-4 col-md-6 col-xs-12">
                    <div class="box-content">
                        <h4 class="box-title">عدد العيادات</h4>
                        <!-- /.box-title -->
                      
                        <!-- /.dropdown js__dropdown -->
                        <div class="content widget-stat">
                            <div class="percent bg-success"><i class="fa fa-hospital-o"></i></div>
                            <!-- /.percent -->
                            <div class="right-content">
                                <h2 class="counter">{{ $clinicsCount ?? 0 }}</h2>
                                <!-- /.counter -->
                                <p class="text">عدد العيادات</p>
                                <!-- /.text -->
                            </div>
                            <!-- /.right-content -->
                            <div class="clear"></div>
                            <!-- /.clear -->
                          
                            <!-- /.process-bar -->
                        </div>
                        <!-- /.content widget-stat -->
                    </div>
                    <!-- /.box-content -->
                </div>
                <!-- /.col-lg-3 col-md-6 col-xs-12 -->
                <div class="col-lg-4 col-md-6 col-xs-12">
                    <div class="box-content">
                        <h4 class="box-title">عدد المرضى المسجلين</h4>
                        <!-- /.box-title -->
                      
                        <!-- /.dropdown js__dropdown -->
                        <div class="content widget-stat">
                            <div class="percent bg-info"><i class="fa fa-users"></i></div>
                            <!-- /.percent -->
                            <div class="right-content">
                                <h2 class="counter">{{ $patientsCount ?? 0 }}</h2>
                                <!-- /.counter -->
                                <p class="text">عدد المرضى المسجلين</p>
                                <!-- /.text -->
                            </div>
                            <!-- /.right-content -->
                            <div class="clear"></div>
                            <!-- /.clear -->
                            
                            <!-- /.process-bar -->
                        </div>
                        <!-- /.content widget-stat -->
                    </div>
                    <!-- /.box-content -->
                </div>
                <!-- /.col-lg-3 col-md-6 col-xs-12 -->
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="box-content">
                        <h4 class="box-title">توزيع الإحصائيات</h4>
                        <!-- /.box-title -->
                      
                        <!-- /.dropdown js__dropdown -->
                        <div class="content">
                            <canvas id="pieChart" height="300"></canvas>
                        </div>
                        <!-- /.content -->
                    </div>
                    <!-- /.box-content -->
                </div>
                <!-- /.col-md-6 -->
                <div class="col-md-6">
                    <div class="box-content">
                        <h4 class="box-title">مقارنة الإحصائيات</h4>
                        <!-- /.box-title -->
                      
                        <!-- /.dropdown js__dropdown -->
                        <div class="content">
                            <canvas id="barChart" height="300"></canvas>
                        </div>
                        <!-- /.content -->
                    </div>
                    <!-- /.box-content -->
                </div>
                <!-- /.col-md-6 -->
            </div>
        </div>
        <!-- /.box-content -->
    </div>
    <!-- /.col-xs-12 -->
</div>
<!-- /.row small-spacing -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Pie Chart
        var pieCtx = document.getElementById('pieChart').getContext('2d');
        var pieChart = new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: ['الأطباء', 'العيادات', 'المرضى'],
                datasets: [{
                    data: [{{ $doctorsCount ?? 0 }}, {{ $clinicsCount ?? 0 }}, {{ $patientsCount ?? 0 }}],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'توزيع الإحصائيات'
                    }
                }
            }
        });

        // Bar Chart
        var barCtx = document.getElementById('barChart').getContext('2d');
        var barChart = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['الأطباء', 'العيادات', 'المرضى'],
                datasets: [{
                    label: 'العدد',
                    data: [{{ $doctorsCount ?? 0 }}, {{ $clinicsCount ?? 0 }}, {{ $patientsCount ?? 0 }}],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'مقارنة الإحصائيات'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endsection
