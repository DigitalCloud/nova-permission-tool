@if (Auth::user()->can('viewAny', app(\Spatie\Permission\PermissionRegistrar::class)->getRoleClass()) || Auth::user()->can('viewAny', app(\Spatie\Permission\PermissionRegistrar::class)->getPermissionClass()))
    <h3 class="flex items-center font-normal text-white mb-6 text-base no-underline">
        <svg class="sidebar-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path fill="var(--sidebar-icon)"
                  d="M7 10V7a5 5 0 1 1 10 0v3h2a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-8c0-1.1.9-2 2-2h2zm2 0h6V7a3 3 0 0 0-6 0v3zm-4 2v8h14v-8H5zm7 2a1 1 0 0 1 1 1v2a1 1 0 0 1-2 0v-2a1 1 0 0 1 1-1z"/>
        </svg>
        <span class="sidebar-label">
                @lang('PermissionTool::navigation.sidebar-label')
        </span>
    </h3>

    <ul class="list-reset mb-8">

        @can('viewAny', app(\Spatie\Permission\PermissionRegistrar::class)->getRoleClass())
            <li class="leading-wide mb-4 text-sm">
                <router-link :to="{
                name: 'index',
                params: {
                    resourceName: 'roles'
                }
            }" class="text-white ml-8 no-underline dim">
                    @lang('PermissionTool::resources.Roles')
                </router-link>
            </li>
        @endcan

        @can('viewAny', app(\Spatie\Permission\PermissionRegistrar::class)->getPermissionClass())
            <li class="leading-wide mb-4 text-sm">
                <router-link :to="{
                name: 'index',
                params: {
                    resourceName: 'permissions'
                }
            }" class="text-white ml-8 no-underline dim">
                    @lang('PermissionTool::resources.Permissions')
                </router-link>
            </li>
        @endcan

    </ul>
@endif


{{--<router-link tag="h3" :to="{name: 'PermissionTool'}" class="cursor-pointer flex items-center font-normal dim text-white mb-6 text-base no-underline">--}}
    {{--<svg class="sidebar-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill="#B3C1D1" d="M3 1h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2H3c-1.1045695 0-2-.8954305-2-2V3c0-1.1045695.8954305-2 2-2zm0 2v4h4V3H3zm10-2h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2h-4c-1.1045695 0-2-.8954305-2-2V3c0-1.1045695.8954305-2 2-2zm0 2v4h4V3h-4zM3 11h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2H3c-1.1045695 0-2-.8954305-2-2v-4c0-1.1045695.8954305-2 2-2zm0 2v4h4v-4H3zm10-2h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2h-4c-1.1045695 0-2-.8954305-2-2v-4c0-1.1045695.8954305-2 2-2zm0 2v4h4v-4h-4z"/></svg>--}}
    {{--<span class="sidebar-label">--}}
        {{--Permission--}}
    {{--</span>--}}
{{--</router-link>--}}
