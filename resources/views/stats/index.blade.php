@extends('layouts.app')
@section('header')
    Статистика
@endsection
@section('content')
    <div class="row row-cards">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="subheader">Пользователей</div>
                    <div class="h3 m-0">{{ $users }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="subheader">За сегодня</div>
                    <div class="h3 m-0">{{ $usersDay }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="subheader">Учеников всего</div>
                    <div class="h3 m-0">{{ $usersStudent }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="subheader">Учеников за сегодня</div>
                    <div class="h3 m-0">{{ $usersDayStudent }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="subheader">Учителей всего</div>
                    <div class="h3 m-0">{{ $usersTeacher }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="subheader">Учителей за сегодня</div>
                    <div class="h3 m-0">{{ $usersDayTeacher }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="subheader">Потраченно время</div>
                    <div class="h3 m-0">0</div>
                </div>
            </div>
        </div>
    </div>
@endsection
