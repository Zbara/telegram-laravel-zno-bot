@extends('layouts.app')
@section('header')
    Администраторы
@endsection
@section('content')
    <div class="row row-cards">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap datatable">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Имя</th>
                            <th>E-mail</th>
                            <th>Создан</th>
                            <th>Активность</th>
{{--                            <th></th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @include('admin.items', ['users' => $users])
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
         tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel">Редактирование аккаунта</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body edit-box"></div>
            </div>
        </div>
    </div>
    @include('modal.remove', [
        'button' =>  'adminButtonRemove'
    ])
@endsection
