@php
    $blocks = old($field['name']) ? json_encode(old($field['name'])) : (isset($field['value']) ? json_encode($field['value']) : (isset($field['default']) ? json_encode($field['default']) : '' ));
@endphp


@include('crud::fields.inc.wrapper_start')
<div>
    <label>{!! $field['label'] !!}</label>
    @include('crud::fields.inc.translatable_icon')

    <div id="editorjs" data-init-function="techdiary__editorjsFunction"></div>

    <input type="hidden" name="{{ $field['name'] }}" id="editorjs-{{$field['name']}}">

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>
@include('crud::fields.inc.wrapper_end')


@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp

    {{-- push things in the after_scripts section --}}
    @push('crud_fields_scripts')
        <script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script>

        <script>
            const editor = new EditorJS({
                holder: 'editorjs',
                data: {
                    blocks: {!! $blocks !!}
                },
                onChange: (api) => {
                    api.saver.save().then((newData) => {
                        document.getElementById('editorjs-{{$field['name']}}').value = JSON.stringify(newData.blocks);
                    })
                },
            });
        </script>
    @endpush
@endif
