@php
    $blocks = old($field['name']) ? json_encode(old($field['name'])) : (isset($field['value']) ? json_encode($field['value']) : (isset($field['default']) ? json_encode($field['default']) : json_encode([]) ));
@endphp


@include('crud::fields.inc.wrapper_start')
<div>
    <label>{!! $field['label'] !!}</label>
    @include('crud::fields.inc.translatable_icon')

    <div id="editorjs" data-init-function="techdiary__editorjsFunction" style="border: 1px solid #dddddd"></div>

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

        <script src="https://cdn.jsdelivr.net/npm/@editorjs/header@latest"></script>
        <script src="https://cdn.jsdelivr.net/npm/@editorjs/list@latest"></script>
        <script src="https://cdn.jsdelivr.net/npm/@editorjs/checklist@latest"></script>
        <script src="https://cdn.jsdelivr.net/npm/@editorjs/quote@latest"></script>
        <script src="https://cdn.jsdelivr.net/npm/@editorjs/link@latest"></script>
        <script src="https://cdn.jsdelivr.net/npm/@editorjs/marker@latest"></script>
        <script src="https://cdn.jsdelivr.net/npm/@editorjs/embed@latest"></script>
        <script src="https://cdn.jsdelivr.net/npm/@editorjs/table@latest"></script>
        <script src="https://cdn.jsdelivr.net/npm/@editorjs/warning@latest"></script>
        <script src="https://cdn.jsdelivr.net/gh/paraswaykole/editor-js-code@latest/dist/bundle.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script>

        <script>
            const editor = new EditorJS({
                holder: 'editorjs',
                placeholder: "Start your diary",
                tools: {
                    /**
                     * Each Tool is a Plugin. Pass them via 'class' option with necessary settings {@link docs/tools.md}
                     */
                    header: {
                        class: Header,
                        inlineToolbar: ['marker'],
                        config: {
                            placeholder: 'Header',
                            levels: [2, 3],
                        },
                        shortcut: 'CMD+SHIFT+H',
                    },
                    list: {
                        class: List,
                        inlineToolbar: true,
                        shortcut: 'CMD+SHIFT+L',
                    },
                    checklist: {
                        class: Checklist,
                        inlineToolbar: true,
                    },
                    quote: {
                        class: Quote,
                        inlineToolbar: true,
                        config: {
                            quotePlaceholder: 'Enter a quote',
                            captionPlaceholder: "Quote's author",
                        },
                        shortcut: 'CMD+SHIFT+O',
                    },
                    warning: Warning,
                    marker: {
                        class: Marker,
                        shortcut: 'CMD+SHIFT+M',
                    },
                    code: CodeTool,
                    embed: Embed,
                    table: {
                        class: Table,
                        inlineToolbar: true,
                        shortcut: 'CMD+ALT+T',
                    },
                },
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
