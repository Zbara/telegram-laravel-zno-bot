@extends('layouts.app')
@section('header')
    Пользователи Бота
@endsection
@section('content')

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-2">
                    <form class="filterData">
                        <div class="subheader mb-2">Показать</div>
                        <div class="mb-3">
                            <label class="form-check mb-1">
                                <input type="checkbox" class="form-check-input" name="teacher" value="1">
                                <span class="form-check-label">Учителя</span>
                            </label>
                            <label class="form-check mb-1">
                                <input type="checkbox" class="form-check-input" name="student" value="1">
                                <span class="form-check-label">Ученики</span>
                            </label>
                            <label class="form-check mb-1">
                                <input type="checkbox" class="form-check-input" name="status" value="1">
                                <span class="form-check-label">Заблокированые</span>
                            </label>
                        </div>
                        <div class="mt-2">
                            <button class="btn btn-primary w-100">
                                Показать результаты
                            </button>

                            <div class="btn btn-link w-100 reset__filter">
                                Сбросить фильтр
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-10">
                    <div class="row row-cards">

                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Имя и Фамилия</th>
                                    <th>Login</th>
                                    <th>Создан</th>
                                    <th>Активность</th>
                                    <th>Роль</th>
                                    <th>Статус</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody id="users">
                                     @include('telegram.users.item', ['users' => $users])
                                </tbody>
                                <tbody id="userFilter" class="d-none"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('modal.edit', ['name' => 'Редактирование'])
@endsection
