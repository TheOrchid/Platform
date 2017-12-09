<div class="bg-white-only  bg-auto no-border-xs">
    <div class="panel-body row">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    @foreach($form['fields'] as $key => $name)
                        @if(is_array($name))
                            <th>{{$name['name']}}</th>
                        @else
                            <th>{{$name}}</th>
                        @endif
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($form['data'] as $key => $datum)
                    <tr>
                        @foreach($form['fields'] as $key => $name)
                            <td>
                                @if(is_array($name))
                                    {!! $name['action']($datum) !!}
                                @else
                                    {{ $datum->getContent($key) }}
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <footer class="panel-footer">
            <div class="row">
                <div class="col-sm-6">
                    <small class="text-muted inline m-t-sm m-b-sm">{{trans('dashboard::common.show')}} {{$form['data']->total()}}
                        -{{$form['data']->perPage()}} {{trans('dashboard::common.of')}} {!! $form['data']->count() !!} {{trans('dashboard::common.elements')}}</small>
                </div>
                <div class="col-sm-6 text-right text-center-xs">
                    {!! $form['data']->appends('search')->links('dashboard::partials.pagination') !!}
                </div>
            </div>
        </footer>
    </div>
</div>

