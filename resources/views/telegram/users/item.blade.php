@foreach($users as $item)
    <tr data-users-id="{{ $item['id'] }}">
        <td>
            <div class="d-flex py-1 align-items-center">
                <div class="flex-fill">
                    <div
                        class="font-weight-medium">{{ $item['id'] }}</div>
                </div>
            </div>
        </td>
        <td>
            {{ $item['first_name'] }}
        </td>
        <td>
            <a href="//t.me/{{ $item['login'] }}" target="_blank">{{ $item['login'] }}</a>
        </td>
        <td>
            {{ $item['created_at'] }}
        </td>
        <td>
            {{ $item['updated_at'] }}
        </td>
        <td>
            @if($item['role'] == 1)
                Ученик
            @else
                Учитель
            @endif
        </td>

        <td>
            @if($item['status'] == 0)
                <span class="badge bg-success me-1"></span> Заблокирован
            @else
                <span class="badge bg-success me-1"></span> Активный
            @endif
        </td>
        <td class="text-nowrap text-muted">
                                            <span class="text-muted cursor-pointer"
                                                  data-bs-toggle="dropdown"
                                                  data-bs-placement="bottom"
                                                  data-bs-original-title="Изменить статус">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                 stroke-linecap="round" stroke-linejoin="round"><path stroke="none"
                                                                                                      d="M0 0h24v24H0z"
                                                                                                      fill="none"/><path
                                                    d="M7 6a7.75 7.75 0 1 0 10 0"/><line x1="12" y1="4" x2="12"
                                                                                         y2="12"/></svg>
                                            </span>
            <div class="dropdown-menu dropdown-menu-end  status_user">
                <div class="dropdown-item cursor-pointer" data-status-id="3">
                    Заблокировать
                </div>
                <div class="dropdown-item cursor-pointer" data-status-id="1">
                    Разброкировать
                </div>
            </div>
        </td>
    </tr>
@endforeach
