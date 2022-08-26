@foreach($users as $item)
    <tr data-admin-id="{{ $item['id'] }}">
        <td>
            {{ $item['id'] }}
        </td>
        <td>
            <div class="d-flex py-1 align-items-center">
                <div class="flex-fill">
                    <div class="font-weight-medium">{{ $item['name'] }}</div>
                </div>
            </div>
        </td>
        <td>
            {{ $item['email'] }}
        </td>
        <td>
            {{ $item['created_at'] }}
        </td>
        <td>
            {{ $item['updated_at'] }}
        </td>
        <td class="text-nowrap text-muted d-none">
            @if($item['id'] != 1)
                <span class="text-muted cursor-pointer remove-admin"
                      data-bs-toggle="tooltip"
                      data-bs-placement="bottom"
                      data-bs-original-title="Удалить аккаунт">
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
            @endif
            <span class="text-muted cursor-pointer edit-account"
                  data-bs-toggle="tooltip"
                  data-bs-placement="bottom"
                  data-bs-original-title="Редактировать аккаунт">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="icon icon-tabler icon-tabler-edit-circle" width="24" height="24"
                                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                 stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path
                                                    d="M12 15l8.385 -8.415a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3z"></path>
                                                <path d="M16 5l3 3"></path>
                                                <path
                                                    d="M9 7.07a7.002 7.002 0 0 0 1 13.93a7.002 7.002 0 0 0 6.929 -5.999"></path>
                                            </svg>
                                        </span>
        </td>
    </tr>
@endforeach
