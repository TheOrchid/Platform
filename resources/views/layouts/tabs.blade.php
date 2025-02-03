<div
    class="mb-3"
    data-controller="tabs"
    data-tabs-slug="{{$templateSlug}}"
    data-tabs-active-tab="{{$activeTab}}"
>
    <div class="nav-tabs-alt">
        <ul class="nav nav-tabs nav-tabs-scroll-bar" role="tablist">
            @foreach($manyForms as $name => $tab)
                <li class="nav-item" role="presentation">
                    <a
                        @class([
                            'nav-link',
                            'active' => $activeTab === $name || ($loop->first && is_null($activeTab))
                        ])
                        data-action="tabs#setActiveTab"
                        href="#tab-{{sha1($templateSlug.$name)}}"
                        data-bs-target="#tab-{{sha1($templateSlug.$name)}}"
                        id="button-tab-{{sha1($templateSlug.$name)}}"
                        aria-selected="false"
                        role="tab"
                        data-bs-toggle="tab">
                        {!! $labels[$name] ?? $name !!}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <section class="tab-content">
        @foreach($manyForms as $name => $forms)
            <div role="tabpanel"
                 id="tab-{{sha1($templateSlug.$name)}}"
                 @class([
                    'tab-pane',
                    'active' => $activeTab === $name || ($loop->first && is_null($activeTab))
                 ])
            >
                @foreach($forms as $form)
                    {!! $form !!}
                @endforeach
            </div>
        @endforeach
    </section>
</div>
