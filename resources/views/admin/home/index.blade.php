<?php
$week_number = app('request')->input('week_number');
?>
@extends('adminlte::page')

@section('title', 'Главная страница')

@section('content_header')
    <h1 class="m-0 text-dark">Главная страница (Информация)</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$users}}</h3>
                    <p>Количество активных пользователей
                    </p>
                </div>
                <div class="icon">
                    <i class="fa fa-user"></i>
                </div>
                <a href="#" class="small-box-footer">Подробнее <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$subscriptions}}</h3>
                    <p>Количество пользователей с подпиской </p>
                </div>
                <div class="icon">
                    <i class="fa fa-book-reader"></i>
                </div>
                <a href="#" class="small-box-footer">Подробнее <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$subjects}}</h3>
                    <p>
                        Количество активных предметов
                        <br>
                        <br>
                    </p>
                </div>
                <div class="icon">
                    <i class="fa fa-book"></i>
                </div>
                <a href="#" class="small-box-footer">Подробнее <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$lessons}}</h3>

                    <p>
                        Количество уроков
                        <br>
                        <br>
                    </p>
                </div>
                <div class="icon">
                    <i class="fa fa-book-open"></i>
                </div>
                <a href="#" class="small-box-footer">Подробнее <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$tests}}</h3>

                    <p>Количество тестов</p>
                </div>
                <div class="icon">
                    <i class="fa fa-question"></i>
                </div>
                <a href="#" class="small-box-footer">Подробнее <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$videos}}</h3>

                    <p>Количество видео</p>
                </div>
                <div class="icon">
                    <i class="fa fa-video"></i>
                </div>
                <a href="#" class="small-box-footer">Подробнее <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$conspectus}}</h3>

                    <p>Количество конспектов</p>
                </div>
                <div class="icon">
                    <i class="fa fa-text-height"></i>
                </div>
                <a href="#" class="small-box-footer">Подробнее <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$assignments}}</h3>

                    <p>Количество задач</p>
                </div>
                <div class="icon">
                    <i class="fa fa-tasks"></i>
                </div>
                <a href="#" class="small-box-footer">Подробнее <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Лайки</span>
                    <span class="info-box-number">{{$likes}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fa fa-star"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Оценки</span>
                    <span class="info-box-number">{{$reviews}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">График активности пользователей</h3>
                        <a href="javascript:void(0);">Посмотреть таблицу</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <p class="d-flex flex-column">
                            <span class="text-bold text-lg">{{$users}}</span>
                            <span>Общее кол-во активных пользователей</span>
                        </p>
                    </div>
                    <!-- /.d-flex -->

                    <div class="chart">
                        <canvas id="barChart"
                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>

                    <div class="d-flex flex-row justify-content-end">
                        <a href="{{route('home.index', ['week_number' => ($week_number - 1)])}}"
                           class="mr-2 btn btn-success text-white">
                            <i class="fas fa-arrow-left"></i> &nbsp; Предыдущая неделя
                        </a>

                        <a href="{{route('home.index', ['week_number' => ($week_number + 1)])}}"
                           class=" btn btn-success text-white">
                            Следующая неделя &nbsp;<i class="fas fa-arrow-right "></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Статистика по предметам</h5>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($subject_rates as $subject_rate)
                    <div class="col-md-6">
                        <p class="text-center">
                            <strong>{{$subject_rate['name_ru']}}</strong>
                        </p>

                        <div class="progress-group">
                            Кол-во курсов
                            <span class="float-right"><b>{{$subject_rate['course_count']}}</b>/{{$courses}}</span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-primary"
                                     style="width: {{($subject_rate['course_count']/$courses ?? 1) * 100}}%"></div>
                            </div>
                        </div>

                        <div class="progress-group">
                            Кол-во уроков
                            <span class="float-right"><b>{{$subject_rate['lesson_count']}}</b>/{{$lessons}}</span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-danger"
                                     style="width: {{($subject_rate['lesson_count']/$lessons ?? 1) * 100}}%"></div>
                            </div>
                        </div>

                        <div class="progress-group">
                            Кол-во тестов
                            <span class="float-right"><b>{{$subject_rate['test_count']}}</b>/{{$tests}}</span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-success"
                                     style="width: {{($subject_rate['test_count']/($tests ?? 1)) * 100}}%"></div>
                            </div>
                        </div>

                        <!-- /.progress-group -->
                        <div class="progress-group">
                            Кол-во задач
                            <span
                                class="float-right"><b>{{$subject_rate['assignment_count']}}</b>/{{$assignments}}</span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-warning"
                                     style="width: {{($subject_rate['assignment_count']/($assignments ?? 1) * 100}}%"></div>
                            </div>
                        </div>
                        <!-- /.progress-group -->
                    </div>
                @endforeach
            </div>
            <div style="width: 100%;" class="text-center mt-3">
                <a href="">Еще...</a>
            </div>
        </div>
    </div>



@stop

@section('plugins.Chartjs', true)
@section('js')
    <script>
        var date_range = <?php echo json_encode(sprintf('%s - %s', $weekDays[0], $weekDays[6])) ?>;
        var week_days = <?php echo json_encode($weekDays); ?>;
        var registered_count = <?php echo json_encode($registered_count); ?>;
        var areaChartData = {
            labels: week_days,
            datasets: [
                {
                    label: 'Динамика регистраций пользователей: ' + date_range,
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: registered_count
                },
            ]
        }

        var barChartCanvas = $('#barChart').get(0).getContext('2d')
        var barChartData = $.extend(true, {}, areaChartData)
        var temp0 = areaChartData.datasets[0]
        barChartData.datasets[0] = temp0

        var barChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            datasetFill: false,
            scales: {
                yAxes: [{
                    ticks: {
                        stepSize: 1
                    }
                }]
            },
        }

        var barChart = new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        })


    </script>
@stop
