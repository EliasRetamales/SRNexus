<!-- resources/views/vendor/adminlte/partials/sidebar/menu.blade.php -->

<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    @foreach($items as $item)
        @php
            // Inicializar la variable para determinar si se muestra el elemento
            $canSee = true;

            // Verificar permisos con 'can'
            if (isset($item['can'])) {
                $canSee = auth()->user()->can($item['can']);
            }

            // Verificar roles con 'role'
            if (isset($item['role'])) {
                $canSee = auth()->user()->hasRole($item['role']);
            }
        @endphp

        @if($canSee)
            <li class="nav-item">
                <a href="{{ url($item['url']) }}" class="nav-link {{ Request::is($item['url'] . '*') ? 'active' : '' }}">
                    <i class="nav-icon {{ $item['icon'] }}"></i>
                    <p>
                        {{ $item['text'] }}
                        @if(isset($item['submenu']))
                            <i class="right fas fa-angle-left"></i>
                        @endif
                    </p>
                </a>

                @if(isset($item['submenu']))
                    <ul class="nav nav-treeview">
                        @foreach($item['submenu'] as $subitem)
                            @php
                                $canSeeSub = true;

                                if (isset($subitem['can'])) {
                                    $canSeeSub = auth()->user()->can($subitem['can']);
                                }

                                if (isset($subitem['role'])) {
                                    $canSeeSub = auth()->user()->hasRole($subitem['role']);
                                }
                            @endphp

                            @if($canSeeSub)
                                <li class="nav-item">
                                    <a href="{{ url($subitem['url']) }}" class="nav-link {{ Request::is($subitem['url'] . '*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ $subitem['text'] }}</p>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            </li>
        @endif
    @endforeach
</ul>
