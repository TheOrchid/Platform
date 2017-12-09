@extends('dashboard::layouts.dashboard')


@section('title',$name)
@section('description',$description)



@section('navbar')
    <div class="text-right">
        <div class="btn-group" role="group">
            <a href="{{ route('dashboard.systems.users.create')}}" class="btn btn-link"><i
                        class="icon-plus fa fa-2x"></i></a>
        </div>
    </div>
@stop



@section('content')


    <!-- main content  -->
    <section class="wrapper-md">
        <div class="bg-white-only bg-auto no-border-xs">

            @if($users->count() > 0)
                <div class="panel">

                    <div class="panel-body row">

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th class="w-xs">{{trans('dashboard::common.Manage')}}</th>
                                    @foreach($grid as $key => $column)
                                        <th>{{$column}}</th>
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="text-center">
                                            <a href="{{ route('dashboard.systems.users.edit',$user->id) }}"><i
                                                        class="fa fa-bars"></i></a>
                                        </td>

                                        @foreach($grid as $key => $column)
                                            <td>{{$user->getContent($key)}}</td>
                                        @endforeach
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <footer class="panel-footer">
                        <div class="row">
                            <div class="col-sm-6">
                                <small class="text-muted inline m-t-sm m-b-sm">{{trans('dashboard::common.show')}} {{$users->total()}}
                                    -{{$users->perPage()}} {{trans('dashboard::common.of')}} {!! $users->count() !!} {{trans('dashboard::common.elements')}}</small>
                            </div>
                            <div class="col-sm-6 text-right text-center-xs">
                                {!! $users->links('dashboard::partials.pagination') !!}
                            </div>
                        </div>
                    </footer>
                </div>

            @else

                <div class="jumbotron text-center bg-white not-found">
                    <div>
                        <h3 class="font-thin">{{trans('dashboard::systems/users.not_found')}}</h3>

                        <a href="{{ route('dashboard.systems.roles.create')}}" class="btn btn-link">
                            {{trans('dashboard::systems/users.create')}}
                        </a>
                    </div>
                </div>

            @endif

        </div>
    </section>
    <!-- / main content  -->


@stop




