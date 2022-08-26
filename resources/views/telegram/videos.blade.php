@extends('layouts.app')
@section('header')
    Видео
@endsection
@section('content')

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row row-cards">

                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Просмотреть</th>
                                    <th>Пользватель</th>
                                    <th>Login</th>
                                    <th>Тема</th>
                                    <th>Созданано</th>
                                    <th>Просмотры</th>
                                    <th>Последний просмотр</th>
                                    <th>Статус</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($videos as $item)
                                    <tr data-video-id="{{ $item->id }}">
                                        <td>
                                            <div class="d-flex py-1 align-items-center">
                                                <div class="flex-fill">
                                                    <div
                                                        class="font-weight-medium">{{ $item->id }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                           <a href="{{ route('telegram.video.get', ['id' => $item->id]) }}" target="_blank">{{ $item->file_path }}</a>
                                        </td>
                                        <td>
                                            {{ $item->user->value('first_name') }}
                                        </td>
                                        <td>
                                            <a href="//t.me/{{ $item->user->value('login') }}" target="_blank">{{ $item->user->value('login') }}</a>
                                        </td>
                                        <td>
                                            {{ $item->theme }}
                                        </td>
                                        <td>
                                            {{ $item->created_at }}
                                        </td>
                                        <td>
                                            {{ $item->views }}
                                        </td>
                                        <td>
                                            {{ $item->updated_at }}
                                        </td>

                                        <td>
                                            @if($item['status'] == 0)
                                                <span class="badge bg-success me-1"></span> Выключено
                                            @else
                                                <span class="badge bg-success me-1"></span> Включено
                                            @endif
                                        </td>
                                        <td class="text-nowrap text-muted">

                                            <span class="text-muted cursor-pointer remove__videos"
                                                  data-bs-toggle="tooltip"
                                                  data-bs-placement="bottom"
                                                  data-bs-original-title="Удалить видео">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="icon icon-tabler icon-tabler-trash" width="24" height="24"
                                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                 stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <line x1="4" y1="7" x2="20" y2="7"></line>
                                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                                <line x1="14" y1="11" x2="14" y2="17"></line>
                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                            </svg>
                                        </span>


                                            <span class="text-muted cursor-pointer"
                                                  data-bs-toggle="dropdown"
                                                  data-bs-placement="bottom"
                                                  data-bs-original-title="Изменить роль">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                 stroke-linecap="round" stroke-linejoin="round"><path stroke="none"
                                                                                                      d="M0 0h24v24H0z"
                                                                                                      fill="none"/><path
                                                    d="M7 6a7.75 7.75 0 1 0 10 0"/><line x1="12" y1="4" x2="12"
                                                                                         y2="12"/></svg>
                                            </span>
                                            <div class="dropdown-menu dropdown-menu-end  status_video">
                                                <div class="dropdown-item cursor-pointer" data-status-id="0">
                                                    Выключить
                                                </div>
                                                <div class="dropdown-item cursor-pointer" data-status-id="1">
                                                    Включить
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('modal.remove', [
    'button' => 'videosButtonRemove'
])
@endsection
