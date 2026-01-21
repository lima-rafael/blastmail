@props(['name', 'value' => null])

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
@endpush

<div x-data="
{
    value: '{{$value}}',
    init() {
        let quill = new Quill(this.$refs.quill, {theme: 'snow'});
        quill.root.innerHTML = this.value;
        quill.on('text-change', () => this.value = quill.root.innerHTML);
    }
}
">
    <input type="hidden" name="{{ $name }}" x-model="value">
    <div x-ref="quill"></div>

</div>

{{-- <textarea {{ $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm']) }}>
    {{ $value }}
</textarea> --}}