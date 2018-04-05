@if (is_string($item))
    <li class="header">{{ $item }}</li>
@else

    <style type="text/css">
        .menu_badge {
            margin-top: -10px !important;
            min-width: 15px !important;
            min-height: 15px !important;
            font-size: 10px !important;
            padding-left: 5px !important;
        }
    </style>

    <li class="{{ $item['class'] }}">
        <a href="{{ $item['href'] }}"
           @if (isset($item['target'])) target="{{ $item['target'] }}" @endif
        >
            @if(isset($item['avatar']))
                <span class="profile-header-container">
                    <span class="profile-menu-img">
                        <img class="img-circle" src="{{ $item['avatar'] }}" style="max-width: 40px" />
                    </span>
                </span>
            @else
                <i class="fa fa-fw fa-{{ $item['icon'] or 'circle-o' }} {{ isset($item['icon_color']) ? 'text-' . $item['icon_color'] : '' }}"></i>
            @endif

            <span>
                {{ $item['text'] }}
                @if(!empty($item['badge']))
                    <span class="badge menu_badge">{{ $item['badge'] }}</span>
                @endif
            </span>
            @if (isset($item['label']))
                <span class="pull-right-container">
                    <span class="label label-{{ $item['label_color'] or 'primary' }} pull-right">{{ $item['label'] }}</span>
                </span>
            @elseif (isset($item['submenu']))
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
            @endif
        </a>
        @if (isset($item['submenu']))
            <ul class="{{ $item['submenu_class'] }}">
                @each('adminlte::partials.menu-item', $item['submenu'], 'item')
            </ul>
        @endif
    </li>
@endif
