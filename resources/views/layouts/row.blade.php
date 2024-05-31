<fieldset class="mb-3">

    @empty(!$title)
        <div class="col p-0 px-3">
            <legend class="text-black">
                {{ $title }}
            </legend>
        </div>
    @endempty

    <div class="bg-body-tertiary rounded shadow-sm p-4 py-4 d-flex flex-column gap-3">
        {!! $form ?? '' !!}
    </div>
</fieldset>
