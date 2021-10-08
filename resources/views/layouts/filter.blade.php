@if($filters->count() > 0)
    <div class="g-0 bg-white py-4 px-4 rounded mb-3">
        <div class="row align-items-center" data-controller="filter">
            @foreach($filters->where('display', true) as $filter)
                <div class="col-sm-auto align-self-start">
                    {!! $filter->render() !!}
                </div>
            @endforeach
            <div class="col-sm-auto ms-auto mt-3 text-end">
                <div class="form-group">
                    <div class="btn-group" role="group">
                        <button data-action="filter#clear" class="btn btn-default">
                            <x-orchid-icon class="me-1" path="refresh" /> {{ __('Refresh') }}
                        </button>
                        <button type="submit" form="filters" class="btn btn-default">
                            <x-orchid-icon class="me-1" path="filter" /> {{ __('Apply') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
